<?
// PROTOTYPE BATTLE 5 : VS CUT MAN
$battle = array(
  'battle_name' => 'Cut Man Battle',
  'battle_button' => 'Cut Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-cut-man',
  'battle_description' => 'Stop Cut Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'abandoned-warehouse'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1002, 'robot_token' => 'cut-man', 'robot_points' => 0, 'robot_abilities' => array('rolling-cutter'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'cut-man')
      )
    )
  );
?>