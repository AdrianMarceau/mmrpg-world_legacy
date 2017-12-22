<?
// OIL SLIDER
$ability = array(
  'ability_name' => 'Oil Slider',
  'ability_token' => 'oil-slider',
  'ability_image' => 'oil-slider',
  'ability_description' => 'The user slides toward the target at blinding speed on a wave of crude oil!',
  'ability_type' => 'earth',
  'ability_speed' => 2,
  'ability_damage' => 10,
  'ability_accuracy' => 85,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'slide',
      'success' => array(0, 15, -10, -10, $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(5, 0, 0),
      'success' => array(1, -65, -10, 10, 'The '.$this_ability->print_ability_name().' crashes into the target!'),
      'failure' => array(0, -85, 15, -10, 'The '.$this_ability->print_ability_name().' continued past the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -35, -10, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -65, 15, -10, 'The '.$this_ability->print_ability_name().' continued past the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );
?>