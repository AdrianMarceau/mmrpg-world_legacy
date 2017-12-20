<?
// DEFENSE BURN
$ability = array(
  'ability_name' => 'Defense Burn',
  'ability_token' => 'defense-burn',
  'ability_description' => 'The user breaks down the target&#39;s shields using fire, lowering its defense stat!',
  'ability_damage' => 15,
  'ability_type' => 'flame',
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 85;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 85;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's defense stat
    $this_ability->damage_options['damage_kind'] = 'defense';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -50;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 10;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -75;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s shields were burned!';
    $this_ability->damage_options['failure_text'] = 'It had no effect on '.$target_robot->print_robot_name().'&hellip;';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -50;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 10;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -75;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['recovery_kind'] = 'defense';
    $this_ability->recovery_options['success_text'] = $target_robot->print_robot_name().'&#39;s shields were ignited!';
    $this_ability->recovery_options['failure_text'] = 'It had no effect on '.$target_robot->print_robot_name().'&hellip;';
    $defense_damage_amount = ceil($target_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );
?>