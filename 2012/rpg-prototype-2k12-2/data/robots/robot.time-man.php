<?
// TIME MAN
$robot = array(
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
  );
?>