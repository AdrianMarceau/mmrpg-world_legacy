<?
// OIL MAN
$robot = array(
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
  );
?>