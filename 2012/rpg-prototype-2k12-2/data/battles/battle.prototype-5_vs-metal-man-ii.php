<?
// PROTOTYPE BATTLE 5 : VS METAL MAN
$battle = array(
  'battle_name' => 'Metal Man Battle',
  'battle_button' => 'Metal Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-metal-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Metal Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'industrial-facility'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2002, 'robot_token' => 'metal-man', 'robot_points' => 4000, 'robot_abilities' => array('metal-blade', 'buster-shot', 'speed-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>