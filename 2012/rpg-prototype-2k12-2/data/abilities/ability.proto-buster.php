<?
// PROTO BUSTER
$ability = array(
  'ability_name' => 'Proto Buster',
  'ability_token' => 'proto-buster',
  'ability_image' => 'proto-buster',
  'ability_description' => 'The user fires an energy shot at the target that charges and grows more powerful with successive uses.',
  'ability_damage' => 12,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Collect the shot power counter if set, otherwise default to level one
    $shot_power = !empty($this_ability->counters['shot_power']) ? $this_ability->counters['shot_power'] : 0;
    // Reward successive uses of this ability with boosts in power
    if (!empty($this_robot->history['triggered_abilities'])){
      // Collect up to the last three triggered abilities
      $ability_history_count = count($this_robot->history['triggered_abilities']);
      if ($ability_history_count <= 3){ $recent_ability_history = $this_robot->history['triggered_abilities']; }
      else { $recent_ability_history = array_slice($this_robot->history['triggered_abilities'], -3, 3, false); }
      $recent_ability_history = array_reverse($recent_ability_history, false);
      // If this ability was used last turn, increment the base power
      if (isset($recent_ability_history[1]) && $recent_ability_history[1] == $this_ability->ability_token){ $shot_power++; }
      else { $shot_power = 1; }
    }
    // Update this ability's internal shot power counter
    $this_ability->counters['shot_power'] = $shot_power;
    
    // Update the text and animation frames
    $shot_power_text = 'A shot ';
    $shot_power_frame = 0;
    if ($shot_power == 2){ $shot_power_text = 'A powerful shot '; $shot_power_frame = 1; }
    elseif ($shot_power == 3){ $shot_power_text = 'A massive shot '; $shot_power_frame = 2; }
    
    // Update this ability's target options and trigger
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array($shot_power_frame, (85 + (20 * $shot_power)), 0, 10, $this_robot->print_robot_name().' fires the '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array((12 * $shot_power), 0, 0),
      'success' => array($shot_power_frame, (-50 - (20 * $shot_power)), 0, 10, $shot_power_text.' hit the target!'),
      'failure' => array($shot_power_frame, (-50 - (20 * $shot_power)), 0, -10, 'The '.$this_ability->print_ability_name().' shot missed&hellip;')
      ));
    $energy_damage_amount = ceil($this_ability->ability_damage * $shot_power);
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // If the shot power has reached its limit, reset
    if ($shot_power >= 3){
      unset($this_ability->counters['shot_power']);
      $this_ability->update_session();
    }
    
    // Return true on success
    return true;
      
    }
  );
?>