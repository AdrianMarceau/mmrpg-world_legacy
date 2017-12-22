<?
// CUT MAN
$robot = array(
  'robot_number' => 'DLN-003',
  'robot_name' => 'Cut Man',
  'robot_token' => 'cut-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 110,
  'robot_defense' => 85,
  'robot_speed' => 105,
  'robot_weaknesses' => array('impact', 'flame'),
  'robot_resistances' => array('homing'),
  'robot_abilities' => array('buster-shot', 'rolling-cutter', 'attack-mode', 'speed-mode', 'attack-boost', 'speed-boost', 'defense-break', 'energy-boost'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'rolling-cutter'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-break'),
        array('points' => 3000, 'token' => 'attack-boost'),
        array('points' => 4000, 'token' => 'speed-boost'),
        array('points' => 5000, 'token' => 'attack-mode'),
        array('points' => 6000, 'token' => 'speed-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'May the sharpest blade win!',
    'battle_taunt' => 'I\'m gonna cut you down to size!',
    'battle_victory' => 'Snip-snippety-snip!',
    'battle_defeat' => 'Was I not sharp enough?'
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
      if ($this_robot->has_ability('rolling-cutter')){ $options[] = 'rolling-cutter'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-break') && !$target_robot->has_defense_break()){ $options[] = 'defense-break'; $weights[] = 10;  }
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