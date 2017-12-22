<?
// THUNDER BEAM
$ability = array(
  'ability_name' => 'Thunder Beam',
  'ability_token' => 'thunder-beam',
  'ability_image' => 'thunder-beam',
  'ability_description' => 'The user throws a powerful bolt of electricity at the target for massive damage.',
  'ability_type' => 'electric',
  'ability_damage' => 18,
  'ability_accuracy' => 65,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(0, 95, 0, 10, $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(15, 0, 0),
      'success' => array(1, -65, 0, 10, 'The '.$this_ability->print_ability_name().' zapped the target!'),
      'failure' => array(1, -95, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -65, 0, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -95, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );
?>