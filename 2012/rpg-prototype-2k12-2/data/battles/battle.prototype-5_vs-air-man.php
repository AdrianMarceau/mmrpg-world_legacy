<?
// PROTOTYPE BATTLE 5 : VS AIR MAN
$battle = array(
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
  );
?>