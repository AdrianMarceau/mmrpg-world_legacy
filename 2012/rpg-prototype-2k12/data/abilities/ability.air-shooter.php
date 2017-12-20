<?
// AIR SHOOTER
$ability = array(
  'ability_name' => 'Air Shooter',
  'ability_token' => 'air-shooter',
  'ability_description' => 'The user fires three whirlwinds that spread out and rise upward, hitting the target up to three times!',
  'ability_type' => 'wind',
  'ability_damage' => 10,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'shoot';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 125;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 125;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_ability->print_ability_name().' fires whirlwinds!';
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -40;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 2;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -40;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -20;
    $this_ability->damage_options['success_text'] = 'A whirlwind hit!';
    $this_ability->damage_options['failure_text'] = 'One of the whirlwinds missed!';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -40;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 2;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -40;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -20;
    $this_ability->recovery_options['success_text'] = 'A whilrwind hit!';
    $this_ability->recovery_options['failure_text'] = 'One of the whirlwinds missed!';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Ensure the target has not been disabled
    if ($target_robot->robot_status != 'disabled'){
      
      // Adjust damage/recovery text based on results
      if ($this_ability->ability_results['total_strikes'] == 1){
        $this_ability->damage_options['success_text'] = 'Another whirlwind hit!';
        $this_ability->recovery_options['success_text'] = 'Another whirlwind hit!';
      }
      if ($this_ability->ability_results['total_misses'] == 1){
        $this_ability->damage_options['failure_text'] = 'Another whirlwind missed!';
        $this_ability->recovery_options['failure_text'] = 'Another whirlwind missed!';
      }
      
      // Attempt to trigger damage to the target robot again
      $this_ability->damage_options['ability_success_frame'] = 3;
      $this_ability->damage_options['ability_success_frame_offset']['x'] = -60;
      $this_ability->damage_options['ability_failure_frame'] = 3;
      $this_ability->damage_options['ability_failure_frame_offset']['x'] = -60;
      $this_ability->recovery_options['ability_success_frame'] = 3;
      $this_ability->recovery_options['ability_success_frame_offset']['x'] = -60;
      $this_ability->recovery_options['ability_failure_frame'] = 3;
      $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -60;
      $target_robot->trigger_damage($this_robot, $this_ability,  $energy_damage_amount);
      
      // Ensure the target has not been disabled
      if ($target_robot->robot_status != 'disabled'){
        
        // Adjust damage/recovery text based on results again
        if ($this_ability->ability_results['total_strikes'] == 1){
          $this_ability->damage_options['success_text'] = 'Another whirlwind hit!';
          $this_ability->recovery_options['success_text'] = 'Another whirlwind hit!';
        }
        elseif ($this_ability->ability_results['total_strikes'] == 2){
          $this_ability->damage_options['success_text'] = 'A third whirlwind hit!';
          $this_ability->recovery_options['success_text'] = 'A third whirlwind hit!';
        }
        if ($this_ability->ability_results['total_misses'] == 1){
          $this_ability->damage_options['failure_text'] = 'Another whirlwind missed!';
          $this_ability->recovery_options['failure_text'] = 'Another whirlwind missed!';
        }
        elseif ($this_ability->ability_results['total_misses'] == 2){
          $this_ability->damage_options['failure_text'] = 'A third whirlwind missed!';
          $this_ability->recovery_options['failure_text'] = 'A third whirlwind missed!';
        }
        
        // Attempt to trigger damage to the target robot a third time
        $this_ability->damage_options['ability_success_frame'] = 1;
        $this_ability->damage_options['ability_success_frame_offset']['x'] = -80;
        $this_ability->damage_options['ability_failure_frame'] = 1;
        $this_ability->damage_options['ability_failure_frame_offset']['x'] = -80;
        $this_ability->recovery_options['ability_success_frame'] = 1;
        $this_ability->recovery_options['ability_success_frame_offset']['x'] = -80;
        $this_ability->recovery_options['ability_failure_frame'] = 1;
        $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -80;
        $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
        
      }
           
    }
    
    // Return true on success
    return true;
        
  }
  );
?>