<?
// DIVE TORPEDO
$ability = array(
  'ability_name' => 'Dive Torpedo',
  'ability_token' => 'dive-torpedo',
  'ability_game' => 'MM04',
  'ability_group' => 'MM04/Weapons/031',
  'ability_master' => 'dive-man',
  'ability_number' => 'DCN-031',
  'ability_description' => 'The user propells itself toward the target using a high speed jet of water to deal massive damage with a {RECOVERY2}% chance of a critical hit!',
  'ability_type' => 'missile',
  'ability_type2' => 'water',
  'ability_energy' => 8,
  'ability_damage' => 24,
  'ability_recovery2' => 20,
  'ability_accuracy' => 98,
  'ability_function' => function($objects){

    // Extract all objects into the current scope
    extract($objects);

    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 75, 0, 10, $this_robot->print_robot_name().' uses the '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);

    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -55, 0, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(1, -75, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -35, 0, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -75, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

    // Return true on success
    return true;

  }
  );
?>