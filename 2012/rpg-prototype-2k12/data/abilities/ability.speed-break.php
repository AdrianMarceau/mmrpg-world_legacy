<?
// SPEED BREAK
$ability = array(
  'ability_name' => 'Speed Break',
  'ability_token' => 'speed-break',
  'ability_description' => 'The user fires a shot that breaks the target&#39;s mobility down, lowering its speed stat!',
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'shoot';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's speed stat
    $this_ability->damage_options['damage_kind'] = 'speed';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility was damaged!';
    $this_ability->damage_options['failure_text'] = 'It had no effect on '.$target_robot->print_robot_name().'&hellip;';
    $speed_damage_amount = ceil($target_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );
?>