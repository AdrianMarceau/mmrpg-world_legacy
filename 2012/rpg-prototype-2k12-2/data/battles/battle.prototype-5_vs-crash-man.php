<?
// PROTOTYPE BATTLE 5 : VS CRASH MAN
$battle = array(
  'battle_name' => 'Crash Man Battle',
  'battle_button' => 'Crash Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-crash-man',
  'battle_description' => 'Stop Crash Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'pipe-station'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2006, 'robot_token' => 'crash-man', 'robot_points' => 0, 'robot_abilities' => array('crash-bomber'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'crash-man')
      )
    )
  );
?>