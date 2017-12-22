<?
// ICE SLASHER
$ability = array(
  'ability_name' => 'Ice Slasher',
  'ability_token' => 'ice-slasher',
  'ability_image' => 'ice-slasher',
  'ability_description' => 'The user fires a blast of super-chilled air at the target, doing damage and occasionally lowering speed!',
  'ability_type' => 'freeze',
  'ability_damage' => 16,
  'ability_accuracy' => 85,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(1, 110, 0, 10, $this_robot->print_robot_name().' fires an '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -90, 0, 10, 'The '.$this_ability->print_ability_name().' cut into the target!'),
      'failure' => array(1, -100, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -45, 0, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -100, 0, -10, 'The '.$this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Randomly inflict a speed break on critical chance 50%
    if ($target_robot->robot_status != 'disabled'
      && $target_robot->robot_speed > 0
      && $this_ability->ability_results['this_result'] != 'failure'
      && $this_battle->critical_chance(50)){
      // Decrease the target robot's speed stat
      $this_ability->damage_options_update(array(
        'kind' => 'speed',
        'frame' => 'defend',
        'kickback' => array(10, 0, 0),
        'success' => array(2, 0, -6, 10, $target_robot->print_robot_name().'&#39;s mobility was damaged!'),
        'failure' => array(2, 0, -6, -10, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'speed',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(2, 0, -6, 10, $target_robot->print_robot_name().'&#39;s mobility improved!'),
        'failure' => array(2, 0, -6, -9999, '')
        ));
      $speed_damage_amount = ceil($target_robot->robot_base_speed * (($this_ability->ability_damage / 4) / 100));
      $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    }
    
    // Return true on success
    return true;
    
      
    }
  );
?>