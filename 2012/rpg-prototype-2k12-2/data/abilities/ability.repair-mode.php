<?
// REPAIR MODE
$ability = array(
  'ability_name' => 'Repair Mode',
  'ability_token' => 'repair-mode',
  'ability_image' => 'repair-mode',
  'ability_description' => 'The user repairs itself and restores energy using the power from its weapon, shield, and mobility systems.',
  'ability_recovery' => 30,
  'ability_damage' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options_update(array(
      'frame' => 'summon',
      'success' => array(0, 0, 0, -10, $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's attack stat
    $this_ability->damage_options_update(array(
      'kind' => 'attack',
      'frame' => 'defend',
      'success' => array(0, -2, 0, -10,  $this_robot->print_robot_name().'&#39;s weapons powered down&hellip;'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;')
      ));
    $attack_damage_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Decrease this robot's defense stat
    $this_ability->damage_options_update(array(
      'kind' => 'defense',
      'frame' => 'defend',
      'success' => array(0, -4, 0, -10,  $this_robot->print_robot_name().'&#39;s shields powered down&hellip;'),
      'failure' => array(0, -4, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
      ));
    $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Decrease this robot's speed stat
    $this_ability->damage_options_update(array(
      'kind' => 'speed',
      'frame' => 'defend',
      'success' => array(0, -6, 0, -10,  $this_robot->print_robot_name().'&#39;s mobility slowed&hellip;'),
      'failure' => array(0, -6, 0, -10, $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;')
      ));
    $speed_damage_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Increase this robot's energy stat
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'success' => array(0, -8, 0, -10,  $this_robot->print_robot_name().' recovered energy!'),
      'failure' => array(0, -8, 0, -10, $this_robot->print_robot_name().'&#39;s energy was not effected&hellip;')
      ));
    $energy_recovery_amount = ceil($this_robot->robot_base_energy * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $energy_recovery_amount);
        
    // Return true on success
    return true;
      
  }
  );
?>