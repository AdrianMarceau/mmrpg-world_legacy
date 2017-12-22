<?
// BOMB MAN
$robot = array(
  'robot_number' => 'DLN-006',
  'robot_name' => 'Bomb Man',
  'robot_token' => 'bomb-man',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 150,
  'robot_defense' => 70,
  'robot_speed' => 80,
  'robot_weaknesses' => array('cutter', 'flame'),
  'robot_resistances' => array('water'),
  'robot_affinities' => array('explode'),
  'robot_abilities' => array('buster-shot', 'hyper-bomb', 'defense-mode', 'attack-mode', 'defense-boost', 'attack-boost', 'speed-break', 'energy-boost'),
  'robot_attachments' => array(
    'ability_hyper-bomb' => array('class' => 'ability', 'ability_id' => 997, 'ability_token' => 'hyper-bomb')
    ),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'hyper-bomb'),
        array('points' => 1000, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'speed-break'),
        array('points' => 3000, 'token' => 'defense-boost'),
        array('points' => 4000, 'token' => 'attack-boost'),
        array('points' => 5000, 'token' => 'defense-mode'),
        array('points' => 6000, 'token' => 'attack-mode'),
        array('points' => 7000, 'token' => 'energy-boost')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => 'Bombs! Bombs! Bombs!',
    'battle_taunt' => 'Bombs?!',
    'battle_victory' => 'Bombs!!!',
    'battle_defeat' => 'Bombs...?'
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
      if ($this_robot->has_ability('hyper-bomb')){ $options[] = 'hyper-bomb'; $weights[] = 75;  }
      if ($this_robot->has_ability('speed-break') && !$target_robot->has_speed_break()){ $options[] = 'speed-break'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('attack-boost') && !$this_robot->has_attack_boost()){ $options[] = 'attack-boost'; $weights[] = 10;  }
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