<?
// PROTOTYPE BATTLE 5 : VS AIR MAN
$battle = array(
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
  );
?>