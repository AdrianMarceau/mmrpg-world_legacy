<?
// PROTOTYPE BATTLE 5 : VS FLASH MAN
$battle = array(
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
  );
?>