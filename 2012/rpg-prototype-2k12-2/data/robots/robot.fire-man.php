<?
// FIRE MAN
$robot = array(
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
  );
?>