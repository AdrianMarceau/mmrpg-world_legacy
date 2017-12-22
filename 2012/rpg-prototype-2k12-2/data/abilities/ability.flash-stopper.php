<?
// FLASH STOPPER
$ability = array(
  'ability_name' => 'Flash Stopper',
  'ability_token' => 'flash-stopper',
  'ability_image' => 'flash-stopper',
  'ability_description' => 'The flash-freezes time around the target then quickly releases to cause temporal damage!',
  'ability_type' => 'time',
  'ability_damage' => 12,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, -10, 0, -10, $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's speed stat
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(5, 0, 0),
      'success' => array(1, -5, 0, -10, 'The '.$this_ability->print_ability_name().' freezes time around the target!'),
      'failure' => array(2, -5, 0, -10, $this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -5, 0, -10, 'The '.$this_ability->print_ability_name().' freezes time around the target!'),
      'failure' => array(2, -5, 0, -10, $this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
    
      
    }
  );
?>