<?
// TIME STOPPER
$ability = array(
  'ability_name' => 'Time Stopper',
  'ability_token' => 'time-stopper',
  'ability_description' => 'The user briefly freezes time around the target, greatly reducing the it\'s speed.  This ability may also cause damage to certain opponents...',
  'ability_type' => 'time',
  'ability_damage' => 20,
  'ability_accuracy' => 80,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = -10;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = -10;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's speed stat
    $this_ability->damage_options['damage_kind'] = 'speed';
    $this_ability->damage_options['ability_success_frame'] = 3;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -5;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 4;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -5;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility was slowed&hellip;';
    $this_ability->damage_options['failure_text'] = $this_ability->print_ability_name().' had no effect&hellip;';
    $this_ability->recovery_options['damage_kind'] = 'speed';
    $this_ability->recovery_options['ability_success_frame'] = 3;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -5;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 4;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -5;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility improved!';
    $this_ability->recovery_options['failure_text'] = $this_ability->print_ability_name().' had no effect&hellip;';
    $speed_damage_amount = ceil($target_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Randomly inflict a speed break on critical chance 30%
    if ($target_robot->has_weakness($this_ability->ability_type)){
        
      // Inflict damage on the opposing robot
      $this_ability->damage_options['damage_kind'] = 'energy';
      $this_ability->damage_options['ability_success_frame'] = 2;
      $this_ability->damage_options['ability_success_frame_offset']['x'] = 0;
      $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
      $this_ability->damage_options['ability_failure_frame'] = 4;
      $this_ability->damage_options['ability_failure_frame_offset']['x'] = 0;
      $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->damage_options['success_text'] = 'It damaged the target!';
      $this_ability->damage_options['failure_text'] = '';
      $this_ability->recovery_options['recovery_kind'] = 'energy';
      $this_ability->recovery_options['ability_success_frame'] = 2;
      $this_ability->recovery_options['ability_success_frame_offset']['x'] = 0;
      $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
      $this_ability->recovery_options['ability_failure_frame'] = 4;
      $this_ability->recovery_options['ability_failure_frame_offset']['x'] = 0;
      $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->recovery_options['success_text'] = 'It was absorbed by the target!';
      $this_ability->recovery_options['failure_text'] = '';
      $energy_damage_amount = $this_ability->ability_damage;
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
             
    }
    
    // Return true on success
    return true;
    
      
    }
  );
?>