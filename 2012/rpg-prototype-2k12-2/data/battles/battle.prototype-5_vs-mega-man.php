<?
// PROTOTYPE BATTLE 5 : VS MEGA MAN
$battle = array(
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
  );
?>