<?
// DEFENSE MODE
$ability = array(
  'ability_name' => 'Defense Mode',
  'ability_token' => 'defense-mode',
  'ability_description' => 'The user optimizes internal systems to raise defense, but lowers speed and attack in the process.',
  'ability_damage' => 0,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // Increase this robot's defense by 30% after charging
    $this_robot->robot_defense = $this_robot->robot_defense + ceil($this_robot->robot_base_defense * 0.30);
    // Decrease this robot's attack by 15%
    $this_robot->robot_attack = $this_robot->robot_attack - ceil($this_robot->robot_base_attack * 0.15);
    // Decrease this robot's speed by 15%
    $this_robot->robot_speed = $this_robot->robot_speed - ceil($this_robot->robot_base_speed * 0.15);
    
    // Update the ability results variable with a success flag
    $this_ability->ability_results['total_result'] = $this_ability->ability_results['this_result'] = 'success';
    
    // Create a message to show the mode switching
    $this_robot->robot_frame = 'defend';
    $event_body = "{$this_robot->print_robot_name()} enters {$this_ability->print_ability_name()}!<br />";
    $event_body .= "Optimizing internal systems&hellip;";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false, 'ability_results' => $this_ability->ability_results));

    // Create a message to show the mode effects
    $this_robot->robot_frame = 'defend';
    $event_body = "Speed and attack fell by 15%&hellip;<br />";
    $event_body .= "Defense rose by 30%!";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false, 'ability_results' => $this_ability->ability_results));
          
    
    // Reset this robot's frame back to base
    $this_robot->robot_frame = 'base';
    
    // Return true on success
    return true;
      
    }
  );
?>