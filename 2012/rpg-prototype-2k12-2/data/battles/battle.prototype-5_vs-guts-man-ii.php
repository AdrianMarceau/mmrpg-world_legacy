<?
// PROTOTYPE BATTLE 5 : VS GUTS MAN
$battle = array(
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
  );
?>