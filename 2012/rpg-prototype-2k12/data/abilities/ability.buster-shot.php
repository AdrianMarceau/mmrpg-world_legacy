<?
// BUSTER SHOT
$ability = array(
  'ability_name' => 'Buster Shot',
  'ability_token' => 'buster-shot',
  'ability_description' => 'The user fires an energy shot at the target that charges and grows more powerful with successive uses.',
  'ability_damage' => 10,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Collect the shot power counter if set, otherwise default to level one
    $shot_power = !empty($this_ability->counters['shot_power']) ? $this_ability->counters['shot_power'] : 1;
    // Reward successive uses of this ability with boosts in power
    if (!empty($this_robot->history['triggered_abilities'])){
      // Collect this robot's ability history, excluding this one
      $ability_history = array_slice($this_robot->history['triggered_abilities'], 0, -1, true);
      $ability_history_count = count($ability_history);
      // If this ability was used last turn, increase the power by 1
      if ($shot_power < 3 && $ability_history[$ability_history_count - 1] == $this_ability->ability_token){ $shot_power += 1; }
      // Otherwise, if shot power was over its limit or not used last, reset back to 1
      else { $shot_power = 1; }
    }
    // Update this ability's internal shot power counter
    $this_ability->counters['shot_power'] = $shot_power;
    
    // Update the text and animation frames
    $shot_power_text = 'A shot ';
    $shot_power_frame = 1;
    if ($shot_power == 2){ $shot_power_text = 'A powerful shot '; $shot_power_frame = 2; }
    elseif ($shot_power == 3){ $shot_power_text = 'A massive shot '; $shot_power_frame = 3; }
    //$shot_power_text .= ' ['.$shot_power.'] ';
    
    
    //$shot_power_text .= 'testing '.$shot_power.' : <br/><pre>'.preg_replace('#\s+#', ' ', print_r($ability_history, true)).'</pre>';
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = $shot_power_frame;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 85 + (20 * $shot_power);
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = $shot_power_frame;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 85 + (20 * $shot_power);
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = $shot_power_frame;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -50 - (20 * $shot_power);
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = $shot_power_frame;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -50 - (20 * $shot_power);
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['critical_rate'] = 0;
    $this_ability->damage_options['success_text'] = $shot_power_text.' hit the target!';
    $this_ability->damage_options['failure_text'] = 'The '.$this_ability->print_ability_name().' shot missed&hellip;';
    $energy_damage_amount = ceil($this_ability->ability_damage * $shot_power);
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );
?>