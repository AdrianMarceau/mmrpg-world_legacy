<?
// METAL MAN
$robot = array(
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
  );
?>