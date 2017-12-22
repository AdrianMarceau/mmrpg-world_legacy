<?
// PROTOTYPE BATTLE 5 : VS METAL MAN
$battle = array(
  'battle_name' => 'Metal Man Battle',
  'battle_button' => 'Metal Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-metal-man',
  'battle_description' => 'Stop Metal Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'industrial-facility'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2002, 'robot_token' => 'metal-man', 'robot_points' => 0, 'robot_abilities' => array('metal-blade'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'metal-man')
      )
    )
  );
?>