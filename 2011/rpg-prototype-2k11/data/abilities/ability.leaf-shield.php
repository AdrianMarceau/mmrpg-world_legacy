<?
// LEAF SHIELD
$ability = array(
  'ability_name' => 'Leaf Shield',
  'ability_token' => 'leaf-shield',
  'ability_description' => 'The user surrounds itself with leaves to raise defense, which can be thrown at the target for moderate damage.',
  'ability_type' => 'nature',
  'ability_damage' => 30,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Define the damage variable and default to the base value
    $damage_amount = $this_ability->ability_damage;
    
    // Define the damage success/failure text for this attack
    $this_ability->damage_options['success_text'] = "The shield hit the target!";
    $this_ability->damage_options['failure_text'] = "The {$this_ability->print_ability_name()} missed!";
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // If this is the first time using the attack, start active
    if (!isset($this_ability->flags['active']) || $this_ability->flags['active'] == false){
      
      // Update the ability active flag to true
      $this_ability->flags['active'] = true;
      
      // Increase this robot's defense by 50% on first use
      $this_robot->robot_defense = $this_robot->robot_defense + ceil($this_robot->robot_base_defense * 0.50);
      
      // Create a message to show the active
      $this_robot->robot_frame = 'defend';
      $event_body = "{$this_robot->print_robot_name()} activates its {$this_ability->print_ability_name()}!<br />";
      $event_body .= "{$this_robot->print_robot_name()}&#39;s defense rose by 50%!";
      $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false, 'ability_results' => $this_ability->ability_results));
      
    }
    // Otherwise, unleash the charged attack at the target
    else {
      
      // Update the ability active flag to false
      $this_ability->flags['active'] = false;
      
      // Create an event to show the targeting action
      $this_robot->robot_frame = 'attack';
      $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
      $event_body .= "{$this_robot->print_robot_name()} throws its {$this_ability->print_ability_name()}!";
      $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
      
      // Trigger damage to the target robot
      $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
      
      // Drop this robots defense back down 50% after throwing the shield
      $this_robot->robot_defense = $this_robot->robot_defense - ceil($this_robot->robot_base_defense * 0.50);
      
      // Create a message to show the defense falling
      $this_robot->robot_frame = 'defend';
      $event_body = "{$this_ability->print_ability_name()}&#39;s protection was lost!<br />";
      $event_body .= "{$this_robot->print_robot_name()}&#39;s defense fell by 50%!";
      $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false, 'ability_results' => $this_ability->ability_results));
      
    }
    
    // Reset this robot's frame back to base
    $this_robot->robot_frame = 'base';
    
    // Return true on success
    return true;
      
    }
  );
?>