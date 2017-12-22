<?
// DEFENSE BOOST
$ability = array(
  'ability_name' => 'Defense Boost',
  'ability_token' => 'defense-boost',
  'ability_image' => 'defense-boost',
  'ability_description' => 'The user optimizes internal systems to raise its defense slightly.',
  'ability_recovery' => 15,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target this robot's self
    $this_ability->target_options_update(array(
      'frame' => 'summon',
      'success' => array(0, 0, 0, -10, $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Increase this robot's defense stat
    $this_ability->recovery_options_update(array(
      'kind' => 'defense',
      'frame' => 'taunt',
      'success' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s shields powered up!'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
      ));
    $defense_recovery_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $defense_recovery_amount);
    
    // Return true on success
    return true;
      
  }
  );
?>