<?
// DEFENSE BREAK
$ability = array(
  'ability_name' => 'Defense Break',
  'ability_token' => 'defense-break',
  'ability_image' => 'defense-break',
  'ability_description' => 'The user breaks the target&#39;s shields down, lowering its defense stat!',
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
    
    // Decrease the target robot's defense stat
    $this_ability->damage_options_update(array(
      'kind' => 'defense',
      'kickback' => array(10, 0, 0),
      'success' => array(0, -2, 0, -10, $target_robot->print_robot_name().'&#39;s shields were damaged!'),
      'failure' => array(0, -2, 0, -10, 'It had no effect on '.$target_robot->print_robot_name().'&hellip;')
      ));
    $defense_damage_amount = ceil($target_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );
?>