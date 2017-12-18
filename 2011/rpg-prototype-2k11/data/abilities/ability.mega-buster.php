<?
// MEGA BUSTER
$ability = array(
  'ability_name' => 'Mega Buster',
  'ability_token' => 'mega-buster',
  'ability_description' => 'The user fires a round of three energy shots at the target using a buster cannon.',
  'ability_damage' => 10,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Randomly calculate how many shots are fired at the target
    $number_shots = $this_battle->weighted_chance(array(1, 2, 3), array(1, 2, 3));
    $number_shots_text = 'A shot ';
    if ($number_shots == 2){ $number_shots_text = 'Two shots '; }
    elseif ($number_shots == 3){ $number_shots_text = 'All three shots '; }
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['critical_rate'] = 0;
    $this_ability->damage_options['success_text'] = $number_shots_text.' hit the target!';
    $this_ability->damage_options['failure_text'] = 'The '.$this_ability->print_ability_name().' shots missed&hellip;';
    $energy_damage_amount = ceil($target_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );
?>