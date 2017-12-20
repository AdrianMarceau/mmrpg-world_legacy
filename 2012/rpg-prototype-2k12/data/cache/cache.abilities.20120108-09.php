<?
// AIR SHOOTER
$mmrpg_index['abilities']['air-shooter'] = array(
  'ability_name' => 'Air Shooter',
  'ability_token' => 'air-shooter',
  'ability_description' => 'The user fires three whirlwinds that spread out and rise upward, hitting the target up to three times!',
  'ability_type' => 'wind',
  'ability_damage' => 10,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'shoot';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 125;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 125;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_ability->print_ability_name().' fires whirlwinds!';
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -40;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 2;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -40;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -20;
    $this_ability->damage_options['success_text'] = 'A whirlwind hit!';
    $this_ability->damage_options['failure_text'] = 'One of the whirlwinds missed!';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -40;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 2;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -40;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -20;
    $this_ability->recovery_options['success_text'] = 'A whilrwind hit!';
    $this_ability->recovery_options['failure_text'] = 'One of the whirlwinds missed!';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Ensure the target has not been disabled
    if ($target_robot->robot_status != 'disabled'){
      
      // Adjust damage/recovery text based on results
      if ($this_ability->ability_results['total_strikes'] == 1){
        $this_ability->damage_options['success_text'] = 'Another whirlwind hit!';
        $this_ability->recovery_options['success_text'] = 'Another whirlwind hit!';
      }
      if ($this_ability->ability_results['total_misses'] == 1){
        $this_ability->damage_options['failure_text'] = 'Another whirlwind missed!';
        $this_ability->recovery_options['failure_text'] = 'Another whirlwind missed!';
      }
      
      // Attempt to trigger damage to the target robot again
      $this_ability->damage_options['ability_success_frame'] = 3;
      $this_ability->damage_options['ability_success_frame_offset']['x'] = -60;
      $this_ability->damage_options['ability_failure_frame'] = 3;
      $this_ability->damage_options['ability_failure_frame_offset']['x'] = -60;
      $this_ability->recovery_options['ability_success_frame'] = 3;
      $this_ability->recovery_options['ability_success_frame_offset']['x'] = -60;
      $this_ability->recovery_options['ability_failure_frame'] = 3;
      $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -60;
      $target_robot->trigger_damage($this_robot, $this_ability,  $energy_damage_amount);
      
      // Ensure the target has not been disabled
      if ($target_robot->robot_status != 'disabled'){
        
        // Adjust damage/recovery text based on results again
        if ($this_ability->ability_results['total_strikes'] == 1){
          $this_ability->damage_options['success_text'] = 'Another whirlwind hit!';
          $this_ability->recovery_options['success_text'] = 'Another whirlwind hit!';
        }
        elseif ($this_ability->ability_results['total_strikes'] == 2){
          $this_ability->damage_options['success_text'] = 'A third whirlwind hit!';
          $this_ability->recovery_options['success_text'] = 'A third whirlwind hit!';
        }
        if ($this_ability->ability_results['total_misses'] == 1){
          $this_ability->damage_options['failure_text'] = 'Another whirlwind missed!';
          $this_ability->recovery_options['failure_text'] = 'Another whirlwind missed!';
        }
        elseif ($this_ability->ability_results['total_misses'] == 2){
          $this_ability->damage_options['failure_text'] = 'A third whirlwind missed!';
          $this_ability->recovery_options['failure_text'] = 'A third whirlwind missed!';
        }
        
        // Attempt to trigger damage to the target robot a third time
        $this_ability->damage_options['ability_success_frame'] = 1;
        $this_ability->damage_options['ability_success_frame_offset']['x'] = -80;
        $this_ability->damage_options['ability_failure_frame'] = 1;
        $this_ability->damage_options['ability_failure_frame_offset']['x'] = -80;
        $this_ability->recovery_options['ability_success_frame'] = 1;
        $this_ability->recovery_options['ability_success_frame_offset']['x'] = -80;
        $this_ability->recovery_options['ability_failure_frame'] = 1;
        $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -80;
        $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
        
      }
           
    }
    
    // Return true on success
    return true;
        
  }
  );// ATTACK BREAK
$mmrpg_index['abilities']['attack-break'] = array(
  'ability_name' => 'Attack Break',
  'ability_token' => 'attack-break',
  'ability_description' => 'The user fires a shot that breaks the target&#39;s weapons down, lowering its attack stat!',
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'shoot';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's attack stat
    $this_ability->damage_options['damage_kind'] = 'attack';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s weapons were damaged!';
    $this_ability->damage_options['failure_text'] = 'It had no effect on '.$target_robot->print_robot_name().'&hellip;';
    $attack_damage_amount = ceil($target_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Return true on success
    return true;
      
  }
  );// ATTACK MODE
$mmrpg_index['abilities']['attack-mode'] = array(
  'ability_name' => 'Attack Mode',
  'ability_token' => 'attack-mode',
  'ability_description' => 'The user optimizes internal systems to raise attack, but lowers speed and defense in the process.',
  'ability_recovery' => 30,
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_frame_index' => array('mugshot', 'base', 'defense', 'speed', 'attack'),
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'summon';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's defense stat
    $this_ability->damage_options['damage_kind'] = 'defense';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s shields powered down&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;';
    $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Decrease this robot's speed stat
    $this_ability->damage_options['damage_kind'] = 'speed';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s mobility slowed&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;';
    $speed_damage_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Increase this robot's attack stat
    $this_ability->recovery_options['recovery_kind'] = 'attack';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -6;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -6;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $this_robot->print_robot_name().'&#39;s weapons powered up!';
    $this_ability->recovery_options['failure_text'] = $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;';
    $attack_recovery_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $attack_recovery_amount);
        
    // Return true on success
    return true;
      
  }
  );// ATTACK BOOST
$mmrpg_index['abilities']['attack-boost'] = array(
  'ability_name' => 'Attack Boost',
  'ability_token' => 'attack-boost',
  'ability_description' => 'The user optimizes internal systems to raise its attack slightly.',
  'ability_recovery' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target this robot's self
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'summon';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Increase this robot's attack stat
    $this_ability->recovery_options['recovery_kind'] = 'attack';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $this_robot->print_robot_name().'&#39;s weapons powered up!';
    $this_ability->recovery_options['failure_text'] = $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;';
    $attack_recovery_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $attack_recovery_amount);
    
    // Return true on success
    return true;
      
  }
  );// ABILITY
$mmrpg_index['abilities']['ability'] = array(
  'ability_name' => 'Ability',
  'ability_token' => 'ability',
  'ability_description' => 'The default ability object.',
  'ability_type' => '',
  'ability_damage' => 0,
  'ability_accuracy' => 0,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Generate an event to show nothing happened
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    $event_body = 'Nothing happened&hellip; '.$this_ability->ability_token.' : '.$this_ability->ability_name.' '.print_r($this_robot->robot_abilities, true);
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Return true on success
    return true;
      
  }
  );// BUBBLE LEAD
$mmrpg_index['abilities']['bubble-lead'] = array(
  'ability_name' => 'Bubble Lead',
  'ability_token' => 'bubble-lead',
  'ability_description' => 'The user creates a super-dense bubble that rolls along the ground until it hits a target.',
  'ability_type' => 'water',
  'ability_damage' => 20,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'shoot';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 75;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 75;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = 10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' fires a '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -75;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 2;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -75;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'The '.$this_ability->print_ability_name().' hit the target!';
    $this_ability->damage_options['failure_text'] = 'The '.$this_ability->print_ability_name().' rolled past the target&hellip;';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -75;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 2;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -75;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'The '.$this_ability->print_ability_name().' hit the target!';
    $this_ability->recovery_options['failure_text'] = 'The '.$this_ability->print_ability_name().' rolled past the target&hellip;';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );// BUSTER SHOT
$mmrpg_index['abilities']['buster-shot'] = array(
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
  );// DEFENSE BOOST
$mmrpg_index['abilities']['defense-boost'] = array(
  'ability_name' => 'Defense Boost',
  'ability_token' => 'defense-boost',
  'ability_description' => 'The user optimizes internal systems to raise its defense slightly.',
  'ability_recovery' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target this robot's self
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'summon';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Increase this robot's defense stat
    $this_ability->recovery_options['recovery_kind'] = 'defense';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $this_robot->print_robot_name().'&#39;s shields powered up!';
    $this_ability->recovery_options['failure_text'] = $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;';
    $defense_recovery_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $defense_recovery_amount);
    
    // Return true on success
    return true;
      
  }
  );// DEFENSE BREAK
$mmrpg_index['abilities']['defense-break'] = array(
  'ability_name' => 'Defense Break',
  'ability_token' => 'defense-break',
  'ability_description' => 'The user fires a shot that breaks the target&#39;s shields down, lowering its defense stat!',
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'shoot';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's defense stat
    $this_ability->damage_options['damage_kind'] = 'defense';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s shields were damaged!';
    $this_ability->damage_options['failure_text'] = 'It had no effect on '.$target_robot->print_robot_name().'&hellip;';
    $defense_damage_amount = ceil($target_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );// DEFENSE BURN
$mmrpg_index['abilities']['defense-burn'] = array(
  'ability_name' => 'Defense Burn',
  'ability_token' => 'defense-burn',
  'ability_description' => 'The user breaks down the target&#39;s shields using fire, lowering its defense stat!',
  'ability_damage' => 15,
  'ability_type' => 'flame',
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 85;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 85;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's defense stat
    $this_ability->damage_options['damage_kind'] = 'defense';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -50;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 10;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -75;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s shields were burned!';
    $this_ability->damage_options['failure_text'] = 'It had no effect on '.$target_robot->print_robot_name().'&hellip;';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -50;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 10;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -75;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['recovery_kind'] = 'defense';
    $this_ability->recovery_options['success_text'] = $target_robot->print_robot_name().'&#39;s shields were ignited!';
    $this_ability->recovery_options['failure_text'] = 'It had no effect on '.$target_robot->print_robot_name().'&hellip;';
    $defense_damage_amount = ceil($target_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );// DEFENSE MODE
$mmrpg_index['abilities']['defense-mode'] = array(
  'ability_name' => 'Defense Mode',
  'ability_token' => 'defense-mode',
  'ability_description' => 'The user optimizes internal systems to raise defense, but lowers speed and attack in the process.',
  'ability_recovery' => 30,
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options['target_kind'] = 'defense';
    $this_ability->target_options['target_frame'] = 'summon';
     $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's attack stat
    $this_ability->damage_options['damage_kind'] = 'attack';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s weapons powered down&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;';
    $attack_damage_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Decrease this robot's speed stat
    $this_ability->damage_options['damage_kind'] = 'speed';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s mobility slowed&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;';
    $speed_damage_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Increase this robot's defense stat
    $this_ability->recovery_options['recovery_kind'] = 'defense';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -6;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -6;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $this_robot->print_robot_name().'&#39;s shields powered up!';
    $this_ability->recovery_options['failure_text'] = $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;';
    $defense_recovery_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $defense_recovery_amount);
        
    // Return true on success
    return true;
      
    }
  );// FIRE STORM
$mmrpg_index['abilities']['fire-storm'] = array(
  'ability_name' => 'Fire Storm',
  'ability_token' => 'fire-storm',
  'ability_description' => 'The user a unleashes a powerful storm of fire doing massive damage to slower targets!',
  'ability_type' => 'flame',
  'ability_damage' => 15,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 100;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 100;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -75;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -100;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'Flames chased the target!';
    $this_ability->damage_options['failure_text'] = $this_ability->print_ability_name().' missed&hellip;';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -75;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -100;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'Flames chased the target!';
    $this_ability->recovery_options['failure_text'] = $this_ability->print_ability_name().' had no effect&hellip;';
    $energy_damage_amount = $this_ability->ability_damage;
    if ($target_robot->robot_speed > 100 || $target_robot->robot_speed < 100){
      $speed_multiplier = $target_robot->robot_speed > 0 ? $target_robot->robot_speed / 100 : 0.01;
      $energy_damage_amount = ceil($energy_damage_amount / $speed_multiplier);
    }
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
    
      
    }
  );// ICE SLASHERs
$mmrpg_index['abilities']['ice-slasher'] = array(
  'ability_name' => 'Ice Slasher',
  'ability_token' => 'ice-slasher',
  'ability_description' => 'The user fires a blast of super-chilled air at the target, doing damage and occasionally lowering speed!!',
  'ability_type' => 'freeze',
  'ability_damage' => 20,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 110;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 110;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -90;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -100;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'The '.$this_ability->print_ability_name().' cut into the target!';
    $this_ability->damage_options['failure_text'] = 'The '.$this_ability->print_ability_name().' missed&hellip;';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -90;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -100;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'The '.$this_ability->print_ability_name().' was absorbed by the target!';
    $this_ability->recovery_options['failure_text'] = 'The '.$this_ability->print_ability_name().' had no effect&hellip;';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Randomly inflict a speed break on critical chance 30%
    if ($target_robot->robot_status != 'disabled'
      && $this_battle->critical_chance(30)){
      // Decrease the target robot's speed stat
      $this_ability->damage_options['damage_kind'] = 'speed';
      $this_ability->damage_options['ability_success_frame'] = 1;
      $this_ability->damage_options['ability_success_frame_offset']['x'] = -125;
      $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
      $this_ability->damage_options['ability_failure_frame'] = 1;
      $this_ability->damage_options['ability_failure_frame_offset']['x'] = -125;
      $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility was damaged!';
      $this_ability->damage_options['failure_text'] = '';
      $this_ability->recovery_options['damage_kind'] = 'speed';
      $this_ability->recovery_options['ability_success_frame'] = 1;
      $this_ability->recovery_options['ability_success_frame_offset']['x'] = -125;
      $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
      $this_ability->recovery_options['ability_failure_frame'] = 1;
      $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -125;
      $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->recovery_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility improved!';
      $this_ability->recovery_options['failure_text'] = '';
      $speed_damage_amount = ceil($target_robot->robot_base_speed * (($this_ability->ability_damage / 2) / 100));
      $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    }
    
    // Return true on success
    return true;
    
      
    }
  );// MEGA BUSTER
$mmrpg_index['abilities']['mega-buster'] = array(
  'ability_name' => 'Mega Buster',
  'ability_token' => 'mega-buster',
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
  );// METAL BLADE
$mmrpg_index['abilities']['metal-blade'] = array(
  'ability_name' => 'Metal Blade',
  'ability_token' => 'metal-blade',
  'ability_description' => 'The user throws a sharp disc-like blade at the target for massive damage.',
  'ability_type' => 'cutter',
  'ability_damage' => 25,
  'ability_accuracy' => 70,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'throw';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 65;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 65;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = 10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -65;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 2;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -65;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'The '.$this_ability->print_ability_name().' hit the target!';
    $this_ability->damage_options['failure_text'] = 'The '.$this_ability->print_ability_name().' flew past the target&hellip;';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -65;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 2;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -65;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'The '.$this_ability->print_ability_name().' hit the target!';
    $this_ability->recovery_options['failure_text'] = 'The '.$this_ability->print_ability_name().' flew past the target&hellip;';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );// PROTO BUSTER
$mmrpg_index['abilities']['proto-buster'] = array(
  'ability_name' => 'Proto Buster',
  'ability_token' => 'proto-buster',
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
  );// REPAIR MODE
$mmrpg_index['abilities']['repair-mode'] = array(
  'ability_name' => 'Repair Mode',
  'ability_token' => 'repair-mode',
  'ability_description' => 'The user repairs itself and restores energy using the power from its weapon, shield, and mobility systems.',
  'ability_recovery' => 30,
  'ability_damage' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'summon';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's attack stat
    $this_ability->damage_options['damage_kind'] = 'attack';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s weapons powered down&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;';
    $attack_damage_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Decrease this robot's defense stat
    $this_ability->damage_options['damage_kind'] = 'defense';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s shields powered down&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;';
    $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Decrease this robot's speed stat
    $this_ability->damage_options['damage_kind'] = 'speed';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -6;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -6;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s mobility slowed&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;';
    $speed_damage_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Increase this robot's energy stat
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -8;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -8;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $this_robot->print_robot_name().'&#39;s recovered energy!';
    $this_ability->recovery_options['failure_text'] = $this_robot->print_robot_name().'&#39;s energy was not effected&hellip;';
    $energy_recovery_amount = ceil($this_robot->robot_base_energy * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $energy_recovery_amount);
        
    // Return true on success
    return true;
      
  }
  );// ROLLING CUTTER
$mmrpg_index['abilities']['rolling-cutter'] = array(
  'ability_name' => 'Rolling Cutter',
  'ability_token' => 'rolling-cutter',
  'ability_description' => 'The user throws a boomerang-like blade that strikes the target up to four times at increasing strength!',
  'ability_type' => 'cutter',
  'ability_damage' => 10,
  'ability_accuracy' => 75,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'throw';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 100;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 100;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = 10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->damage_options['ability_success_frame_offset']['y'] = 5;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 2;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -30;
    $this_ability->damage_options['ability_failure_frame_offset']['y'] = 5;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'It hit the target!';
    $this_ability->damage_options['failure_text'] = $this_ability->print_ability_name().' missed!';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->recovery_options['ability_success_frame_offset']['y'] = 5;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 2;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -30;
    $this_ability->recovery_options['ability_failure_frame_offset']['y'] = 5;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'It hit the target!';
    $this_ability->recovery_options['failure_text'] = $this_ability->print_ability_name().' missed!';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    

    // If this attack returns and strikes a second time (random chance)
    if ($this_ability->ability_results['this_result'] != 'failure'
      && $target_robot->robot_status != 'disabled'){

      // Inflict damage on the opposing robot
      $this_ability->damage_options['ability_success_frame'] = 3;
      $this_ability->damage_options['ability_success_frame_offset']['x'] = -40;
      $this_ability->damage_options['ability_success_frame_offset']['y'] = 10;
      $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
      $this_ability->damage_options['ability_failure_frame'] = 3;
      $this_ability->damage_options['ability_failure_frame_offset']['x'] = -60;
      $this_ability->damage_options['ability_failure_frame_offset']['y'] = 10;
      $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->damage_options['success_text'] = 'Oh! It hit again!';
      $this_ability->damage_options['failure_text'] = '';
      $this_ability->recovery_options['ability_success_frame'] = 3;
      $this_ability->recovery_options['ability_success_frame_offset']['x'] = -40;
      $this_ability->recovery_options['ability_success_frame_offset']['y'] = 10;
      $this_ability->recovery_options['ability_failure_frame'] = 3;
      $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -60;
      $this_ability->recovery_options['ability_failure_frame_offset']['y'] = 10;
      $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->recovery_options['success_text'] = 'Oh! It hit again!';
      $this_ability->recovery_options['failure_text'] = '';
      $energy_damage_amount = ceil($energy_damage_amount * 1.10);
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

      // If this attack returns and strikes a third time (random chance)
      if ($this_ability->ability_results['this_result'] != 'failure'
        && $target_robot->robot_energy != 'disabled'){
        
        // Inflict damage on the opposing robot
        $this_ability->damage_options['ability_success_frame'] = 4;
        $this_ability->damage_options['ability_success_frame_offset']['x'] = 10;
        $this_ability->damage_options['ability_success_frame_offset']['y'] = 15;
        $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
        $this_ability->damage_options['ability_failure_frame'] = 4;
        $this_ability->damage_options['ability_failure_frame_offset']['x'] = 10;
        $this_ability->damage_options['ability_failure_frame_offset']['y'] = 15;
        $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
        $this_ability->damage_options['success_text'] = 'Wow! A third hit?!?';
        $this_ability->damage_options['failure_text'] = '';
        $this_ability->recovery_options['ability_success_frame'] = 4;
        $this_ability->recovery_options['ability_success_frame_offset']['x'] = 10;
        $this_ability->recovery_options['ability_success_frame_offset']['y'] = 15;
        $this_ability->recovery_options['ability_success_frame_offset']['y'] = -10;
        $this_ability->recovery_options['ability_failure_frame'] = 4;
        $this_ability->recovery_options['ability_failure_frame_offset']['x'] = 10;
        $this_ability->recovery_options['ability_failure_frame_offset']['y'] = 15;
        $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
        $this_ability->recovery_options['success_text'] = 'Wow! A third hit?!?';
        $this_ability->recovery_options['failure_text'] = '';
        $energy_damage_amount = ceil($energy_damage_amount * 1.10);
        $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

        // If this attack returns and strikes a fourth time (random chance)
        if ($this_ability->ability_results['this_result'] != 'failure'
          && $target_robot->robot_status != 'disabled'){
          
          // Inflict damage on the opposing robot
          $this_ability->damage_options['ability_success_frame'] = 1;
          $this_ability->damage_options['ability_success_frame_offset']['x'] = 50;
          $this_ability->damage_options['ability_success_frame_offset']['y'] = 20;
          $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
          $this_ability->damage_options['ability_failure_frame'] = 1;
          $this_ability->damage_options['ability_failure_frame_offset']['x'] = 50;
          $this_ability->damage_options['ability_failure_frame_offset']['y'] = 20;
          $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
          $this_ability->damage_options['success_text'] = 'One more time!';
          $this_ability->damage_options['failure_text'] = '';
          $this_ability->recovery_options['ability_success_frame'] = 1;
          $this_ability->recovery_options['ability_success_frame_offset']['x'] = 50;
          $this_ability->recovery_options['ability_success_frame_offset']['y'] = 20;
          $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
          $this_ability->recovery_options['ability_failure_frame'] = 1;
          $this_ability->recovery_options['ability_failure_frame_offset']['x'] = 50;
          $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
          $this_ability->recovery_options['success_text'] = 'One more time!';
          $this_ability->recovery_options['failure_text'] = '';
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
  'ability_description' => 'The user optimizes internal systems to raise its speed slightly.',
  'ability_recovery' => 10,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target this robot's self
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'summon';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' uses '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Increase this robot's speed stat
    $this_ability->recovery_options['recovery_kind'] = 'speed';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $this_robot->print_robot_name().'&#39;s mobility improved!';
    $this_ability->recovery_options['failure_text'] = $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;';
    $speed_recovery_amount = ceil($this_robot->robot_base_speed * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $speed_recovery_amount);
    
    // Return true on success
    return true;
      
  }
  );// SPEED BREAK
$mmrpg_index['abilities']['speed-break'] = array(
  'ability_name' => 'Speed Break',
  'ability_token' => 'speed-break',
  'ability_description' => 'The user fires a shot that breaks the target&#39;s mobility down, lowering its speed stat!',
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'shoot';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's speed stat
    $this_ability->damage_options['damage_kind'] = 'speed';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility was damaged!';
    $this_ability->damage_options['failure_text'] = 'It had no effect on '.$target_robot->print_robot_name().'&hellip;';
    $speed_damage_amount = ceil($target_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Return true on success
    return true;
      
    }
  );// SPEED MODE
$mmrpg_index['abilities']['speed-mode'] = array(
  'ability_name' => 'Speed Mode',
  'ability_token' => 'speed-mode',
  'ability_description' => 'The user optimizes internal systems to raise speed, but lowers attack and defense in the process.',
  'ability_recovery' => 30,
  'ability_damage' => 15,
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);

    // Target this robot's self
    $this_ability->target_options['target_kind'] = 'speed';
    $this_ability->target_options['target_frame'] = 'summon';
     $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 0;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->target_options['target_text'] = $this_robot->print_robot_name().' enters '.$this_ability->print_ability_name().'!';
    $this_robot->trigger_target($this_robot, $this_ability);
    
    // Decrease this robot's defense stat
    $this_ability->damage_options['damage_kind'] = 'defense';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -2;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s shields powered down&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;';
    $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
    
    // Decrease this robot's attack stat
    $this_ability->damage_options['damage_kind'] = 'attack';
    $this_ability->damage_options['damage_frame'] = 'defend';
    $this_ability->damage_options['ability_success_frame'] = 1;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 1;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -4;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $this_robot->print_robot_name().'&#39;s weapons powered down&hellip;';
    $this_ability->damage_options['failure_text'] = $this_robot->print_robot_name().'&#39;s weapons were not effected&hellip;';
    $attack_damage_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_damage / 100));
    $this_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    
    // Increase this robot's speed stat
    $this_ability->recovery_options['recovery_kind'] = 'speed';
    $this_ability->recovery_options['recovery_frame'] = 'taunt';
    $this_ability->recovery_options['ability_success_frame'] = 1;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -6;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 1;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -6;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $this_robot->print_robot_name().'&#39;s mobility improved!';
    $this_ability->recovery_options['failure_text'] = $this_robot->print_robot_name().'&#39;s mobility was not effected&hellip;';
    $speed_recovery_amount = ceil($this_robot->robot_base_attack * ($this_ability->ability_recovery / 100));
    $this_robot->trigger_recovery($this_robot, $this_ability, $speed_recovery_amount);
        
    // Return true on success
    return true;
    
      
    }
  );// TIME STOPPER
$mmrpg_index['abilities']['time-stopper'] = array(
  'ability_name' => 'Time Stopper',
  'ability_token' => 'time-stopper',
  'ability_description' => 'The user briefly freezes time around the target, greatly reducing the it\'s speed.  This ability may also cause damage to certain opponents...',
  'ability_type' => 'time',
  'ability_damage' => 20,
  'ability_accuracy' => 80,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = -10;
    $this_ability->target_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = -10;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = -10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Decrease the target robot's speed stat
    $this_ability->damage_options['damage_kind'] = 'speed';
    $this_ability->damage_options['ability_success_frame'] = 3;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = -5;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->damage_options['ability_failure_frame'] = 4;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -5;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility was slowed&hellip;';
    $this_ability->damage_options['failure_text'] = $this_ability->print_ability_name().' had no effect&hellip;';
    $this_ability->recovery_options['damage_kind'] = 'speed';
    $this_ability->recovery_options['ability_success_frame'] = 3;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = -5;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
    $this_ability->recovery_options['ability_failure_frame'] = 4;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -5;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = $target_robot->print_robot_name().'&#39;s mobility improved!';
    $this_ability->recovery_options['failure_text'] = $this_ability->print_ability_name().' had no effect&hellip;';
    $speed_damage_amount = ceil($target_robot->robot_base_speed * ($this_ability->ability_damage / 100));
    $target_robot->trigger_damage($this_robot, $this_ability, $speed_damage_amount);
    
    // Randomly inflict a speed break on critical chance 30%
    if ($target_robot->has_weakness($this_ability->ability_type)){
        
      // Inflict damage on the opposing robot
      $this_ability->damage_options['damage_kind'] = 'energy';
      $this_ability->damage_options['ability_success_frame'] = 2;
      $this_ability->damage_options['ability_success_frame_offset']['x'] = 0;
      $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
      $this_ability->damage_options['ability_failure_frame'] = 4;
      $this_ability->damage_options['ability_failure_frame_offset']['x'] = 0;
      $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->damage_options['success_text'] = 'It damaged the target!';
      $this_ability->damage_options['failure_text'] = '';
      $this_ability->recovery_options['recovery_kind'] = 'energy';
      $this_ability->recovery_options['ability_success_frame'] = 2;
      $this_ability->recovery_options['ability_success_frame_offset']['x'] = 0;
      $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
      $this_ability->recovery_options['ability_failure_frame'] = 4;
      $this_ability->recovery_options['ability_failure_frame_offset']['x'] = 0;
      $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->recovery_options['success_text'] = 'It was absorbed by the target!';
      $this_ability->recovery_options['failure_text'] = '';
      $energy_damage_amount = $this_ability->ability_damage;
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
             
    }
    
    // Return true on success
    return true;
    
      
    }
  );
?>