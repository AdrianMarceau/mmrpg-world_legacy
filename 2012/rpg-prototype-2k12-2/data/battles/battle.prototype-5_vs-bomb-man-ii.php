<?
// PROTOTYPE BATTLE 5 : VS BOMB MAN
$battle = array(
  'battle_name' => 'Bomb Man Battle',
  'battle_button' => 'Bomb Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-bomb-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Bomb Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'orb-city'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1005, 'robot_token' => 'bomb-man', 'robot_points' => 4000, 'robot_abilities' => array('hyper-bomb', 'buster-shot', 'speed-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>