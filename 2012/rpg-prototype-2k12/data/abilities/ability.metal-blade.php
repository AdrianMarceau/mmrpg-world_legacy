<?
// METAL BLADE
$ability = array(
  'ability_name' => 'Metal Blade',
  'ability_token' => 'metal-blade',
  'ability_description' => 'The user throws a sharp disc-like blade at the target for massive damage.',
  'ability_type' => 'cutter',
  'ability_damage' => 25,
  'ability_accuracy' => 70,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'throw';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 65;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 65;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = 10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -65;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 2;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -65;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'The '.$this_ability->print_ability_name().' hit the target!';
    $this_ability->damage_options['failure_text'] = 'The '.$this_ability->print_ability_name().' flew past the target&hellip;';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -65;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 2;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -65;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'The '.$this_ability->print_ability_name().' hit the target!';
    $this_ability->recovery_options['failure_text'] = 'The '.$this_ability->print_ability_name().' flew past the target&hellip;';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );
?>