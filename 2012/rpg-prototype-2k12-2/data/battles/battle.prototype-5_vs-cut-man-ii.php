<?
// PROTOTYPE BATTLE 5 : VS CUT MAN
$battle = array(
  'battle_name' => 'Cut Man Battle',
  'battle_button' => 'Cut Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-cut-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Cut Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'abandoned-warehouse'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1002, 'robot_token' => 'cut-man', 'robot_points' => 4000, 'robot_abilities' => array('rolling-cutter', 'buster-shot', 'defense-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>