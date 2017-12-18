<?
// ROLLING CUTTER
$ability = array(
  'ability_name' => 'Rolling Cutter',
  'ability_token' => 'rolling-cutter',
  'ability_description' => 'The user throws a boomerang-like blade that strikes the target up to four times!',
  'ability_type' => 'cutter',
  'ability_damage' => 10,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Define the local damage amount variable and default to the base value
    $damage_amount = $this_ability->ability_damage;
    
    // Define the damage success/failure text for this attack
    $this_ability->damage_options['success_text'] = "It hit the target!";
    $this_ability->damage_options['failure_text'] = "{$this_ability->print_ability_name()} missed!";
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // Create an event to show the targeting action
    $this_robot->robot_frame = 'attack';
    $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    $event_body .= "{$this_robot->print_robot_name()} throws its {$this_ability->print_ability_name()}!";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Trigger damage to the target robot
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
    
    // If this attack returns and strikes a second time (random chance)
    if ($this_ability->ability_results['this_result'] != 'failure' && $target_robot->robot_status != 'disabled'){

      // Trigger damage to the target robot
      $this_ability->damage_options['failure_text'] = '';
      $this_ability->damage_options['success_text'] = "Oh! It hit again!";
      $damage_amount = ceil($damage_amount * 1.25);
      $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
      
      // If this attack returns and strikes a third time (random chance)
      if ($this_ability->ability_results['this_result'] != 'failure' && $target_robot->robot_energy != 'disabled'){
        
        // Trigger damage to the target robot
        $this_ability->damage_options['success_text'] = "Wow! A third hit?!?";
        $damage_amount = ceil($damage_amount * 1.25);
        $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
        
        // If this attack returns and strikes a fourth time (random chance)
        if ($this_ability->ability_results['this_result'] != 'failure' && $target_robot->robot_status != 'disabled'){
          
          // Trigger damage to the target robot
          $this_ability->damage_options['success_text'] = "One more time!";
          $damage_amount = ceil($damage_amount * 1.25);
          $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
          
        }
        
      }
    
    }
    
    // Reset this robot's frame back to base
    $this_robot->robot_frame = 'base';
    
    // Return true on success
    return true;
      
  }
  );
?>