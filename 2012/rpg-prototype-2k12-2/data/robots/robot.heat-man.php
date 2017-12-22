<?
// HEAT MAN
$robot = array(
  'robot_number' => 'DWN-015',
  'robot_name' => 'Heat Man',
  'robot_token' => 'heat-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 80,
  'robot_defense' => 155,
  'robot_speed' => 65,
  'robot_weaknesses' => array('water', 'freeze'),
  'robot_resistances' => array('impact'),
  'robot_affinities' => array('flame'),
  'robot_abilities' => array('buster-shot', 'atomic-fire', 'defense-mode', 'speed-mode', 'defense-burn', 'speed-break', 'attack-boost', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'atomic-fire'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'attack-boost'),
        array('points' => 3000, 'token' => 'defense-burn'),
        array('points' => 4000, 'token' => 'speed-break'),
        array('points' => 5000, 'token' => 'defense-mode'),
        array('points' => 6000, 'token' => 'speed-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Wait a minute... I\'ll get ignited.',
    'battle_taunt' => 'Watch out, I guess?',
    'battle_victory' => 'I won? Oh... thank you?',
    'battle_defeat' => 'I wasn\'t really paying attention...'
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
      if ($this_robot->has_ability('atomic-fire')){ $options[] = 'atomic-fire'; $weights[] = 75;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-burn') && !$target_robot->has_defense_break()){ $options[] = 'defense-burn'; $weights[] = 10;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
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