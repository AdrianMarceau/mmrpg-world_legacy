<?
// CRASH BOMBER
$ability = array(
  'ability_name' => 'Crash Bomber',
  'ability_token' => 'crash-bomber',
  'ability_image' => 'crash-bomber',
  'ability_description' => 'The user fires a small explosive that latches onto the target and explodes.',
  'ability_type' => 'explode',
  'ability_damage' => 15,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 85, 0, 10, $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(20, 0, 0),
      'success' => array(2, 20, 0, 10, 'The '.$this_ability->print_ability_name().' exploded on contact!'),
      'failure' => array(1, -85, -1, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(2, 20, 0, 10, 'The '.$this_ability->print_ability_name().' exploded on contact!'),
      'failure' => array(1, -85, -1, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );
?>