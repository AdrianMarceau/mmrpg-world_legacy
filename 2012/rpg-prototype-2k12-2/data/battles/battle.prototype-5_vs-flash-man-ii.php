<?
// PROTOTYPE BATTLE 5 : VS FLASH MAN
$battle = array(
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
  );
?>