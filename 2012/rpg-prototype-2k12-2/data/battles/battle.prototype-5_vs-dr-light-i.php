<?
// PROTOTYPE BATTLE 5 : VS DR. LIGHT I
$battle = array(
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
  );
?>