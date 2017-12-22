<?
// ATTACK BREAK
$ability = array(
  'ability_name' => 'Attack Break',
  'ability_token' => 'attack-break',
  'ability_image' => 'attack-break',
  'ability_description' => 'The user breaks the target&#39;s weapons down, lowering its attack stat!',
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'summon',
      'success' => array(0, -2, 0, -10, $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's attack stat
    $this_ability->damage_options_update(array(
      'kind' => 'attack',
      'kickback' => array(10, 0, 0),
      'success' => array(0, -2, 0, -10, $target_robot->print_robot_name().'&#39;s weapons were damaged!'),
      'failure' => array(0, -2, 0, -10, 'It had no effect on '.$target_robot->print_robot_name().'&hellip;')
      ));
    $attack_damage_amount = ceil($target_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Return true on success
    return true;
      
  }
  );
?>