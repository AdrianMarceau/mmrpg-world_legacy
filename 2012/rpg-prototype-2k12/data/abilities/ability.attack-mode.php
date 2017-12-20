<?
// ATTACK MODE
$ability = array(
  'ability_name' => 'Attack Mode',
  'ability_token' => 'attack-mode',
  'ability_description' => 'The user optimizes internal systems to raise attack, but lowers speed and defense in the process.',
  'ability_recovery' => 30,
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_frame_index' => array('mugshot', 'base', 'defense', 'speed', 'attack'),
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
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's defense stat
    $this_ability->damage_options['damage_kind'] = 'defense';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s shields powered down&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;';
    $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Decrease this robot's speed stat
    $this_ability->damage_options['damage_kind'] = 'speed';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s mobility slowed&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;';
    $speed_damage_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Increase this robot's attack stat
    $this_ability->recovery_options['recovery_kind'] = 'attack';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -6;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -6;
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