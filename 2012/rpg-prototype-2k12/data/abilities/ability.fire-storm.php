<?
// FIRE STORM
$ability = array(
  'ability_name' => 'Fire Storm',
  'ability_token' => 'fire-storm',
  'ability_description' => 'The user a unleashes a powerful storm of fire doing massive damage to slower targets!',
  'ability_type' => 'flame',
  'ability_damage' => 15,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 100;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 100;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -75;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -100;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'Flames chased the target!';
    $this_ability->damage_options['failure_text'] = $this_ability->print_ability_name().' missed&hellip;';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -75;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -100;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'Flames chased the target!';
    $this_ability->recovery_options['failure_text'] = $this_ability->print_ability_name().' had no effect&hellip;';
    $energy_damage_amount = $this_ability->ability_damage;
    if ($target_robot->robot_speed > 100 || $target_robot->robot_speed < 100){
      $speed_multiplier = $target_robot->robot_speed > 0 ? $target_robot->robot_speed / 100 : 0.01;
      $energy_damage_amount = ceil($energy_damage_amount / $speed_multiplier);
    }
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
    
      
    }
  );
?>