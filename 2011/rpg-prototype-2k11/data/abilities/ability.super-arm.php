<?
// SUPER ARM
$ability = array(
  'ability_name' => 'Super Arm',
  'ability_token' => 'super-arm',
  'ability_description' => 'The user finds a nearby heavy object and hurls it at the target.',
  'ability_type' => 'impact',
  'ability_damage' => 30,
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
    
    // Collect the current field type if there is one
    if (isset($this_battle->battle_field['field_type'])){ $temp_field_type = $this_battle->battle_field['field_type']; }
    else { $temp_field_type = ''; }
    
    // Create an event to show the targeting action
    $this_robot->robot_frame = 'attack';
    $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    $event_body .= "{$this_ability->print_ability_name()} ";
    switch ($temp_field_type){
      case 'cold': { $event_body .= "hurls a large snowball "; break; }
      case 'earth': { $event_body .= "hurls a large boulder "; break; }
      default: { $event_body .= "throws some debris "; break; }
    }
    $event_body .= "!";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Trigger damage to the target robot
    switch ($temp_field_type){
      case 'cold': { $this_ability->damage_options['success_text'] = 'The snowball hit!'; break; }
      case 'earth': { $this_ability->damage_options['success_text'] = 'The boulder hit!'; break; }
      default: { $this_ability->damage_options['success_text'] = 'The debris hit!'; break; }
    }
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);
    
    // Reset this robot's frame back to base
    $this_robot->robot_frame = 'base';
    
    // Return true on success
    return true;
      
  }
  );
?>