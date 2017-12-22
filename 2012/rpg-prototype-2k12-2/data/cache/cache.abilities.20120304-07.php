<?
// ABILITY
$mmrpg_index['abilities']['ability'] = array(
  'ability_name' => 'Ability',
  'ability_token' => 'ability',
  'ability_image' => 'ability',
  'ability_description' => 'The default ability object.',
  'ability_type' => '',
  'ability_damage' => 0,
  'ability_accuracy' => 0,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Generate an event to show nothing happened
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    $event_body = 'Nothing happened&hellip;';
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Return true on success
    return true;
      
  }
  );// AIR SHOOTER
$mmrpg_index['abilities']['air-shooter'] = array(
  'ability_name' => 'Air Shooter',
  'ability_token' => 'air-shooter',
  'ability_image' => 'air-shooter',
  'ability_description' => 'The user fires three whirlwinds that spread out and rise upward, hitting the target up to three times!',
  'ability_type' => 'wind',
  'ability_damage' => 6,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Attach three whirlwind attachments to the robot
    $this_attachment_token = 'ability_'.$this_ability->ability_token;
    $this_attachment_info = array('class' => 'ability', 'ability_id' => $this_ability->ability_id, 'ability_token' => $this_ability->ability_token, 'ability_frame' => 0, 'animate_frames' => array(1, 2));
    $this_robot->robot_attachments[$this_attachment_token.'_1'] = $this_attachment_info;
    $this_robot->robot_attachments[$this_attachment_token.'_2'] = $this_attachment_info;
    $this_robot->robot_attachments[$this_attachment_token.'_1']['ability_frame_offset'] = array('x' => 75, 'y' => -25, 'z' => 10);
    $this_robot->robot_attachments[$this_attachment_token.'_2']['ability_frame_offset'] = array('x' => 95, 'y' => 25, 'z' => 10);
    $this_robot->update_session();
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 115, -25, 10, $this_ability->print_ability_name().' fires whirlwinds!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Update the two whirlwind's animation frames
    $this_robot->robot_attachments[$this_attachment_token.'_1']['ability_frame'] = 1;
    $this_robot->robot_attachments[$this_attachment_token.'_2']['ability_frame'] = 1;
    $this_robot->update_session();
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(5, 0, 0),
      'success' => array(1, -80, -25, 10, 'A whirlwind hit!'),
      'failure' => array(1, -100, -25, -10, 'One of the whirlwinds missed!')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -80, -25, 10, 'A whilrwind hit!'),
      'failure' => array(1, -100, -25, -10, 'One of the whirlwinds missed!')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Ensure the target has not been disabled
    if ($target_robot->robot_status != 'disabled'){
      
      // Define the success/failure text variables
      $success_text = '';
      $failure_text = '';
      
      // Adjust damage/recovery text based on results
      if ($this_ability->ability_results['total_strikes'] == 1){ $success_text = 'Another whirlwind hit!'; }
      if ($this_ability->ability_results['total_misses'] == 1){ $failure_text = 'Another whirlwind missed!'; }
      
      // Remove the second extra whirlwind attached to the robot
      if (isset($this_robot->robot_attachments[$this_attachment_token.'_2'])){
        unset($this_robot->robot_attachments[$this_attachment_token.'_2']);
        $this_robot->update_session();
      }
      
      // Update the remaining whirlwind's animation frame
      $this_robot->robot_attachments[$this_attachment_token.'_1']['ability_frame'] = 2;
      $this_robot->update_session();
      
      // Attempt to trigger damage to the target robot again
      $this_ability->damage_options_update(array(
        'kind' => 'energy',
        'kickback' => array(10, 0, 0),
        'success' => array(2, -40, 25, 10, $success_text),
        'failure' => array(2, -60, 25, -10, $failure_text)
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'energy',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(2, -40, 25, 10, $success_text),
        'failure' => array(2, -60, 25, -10, $failure_text)
        ));
      $target_robot->trigger_damage($this_robot, $this_ability,  $energy_damage_amount);
      
      // Ensure the target has not been disabled
      if ($target_robot->robot_status != 'disabled'){
        
        // Adjust damage/recovery text based on results again
        if ($this_ability->ability_results['total_strikes'] == 1){ $success_text = 'Another whirlwind hit!'; }
        elseif ($this_ability->ability_results['total_strikes'] == 2){ $success_text = 'A third whirlwind hit!'; }
        if ($this_ability->ability_results['total_misses'] == 1){ $failure_text = 'Another whirlwind missed!'; }
        elseif ($this_ability->ability_results['total_misses'] == 2){ $failure_text = 'A third whirlwind missed!'; }
        
        // Remove the first extra whirlwind
        if (isset($this_robot->robot_attachments[$this_attachment_token.'_1'])){
          unset($this_robot->robot_attachments[$this_attachment_token.'_1']);
          $this_robot->update_session();
        }
        
        // Attempt to trigger damage to the target robot a third time
        $this_ability->damage_options_update(array(
          'kind' => 'energy',
          'kickback' => array(15, 0, 0),
          'success' => array(1, -70, -25, 10, $success_text),
          'failure' => array(1, -90, -25, -10, $failure_text)
          ));
        $this_ability->recovery_options_update(array(
          'kind' => 'energy',
          'frame' => 'taunt',
          'kickback' => array(0, 0, 0),
          'success' => array(1, -70, -25, 10, $success_text),
          'failure' => array(1, -90, -25, -10, $failure_text)
          ));
        $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
        
      }
           
    }
    
    // Remove the second whirlwind
    if (isset($this_robot->robot_attachments[$this_attachment_token.'_2'])){
      unset($this_robot->robot_attachments[$this_attachment_token.'_2']);
      $this_robot->update_session();
    }
    
    // Remove the third whirlwind
    if (isset($this_robot->robot_attachments[$this_attachment_token.'_1'])){
      unset($this_robot->robot_attachments[$this_attachment_token.'_1']);
      $this_robot->update_session();
    }
    
    // Return true on success
    return true;
        
  },
  'attachment_frame' => array(1, 2),
  'attachment_frame_offset' => array('x' => 0, 'y' => 0, 'z' => 0)
  );// ATOMIC FIRE
$mmrpg_index['abilities']['atomic-fire'] = array(
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
  );// ATTACK BOOST
$mmrpg_index['abilities']['attack-boost'] = array(
  'ability_name' => 'Attack Boost',
  'ability_token' => 'attack-boost',
  'ability_image' => 'attack-boost',
  'ability_description' => 'The user optimizes internal systems to raise its attack slightly.',
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
    
    // Increase this robot's attack stat
    $this_ability->recovery_options_update(array(
      'kind' => 'attack',
      'frame' => 'taunt',
      'success' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s weapons powered up!'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;')
      ));
    $attack_recovery_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $attack_recovery_amount);
    
    // Return true on success
    return true;
      
  }
  );// ATTACK BREAK
$mmrpg_index['abilities']['attack-break'] = array(
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
  );// ATTACK MODE
$mmrpg_index['abilities']['attack-mode'] = array(
  'ability_name' => 'Attack Mode',
  'ability_token' => 'attack-mode',
  'ability_image' => 'attack-mode',
  'ability_description' => 'The user optimizes internal systems to raise attack, but lowers speed and defense in the process.',
  'ability_recovery' => 30,
  'ability_damage' => 10,
  'ability_accuracy' => 100,
  'ability_frame_index' => array('mugshot', 'base', 'defense', 'speed', 'attack'),
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options_update(array(
      'frame' => 'summon',
      'success' => array(0, 0, 0, -10, $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's defense stat
    $this_ability->damage_options_update(array(
      'kind' => 'defense',
      'frame' => 'defend',
      'success' => array(0, -2, 0, -10,  $this_robot->print_robot_name().'&#39;s shields powered down&hellip;'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
      ));
    $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Decrease this robot's speed stat
    $this_ability->damage_options_update(array(
      'kind' => 'speed',
      'frame' => 'defend',
      'success' => array(1, -4, 0, -10,  $this_robot->print_robot_name().'&#39;s mobility slowed&hellip;'),
      'failure' => array(1, -4, 0, -10, $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;')
      ));
    $speed_damage_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Increase this robot's attack stat
    $this_ability->recovery_options_update(array(
      'kind' => 'attack',
      'frame' => 'taunt',
      'success' => array(1, -6, 0, -10,  $this_robot->print_robot_name().'&#39;s weapons powered up&hellip;'),
      'failure' => array(1, -6, 0, -10, $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;')
      ));
    $attack_recovery_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $attack_recovery_amount);
        
    // Return true on success
    return true;
      
  }
  );// BUBBLE BOMB
$mmrpg_index['abilities']['bubble-bomb'] = array(
  'ability_name' => 'Bubble Bomb',
  'ability_token' => 'bubble-bomb',
  'ability_image' => 'bubble-bomb',
  'ability_description' => 'The user throws a large bobble at the target that explodes on contact and for massive damage.',
  'ability_type' => 'water',
  'ability_damage' => 20,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // If this ability is attached, remove it
    $this_attachment_backup = false;
    $this_attachment_token = 'ability_'.$this_ability->ability_token;
    if (isset($this_robot->robot_attachments[$this_attachment_token])){
      $this_attachment_backup = $this_robot->robot_attachments[$this_attachment_token];
      unset($this_robot->robot_attachments[$this_attachment_token]);
      $this_robot->update_session();
    }
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(0, 85, 35, 10, $this_robot->print_robot_name().' thows a '.$this_ability->print_ability_name().'!'),
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(0, 0, 0),
      'success' => array(2, -10, -10, 10, 'The '.$this_ability->print_ability_name().' burst on contact!'),
      'failure' => array(1, -65, -10, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(2, -10, -10, 10, 'The '.$this_ability->print_ability_name().' burst on contact!'),
      'failure' => array(1, -65, -10, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Randomly inflict a speed break on critical chance 30%
    if ($target_robot->robot_status != 'disabled'
      && $this_ability->ability_results['this_result'] != 'failure'
      && $this_battle->critical_chance(99)){
      // Decrease the target robot's speed stat
      $this_ability->damage_options_update(array(
        'kind' => 'attack',
        'frame' => 'defend',
        'kickback' => array(0, 0, 0),
        'success' => array(1, -10, -10, -10, $target_robot->print_robot_name().'&#39;s weapons were damaged!'),
        'failure' => array(1, -65, -10, -10, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'attack',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(1, -10, -10, -10, $target_robot->print_robot_name().'&#39;s weapons improved!'),
        'failure' => array(1, -65, -10, -9999, '')
        ));
      $attack_damage_amount = ceil($target_robot->robot_base_attack * (($this_ability->ability_damage / 2) / 100));
      $target_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    }
    
    // If there was a removed attachment, put it back
    if (!empty($this_attachment_backup)){
      $this_robot->robot_attachments[$this_attachment_token] = $this_attachment_backup;
      $this_robot->update_session();
    }
    
    // Return true on success
    return true;
        
  },
  'attachment_frame' => array(1),
  'attachment_frame_offset' => array('x' => -55, 'y' => 1, 'z' => -10)
  );// BUBBLE LEAD
$mmrpg_index['abilities']['bubble-lead'] = array(
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
  );// BUSTER SHOT
$mmrpg_index['abilities']['buster-shot'] = array(
  'ability_name' => 'Buster Shot',
  'ability_token' => 'buster-shot',
  'ability_image' => 'buster-shot',
  'ability_description' => 'The user fires an energy shot at the target that charges and grows more powerful with successive uses.',
  'ability_damage' => 8,
  'ability_accuracy' => 94,
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
    
    // Update the ability's target options and trigger
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array($shot_power_frame, (85 + (20 * $shot_power)), 0, 10, $this_robot->print_robot_name().' fires a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array((10 * $shot_power), 0, 0),
      'success' => array($shot_power_frame, (-50 - (20 * $shot_power)), 0, 10, $shot_power_text.' hit the target!'),
      'failure' => array($shot_power_frame, (-50 - (20 * $shot_power)), 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
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
  );// COPY SHOT
$mmrpg_index['abilities']['copy-shot'] = array(
  'ability_name' => 'Copy Shot',
  'ability_token' => 'copy-shot',
  'ability_image' => 'copy-shot',
  'ability_description' => 'The user fires a small emulation device at the target that deals minor damage and copies its last used ability!',
  'ability_speed' => 2,
  'ability_damage' => 5,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Update the ability's target options and trigger
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 105, 0, 10, $this_robot->print_robot_name().' fires a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(0, -70, 0, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(0, -70, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_damage);
    
    // Check to ensure the ability was a success before continuing
    if ($this_ability->ability_results['this_result'] != 'failure'){
      
      // Ensure the target robot has an ability history to draw from
      if (!empty($target_robot->history['triggered_abilities'])){
        
        // Find the position of the current copy-shot ability
        $this_ability_key = $this_ability->ability_id; //array_search($this_ability->ability_token, $this_robot->robot_abilities);
        
        // Loop through the opponent's ability history in reverse
        $num_triggered_abilities = count($target_robot->history['triggered_abilities']);
        $new_ability_token = $target_robot->history['triggered_abilities'][$num_triggered_abilities - 1];
        $new_ability_info = !empty($this_index['abilities'][$new_ability_token]) ? $this_index['abilities'][$new_ability_token] : array();
        
        // If the current robot does not already have this ability
        if (!empty($new_ability_info) && !in_array($new_ability_token, $this_robot->robot_abilities)){
          // Copy the current ability to this robot's list, and update
          $this_robot->robot_frame = 'taunt';
          $this_robot->robot_abilities[$this_ability_key] = $new_ability_token;
          $this_robot->update_session();
          // Create the ability object to trigger data loading
          $this_new_ability = new mmrpg_ability($this_battle, $this_player, $this_robot, $new_ability_info);
          // Create an event displaying the new copied ability
          $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
          $event_body = $this_ability->print_ability_name().' downloads the target&#39;s battle data&hellip;<br />';
          $event_body .= $this_robot->print_robot_name().' learned how to use '.$this_new_ability->print_ability_name().'!';
          $event_options = array();
          $event_options['console_show_target'] = false;
          $event_options['this_ability'] = $this_new_ability;
          $event_options['this_ability_image'] = 'icon';
          $event_options['console_show_this_robot'] = false;
          $event_options['canvas_show_this_ability'] = false;
          $event_options['console_show_this_ability'] = true;
          $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
        }
        
      }
      
    }
    
    
    // Return true on success
    return true;
      
    }
  );// CRASH BOMBER
$mmrpg_index['abilities']['crash-bomber'] = array(
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
  );// DEFENSE BOOST
$mmrpg_index['abilities']['defense-boost'] = array(
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
  );// DEFENSE BREAK
$mmrpg_index['abilities']['defense-break'] = array(
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
  );// DEFENSE BURN
$mmrpg_index['abilities']['defense-burn'] = array(
  'ability_name' => 'Defense Burn',
  'ability_token' => 'defense-burn',
  'ability_image' => 'defense-burn',
  'ability_description' => 'The user breaks down the target&#39;s shields using fire, lowering its defense stat!',
  'ability_damage' => 15,
  'ability_type' => 'flame',
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 85, 0, 10, $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's defense stat
    $this_ability->damage_options_update(array(
      'kind' => 'defense',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -50, 0, 10, $target_robot->print_robot_name().'&#39;s shields were burned!'),
      'failure' => array(1, -75, 0, -10, 'It had no effect on '.$target_robot->print_robot_name().'&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'defense',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -50, 0, 10, $target_robot->print_robot_name().'&#39;s shields were ignited!'),
      'failure' => array(1, -75, 0, -10, 'It had no effect on '.$target_robot->print_robot_name().'&hellip;')
      ));
    $defense_damage_amount = ceil($target_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );// DEFENSE MODE
$mmrpg_index['abilities']['defense-mode'] = array(
  'ability_name' => 'Defense Mode',
  'ability_token' => 'defense-mode',
  'ability_image' => 'defense-mode',
  'ability_description' => 'The user optimizes internal systems to raise defense, but lowers speed and attack in the process.',
  'ability_recovery' => 30,
  'ability_damage' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options_update(array(
      'frame' => 'summon',
      'success' => array(0, 0, 0, -10, $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's attack stat
    $this_ability->damage_options_update(array(
      'kind' => 'attack',
      'frame' => 'defend',
      'success' => array(0, -2, 0, -10,  $this_robot->print_robot_name().'&#39;s weapons powered down&hellip;'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;')
      ));
    $attack_damage_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Decrease this robot's speed stat
    $this_ability->damage_options_update(array(
      'kind' => 'speed',
      'frame' => 'defend',
      'success' => array(0, -4, 0, -10,  $this_robot->print_robot_name().'&#39;s mobility slowed&hellip;'),
      'failure' => array(0, -4, 0, -10, $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;')
      ));
    $speed_damage_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Increase this robot's defense stat
    $this_ability->recovery_options_update(array(
      'kind' => 'defense',
      'frame' => 'taunt',
      'success' => array(0, -6, 0, -10,  $this_robot->print_robot_name().'&#39;s shields powered up&hellip;'),
      'failure' => array(0, -6, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
      ));
    $defense_recovery_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $defense_recovery_amount);
        
    // Return true on success
    return true;
      
    }
  );// ENERGY BOOST
$mmrpg_index['abilities']['energy-boost'] = array(
  'ability_name' => 'Energy Boost',
  'ability_token' => 'energy-boost',
  'ability_image' => 'energy-boost',
  'ability_description' => 'The user optimizes internal systems to restore its energy slightly.',
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
    
    // Increase this robot's attack stat
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'success' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s energy was restored!'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s energy was not effected&hellip;')
      ));
    $energy_recovery_amount = ceil($this_robot->robot_base_energy * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $energy_recovery_amount);
    
    // Return true on success
    return true;
      
  }
  );// ENERGY BREAK
$mmrpg_index['abilities']['energy-break'] = array(
  'ability_name' => 'Energy Break',
  'ability_token' => 'energy-break',
  'ability_image' => 'energy-break',
  'ability_description' => 'The user breaks the target&#39;s systems down, lowering its energy stat!',
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
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(0, -2, 0, -10, $target_robot->print_robot_name().'&#39;s systems were damaged!'),
      'failure' => array(0, -2, 0, -10, 'It had no effect on '.$target_robot->print_robot_name().'&hellip;')
      ));
    $energy_damage_amount = ceil($target_robot->robot_base_energy * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
      
  }
  );// FIRE STORM
$mmrpg_index['abilities']['fire-storm'] = array(
  'ability_name' => 'Fire Storm',
  'ability_token' => 'fire-storm',
  'ability_image' => 'fire-storm',
  'ability_description' => 'The user a unleashes a powerful storm of fire doing massive damage to slower targets!',
  'ability_type' => 'flame',
  'ability_damage' => 15,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 100, 0, 10, $this_robot->print_robot_name().' unleashes a '.$this_ability->print_ability_name().'!'),
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(15, 0, 0),
      'success' => array(1, -75, 0, 10, 'The '.$this_ability->print_ability_name().' chased the target!'),
      'failure' => array(1, -100, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -75, 0, 10, 'The '.$this_ability->print_ability_name().' ignited the target!'),
      'failure' => array(1, -100, 0, -10, 'The '.$this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    if ($target_robot->robot_speed > 100 || $target_robot->robot_speed < 100){
      $speed_multiplier = $target_robot->robot_speed > 0 ? $target_robot->robot_speed / 100 : 0.01;
      $energy_damage_amount = ceil($energy_damage_amount / $speed_multiplier);
    }
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
    
      
    }
  );// FLASH STOPPER
$mmrpg_index['abilities']['flash-stopper'] = array(
  'ability_name' => 'Flash Stopper',
  'ability_token' => 'flash-stopper',
  'ability_image' => 'flash-stopper',
  'ability_description' => 'The flash-freezes time around the target then quickly releases to cause temporal damage!',
  'ability_type' => 'time',
  'ability_damage' => 12,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, -10, 0, -10, $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's speed stat
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(5, 0, 0),
      'success' => array(1, -5, 0, -10, 'The '.$this_ability->print_ability_name().' freezes time around the target!'),
      'failure' => array(2, -5, 0, -10, $this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -5, 0, -10, 'The '.$this_ability->print_ability_name().' freezes time around the target!'),
      'failure' => array(2, -5, 0, -10, $this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
    
      
    }
  );// HYPER BOMB
$mmrpg_index['abilities']['hyper-bomb'] = array(
  'ability_name' => 'Hyper Bomb',
  'ability_token' => 'hyper-bomb',
  'ability_image' => 'hyper-bomb',
  'ability_description' => 'The user throws a large bomb at the target that explodes for massive damage.',
  'ability_type' => 'explode',
  'ability_damage' => 18,
  'ability_accuracy' => 80,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // If this ability is attached, remove it
    $this_attachment_backup = false;
    $this_attachment_token = 'ability_'.$this_ability->ability_token;
    if (isset($this_robot->robot_attachments[$this_attachment_token])){
      $this_attachment_backup = $this_robot->robot_attachments[$this_attachment_token];
      unset($this_robot->robot_attachments[$this_attachment_token]);
      $this_robot->update_session();
    }
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(0, 85, 35, 10, $this_robot->print_robot_name().' thows a '.$this_ability->print_ability_name().'!'),
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 5, 0),
      'success' => array(2, 30, 0, 10, 'The '.$this_ability->print_ability_name().' exploded on contact!'),
      'failure' => array(1, -65, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(2, 30, 0, 10, 'The '.$this_ability->print_ability_name().' exploded on contact!'),
      'failure' => array(1, -65, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // If there was a removed attachment, put it back
    if (!empty($this_attachment_backup)){
      $this_robot->robot_attachments[$this_attachment_token] = $this_attachment_backup;
      $this_robot->update_session();
    }
    
    // Return true on success
    return true;
        
  },
  'attachment_frame' => array(1),
  'attachment_frame_offset' => array('x' => -55, 'y' => 1, 'z' => -10)
  );// ICE SLASHER
$mmrpg_index['abilities']['ice-slasher'] = array(
  'ability_name' => 'Ice Slasher',
  'ability_token' => 'ice-slasher',
  'ability_image' => 'ice-slasher',
  'ability_description' => 'The user fires a blast of super-chilled air at the target, doing damage and occasionally lowering speed!',
  'ability_type' => 'freeze',
  'ability_damage' => 16,
  'ability_accuracy' => 85,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(1, 110, 0, 10, $this_robot->print_robot_name().' fires an '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -90, 0, 10, 'The '.$this_ability->print_ability_name().' cut into the target!'),
      'failure' => array(1, -100, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -45, 0, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -100, 0, -10, 'The '.$this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Randomly inflict a speed break on critical chance 50%
    if ($target_robot->robot_status != 'disabled'
      && $target_robot->robot_speed > 0
      && $this_ability->ability_results['this_result'] != 'failure'
      && $this_battle->critical_chance(50)){
      // Decrease the target robot's speed stat
      $this_ability->damage_options_update(array(
        'kind' => 'speed',
        'frame' => 'defend',
        'kickback' => array(10, 0, 0),
        'success' => array(2, 0, -6, 10, $target_robot->print_robot_name().'&#39;s mobility was damaged!'),
        'failure' => array(2, 0, -6, -10, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'speed',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(2, 0, -6, 10, $target_robot->print_robot_name().'&#39;s mobility improved!'),
        'failure' => array(2, 0, -6, -9999, '')
        ));
      $speed_damage_amount = ceil($target_robot->robot_base_speed * (($this_ability->ability_damage / 4) / 100));
      $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    }
    
    // Return true on success
    return true;
    
      
    }
  );// LEAF SHIELD
$mmrpg_index['abilities']['leaf-shield'] = array(
  'ability_name' => 'Leaf Shield',
  'ability_token' => 'leaf-shield',
  'ability_image' => 'leaf-shield',
  'ability_description' => 'The user raises a shield of sharp, metal leaves to greatly raise defense! This shield can also be thrown at the target.',
  'ability_type' => 'nature',
  'ability_damage' => 30,
  'ability_recovery' => 30,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Define this ability's attachment token
    $this_attachment_token = 'ability_'.$this_ability->ability_token;
    $this_attachment_info = array('class' => 'ability', 'ability_id' => $this_ability->ability_id, 'ability_token' => $this_ability->ability_token);
    
    // If the ability flag was not set, leaf shield raises defense by 30%
    if (!isset($this_robot->robot_attachments[$this_attachment_token])){
      
      // Target this robot's self
      $this_ability->target_options_update(array(
        'frame' => 'summon',
        'success' => array(0, -10, 0, -10, $this_robot->print_robot_name().' raises a '.$this_ability->print_ability_name().'!')
        ));
      $this_robot->trigger_target($this_robot, $this_ability);
      
      // Increase this robot's defense stat
      $this_ability->recovery_options_update(array(
        'kind' => 'defense',
        'frame' => 'taunt',
        'rates' => array(100, 0, 0),
        'success' => array(1, -10, 0, -10, $this_robot->print_robot_name().'&#39;s shields were bolstered!'),
        'failure' => array(1, -10, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
        ));
      $this_ability->damage_options_update(array(
        'kind' => 'defense',
        'frame' => 'defend',
        'rates' => array(100, 0, 0),
        'success' => array(1, -10, 0, -10, $this_robot->print_robot_name().'&#39;s shields were damaged!'),
        'failure' => array(1, -10, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
        ));
      $defense_recovery_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_recovery / 100));
      $this_robot->trigger_recovery($this_robot, $this_ability, $defense_recovery_amount);
      
      // Attach this ability attachment to the robot using it
      $this_robot->robot_attachments[$this_attachment_token] = $this_attachment_info;
      $this_robot->update_session();
      
      // Update the is_active flag to true, shield is up
      //$this_ability->flags['is_active'] = true;
    }
    // Else if the ability flag was set, leaf shield is thrown and defense is lowered by 30%
    else {
      
      // Remove this ability attachment to the robot using it
      unset($this_robot->robot_attachments[$this_attachment_token]);
      $this_robot->update_session();
      
      // Target the opposing robot
      $this_ability->target_options_update(array(
        'frame' => 'summon',
        'success' => array(0, 85, -10, -10, $this_robot->print_robot_name().' releases the '.$this_ability->print_ability_name().'!')
        ));
      $this_robot->trigger_target($target_robot, $this_ability);
      
      // Inflict damage on the opposing robot
      $this_ability->damage_options_update(array(
        'kind' => 'energy',
        'kickback' => array(5, 0, 0),
        'success' => array(1, -75, 0, -10, 'The '.$this_ability->print_ability_name().' crashed into the target!'),
        'failure' => array(1, -85, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'energy',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(1, -75, 0, -10, 'The '.$this_ability->print_ability_name().' crashed into the target!'),
        'failure' => array(1, -85, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
        ));
      $energy_damage_amount = $this_ability->ability_damage;
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
      
      // Decrease this robot's defense stat
      $this_ability->damage_options_update(array(
        'kind' => 'defense',
        'frame' => 'defend',
        'rates' => array(100, 0, 0),
        'success' => array(2, -2, 0, -10,  'The '.$this_ability->print_ability_name().'&#39;s protection was lost&hellip;'),
        'failure' => array(2, -2, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
        ));
      $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_recovery / 100));
      $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
      
      // Update the is_active flag to false, shield is down
      //unset($this_ability->flags['is_active']);
    }
    
    
    // Return true on success
    return true;
        
  },
  'attachment_frame' => array(0, 1),
  'attachment_frame_offset' => array('x' => -10, 'y' => 0, 'z' => -10)
  );// MEGA BUSTER
$mmrpg_index['abilities']['mega-buster'] = array(
  'ability_name' => 'Mega Buster',
  'ability_token' => 'mega-buster',
  'ability_image' => 'mega-buster',
  'ability_description' => 'The user fires an energy shot at the target that charges and grows more powerful with successive uses.',
  'ability_damage' => 10,
  'ability_accuracy' => 92,
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
      'success' => array($shot_power_frame, (85 + (20 * $shot_power)), 0, 10, $this_robot->print_robot_name().' fires the '.$this_ability->print_ability_name().'!'),
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array((8 * $shot_power), 0, 0),
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
  );// METAL BLADE
$mmrpg_index['abilities']['metal-blade'] = array(
  'ability_name' => 'Metal Blade',
  'ability_token' => 'metal-blade',
  'ability_image' => 'metal-blade',
  'ability_description' => 'The user throws a sharp, disc-like blade that rips through the target for massive damage!',
  'ability_type' => 'cutter',
  'ability_damage' => 20,
  'ability_accuracy' => 65,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(0, 65, 0, 10, $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(5, 0, 0),
      'success' => array(1, -65, 0, 10, 'The '.$this_ability->print_ability_name().' rips through the target!'),
      'failure' => array(1, -85, 0, -10, 'The '.$this_ability->print_ability_name().' spun past the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -65, 0, 10, 'The '.$this_ability->print_ability_name().' rips through target!'),
      'failure' => array(1, -85, 0, -10, 'The '.$this_ability->print_ability_name().' spun past the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );// OIL SLIDER
$mmrpg_index['abilities']['oil-slider'] = array(
  'ability_name' => 'Oil Slider',
  'ability_token' => 'oil-slider',
  'ability_image' => 'oil-slider',
  'ability_description' => 'The user slides toward the target at blinding speed on a wave of crude oil!',
  'ability_type' => 'earth',
  'ability_speed' => 2,
  'ability_damage' => 10,
  'ability_accuracy' => 85,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'slide',
      'success' => array(0, 15, -10, -10, $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(5, 0, 0),
      'success' => array(1, -65, -10, 10, 'The '.$this_ability->print_ability_name().' crashes into the target!'),
      'failure' => array(0, -85, 15, -10, 'The '.$this_ability->print_ability_name().' continued past the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -35, -10, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -65, 15, -10, 'The '.$this_ability->print_ability_name().' continued past the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );// PROTO BUSTER
$mmrpg_index['abilities']['proto-buster'] = array(
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
  );// QUICK BOOMERANG
$mmrpg_index['abilities']['quick-boomerang'] = array(
  'ability_name' => 'Quick Boomerang',
  'ability_token' => 'quick-boomerang',
  'ability_image' => 'quick-boomerang',
  'ability_description' => 'The user throws a boomerang-like blade at blinding speed toward the target, striking up to four times at increasing strength!',
  'ability_type' => 'cutter',
  'ability_speed' => 2,
  'ability_damage' => 4,
  'ability_accuracy' => 85,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(1, 100, 0, 10, $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(5, 0, 0),
      'success' => array(0, 5, 0, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(0, -50, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(0, 0, 5, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(0, -50, 5, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    

    // If this attack returns and strikes a second time (random chance)
    if ($this_ability->ability_results['this_result'] != 'failure'
      && $target_robot->robot_status != 'disabled'){

      // Inflict damage on the opposing robot
      $this_ability->damage_options_update(array(
        'kind' => 'energy',
        'kickback' => array(10, 0, 0),
        'success' => array(1, -40, 10, 10, 'Oh! It hit again!'),
        'failure' => array(1, -90, 10, -10, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'energy',
        'kickback' => array(0, 0, 0),
        'frame' => 'taunt',
        'success' => array(1, -40, 10, 10, 'Oh! It hit again!'),
        'failure' => array(1, -90, 10, -10, '')
        ));
      $energy_damage_amount = ceil($energy_damage_amount * 1.10);
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

      // If this attack returns and strikes a third time (random chance)
      if ($this_ability->ability_results['this_result'] != 'failure'
        && $target_robot->robot_energy != 'disabled'){
        
        // Inflict damage on the opposing robot
        $this_ability->damage_options_update(array(
          'kind' => 'energy',
          'kickback' => array(15, 0, 0),
          'success' => array(2, -10, 15, -10, 'Wow! A third hit?!?'),
          'failure' => array(2, 60, 15, -10, '')
          ));
        $this_ability->recovery_options_update(array(
          'kind' => 'energy',
          'frame' => 'taunt',
          'kickback' => array(0, 0, 0),
          'success' => array(2, 10, 15, -10, 'Wow! A third hit?!?'),
          'failure' => array(2, 60, 15, -10, '')
          ));
        $energy_damage_amount = ceil($energy_damage_amount * 1.10);
        $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

        // If this attack returns and strikes a fourth time (random chance)
        if ($this_ability->ability_results['this_result'] != 'failure'
          && $target_robot->robot_status != 'disabled'){
          
          // Inflict damage on the opposing robot
          $this_ability->damage_options_update(array(
            'kind' => 'energy',
            'kickback' => array(20, 0, 0),
            'success' => array(3, 50, 20, -10, 'Nice! One more time!'),
            'failure' => array(3, 90, 20, -10, '')
            ));
          $this_ability->recovery_options_update(array(
            'kind' => 'energy',
            'frame' => 'taunt',
            'kickback' => array(0, 0, 0),
            'success' => array(3, 50, 20, -10, 'Nice! One more time!'),
            'failure' => array(3, 90, 20, -10, '')
            ));
          $energy_damage_amount = ceil($energy_damage_amount * 1.10);
          $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
          
        }
        
      }
    
    }
    
    // Return true on success
    return true;
      
  }
  );// REPAIR MODE
$mmrpg_index['abilities']['repair-mode'] = array(
  'ability_name' => 'Repair Mode',
  'ability_token' => 'repair-mode',
  'ability_image' => 'repair-mode',
  'ability_description' => 'The user repairs itself and restores energy using the power from its weapon, shield, and mobility systems.',
  'ability_recovery' => 30,
  'ability_damage' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options_update(array(
      'frame' => 'summon',
      'success' => array(0, 0, 0, -10, $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's attack stat
    $this_ability->damage_options_update(array(
      'kind' => 'attack',
      'frame' => 'defend',
      'success' => array(0, -2, 0, -10,  $this_robot->print_robot_name().'&#39;s weapons powered down&hellip;'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;')
      ));
    $attack_damage_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Decrease this robot's defense stat
    $this_ability->damage_options_update(array(
      'kind' => 'defense',
      'frame' => 'defend',
      'success' => array(0, -4, 0, -10,  $this_robot->print_robot_name().'&#39;s shields powered down&hellip;'),
      'failure' => array(0, -4, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
      ));
    $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Decrease this robot's speed stat
    $this_ability->damage_options_update(array(
      'kind' => 'speed',
      'frame' => 'defend',
      'success' => array(0, -6, 0, -10,  $this_robot->print_robot_name().'&#39;s mobility slowed&hellip;'),
      'failure' => array(0, -6, 0, -10, $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;')
      ));
    $speed_damage_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Increase this robot's energy stat
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'success' => array(0, -8, 0, -10,  $this_robot->print_robot_name().' recovered energy!'),
      'failure' => array(0, -8, 0, -10, $this_robot->print_robot_name().'&#39;s energy was not effected&hellip;')
      ));
    $energy_recovery_amount = ceil($this_robot->robot_base_energy * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $energy_recovery_amount);
        
    // Return true on success
    return true;
      
  }
  );// ROLLING CUTTER
$mmrpg_index['abilities']['rolling-cutter'] = array(
  'ability_name' => 'Rolling Cutter',
  'ability_token' => 'rolling-cutter',
  'ability_image' => 'rolling-cutter',
  'ability_description' => 'The user throws a boomerang-like blade that strikes the target up to four times at increasing strength!',
  'ability_type' => 'cutter',
  'ability_damage' => 5,
  'ability_accuracy' => 75,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(1, 100, 0, 10, $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(0, 0, 5, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(0, -50, 5, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(0, 0, 5, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(0, -50, 5, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    

    // If this attack returns and strikes a second time (random chance)
    if ($this_ability->ability_results['this_result'] != 'failure'
      && $target_robot->robot_status != 'disabled'){

      // Inflict damage on the opposing robot
      $this_ability->damage_options_update(array(
        'kind' => 'energy',
        'kickback' => array(20, 0, 0),
        'success' => array(1, -40, 10, 10, 'Oh! It hit again!'),
        'failure' => array(1, -90, 10, -10, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'energy',
        'kickback' => array(0, 0, 0),
        'frame' => 'taunt',
        'success' => array(1, -40, 10, 10, 'Oh! It hit again!'),
        'failure' => array(1, -90, 10, -10, '')
        ));
      $energy_damage_amount = ceil($energy_damage_amount * 1.10);
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

      // If this attack returns and strikes a third time (random chance)
      if ($this_ability->ability_results['this_result'] != 'failure'
        && $target_robot->robot_energy != 'disabled'){
        
        // Inflict damage on the opposing robot
        $this_ability->damage_options_update(array(
          'kind' => 'energy',
          'kickback' => array(30, 0, 0),
          'success' => array(2, 10, 15, -10, 'Wow! A third hit?!?'),
          'failure' => array(2, 60, 15, -10, '')
          ));
        $this_ability->recovery_options_update(array(
          'kind' => 'energy',
          'frame' => 'taunt',
          'kickback' => array(0, 0, 0),
          'success' => array(2, 10, 15, -10, 'Wow! A third hit?!?'),
          'failure' => array(2, 60, 15, -10, '')
          ));
        $energy_damage_amount = ceil($energy_damage_amount * 1.10);
        $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

        // If this attack returns and strikes a fourth time (random chance)
        if ($this_ability->ability_results['this_result'] != 'failure'
          && $target_robot->robot_status != 'disabled'){
          
          // Inflict damage on the opposing robot
          $this_ability->damage_options_update(array(
            'kind' => 'energy',
            'kickback' => array(40, 0, 0),
            'success' => array(3, 50, 20, -10, 'Nice! One more time!'),
            'failure' => array(3, 90, 20, -10, '')
            ));
          $this_ability->recovery_options_update(array(
            'kind' => 'energy',
            'frame' => 'taunt',
            'kickback' => array(0, 0, 0),
            'success' => array(3, 50, 20, -10, 'Nice! One more time!'),
            'failure' => array(3, 90, 20, -10, '')
            ));
          $energy_damage_amount = ceil($energy_damage_amount * 1.10);
          $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
          
        }
        
      }
    
    }
    
    // Return true on success
    return true;
      
  }
  );// SPEED BOOST
$mmrpg_index['abilities']['speed-boost'] = array(
  'ability_name' => 'Speed Boost',
  'ability_token' => 'speed-boost',
  'ability_image' => 'speed-boost',
  'ability_description' => 'The user optimizes internal systems to raise its speed slightly.',
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
    
    // Increase this robot's speed stat
    $this_ability->recovery_options_update(array(
      'kind' => 'speed',
      'frame' => 'taunt',
      'success' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s mobility improved!'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;')
      ));
    $speed_recovery_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $speed_recovery_amount);
    
    // Return true on success
    return true;
      
  }
  );// SPEED BREAK
$mmrpg_index['abilities']['speed-break'] = array(
  'ability_name' => 'Speed Break',
  'ability_token' => 'speed-break',
  'ability_image' => 'speed-break',
  'ability_description' => 'The user that breaks the target&#39;s mobility down, lowering its speed stat!',
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
    
    // Decrease the target robot's speed stat
    $this_ability->damage_options_update(array(
      'kind' => 'speed',
      'kickback' => array(10, 0, 0),
      'success' => array(0, -2, 0, -10, $target_robot->print_robot_name().'&#39;s mobility was damaged!'),
      'failure' => array(0, -2, 0, -10, 'It had no effect on '.$target_robot->print_robot_name().'&hellip;')
      ));
    $speed_damage_amount = ceil($target_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );// SPEED MODE
$mmrpg_index['abilities']['speed-mode'] = array(
  'ability_name' => 'Speed Mode',
  'ability_token' => 'speed-mode',
  'ability_image' => 'speed-mode',
  'ability_description' => 'The user optimizes internal systems to raise speed, but lowers attack and defense in the process.',
  'ability_recovery' => 30,
  'ability_damage' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options_update(array(
      'frame' => 'summon',
      'success' => array(0, 0, 0, -10, $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's defense stat
    $this_ability->damage_options_update(array(
      'kind' => 'defense',
      'frame' => 'defend',
      'success' => array(0, -2, 0, -10,  $this_robot->print_robot_name().'&#39;s shields powered down&hellip;'),
      'failure' => array(0, -2, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
      ));
    $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Decrease this robot's attack stat
    $this_ability->damage_options_update(array(
      'kind' => 'attack',
      'frame' => 'defend',
      'success' => array(0, -4, 0, -10,  $this_robot->print_robot_name().'&#39;s weapons powered down&hellip;'),
      'failure' => array(0, -4, 0, -10, $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;')
      ));
    $attack_damage_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Increase this robot's speed stat
    $this_ability->recovery_options_update(array(
      'kind' => 'defense',
      'frame' => 'taunt',
      'success' => array(0, -6, 0, -10,  $this_robot->print_robot_name().'&#39;s mobility improved&hellip;'),
      'failure' => array(0, -6, 0, -10, $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;')
      ));
    $speed_recovery_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $speed_recovery_amount);
        
    // Return true on success
    return true;
    
      
    }
  );// METAL BLADE
$mmrpg_index['abilities']['super-arm'] = array(
  'ability_name' => 'Super Arm',
  'ability_token' => 'super-arm',
  'ability_image' => 'super-arm',
  'ability_description' => 'The user finds a nearby heavy object and hurls it at the target for massive damage.',
  'ability_type' => 'impact',
  'ability_damage' => 15,
  'ability_accuracy' => 75,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Define the ability frames based on field
    $this_field_token = $this_battle->battle_field->field_token;
    $this_target_frame = 0;
    $this_impact_frame = 1;
    $this_object_name = 'boulder';
    if ($this_field_token == 'guts-field'){
      $this_target_frame = 0;
      $this_impact_frame = 1;
      $this_object_name = 'rocky boulder';
    }
    elseif ($this_field_token == 'ice-field'){
      $this_target_frame = 2;
      $this_impact_frame = 3;
      $this_object_name = 'frozen snowball';
    }
    elseif ($this_field_token == 'elec-field'){
      $this_target_frame = 4;
      $this_impact_frame = 5;
      $this_object_name = 'metal heap';
    }
    elseif ($this_field_token == 'base-field'){
      $this_target_frame = 6;
      $this_impact_frame = 7;
      $this_object_name = 'pile of debris';
    }
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array($this_target_frame, 115, 15, 10, $this_ability->print_ability_name().' throws a '.$this_object_name.'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(20, 0, 0),
      'success' => array($this_impact_frame, -85, 0, 10, 'The '.$this_object_name.' crashed into the target!'),
      'failure' => array($this_target_frame, -110, 0, -10, 'The '.$this_object_name.' missed the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array($this_impact_frame, -85, 0, 10, 'The '.$this_object_name.' crashed into the target!'),
      'failure' => array($this_target_frame, -110, 0, -10, 'The '.$this_object_name.' missed the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );// SUPER THROW
$mmrpg_index['abilities']['super-throw'] = array(
  'ability_name' => 'Super Throw',
  'ability_token' => 'super-throw',
  'ability_image' => 'super-throw',
  'ability_description' => 'The grabs hold of the target and throws them across the field, forcing the opponent to switch.',
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $target_robot->robot_position = 'bench';
    $target_robot->robot_frame = 'damage';
    $target_robot->update_session();
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(0, 0, 0, 10, $target_robot->print_robot_name().' is thrown to the bench!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Trigger a switch on the opponent immediately
    $this_battle->actions_prepend(
      $target_player,
      $target_robot,
      $this_player,
      $this_robot,
      'switch',
      ''
      );
    
    // Return true on success
    return true;
        
  }
  );// THUNDER BEAM
$mmrpg_index['abilities']['thunder-beam'] = array(
  'ability_name' => 'Thunder Beam',
  'ability_token' => 'thunder-beam',
  'ability_image' => 'thunder-beam',
  'ability_description' => 'The user throws a powerful bolt of electricity at the target for massive damage.',
  'ability_type' => 'electric',
  'ability_damage' => 18,
  'ability_accuracy' => 65,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(0, 95, 0, 10, $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(15, 0, 0),
      'success' => array(1, -65, 0, 10, 'The '.$this_ability->print_ability_name().' zapped the target!'),
      'failure' => array(1, -95, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -65, 0, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -95, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );// TIME ARROW
$mmrpg_index['abilities']['time-arrow'] = array(
  'ability_name' => 'Time Arrow',
  'ability_token' => 'time-arrow',
  'ability_image' => 'time-arrow',
  'ability_description' => 'The user directs a mysterious arrow at the target, dealing damage and lowering speed!',
  'ability_type' => 'time',
  'ability_damage' => 10,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(1, 125, 0, 10, $this_robot->print_robot_name().' fires an '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(1, -125, 0, 10, 'The '.$this_ability->print_ability_name().' sliced into the target!'),
      'failure' => array(1, -150, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(1, -60, 0, 10, 'The '.$this_ability->print_ability_name().' was absorbed by the target!'),
      'failure' => array(1, -90, 0, -10, 'The '.$this_ability->print_ability_name().' had no effect&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Inflect a break on speed if the robot wasn't disabled
    if ($target_robot->robot_status != 'disabled'
      && $target_robot->robot_speed > 0
      && $this_ability->ability_results['this_result'] != 'failure'){
      // Decrease the target robot's speed stat
      $this_ability->damage_options_update(array(
        'kind' => 'speed',
        'frame' => 'defend',
        'kickback' => array(10, 0, 0),
        'success' => array(2, -15, 10, -10, $target_robot->print_robot_name().'&#39;s speed was lowered!'),
        'failure' => array(2, 0, 0, -9999, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'speed',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(2, -15, 10, -10, $target_robot->print_robot_name().'&#39;s speed was increased!'),
        'failure' => array(2, 0, 0, -9999, '')
        ));
      $speed_damage_amount = ceil($target_robot->robot_base_speed * (($this_ability->ability_damage / 5) / 100));
      $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    }
    
    // Return true on success
    return true;
    
      
    }
  );
?>