<?
// ICE MAN
$robot = array(
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
  );
?>