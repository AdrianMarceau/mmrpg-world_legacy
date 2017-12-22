<?
// ELEC MAN
$robot = array(
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
  );
?>