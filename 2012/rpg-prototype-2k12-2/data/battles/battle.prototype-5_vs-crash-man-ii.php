<?
// PROTOTYPE BATTLE 5 : VS CRASH MAN
$battle = array(
  'battle_name' => 'Crash Man Battle',
  'battle_button' => 'Crash Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-crash-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Crash Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'pipe-station'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2006, 'robot_token' => 'crash-man', 'robot_points' => 4000, 'robot_abilities' => array('crash-bomber', 'buster-shot', 'speed-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>