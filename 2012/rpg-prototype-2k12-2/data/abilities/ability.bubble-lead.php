<?
// BUBBLE LEAD
$ability = array(
  'ability_name' => 'Bubble Lead',
  'ability_token' => 'bubble-lead',
  'ability_image' => 'bubble-lead',
  'ability_description' => 'The user creates a super-dense bubble that rolls along the ground until it hits a target.',
  'ability_type' => 'water',
  'ability_damage' => 20,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 75, 0, 10, $this_robot->print_robot_name().' fires a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -55, 0, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(1, -75, 0, -10, 'The '.$this_ability->print_ability_name().' rolled past the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -35, 0, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -75, 0, -10, 'The '.$this_ability->print_ability_name().' rolled past the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );
?>