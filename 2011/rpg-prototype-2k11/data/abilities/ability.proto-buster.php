<?
// PROTO BUSTER
$ability = array(
  'ability_name' => 'Proto Buster',
  'ability_token' => 'proto-buster',
  'ability_description' => 'The user fires a round of three energy shots at the target using a buster cannon.',
  'ability_damage' => 10,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Reduce the critical rate for this attack to 1% (combined with not
    // having  a type, this insures it is never becomes too powerful)
    $this_ability->damage_options['critical_rate'] = 100;

    // Define the local damage amount variable and default to the base value
    $damage_amount = $this_ability->ability_damage;
    
    // Randomly calculate how many shots are fired at the target
    $number_shots = $this_battle->weighted_chance(array(1, 2, 3), array(1, 2, 3));
    $number_shots_text = 'A shot ';
    if ($number_shots == 2){ $number_shots_text = 'Two shots '; }
    elseif ($number_shots == 3){ $number_shots_text = 'All three shots '; }
    
    // Multiply the damage amount by the number of shots
    $damage_amount = $damage_amount * $number_shots;
    
    // Define the damage success/failure text for this attack
    $this_ability->damage_options['success_text'] = $number_shots_text.' hit the target!';
    $this_ability->damage_options['failure_text'] = "The {$this_ability->print_ability_name()} shots missed!";
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // If this robot has a type, use it to upgrade this ability
    if (!empty($this_robot->robot_type) && empty($this_ability->ability_type)){
      $this_robot->trigger_ability_event($target_robot, $this_ability, 'battle_start');
    }

    // Create an event to show the targeting action
    $this_robot->robot_frame = 'attack';
    $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    $event_body .= "{$this_robot->print_robot_name()} fires its {$this_ability->print_ability_name()}!";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Trigger damage to the target robot
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);

    // Return true on success
    return true;
      
    }
  );
?>