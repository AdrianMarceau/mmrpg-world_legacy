<?
// FIRE STORM
$ability = array(
  'ability_name' => 'Fire Storm',
  'ability_token' => 'fire-storm',
  'ability_image' => 'fire-storm',
  'ability_description' => 'The user a unleashes a powerful storm of fire doing massive damage to slower targets!',
  'ability_type' => 'flame',
  'ability_damage' => 15,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 100, 0, 10, $this_robot->print_robot_name().' unleashes a '.$this_ability->print_ability_name().'!'),
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(15, 0, 0),
      'success' => array(1, -75, 0, 10, 'The '.$this_ability->print_ability_name().' chased the target!'),
      'failure' => array(1, -100, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -75, 0, 10, 'The '.$this_ability->print_ability_name().' ignited the target!'),
      'failure' => array(1, -100, 0, -10, 'The '.$this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    if ($target_robot->robot_speed > 100 || $target_robot->robot_speed < 100){
      $speed_multiplier = $target_robot->robot_speed > 0 ? $target_robot->robot_speed / 100 : 0.01;
      $energy_damage_amount = ceil($energy_damage_amount / $speed_multiplier);
    }
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
    
      
    }
  );
?>