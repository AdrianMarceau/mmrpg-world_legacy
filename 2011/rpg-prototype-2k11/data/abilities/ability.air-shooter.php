<?
// AIR SHOOTER
$ability = array(
  'ability_name' => 'Air Shooter',
  'ability_token' => 'air-shooter',
  'ability_description' => 'The user fires three whirlwinds that spread out and rise upward, hitting the target up to three times!',
  'ability_type' => 'wind',
  'ability_damage' => 15,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Define the local damage amount variable and default to the base value
    $damage_amount = $this_ability->ability_damage;
    
    // Define the damage success/failure text for this attack
    $this_ability->damage_options['success_text'] = 'A whirlwind hit!';
    $this_ability->damage_options['failure_text'] = 'One of the whirlwinds missed!';
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // Create an event to show the targeting action
    $this_robot->robot_frame = 'attack';
    $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    $event_body .= "{$this_ability->print_ability_name()} fires whirlwinds!";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Trigger damage to the target robot
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
    
    // Trigger damage to the target robot
    if ($this_ability->ability_results['total_strikes'] == 1){ $this_ability->damage_options['success_text'] = 'Another whirlwind hit!'; }
    if ($this_ability->ability_results['total_misses'] == 1){ $this_ability->damage_options['failure_text'] = 'Another whirlwind missed!'; }
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
    
    // Trigger damage to the target robot
    if ($this_ability->ability_results['total_strikes'] == 1){ $this_ability->damage_options['success_text'] = 'Another whirlwind hit!'; }
    elseif ($this_ability->ability_results['total_strikes'] == 2){ $this_ability->damage_options['success_text'] = 'A third whirlwind hit!'; }
    if ($this_ability->ability_results['total_misses'] == 1){ $this_ability->damage_options['failure_text'] = 'Another whirlwind missed!'; }
    elseif ($this_ability->ability_results['total_misses'] == 2){ $this_ability->damage_options['failure_text'] = 'A third whirlwind missed!'; }
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);

    // Reset this robot's frame back to base
    $this_robot->robot_frame = 'base';
    
    // Return true on success
    return true;
      
  }
  );
?>