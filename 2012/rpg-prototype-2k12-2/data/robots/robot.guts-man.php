<?
// GUTS MAN
$robot = array(
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
  );
?>