<?
// BATTLE
$mmrpg_index['battles']['battle'] = array(
  'battle_name' => 'Battle',
  'battle_button' => '',
  'battle_size' => '1x4',
  'battle_encore' => false,
  'battle_status' => 'disabled',
  'battle_token' => 'battle',
  'battle_description' => 'Default battle object.',
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'field'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1, 'robot_token' => 'robot')
      )
    ),
  );// PROTOTYPE BATTLE 5 : VS AIR MAN
$mmrpg_index['battles']['prototype-5_vs-air-man-ii'] = array(
  'battle_name' => 'Air Man Battle',
  'battle_button' => 'Air Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-air-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Air Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'sky-ridge'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2003, 'robot_token' => 'air-man', 'robot_points' => 4000, 'robot_abilities' => array('air-shooter', 'buster-shot', 'defense-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS AIR MAN
$mmrpg_index['battles']['prototype-5_vs-air-man'] = array(
  'battle_name' => 'Air Man Battle',
  'battle_button' => 'Air Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-air-man',
  'battle_description' => 'Stop Air Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'sky-ridge'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2003, 'robot_token' => 'air-man', 'robot_points' => 0, 'robot_abilities' => array('air-shooter'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'air-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS BOMB MAN
$mmrpg_index['battles']['prototype-5_vs-bomb-man-ii'] = array(
  'battle_name' => 'Bomb Man Battle',
  'battle_button' => 'Bomb Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-bomb-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Bomb Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'orb-city'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1005, 'robot_token' => 'bomb-man', 'robot_points' => 4000, 'robot_abilities' => array('hyper-bomb', 'buster-shot', 'speed-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS BOMB MAN
$mmrpg_index['battles']['prototype-5_vs-bomb-man'] = array(
  'battle_name' => 'Bomb Man Battle',
  'battle_button' => 'Bomb Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-bomb-man',
  'battle_description' => 'Stop Bomb Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'orb-city'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1005, 'robot_token' => 'bomb-man', 'robot_points' => 0, 'robot_abilities' => array('hyper-bomb'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'bomb-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS BUBBLE MAN
$mmrpg_index['battles']['prototype-5_vs-bubble-man-ii'] = array(
  'battle_name' => 'Bubble Man Battle',
  'battle_button' => 'Bubble Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-bubble-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Bubble Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'waterfall-institute'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2004, 'robot_token' => 'bubble-man', 'robot_points' => 4000, 'robot_abilities' => array('bubble-lead'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS BUBBLE MAN
$mmrpg_index['battles']['prototype-5_vs-bubble-man'] = array(
  'battle_name' => 'Bubble Man Battle',
  'battle_button' => 'Bubble Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-bubble-man',
  'battle_description' => 'Stop Bubble Man!',
  'battle_points' => 500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'waterfall-institute'),
  'battle_turns' => 3,
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2004, 'robot_token' => 'bubble-man', 'robot_points' => 0, 'robot_abilities' => array('bubble-lead'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'bubble-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS CRASH MAN
$mmrpg_index['battles']['prototype-5_vs-crash-man-ii'] = array(
  'battle_name' => 'Crash Man Battle',
  'battle_button' => 'Crash Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-crash-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Crash Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'pipe-station'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2006, 'robot_token' => 'crash-man', 'robot_points' => 4000, 'robot_abilities' => array('crash-bomber', 'buster-shot', 'speed-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS CRASH MAN
$mmrpg_index['battles']['prototype-5_vs-crash-man'] = array(
  'battle_name' => 'Crash Man Battle',
  'battle_button' => 'Crash Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-crash-man',
  'battle_description' => 'Stop Crash Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'pipe-station'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2006, 'robot_token' => 'crash-man', 'robot_points' => 0, 'robot_abilities' => array('crash-bomber'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'crash-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS CUT MAN
$mmrpg_index['battles']['prototype-5_vs-cut-man-ii'] = array(
  'battle_name' => 'Cut Man Battle',
  'battle_button' => 'Cut Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-cut-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Cut Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'abandoned-warehouse'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1002, 'robot_token' => 'cut-man', 'robot_points' => 4000, 'robot_abilities' => array('rolling-cutter', 'buster-shot', 'defense-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS CUT MAN
$mmrpg_index['battles']['prototype-5_vs-cut-man'] = array(
  'battle_name' => 'Cut Man Battle',
  'battle_button' => 'Cut Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-cut-man',
  'battle_description' => 'Stop Cut Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'abandoned-warehouse'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1002, 'robot_token' => 'cut-man', 'robot_points' => 0, 'robot_abilities' => array('rolling-cutter'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'cut-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS DR. LIGHT I
$mmrpg_index['battles']['prototype-5_vs-dr-light-i'] = array(
  'battle_name' => 'Dr. Light Battle',
  'battle_button' => 'Dr. Light',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-light-i',
  'battle_description' => 'Defeat Dr. Light\'s Robots!',
  'battle_turns' => 18,
  'battle_points' => 5000,
  'battle_robot_limit' => 4,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'light-laboratory'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1002, 'robot_token' => 'cut-man', 'robot_points' => 9000, 'robot_abilities' => array('rolling-cutter', 'buster-shot', 'defense-break', 'attack-boost', 'speed-boost')),
      array('robot_id' => 1003, 'robot_token' => 'guts-man', 'robot_points' => 9000, 'robot_abilities' => array('super-arm', 'buster-shot', 'super-throw', 'defense-boost', 'attack-boost')),
      array('robot_id' => 1004, 'robot_token' => 'ice-man', 'robot_points' => 9000, 'robot_abilities' => array('ice-slasher', 'buster-shot', 'attack-break', 'speed-boost', 'defense-boost')),
      array('robot_id' => 1005, 'robot_token' => 'bomb-man', 'robot_points' => 9000, 'robot_abilities' => array('hyper-bomb', 'buster-shot', 'speed-break', 'defense-boost', 'attack-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS DR. LIGHT II
$mmrpg_index['battles']['prototype-5_vs-dr-light-ii'] = array(
  'battle_name' => 'Dr. Light II Battle',
  'battle_button' => 'Dr. Light II',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-light-ii',
  'battle_description' => 'Defeat Dr. Light\'s Robots!',
  'battle_turns' => 18,
  'battle_points' => 5000,
  'battle_robot_limit' => 4,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'light-laboratory'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1006, 'robot_token' => 'fire-man', 'robot_points' => 9000, 'robot_abilities' => array('fire-storm', 'buster-shot', 'defense-burn', 'attack-boost', 'speed-boost')),
      array('robot_id' => 1007, 'robot_token' => 'elec-man', 'robot_points' => 9000, 'robot_abilities' => array('thunder-beam', 'buster-shot', 'defense-break', 'speed-boost', 'attack-boost')),
      array('robot_id' => 1008, 'robot_token' => 'time-man', 'robot_points' => 9000, 'robot_abilities' => array('time-arrow', 'buster-shot', 'speed-break', 'attack-boost', 'defense-boost')),
      array('robot_id' => 1009, 'robot_token' => 'oil-man', 'robot_points' => 9000, 'robot_abilities' => array('oil-slider', 'buster-shot', 'attack-break', 'speed-boost', 'defense-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS DR. LIGHT III
$mmrpg_index['battles']['prototype-5_vs-dr-light-iii'] = array(
  'battle_name' => 'Dr. Light III Battle',
  'battle_button' => 'Dr. Light III',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-light-iii',
  'battle_description' => 'Defeat Dr. Light\'s Robots!',
  'battle_turns' => 32,
  'battle_points' => 10000,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'light-laboratory'),
  'battle_robot_limit' => 8,
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1002, 'robot_token' => 'cut-man', 'robot_points' => 14000, 'robot_abilities' => array('rolling-cutter', 'buster-shot', 'defense-break', 'attack-boost', 'speed-boost', 'attack-mode', 'speed-mode', 'energy-boost')),
      array('robot_id' => 1003, 'robot_token' => 'guts-man', 'robot_points' => 14000, 'robot_abilities' => array('super-arm', 'buster-shot', 'super-throw', 'defense-boost', 'attack-boost', 'defense-mode', 'attack-mode', 'energy-boost')),
      array('robot_id' => 1004, 'robot_token' => 'ice-man', 'robot_points' => 14000, 'robot_abilities' => array('ice-slasher', 'buster-shot', 'attack-break', 'speed-boost', 'defense-boost', 'speed-mode', 'defense-mode', 'energy-boost')),
      array('robot_id' => 1005, 'robot_token' => 'bomb-man', 'robot_points' => 14000, 'robot_abilities' => array('hyper-bomb', 'buster-shot', 'speed-break', 'defense-boost', 'attack-boost', 'defense-mode', 'speed-mode', 'energy-boost')),
      array('robot_id' => 1006, 'robot_token' => 'fire-man', 'robot_points' => 14000, 'robot_abilities' => array('fire-storm', 'buster-shot', 'defense-burn', 'attack-boost', 'speed-boost', 'attack-mode', 'speed-mode', 'energy-boost')),
      array('robot_id' => 1007, 'robot_token' => 'elec-man', 'robot_points' => 14000, 'robot_abilities' => array('thunder-beam', 'buster-shot', 'defense-break', 'speed-boost', 'atack-boost', 'speed-mode', 'attack-mode', 'energy-boost')),
      array('robot_id' => 1008, 'robot_token' => 'time-man', 'robot_points' => 14000, 'robot_abilities' => array('time-arrow', 'buster-shot', 'speed-break', 'attack-boost', 'defense-boost', 'attack-mode', 'defense-mode', 'energy-boost')),
      array('robot_id' => 1009, 'robot_token' => 'oil-man', 'robot_points' => 14000, 'robot_abilities' => array('oil-slider', 'buster-shot', 'attack-break', 'speed-boost', 'defense-boost', 'speed-mode', 'defense-mode', 'energy-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS DR. WILY I
$mmrpg_index['battles']['prototype-5_vs-dr-wily-i'] = array(
  'battle_name' => 'Dr. Wily Battle',
  'battle_button' => 'Dr. Wily',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-wily-i',
  'battle_description' => 'Defeat Dr. Wily\'s Robots!',
  'battle_turns' => 18,
  'battle_points' => 5000,
  'battle_robot_limit' => 4,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'wily-castle'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2002, 'robot_token' => 'metal-man', 'robot_points' => 9000, 'robot_abilities' => array('metal-blade', 'buster-shot', 'speed-boost', 'attack-break', 'defense-break')),
      array('robot_id' => 2003, 'robot_token' => 'air-man', 'robot_points' => 9000, 'robot_abilities' => array('air-shooter', 'buster-shot', 'defense-boost', 'attack-break', 'speed-break')),
      array('robot_id' => 2004, 'robot_token' => 'bubble-man', 'robot_points' => 9000, 'robot_abilities' => array('bubble-lead', 'buster-shot', 'defense-boost', 'speed-break', 'bubble-bomb')),
      array('robot_id' => 2005, 'robot_token' => 'quick-man', 'robot_points' => 9000, 'robot_abilities' => array('quick-boomerang', 'buster-shot', 'attack-boost', 'speed-break', 'defense-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS DR. WILY II
$mmrpg_index['battles']['prototype-5_vs-dr-wily-ii'] = array(
  'battle_name' => 'Dr. Wily II Battle',
  'battle_button' => 'Dr. Wily II',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-wily-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Robots!',
  'battle_turns' => 18,
  'battle_points' => 5000,
  'battle_robot_limit' => 4,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'wily-castle'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2006, 'robot_token' => 'crash-man', 'robot_points' => 9000, 'robot_abilities' => array('crash-bomber', 'buster-shot', 'speed-boost', 'defense-break', 'attack-break')),
      array('robot_id' => 2007, 'robot_token' => 'flash-man', 'robot_points' => 9000, 'robot_abilities' => array('flash-stopper', 'buster-shot', 'defense-boost', 'speed-break', 'attack-break')),
      array('robot_id' => 2008, 'robot_token' => 'heat-man', 'robot_points' => 9000, 'robot_abilities' => array('atomic-fire', 'buster-shot', 'attack-boost', 'defense-burn', 'speed-break')),
      array('robot_id' => 2009, 'robot_token' => 'wood-man', 'robot_points' => 9000, 'robot_abilities' => array('leaf-shield', 'buster-shot', 'speed-boost', 'defense-break', 'attack-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS DR. WILY III
$mmrpg_index['battles']['prototype-5_vs-dr-wily-iii'] = array(
  'battle_name' => 'Dr. Wily III Battle',
  'battle_button' => 'Dr. Wily III',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-wily-iii',
  'battle_description' => 'Defeat Dr. Wily\'s Robots!',
  'battle_turns' => 32,
  'battle_points' => 10000,
  'battle_robot_limit' => 8,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'wily-castle'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2002, 'robot_token' => 'metal-man', 'robot_points' => 14000, 'robot_abilities' => array('metal-blade', 'buster-shot', 'speed-boost', 'attack-break', 'defense-break', 'attack-mode', 'defense-mode', 'energy-boost')),
      array('robot_id' => 2003, 'robot_token' => 'air-man', 'robot_points' => 14000, 'robot_abilities' => array('air-shooter', 'buster-shot', 'defense-boost', 'attack-break', 'speed-break', 'attack-mode', 'speed-mode', 'energy-boost')),
      array('robot_id' => 2004, 'robot_token' => 'bubble-man', 'robot_points' => 14000, 'robot_abilities' => array('bubble-lead', 'buster-shot', 'defense-boost', 'speed-break', 'bubble-bomb', 'speed-mode', 'attack-mode', 'energy-boost')),
      array('robot_id' => 2005, 'robot_token' => 'quick-man', 'robot_points' => 14000, 'robot_abilities' => array('quick-boomerang', 'buster-shot', 'attack-boost', 'speed-break', 'defense-break', 'speed-mode', 'defense-mode', 'energy-boost')),
      array('robot_id' => 2006, 'robot_token' => 'crash-man', 'robot_points' => 14000, 'robot_abilities' => array('crash-bomber', 'buster-shot', 'speed-boost', 'defense-break', 'attack-break', 'defense-mode', 'attack-mode', 'energy-boost')),
      array('robot_id' => 2007, 'robot_token' => 'flash-man', 'robot_points' => 14000, 'robot_abilities' => array('flash-stopper', 'buster-shot', 'defense-boost', 'speed-break', 'attack-break', 'speed-mode', 'attack-mode', 'energy-boost')),
      array('robot_id' => 2008, 'robot_token' => 'heat-man', 'robot_points' => 14000, 'robot_abilities' => array('atomic-fire', 'buster-shot', 'attack-boost', 'defense-burn', 'speed-break', 'defense-mode', 'speed-mode', 'energy-boost')),
      array('robot_id' => 2009, 'robot_token' => 'wood-man', 'robot_points' => 14000, 'robot_abilities' => array('leaf-shield', 'buster-shot', 'speed-boost', 'defense-break', 'attack-break', 'defense-mode', 'attack-mode', 'energy-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS ELEC MAN
$mmrpg_index['battles']['prototype-5_vs-elec-man-ii'] = array(
  'battle_name' => 'Elec Man Battle',
  'battle_button' => 'Elec Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-elec-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Elec Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'electrical-tower'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1007, 'robot_token' => 'elec-man', 'robot_points' => 4000, 'robot_abilities' => array('thunder-beam', 'buster-shot', 'defense-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS ELEC MAN
$mmrpg_index['battles']['prototype-5_vs-elec-man'] = array(
  'battle_name' => 'Elec Man Battle',
  'battle_button' => 'Elec Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-elec-man',
  'battle_description' => 'Stop Elec Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'electrical-tower'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1007, 'robot_token' => 'elec-man', 'robot_points' => 0, 'robot_abilities' => array('thunder-beam'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'elec-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS FIRE MAN
$mmrpg_index['battles']['prototype-5_vs-fire-man-ii'] = array(
  'battle_name' => 'Fire Man Battle',
  'battle_button' => 'Fire Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-fire-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Fire Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'steel-mill'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1006, 'robot_token' => 'fire-man', 'robot_points' => 4000, 'robot_abilities' => array('fire-storm', 'buster-shot', 'defense-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS FIRE MAN
$mmrpg_index['battles']['prototype-5_vs-fire-man'] = array(
  'battle_name' => 'Fire Man Battle',
  'battle_button' => 'Fire Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-fire-man',
  'battle_description' => 'Stop Fire Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'steel-mill'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1006, 'robot_token' => 'fire-man', 'robot_points' => 0, 'robot_abilities' => array('fire-storm'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'fire-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS FLASH MAN
$mmrpg_index['battles']['prototype-5_vs-flash-man-ii'] = array(
  'battle_name' => 'Flash Man Battle',
  'battle_button' => 'Flash Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-flash-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Flash Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'crystal-cave'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2007, 'robot_token' => 'flash-man', 'robot_points' => 4000, 'robot_abilities' => array('flash-stopper', 'buster-shot', 'defense-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS FLASH MAN
$mmrpg_index['battles']['prototype-5_vs-flash-man'] = array(
  'battle_name' => 'Flash Man Battle',
  'battle_button' => 'Flash Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-flash-man',
  'battle_description' => 'Stop Flash Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'crystal-cave'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2007, 'robot_token' => 'flash-man', 'robot_points' => 0, 'robot_abilities' => array('flash-stopper'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'flash-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS GUTS MAN
$mmrpg_index['battles']['prototype-5_vs-guts-man-ii'] = array(
  'battle_name' => 'Guts Man Battle',
  'battle_button' => 'Guts Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-guts-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Guts Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'mountain-mines'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1003, 'robot_token' => 'guts-man', 'robot_points' => 4000, 'robot_abilities' => array('super-arm', 'buster-shot', 'attack-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS GUTS MAN
$mmrpg_index['battles']['prototype-5_vs-guts-man'] = array(
  'battle_name' => 'Guts Man Battle',
  'battle_button' => 'Guts Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-guts-man',
  'battle_description' => 'Stop Guts Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'mountain-mines'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1003, 'robot_token' => 'guts-man', 'robot_points' => 0, 'robot_abilities' => array('super-arm'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'guts-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS HEAT MAN
$mmrpg_index['battles']['prototype-5_vs-heat-man-ii'] = array(
  'battle_name' => 'Heat Man Battle',
  'battle_button' => 'Heat Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-heat-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Heat Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'atomic-furnace'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2008, 'robot_token' => 'heat-man', 'robot_points' => 4000, 'robot_abilities' => array('atomic-fire', 'buster-shot', 'attack-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS HEAT MAN
$mmrpg_index['battles']['prototype-5_vs-heat-man'] = array(
  'battle_name' => 'Heat Man Battle',
  'battle_button' => 'Heat Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-heat-man',
  'battle_description' => 'Stop Heat Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'atomic-furnace'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2008, 'robot_token' => 'heat-man', 'robot_points' => 0, 'robot_abilities' => array('atomic-fire'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'heat-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS ICE MAN
$mmrpg_index['battles']['prototype-5_vs-ice-man-ii'] = array(
  'battle_name' => 'Ice Man Battle',
  'battle_button' => 'Ice Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-ice-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Ice Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'arctic-jungle'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1004, 'robot_token' => 'ice-man', 'robot_points' => 4000, 'robot_abilities' => array('ice-slasher', 'buster-shot', 'attack-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS ICE MAN
$mmrpg_index['battles']['prototype-5_vs-ice-man'] = array(
  'battle_name' => 'Ice Man Battle',
  'battle_button' => 'Ice Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-ice-man',
  'battle_description' => 'Stop Ice Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'arctic-jungle'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1004, 'robot_token' => 'ice-man', 'robot_points' => 0, 'robot_abilities' => array('ice-slasher'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'ice-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS MEGA MAN
$mmrpg_index['battles']['prototype-5_vs-mega-man'] = array(
  'battle_name' => 'Dr. Light Battle',
  'battle_button' => 'Dr. Light?',
  'battle_size' => '1x4',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-mega-man',
  'battle_description' => 'Defeat Dr. Light\'s Mega Man!',
  'battle_turns' => 10,
  'battle_points' => 1500,
  'battle_robot_limit' => 2,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'field'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1001, 'robot_token' => 'mega-man', 'robot_points' => 9000, 'robot_abilities' => array('mega-buster', 'hyper-bomb', 'rolling-cutter', 'thunder-beam', 'fire-storm', 'ice-slasher', 'time-arrow', 'energy-boost')),
      array('robot_id' => 1301, 'robot_token' => 'met', 'robot_points' => 4000, 'robot_abilities' => array('buster-shot', 'defense-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS MET BONUS
$mmrpg_index['battles']['prototype-5_vs-met-bonus'] = array(
  'battle_name' => 'Met Bonus Battle',
  'battle_button' => 'Met Bonus',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-met-bonus',
  'battle_description' => 'Defeat The Met Army!',
  'battle_turns' => 30,
  'battle_points' => 9000,
  'battle_robot_limit' => 1,
  'battle_field_base' => array('field_id' => 1000, 'field_token' => 'guts-field'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1301, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met A'),
      array('robot_id' => 1302, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met B'),
      array('robot_id' => 1303, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met C'),
      array('robot_id' => 1304, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met D'),
      array('robot_id' => 1305, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met E'),
      array('robot_id' => 1306, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met F'),
      array('robot_id' => 1307, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met G'),
      array('robot_id' => 1308, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met H')
      ),
    'player_quotes' => array(
      'battle_start' => 'They\'re not very strong, but they\'re all I have at the moment...',
      'battle_taunt' => 'Please don\'t hurt any more of my robots...',
      'battle_victory' => 'I... I can\'t believe we made it! Great work, robots!',
      'battle_defeat' => 'I have nothing left to fight with...'
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'met')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS METAL MAN
$mmrpg_index['battles']['prototype-5_vs-metal-man-ii'] = array(
  'battle_name' => 'Metal Man Battle',
  'battle_button' => 'Metal Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-metal-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Metal Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'industrial-facility'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2002, 'robot_token' => 'metal-man', 'robot_points' => 4000, 'robot_abilities' => array('metal-blade', 'buster-shot', 'speed-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS METAL MAN
$mmrpg_index['battles']['prototype-5_vs-metal-man'] = array(
  'battle_name' => 'Metal Man Battle',
  'battle_button' => 'Metal Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-metal-man',
  'battle_description' => 'Stop Metal Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'industrial-facility'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2002, 'robot_token' => 'metal-man', 'robot_points' => 0, 'robot_abilities' => array('metal-blade'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'metal-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS OIL MAN
$mmrpg_index['battles']['prototype-5_vs-oil-man-ii'] = array(
  'battle_name' => 'Oil Man Battle',
  'battle_button' => 'Oil Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-oil-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Oil Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'oil-wells'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1009, 'robot_token' => 'oil-man', 'robot_points' => 4000, 'robot_abilities' => array('oil-slider', 'buster-shot', 'attack-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS OIL MAN
$mmrpg_index['battles']['prototype-5_vs-oil-man'] = array(
  'battle_name' => 'Oil Man Battle',
  'battle_button' => 'Oil Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-oil-man',
  'battle_description' => 'Stop Oil Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'oil-wells'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1009, 'robot_token' => 'oil-man', 'robot_points' => 0, 'robot_abilities' => array('oil-slider'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'oil-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS PROTO MAN
$mmrpg_index['battles']['prototype-5_vs-proto-man'] = array(
  'battle_name' => 'Dr. Wily Battle',
  'battle_button' => 'Dr. Wily?',
  'battle_size' => '1x4',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-proto-man',
  'battle_description' => 'Defeat Dr. Wily\'s Proto Man!',
  'battle_turns' => 10,
  'battle_points' => 1500,
  'battle_robot_limit' => 2,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'field'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2001, 'robot_token' => 'proto-man', 'robot_points' => 9000, 'robot_abilities' => array('proto-buster', 'atomic-fire', 'leaf-shield', 'quick-boomerang', 'metal-blade', 'crash-bomber', 'air-shooter', 'energy-boost')),
      array('robot_id' => 1301, 'robot_token' => 'met', 'robot_points' => 4000, 'robot_abilities' => array('buster-shot', 'defense-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS QUICK MAN
$mmrpg_index['battles']['prototype-5_vs-quick-man-ii'] = array(
  'battle_name' => 'Quick Man Battle',
  'battle_button' => 'Quick Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-quick-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Quick Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'underground-laboratory'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2005, 'robot_token' => 'quick-man', 'robot_points' => 4000, 'robot_abilities' => array('quick-boomerang', 'buster-shot', 'attack-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS QUICK MAN
$mmrpg_index['battles']['prototype-5_vs-quick-man'] = array(
  'battle_name' => 'Quick Man Battle',
  'battle_button' => 'Quick Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-quick-man',
  'battle_description' => 'Stop Quick Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'underground-laboratory'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2005, 'robot_token' => 'quick-man', 'robot_points' => 0, 'robot_abilities' => array('quick-boomerang'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'quick-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS TIME MAN
$mmrpg_index['battles']['prototype-5_vs-time-man-ii'] = array(
  'battle_name' => 'Time Man Battle',
  'battle_button' => 'Time Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-time-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Time Man!',
  'battle_turns' => 3,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'clock-tower'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1008, 'robot_token' => 'time-man', 'robot_points' => 4000, 'robot_abilities' => array('time-arrow', 'buster-shot', 'speed-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS TIME MAN
$mmrpg_index['battles']['prototype-5_vs-time-man'] = array(
  'battle_name' => 'Time Man Battle',
  'battle_button' => 'Time Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-time-man',
  'battle_description' => 'Stop Time Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'clock-tower'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1008, 'robot_token' => 'time-man', 'robot_points' => 0, 'robot_abilities' => array('time-arrow'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'time-man')
      )
    )
  );// PROTOTYPE BATTLE 5 : VS WOOD MAN
$mmrpg_index['battles']['prototype-5_vs-wood-man-ii'] = array(
  'battle_name' => 'Wood Man Battle',
  'battle_button' => 'Wood Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-wood-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Wood Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'preserved-forest-base'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2009, 'robot_token' => 'wood-man', 'robot_points' => 4000, 'robot_abilities' => array('leaf-shield', 'buster-shot', 'speed-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );// PROTOTYPE BATTLE 5 : VS WOOD MAN
$mmrpg_index['battles']['prototype-5_vs-wood-man'] = array(
  'battle_name' => 'Wood Man Battle',
  'battle_button' => 'Wood Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-wood-man',
  'battle_description' => 'Stop Wood Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'preserved-forest-base'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2009, 'robot_token' => 'wood-man', 'robot_points' => 0, 'robot_abilities' => array('leaf-shield'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'wood-man')
      )
    )
  );
?>