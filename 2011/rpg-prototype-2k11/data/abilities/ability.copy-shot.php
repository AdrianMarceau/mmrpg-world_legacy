<?
// COPY SHOT
$ability = array(
  'ability_name' => 'Copy Shot',
  'ability_token' => 'copy-shot',
  'ability_description' => 'The user fires a small bullet at the target that copies its last used ability!',
  'ability_damage' => 10,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Define the local damage amount variable and default to the base value
    $damage_amount = $this_ability->ability_damage;
    
    // Define the damage success/failure text for this attack
    $this_ability->damage_options['success_text'] = "{$this_ability->print_ability_name()} hit the target!";
    $this_ability->damage_options['failure_text'] = "{$this_ability->print_ability_name()} missed!";
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // Create an event to show the targeting action
    $this_robot->robot_frame = 'attack';
    $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    $event_body .= "{$this_robot->print_robot_name()} fires its {$this_ability->print_ability_name()}!";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Trigger damage to the target robot
    $this_ability->damage_options['success_rate'] = 100;
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
    
    // If the target has a type and/or an ability history to copy
    if (!empty($target_robot->robot_type) || !empty($target_robot->history['triggered_abilities'])){
      
      // Generate event markup for the type and ability changes
      $event_body = array();
      $this_robot->robot_frame = 'attack';
      
      // If the target has a type to copy
      if (!empty($target_robot->robot_type) && $this_robot->robot_type != $target_robot->robot_type){
        // Update and replace this robot's type with the opponent's
        $this_robot->robot_type = $target_robot->robot_type;
        $this_robot->update_session();
        $event_body[] = "{$this_robot->print_robot_name()} became the {$this_index['types'][$this_robot->robot_type]['type_name']} type!";
      }
      // If the target has used an ability last turn
      if (!empty($target_robot->history['triggered_abilities'])){
        // Collect the target's last used ability token from their history
        $new_ability_token = $target_robot->history['triggered_abilities'][count($target_robot->history['triggered_abilities']) - 1];
        //$event_body[] = "in_array({$new_ability_token}, ".print_r($this_robot->robot_abilities, true).")<br />";
        // Only continue if the copied move is new to this robot
        if (!in_array($new_ability_token, $this_robot->robot_abilities)){
          // Update and replace this ability with the opponent's last
          $this_ability_position = array_search($this_ability->ability_token, $this_robot->robot_abilities);
          $this_robot->robot_abilities[$this_ability_position] = $new_ability_token;
          $this_ability = new mmrpg_ability($this_battle, $this_player, $this_robot, $new_ability_token);
          $this_robot->trigger_ability_event($target_robot, $this_ability, 'battle_start');
          $this_ability->update_session();
          $event_body[] = "{$this_robot->print_robot_name()} acquired {$this_ability->print_ability_name()}!";
        }
        else {
          $target_ability = new mmrpg_ability($this_battle, $target_player, $target_robot, $new_ability_token);
          $event_body[] = "{$this_robot->print_robot_name()} already knows {$target_ability->print_ability_name()}&hellip;";
        }
      }

      // Create the event using the generated markup
      $this_battle->events_create($this_robot, $target_robot, $event_header, implode('<br />', $event_body), array('this_ability' => $this_ability));
      
    }
    
    // Reset this robot's frame back to base
    $this_robot->robot_frame = 'base';
    
    // Return true on success
    return true;
      
  }
  );
?>