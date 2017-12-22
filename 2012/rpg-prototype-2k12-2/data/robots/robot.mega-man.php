<?
// MEGA MAN
$robot = array(
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
  );
?>