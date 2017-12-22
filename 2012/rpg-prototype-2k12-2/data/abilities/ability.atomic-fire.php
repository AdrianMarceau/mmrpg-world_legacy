<?
// ATOMIC FIRE
$ability = array(
  'ability_name' => 'Atomic Fire',
  'ability_token' => 'atomic-fire',
  'ability_image' => 'atomic-fire',
  'ability_description' => 'The user generates a giant ball of fire which it hurls at the target.  This ability grows more powerful with successive uses.',
  'ability_type' => 'flame',
  'ability_damage' => 10,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // If this ability is attached, remove it
    $this_attachment_backup = false;
    $this_attachment_token = 'ability_'.$this_ability->ability_token;
    $this_attachment_info = array('class' => 'ability', 'ability_id' => $this_ability->ability_id, 'ability_token' => $this_ability->ability_token);
    if (isset($this_robot->robot_attachments[$this_attachment_token])){
      $this_attachment_backup = $this_robot->robot_attachments[$this_attachment_token];
      unset($this_robot->robot_attachments[$this_attachment_token]);
      $this_robot->update_session();
    }
    
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
    $shot_power_text = 'A flare ';
    $shot_power_frame = 0;
    if ($shot_power == 2){ $shot_power_text = 'A powerful flare '; $shot_power_frame = 1; }
    elseif ($shot_power == 3){ $shot_power_text = 'A massive flare '; $shot_power_frame = 2; }
    
    // Update the ability's target options and trigger
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array($shot_power_frame, 100, 0, 10, $this_robot->print_robot_name().' throws an '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(($shot_power * 10), 0, 0),
      'success' => array($shot_power_frame, (-20 - (30 * $shot_power)), 0, 10, $shot_power_text.' hit the target!'),
      'failure' => array($shot_power_frame, (-50 - (30 * $shot_power)), 0, -10, $this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array($shot_power_frame, (-20 - (30 * $shot_power)), 0, 10, $shot_power_text.' ignited the target!'),
      'failure' => array($shot_power_frame, (-50 - (30 * $shot_power)), 0, -10, $this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = ceil($this_ability->ability_damage * $shot_power);
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // If the shot power is charging, attach this ability to the robot
    if ($shot_power < 3){
      if ($shot_power == 1){ $this_ability->attachment_frame = array(0, 1); }
      elseif ($shot_power == 2){ $this_ability->attachment_frame = array(0, 1, 2); }
      $this_robot->robot_attachments[$this_attachment_token] = $this_attachment_info;
      $this_ability->update_session();
      $this_robot->update_session();
    } else {
      unset($this_ability->counters['shot_power']);
      $this_ability->update_session();
    }
    
    // Return true on success
    return true;
      
    },
    'attachment_frame' => array(0, 1, 2),
    'attachment_frame_offset' => array('x' => -12, 'y' => -10, 'z' => -10)
  );
?>