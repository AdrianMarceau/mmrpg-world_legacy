<?
// FLASH MAN
$robot = array(
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
  );
?>