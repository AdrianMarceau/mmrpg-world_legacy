<?
// PROTOTYPE BATTLE 5 : VS GUTS MAN
$battle = array(
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
  );
?>