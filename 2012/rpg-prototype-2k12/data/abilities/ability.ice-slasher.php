<?
// ICE SLASHERs
$ability = array(
  'ability_name' => 'Ice Slasher',
  'ability_token' => 'ice-slasher',
  'ability_description' => 'The user fires a blast of super-chilled air at the target, doing damage and occasionally lowering speed!!',
  'ability_type' => 'freeze',
  'ability_damage' => 20,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 110;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 110;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -90;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -100;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'The '.$this_ability->print_ability_name().' cut into the target!';
    $this_ability->damage_options['failure_text'] = 'The '.$this_ability->print_ability_name().' missed&hellip;';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -90;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -100;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'The '.$this_ability->print_ability_name().' was absorbed by the target!';
    $this_ability->recovery_options['failure_text'] = 'The '.$this_ability->print_ability_name().' had no effect&hellip;';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Randomly inflict a speed break on critical chance 30%
    if ($target_robot->robot_status != 'disabled'
      && $this_battle->critical_chance(30)){
      // Decrease the target robot's speed stat
      $this_ability->damage_options['damage_kind'] = 'speed';
      $this_ability->damage_options['ability_success_frame'] = 1;
      $this_ability->damage_options['ability_success_frame_offset']['x'] = -125;
      $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
      $this_ability->damage_options['ability_failure_frame'] = 1;
      $this_ability->damage_options['ability_failure_frame_offset']['x'] = -125;
      $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility was damaged!';
      $this_ability->damage_options['failure_text'] = '';
      $this_ability->recovery_options['damage_kind'] = 'speed';
      $this_ability->recovery_options['ability_success_frame'] = 1;
      $this_ability->recovery_options['ability_success_frame_offset']['x'] = -125;
      $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
      $this_ability->recovery_options['ability_failure_frame'] = 1;
      $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -125;
      $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->recovery_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility improved!';
      $this_ability->recovery_options['failure_text'] = '';
      $speed_damage_amount = ceil($target_robot->robot_base_speed * (($this_ability->ability_damage / 2) / 100));
      $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    }
    
    // Return true on success
    return true;
    
      
    }
  );
?>