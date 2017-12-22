<?
// PROTOTYPE BATTLE 5 : VS TIME MAN
$battle = array(
  'battle_name' => 'Time Man Battle',
  'battle_button' => 'Time Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-time-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Time Man!',
  'battle_turns' => 3,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'clock-tower'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1008, 'robot_token' => 'time-man', 'robot_points' => 4000, 'robot_abilities' => array('time-arrow', 'buster-shot', 'speed-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>