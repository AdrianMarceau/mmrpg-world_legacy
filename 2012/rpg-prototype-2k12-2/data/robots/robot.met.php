<?
// MET
$robot = array(
  'robot_number' => 'DLM-001',
  'robot_name' => 'Met',
  'robot_token' => 'met',
  'robot_type' => '',
  'robot_description' => '',
  'robot_energy' => 100,
  'robot_attack' => 20,
  'robot_defense' => 120,
  'robot_speed' => 10,
  'robot_weaknesses' => array('impact', 'explode'),
  'robot_resistances' => array('water', 'flame', 'electric', 'nature'),
  'robot_abilities' => array('buster-shot', 'defense-boost', 'defense-mode'),
  'robot_rewards' => array(
    'abilities' => array(
        array('points' => 0, 'token' => 'buster-shot'),
        array('points' => 2000, 'token' => 'defense-boost'),
        array('points' => 5000, 'token' => 'defense-mode')
      )
    ),
  'robot_quotes' => array(
    'battle_start' => '&hellip;',
    'battle_taunt' => '&hellip;',
    'battle_victory' => '&hellip;?',
    'battle_defeat' => '&hellip;!'
    ),
  'robot_choices' => array(
    'abilities' => function($objects){
      // Extract all objects into the current scope
      extract($objects);
      // Create the ability options and weights variables
      $options = array();
      $weights = array();
      // Define the frequency of abilities, if not unset
      if ($this_robot->has_ability('buster-shot')){ $options[] = 'buster-shot'; $weights[] = 75;  }
      if ($this_robot->has_ability('defense-boost') && !$this_robot->has_defense_boost()){ $options[] = 'defense-boost'; $weights[] = 10;  }
      if ($this_robot->has_ability('defense-mode') && !$this_robot->has_defense_boost()){ $options[] = 'defense-mode'; $weights[] = 5;  }
      // Loop through unregistered abilities and add them to the options
      foreach ($this_robot->robot_abilities AS $key => $token){ if (!in_array($token, $options)){ $options[] = $token; $weights[] = 20; } }
      // Return an ability based on a weighted chance
      return $this_battle->weighted_chance($options, $weights);
    }
    )
  );
?>