<?
// PROTOTYPE BATTLE 5 : VS BOMB MAN
$battle = array(
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
  );
?>