<?
// PROTO MAN
$robot = array(
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
  );
?>