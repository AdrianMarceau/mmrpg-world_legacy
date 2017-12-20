<?
// BUBBLE LEAD
$ability = array(
  'ability_name' => 'Bubble Lead',
  'ability_token' => 'bubble-lead',
  'ability_description' => 'The user creates a super-dense bubble that rolls along the ground until it hits a target.',
  'ability_type' => 'water',
  'ability_damage' => 20,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'shoot';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 75;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 75;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = 10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' fires a '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -75;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 2;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -75;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'The '.$this_ability->print_ability_name().' hit the target!';
    $this_ability->damage_options['failure_text'] = 'The '.$this_ability->print_ability_name().' rolled past the target&hellip;';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -75;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 2;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -75;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'The '.$this_ability->print_ability_name().' hit the target!';
    $this_ability->recovery_options['failure_text'] = 'The '.$this_ability->print_ability_name().' rolled past the target&hellip;';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );
?>