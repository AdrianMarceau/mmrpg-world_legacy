<?
// PROTOTYPE BATTLE 5 : VS TIME MAN
$battle = array(
  'battle_name' => 'Time Man Battle',
  'battle_button' => 'Time Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-time-man',
  'battle_description' => 'Stop Time Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'clock-tower'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1008, 'robot_token' => 'time-man', 'robot_points' => 0, 'robot_abilities' => array('time-arrow'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'time-man')
      )
    )
  );
?>