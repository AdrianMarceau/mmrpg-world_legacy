<?
// ATTACK BOOST
$ability = array(
  'ability_name' => 'Attack Boost',
  'ability_token' => 'attack-boost',
  'ability_description' => 'The user optimizes internal systems to raise its attack slightly.',
  'ability_recovery' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target this robot's self
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'summon';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Increase this robot's attack stat
    $this_ability->recovery_options['recovery_kind'] = 'attack';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $this_robot->print_robot_name().'&#39;s weapons powered up!';
    $this_ability->recovery_options['failure_text'] = $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;';
    $attack_recovery_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $attack_recovery_amount);
    
    // Return true on success
    return true;
      
  }
  );
?>