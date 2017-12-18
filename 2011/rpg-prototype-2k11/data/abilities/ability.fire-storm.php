<?
// FIRE STORM
$ability = array(
  'ability_name' => 'Fire Storm',
  'ability_token' => 'fire-storm',
  'ability_description' => 'The user a unleashes a powerful storm of fire at the target! Slower opponents take more damage.',
  'ability_type' => 'flame',
  'ability_damage' => 25,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Define the local damage amount variable and default to the base value
    $damage_amount = $this_ability->ability_damage;
    
    // If the target's speed is modified, recalculate the base damage amount
    if ($target_robot->robot_speed > 100 || $target_robot->robot_speed < 100){
      $damage_amount = ceil($damage_amount / ($target_robot->robot_speed / 100));
    }
    
    // Define the damage success/failure text for this attack
    $this_ability->damage_options['success_text'] = "Flames engulfed the target!";
    $this_ability->damage_options['failure_text'] = "{$this_ability->print_ability_name()} missed!";
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // Create an event to show the targeting action
    $this_robot->robot_frame = 'attack';
    $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    $event_body .= "{$this_robot->print_robot_name()} unleashes a {$this_ability->print_ability_name()}!";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Trigger damage to the target robot
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
    
    // Reset this robot's frame back to base
    $this_robot->robot_frame = 'base';
    
    // Return true on success
    return true;
      
    }
  );
?>