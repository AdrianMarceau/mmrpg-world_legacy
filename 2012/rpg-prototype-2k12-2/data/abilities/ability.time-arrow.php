<?
// TIME ARROW
$ability = array(
  'ability_name' => 'Time Arrow',
  'ability_token' => 'time-arrow',
  'ability_image' => 'time-arrow',
  'ability_description' => 'The user directs a mysterious arrow at the target, dealing damage and lowering speed!',
  'ability_type' => 'time',
  'ability_damage' => 10,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(1, 125, 0, 10, $this_robot->print_robot_name().' fires an '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -125, 0, 10, 'The '.$this_ability->print_ability_name().' sliced into the target!'),
      'failure' => array(1, -150, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -60, 0, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -90, 0, -10, 'The '.$this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Inflect a break on speed if the robot wasn't disabled
    if ($target_robot->robot_status != 'disabled'
      && $target_robot->robot_speed > 0
      && $this_ability->ability_results['this_result'] != 'failure'){
      // Decrease the target robot's speed stat
      $this_ability->damage_options_update(array(
        'kind' => 'speed',
        'frame' => 'defend',
        'kickback' => array(10, 0, 0),
        'success' => array(2, -15, 10, -10, $target_robot->print_robot_name().'&#39;s speed was lowered!'),
        'failure' => array(2, 0, 0, -9999, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'speed',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(2, -15, 10, -10, $target_robot->print_robot_name().'&#39;s speed was increased!'),
        'failure' => array(2, 0, 0, -9999, '')
        ));
      $speed_damage_amount = ceil($target_robot->robot_base_speed * (($this_ability->ability_damage / 5) / 100));
      $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    }
    
    // Return true on success
    return true;
    
      
    }
  );
?>