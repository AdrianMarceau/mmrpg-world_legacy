<?
// PROTO BLAST
$ability = array(
  'ability_name' => 'Proto Blast',
  'ability_token' => 'proto-blast',
  'ability_description' => 'The user charges its weapon on the first turn, then unleashes the stored energy on the second lowering the target\'s defenses!',
  'ability_damage' => 30,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Define the local damage amount variable and default to the base value
    $damage_amount = $this_ability->ability_damage;
    
    // Define the damage success/failure text for this attack
    $this_ability->damage_options['success_text'] = "The shot hit the target!";
    $this_ability->damage_options['failure_text'] = "The {$this_ability->print_ability_name()} missed!";
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // If this is the first time using the attack, start charging
    if (!isset($this_ability->flags['charging']) || $this_ability->flags['charging'] == false){
      
      // Update the ability charging flag to true
      $this_ability->flags['charging'] = true;
      
      // Create a message to show the charging
      $this_robot->robot_frame = 'defend';
      $event_body = "{$this_robot->print_robot_name()} begins charging&hellip;";
      $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false, 'ability_results' => $this_ability->ability_results));
      
      // Make a backup of this robot's current abilities for later
      $this_ability->values['backups']['robot_abilities'] = $this_robot->robot_abilities;
      // Remove all other abilities from this robot while charging
      $this_robot->robot_abilities = array($this_ability->ability_token);
      
      // If this robot is faster than the target, finish attack first
      if ($this_robot->robot_speed >= $target_robot->robot_speed){
        
        // Automatically queue up an ability event to finish the attack
        $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'ability', $this_ability->ability_token);
        // And then queue up a return action from the target automatically
        $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, '', '');
        
      }
      // Otherwise, if this robot is slower, finish attack second
      else {
        
        // And then queue up a return action from the target automatically
        $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, '', '');
        // Then queue up an ability event to finish this attack
        $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'ability', $this_ability->ability_token);
        
      }
      
    }
    // Otherwise, unleash the charged attack at the target
    else {
      
      // Update the ability charging flag to false
      $this_ability->flags['charging'] = false;
      
      // Create an event to show the targeting action
      $this_robot->robot_frame = 'shoot';
      $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
      $event_body .= "{$this_robot->print_robot_name()} unleashes its {$this_ability->print_ability_name()}!";
      $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
      
      // Trigger damage to the target robot
      $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
      
      // Collect the abilities from local backup if they exist, else from the index
      if (isset($this_ability->values['backups']['robot_abilities'])){
        $this_robot->robot_abilities = $this_ability->values['backups']['robot_abilities'];
      }
      else {
        $this_robot->robot_abilities = $this_index['robots'][$this_robot->robot_token]['robot_abilities'];
      }
      
      // If the target robot was not disabled by the attack
      if ($target_robot->robot_status != 'disabled'){
        
        // Decrease the opponent's defense by 10% after impact
        $target_robot->robot_defense = $target_robot->robot_defense - ceil($this_robot->robot_base_defense * 0.10);
        
        // Generate the defense dropping event
        $event_body = "{$target_robot->print_robot_name()}&#39;s shields were damaged!<br />";
        $event_body .= "{$target_robot->print_robot_name()}&#39;s defense fell by 10%!";
        $target_robot->robot_frame = 'defend';
        $this_battle->events_create($target_robot, $this_robot, $event_header, $event_body, array('this_ability' => $this_ability));
        
      }
      
    }
    
    // Reset this robot's frame back to base
    $this_robot->robot_frame = 'base';
    
    // Return true on success
    return true;
      
  }
  );
?>