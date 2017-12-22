<?
// PROTOTYPE BATTLE 5 : VS DR. LIGHT III
$battle = array(
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
  );
?>