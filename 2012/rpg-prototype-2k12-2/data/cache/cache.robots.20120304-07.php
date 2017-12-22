<?
// AIR MAN
$mmrpg_index['robots']['air-man'] = array(
  'robot_number' => 'DWN-010',
  'robot_name' => 'Air Man',
  'robot_token' => 'air-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 85,
  'robot_defense' => 135,
  'robot_speed' => 80,
  'robot_weaknesses' => array('nature', 'impact'),
  'robot_affinities' => array('wind'),
  'robot_abilities' => array('buster-shot', 'air-shooter', 'attack-mode', 'speed-mode', 'attack-break', 'speed-break', 'defense-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'air-shooter'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-boost'),
        array('points' => 3000, 'token' => 'attack-break'),
        array('points' => 4000, 'token' => 'speed-break'),
        array('points' => 5000, 'token' => 'attack-mode'),
        array('points' => 6000, 'token' => 'speed-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'You can\'t defeat me!',
    'battle_taunt' => 'Is that all you\'ve got?',
    'battle_victory' => 'Did I blow you away?',
    'battle_defeat' => 'But how?!?'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('air-shooter')){ $options[] = 'air-shooter'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-break') && !$target_robot->has_attack_break()){ $options[] = 'attack-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// BOMB MAN
$mmrpg_index['robots']['bomb-man'] = array(
  'robot_number' => 'DLN-006',
  'robot_name' => 'Bomb Man',
  'robot_token' => 'bomb-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 150,
  'robot_defense' => 70,
  'robot_speed' => 80,
  'robot_weaknesses' => array('cutter', 'flame'),
  'robot_resistances' => array('water'),
  'robot_affinities' => array('explode'),
  'robot_abilities' => array('buster-shot', 'hyper-bomb', 'defense-mode', 'attack-mode', 'defense-boost', 'attack-boost', 'speed-break', 'energy-boost'),
  'robot_attachments' => array(
    'ability_hyper-bomb' => array('class' => 'ability', 'ability_id' => 997, 'ability_token' => 'hyper-bomb')
    ),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'hyper-bomb'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'speed-break'),
        array('points' => 3000, 'token' => 'defense-boost'),
        array('points' => 4000, 'token' => 'attack-boost'),
        array('points' => 5000, 'token' => 'defense-mode'),
        array('points' => 6000, 'token' => 'attack-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Bombs! Bombs! Bombs!',
    'battle_taunt' => 'Bombs?!',
    'battle_victory' => 'Bombs!!!',
    'battle_defeat' => 'Bombs...?'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('hyper-bomb')){ $options[] = 'hyper-bomb'; $weights[] = 75;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// BUBBLE MAN
$mmrpg_index['robots']['bubble-man'] = array(
  'robot_number' => 'DWN-011',
  'robot_name' => 'Bubble Man',
  'robot_token' => 'bubble-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 90,
  'robot_defense' => 120,
  'robot_speed' => 90,
  'robot_weaknesses' => array('cutter', 'electric'),
  'robot_resistances' => array('flame'),
  'robot_immunities' => array('water'),
  'robot_abilities' => array('buster-shot', 'bubble-lead', 'speed-mode', 'attack-mode', 'speed-break', 'bubble-bomb', 'defense-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'bubble-lead'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-boost'),
        array('points' => 3000, 'token' => 'speed-break'),
        array('points' => 4000, 'token' => 'bubble-bomb'),
        array('points' => 5000, 'token' => 'speed-mode'),
        array('points' => 6000, 'token' => 'attack-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'The sea will swallow you!',
    'battle_taunt' => 'Is that all you\'ve got?',
    'battle_victory' => 'I win! Take that!',
    'battle_defeat' => 'How could I lose?'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('bubble-lead')){ $options[] = 'bubble-lead'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('bubble-bomb') && !$target_robot->has_attack_break()){ $options[] = 'bubble-bomb'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// CRASH MAN
$mmrpg_index['robots']['crash-man'] = array(
  'robot_number' => 'DWN-013',
  'robot_name' => 'Crash Man',
  'robot_token' => 'crash-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 145,
  'robot_defense' => 65,
  'robot_speed' => 90,
  'robot_weaknesses' => array('wind', 'flame'),
  'robot_resistances' => array('explode'),
  'robot_abilities' => array('buster-shot', 'crash-bomber', 'defense-mode', 'attack-mode', 'defense-break', 'attack-break', 'speed-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'crash-bomber'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'speed-boost'),
        array('points' => 3000, 'token' => 'defense-break'),
        array('points' => 4000, 'token' => 'attack-break'),
        array('points' => 5000, 'token' => 'defense-mode'),
        array('points' => 6000, 'token' => 'attack-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'I am the destroyer!',
    'battle_taunt' => 'Is that all you\'ve got?',
    'battle_victory' => 'You never stood a chance!',
    'battle_defeat' => 'This is inconceivable!'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('crash-bomber')){ $options[] = 'crash-bomber'; $weights[] = 75;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-break') && !$target_robot->has_defense_break()){ $options[] = 'defense-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-break') && !$target_robot->has_attack_break()){ $options[] = 'attack-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// CUT MAN
$mmrpg_index['robots']['cut-man'] = array(
  'robot_number' => 'DLN-003',
  'robot_name' => 'Cut Man',
  'robot_token' => 'cut-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 110,
  'robot_defense' => 85,
  'robot_speed' => 105,
  'robot_weaknesses' => array('impact', 'flame'),
  'robot_resistances' => array('homing'),
  'robot_abilities' => array('buster-shot', 'rolling-cutter', 'attack-mode', 'speed-mode', 'attack-boost', 'speed-boost', 'defense-break', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'rolling-cutter'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-break'),
        array('points' => 3000, 'token' => 'attack-boost'),
        array('points' => 4000, 'token' => 'speed-boost'),
        array('points' => 5000, 'token' => 'attack-mode'),
        array('points' => 6000, 'token' => 'speed-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'May the sharpest blade win!',
    'battle_taunt' => 'I\'m gonna cut you down to size!',
    'battle_victory' => 'Snip-snippety-snip!',
    'battle_defeat' => 'Was I not sharp enough?'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('rolling-cutter')){ $options[] = 'rolling-cutter'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-break') && !$target_robot->has_defense_break()){ $options[] = 'defense-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// ELEC MAN
$mmrpg_index['robots']['elec-man'] = array(
  'robot_number' => 'DLN-008',
  'robot_name' => 'Elec Man',
  'robot_token' => 'elec-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 155,
  'robot_defense' => 35,
  'robot_speed' => 110,
  'robot_weaknesses' => array('water', 'earth'),
  'robot_resistances' => array('freeze', 'time'),
  'robot_affinities' => array('electric'),
  'robot_abilities' => array('buster-shot', 'thunder-beam', 'speed-mode', 'attack-mode', 'speed-boost', 'attack-boost', 'defense-break', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'thunder-beam'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-break'),
        array('points' => 3000, 'token' => 'speed-boost'),
        array('points' => 4000, 'token' => 'attack-boost'),
        array('points' => 5000, 'token' => 'speed-mode'),
        array('points' => 6000, 'token' => 'attack-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Feel the power of my Thunder Beam!',
    'battle_taunt' => 'Is that all you\'ve got?',
    'battle_victory' => 'Electrifying!',
    'battle_defeat' => 'How could I lose?'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('thunder-beam')){ $options[] = 'thunder-beam'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-break') && !$target_robot->has_defense_break()){ $options[] = 'defense-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// FIRE MAN
$mmrpg_index['robots']['fire-man'] = array(
  'robot_number' => 'DLN-007',
  'robot_name' => 'Fire Man',
  'robot_token' => 'fire-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 135,
  'robot_defense' => 95,
  'robot_speed' => 70,
  'robot_weaknesses' => array('freeze', 'wind'),
  'robot_resistances' => array('water', 'nature'),
  'robot_affinities' => array('flame'),
  'robot_abilities' => array('buster-shot', 'fire-storm', 'attack-mode', 'speed-mode', 'attack-boost', 'speed-boost', 'defense-burn', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'fire-storm'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-burn'),
        array('points' => 3000, 'token' => 'attack-boost'),
        array('points' => 4000, 'token' => 'speed-boost'),
        array('points' => 5000, 'token' => 'attack-mode'),
        array('points' => 6000, 'token' => 'speed-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'I\'ll fire you!',
    'battle_taunt' => 'Is that all you\'ve got?',
    'battle_victory' => 'Fire! Fire! Fire!!',
    'battle_defeat' => 'There wasn\'t enough fire!'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('fire-storm')){ $options[] = 'fire-storm'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-burn') && !$target_robot->has_defense_break()){ $options[] = 'defense-burn'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// FLASH MAN
$mmrpg_index['robots']['flash-man'] = array(
  'robot_number' => 'DWN-014',
  'robot_name' => 'Flash Man',
  'robot_token' => 'flash-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 70,
  'robot_defense' => 95,
  'robot_speed' => 135,
  'robot_weaknesses' => array('explode', 'freeze'),
  'robot_resistances' => array('light'),
  'robot_immunities' => array('time'),
  'robot_abilities' => array('buster-shot', 'flash-stopper', 'speed-mode', 'attack-mode', 'speed-break', 'attack-break', 'defense-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'flash-stopper'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-boost'),
        array('points' => 3000, 'token' => 'speed-break'),
        array('points' => 4000, 'token' => 'attack-break'),
        array('points' => 5000, 'token' => 'speed-mode'),
        array('points' => 6000, 'token' => 'attack-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Stop in the name of love!',
    'battle_taunt' => 'Is that all you\'ve got?',
    'battle_victory' => 'That was illuminating!',
    'battle_defeat' => 'My light is fading...'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('flash-stopper')){ $options[] = 'flash-stopper'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-break') && !$target_robot->has_attack_break()){ $options[] = 'attack-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// GUTS MAN
$mmrpg_index['robots']['guts-man'] = array(
  'robot_number' => 'DLN-004',
  'robot_name' => 'Guts Man',
  'robot_token' => 'guts-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 120,
  'robot_defense' => 120,
  'robot_speed' => 60,
  'robot_weaknesses' => array('explode', 'time'),
  'robot_resistances' => array('impact'),
  'robot_abilities' => array('buster-shot', 'super-arm', 'defense-mode', 'attack-mode', 'defense-boost', 'attack-boost', 'super-throw', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'super-arm'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-boost'),
        array('points' => 3000, 'token' => 'attack-boost'),
        array('points' => 4000, 'token' => 'super-throw'),
        array('points' => 5000, 'token' => 'defense-mode'),
        array('points' => 6000, 'token' => 'attack-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Maximum power!',
    'battle_taunt' => 'Is that all you\'ve got?',
    'battle_victory' => 'You were no match for my power!',
    'battle_defeat' => 'I wont forget this!'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('super-arm')){ $options[] = 'super-arm'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('super-throw') && $target_player->counters['robots_active'] > 1){ $options[] = 'super-throw'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// HEAT MAN
$mmrpg_index['robots']['heat-man'] = array(
  'robot_number' => 'DWN-015',
  'robot_name' => 'Heat Man',
  'robot_token' => 'heat-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 80,
  'robot_defense' => 155,
  'robot_speed' => 65,
  'robot_weaknesses' => array('water', 'freeze'),
  'robot_resistances' => array('impact'),
  'robot_affinities' => array('flame'),
  'robot_abilities' => array('buster-shot', 'atomic-fire', 'defense-mode', 'speed-mode', 'defense-burn', 'speed-break', 'attack-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'atomic-fire'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'attack-boost'),
        array('points' => 3000, 'token' => 'defense-burn'),
        array('points' => 4000, 'token' => 'speed-break'),
        array('points' => 5000, 'token' => 'defense-mode'),
        array('points' => 6000, 'token' => 'speed-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Wait a minute... I\'ll get ignited.',
    'battle_taunt' => 'Watch out, I guess?',
    'battle_victory' => 'I won? Oh... thank you?',
    'battle_defeat' => 'I wasn\'t really paying attention...'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('atomic-fire')){ $options[] = 'atomic-fire'; $weights[] = 75;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-burn') && !$target_robot->has_defense_break()){ $options[] = 'defense-burn'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// ICE MAN
$mmrpg_index['robots']['ice-man'] = array(
  'robot_number' => 'DLN-005',
  'robot_name' => 'Ice Man',
  'robot_token' => 'ice-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 95,
  'robot_defense' => 100,
  'robot_speed' => 105,
  'robot_weaknesses' => array('electric', 'explode'),
  'robot_immunities' => array('freeze'),
  'robot_abilities' => array('buster-shot', 'ice-slasher', 'speed-mode', 'defense-mode', 'speed-boost', 'defense-boost', 'attack-break', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'ice-slasher'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'attack-break'),
        array('points' => 3000, 'token' => 'speed-boost'),
        array('points' => 4000, 'token' => 'defense-boost'),
        array('points' => 5000, 'token' => 'speed-mode'),
        array('points' => 6000, 'token' => 'defense-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Watch out, I\'ll freeze you!',
    'battle_taunt' => 'Can you see me, everyone?',
    'battle_victory' => 'Look, everyone! I won!',
    'battle_defeat' => 'Everyone, I can explain!'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('ice-slasher')){ $options[] = 'ice-slasher'; $weights[] = 75;  }
      if ($this_robot->has_ability('attack-break') && !$target_robot->has_attack_break()){ $options[] = 'attack-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// MEGA MAN
$mmrpg_index['robots']['mega-man'] = array(
  'robot_number' => 'DLN-001',
  'robot_name' => 'Mega Man',
  'robot_token' => 'mega-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 100,
  'robot_defense' => 100,
  'robot_speed' => 100,
  'robot_weaknesses' => array('electric', 'freeze'),
  'robot_abilities' => array('mega-buster', 'copy-shot', 'energy-break', 'attack-boost', 'defense-boost', 'speed-boost', 'energy-boost', 'repair-mode'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'mega-buster'),
        array('points' => 1000, 'token' => 'copy-shot'),
        array('points' => 2000, 'token' => 'energy-boost'),
        array('points' => 3000, 'token' => 'attack-boost'),
        array('points' => 4000, 'token' => 'defense-boost'),
        array('points' => 5000, 'token' => 'speed-boost'),
        array('points' => 6000, 'token' => 'energy-break'),
        array('points' => 7000, 'token' => 'repair-mode')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'I fight for peace and justice!',
    'battle_taunt' => 'Surrender now or prepare to be defeated!',
    'battle_victory' => 'Fight! For everlasting peace!',
    'battle_defeat' => 'I\'m sorry everyone...'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('copy-shot')){ $options[] = 'copy-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('mega-buster')){ $options[] = 'mega-buster'; $weights[] = 75;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('energy-break') && $target_robot->below_energy_percent(15)){ $options[] = 'energy-break'; $weights[] = 40;  }
      if ($this_robot->has_ability('repair-mode') && $this_robot->below_energy_percent(25)){ $options[] = 'repair-mode'; $weights[] = 50;  }
      elseif ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(50)){ $options[] = 'energy-boost'; $weights[] = 25;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// MET
$mmrpg_index['robots']['met'] = array(
  'robot_number' => 'DLM-001',
  'robot_name' => 'Met',
  'robot_token' => 'met',
  'robot_type' => '',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 20,
  'robot_defense' => 120,
  'robot_speed' => 10,
  'robot_weaknesses' => array('impact', 'explode'),
  'robot_resistances' => array('water', 'flame', 'electric', 'nature'),
  'robot_abilities' => array('buster-shot', 'defense-boost', 'defense-mode'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-boost'),
        array('points' => 5000, 'token' => 'defense-mode')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => '&hellip;',
    'battle_taunt' => '&hellip;',
    'battle_victory' => '&hellip;?',
    'battle_defeat' => '&hellip;!'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// METAL MAN
$mmrpg_index['robots']['metal-man'] = array(
  'robot_number' => 'DWN-009',
  'robot_name' => 'Metal Man',
  'robot_token' => 'metal-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 110,
  'robot_defense' => 80,
  'robot_speed' => 110,
  'robot_weaknesses' => array('cutter', 'earth'),
  'robot_abilities' => array('buster-shot', 'metal-blade', 'attack-mode', 'defense-mode', 'attack-break', 'defense-break', 'speed-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'metal-blade'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'speed-boost'),
        array('points' => 3000, 'token' => 'attack-break'),
        array('points' => 4000, 'token' => 'defense-break'),
        array('points' => 5000, 'token' => 'attack-mode'),
        array('points' => 6000, 'token' => 'defense-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Catch! Hee hee hee...',
    'battle_taunt' => 'I\'m gonna slice you up good!',
    'battle_victory' => 'That was barely satisfying.',
    'battle_defeat' => 'This is unacceptable!'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('metal-blade')){ $options[] = 'metal-blade'; $weights[] = 75;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-break') && !$target_robot->has_attack_break()){ $options[] = 'attack-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-break') && !$target_robot->has_defense_break()){ $options[] = 'defense-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// OIL MAN
$mmrpg_index['robots']['oil-man'] = array(
  'robot_number' => 'DLN-010',
  'robot_name' => 'Oil Man',
  'robot_token' => 'oil-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 60,
  'robot_defense' => 100,
  'robot_speed' => 140,
  'robot_weaknesses' => array('flame', 'freeze'),
  'robot_resistances' => array('water', 'electric'),
  'robot_abilities' => array('buster-shot', 'oil-slider', 'speed-mode', 'defense-mode', 'speed-boost', 'defense-boost', 'attack-break', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'oil-slider'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'attack-break'),
        array('points' => 3000, 'token' => 'speed-boost'),
        array('points' => 4000, 'token' => 'defense-boost'),
        array('points' => 5000, 'token' => 'speed-mode'),
        array('points' => 6000, 'token' => 'defense-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Yeah, it\'s showtime!',
    'battle_taunt' => 'You\'re a bit rusty. Want a little oil?',
    'battle_victory' => 'You gotta keep it real, know what I\'m sayin\'?',
    'battle_defeat' => 'Ow, that was harsh!'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('oil-slider')){ $options[] = 'oil-slider'; $weights[] = 75;  }
      if ($this_robot->has_ability('attack-break') && !$target_robot->has_attack_break()){ $options[] = 'attack-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// PROTO MAN
$mmrpg_index['robots']['proto-man'] = array(
  'robot_number' => 'DLN-000',
  'robot_name' => 'Proto Man',
  'robot_token' => 'proto-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 105,
  'robot_defense' => 95,
  'robot_speed' => 100,
  'robot_weaknesses' => array('impact', 'explode'),
  'robot_abilities' => array('proto-buster', 'copy-shot', 'energy-break', 'attack-break', 'defense-break', 'speed-break', 'energy-boost', 'repair-mode'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'proto-buster'),
        array('points' => 1000, 'token' => 'copy-shot'),
        array('points' => 2000, 'token' => 'energy-boost'),
        array('points' => 3000, 'token' => 'attack-break'),
        array('points' => 4000, 'token' => 'defense-break'),
        array('points' => 5000, 'token' => 'speed-break'),
        array('points' => 6000, 'token' => 'energy-break'),
        array('points' => 7000, 'token' => 'repair-mode')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'I warn you not to stand in my way!',
    'battle_taunt' => 'Give up now, or face defeat!',
    'battle_victory' => 'This victory was inevitable.',
    'battle_defeat' => 'I do not understand...'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('copy-shot')){ $options[] = 'copy-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('proto-buster')){ $options[] = 'proto-buster'; $weights[] = 75;  }
      if ($this_robot->has_ability('attack-break') && !$target_robot->has_attack_break()){ $options[] = 'attack-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-break') && !$target_robot->has_defense_break()){ $options[] = 'defense-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('energy-break') && $target_robot->below_energy_percent(15)){ $options[] = 'energy-break'; $weights[] = 40;  }
      if ($this_robot->has_ability('repair-mode') && $this_robot->below_energy_percent(25)){ $options[] = 'repair-mode'; $weights[] = 50;  }
      elseif ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(50)){ $options[] = 'energy-boost'; $weights[] = 25;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// QUICK MAN
$mmrpg_index['robots']['quick-man'] = array(
  'robot_number' => 'DWN-012',
  'robot_name' => 'Quick Man',
  'robot_token' => 'quick-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 70,
  'robot_defense' => 65,
  'robot_speed' => 165,
  'robot_weaknesses' => array('time', 'explode'),
  'robot_resistances' => array(),
  'robot_immunities' => array('impact'),
  'robot_abilities' => array('buster-shot', 'quick-boomerang', 'speed-mode', 'defense-mode', 'speed-break', 'defense-break', 'attack-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'quick-boomerang'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'attack-boost'),
        array('points' => 3000, 'token' => 'speed-break'),
        array('points' => 4000, 'token' => 'defense-break'),
        array('points' => 5000, 'token' => 'speed-mode'),
        array('points' => 6000, 'token' => 'defense-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Can you keep up with me!?!',
    'battle_taunt' => 'I\'m too fast for you!',
    'battle_victory' => 'You weren\'t nearly fast enough!',
    'battle_defeat' => 'This is embarrassing...'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('quick-boomerang')){ $options[] = 'quick-boomerang'; $weights[] = 75;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-break') && !$target_robot->has_defense_break()){ $options[] = 'defense-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-mode') && !$this_robot->has_speed_boost()){ $options[] = 'speed-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// ROBOT
$mmrpg_index['robots']['robot'] = array(
  'robot_number' => 'ROBOT',
  'robot_name' => 'Robot',
  'robot_token' => 'robot',
  'robot_description' => 'The default robot object.',
  'robot_energy' => 1,
  'robot_attack' => 1,
  'robot_defense' => 1,
  'robot_speed' => 1,
  'robot_abilities' => array('buster-shot'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'buster-shot')
      )
    )
  );// TIME MAN
$mmrpg_index['robots']['time-man'] = array(
  'robot_number' => 'DLN-009',
  'robot_name' => 'Time Man',
  'robot_token' => 'time-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 130,
  'robot_defense' => 60,
  'robot_speed' => 110,
  'robot_weaknesses' => array('electric', 'nature'),
  'robot_resistances' => array('space'),
  'robot_immunities' => array('time'),
  'robot_abilities' => array('buster-shot', 'time-arrow', 'attack-mode', 'defense-mode', 'attack-boost', 'defense-boost', 'speed-break', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'time-arrow'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'speed-break'),
        array('points' => 3000, 'token' => 'attack-boost'),
        array('points' => 4000, 'token' => 'defense-boost'),
        array('points' => 5000, 'token' => 'attack-mode'),
        array('points' => 6000, 'token' => 'defense-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Please don\'t waste my time...',
    'battle_taunt' => 'You\'re ahead of schedule... let me slow you down!',
    'battle_victory' => 'I mean really, your timing was all off!',
    'battle_defeat' => 'Oh my, I must have miscalculated...'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('time-arrow')){ $options[] = 'time-arrow'; $weights[] = 75;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(30)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );// WOOD MAN
$mmrpg_index['robots']['wood-man'] = array(
  'robot_number' => 'DWN-016',
  'robot_name' => 'Wood Man',
  'robot_token' => 'wood-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 65,
  'robot_defense' => 185,
  'robot_speed' => 50,
  'robot_weaknesses' => array('flame', 'cutter'),
  'robot_resistances' => array('electric', 'water'),
  'robot_abilities' => array('buster-shot', 'leaf-shield', 'defense-mode', 'attack-mode', 'defense-break', 'attack-break', 'speed-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'leaf-shield'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'speed-boost'),
        array('points' => 3000, 'token' => 'defense-break'),
        array('points' => 4000, 'token' => 'attack-break'),
        array('points' => 5000, 'token' => 'defense-mode'),
        array('points' => 6000, 'token' => 'attack-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Prepare to feel the wrath of mother nature!',
    'battle_taunt' => 'Did I just see you step on that plant over there?!',
    'battle_victory' => 'I had the grace of mother nature on my side!',
    'battle_defeat' => 'Wont somebody please think of the trees?'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 25;  }
      if ($this_robot->has_ability('leaf-shield')){ $options[] = 'leaf-shield'; $weights[] = 75;  }
      if ($this_robot->has_ability('speed-boost') && !$this_robot->has_speed_boost()){ $options[] = 'speed-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-break') && !$target_robot->has_defense_break()){ $options[] = 'defense-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-break') && !$target_robot->has_attack_break()){ $options[] = 'attack-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('attack-mode') && !$this_robot->has_attack_boost()){ $options[] = 'attack-mode'; $weights[] = 5;  }
      if ($this_robot->has_ability('energy-boost') && $this_robot->below_energy_percent(50)){ $options[] = 'energy-boost'; $weights[] = 50;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );
?>