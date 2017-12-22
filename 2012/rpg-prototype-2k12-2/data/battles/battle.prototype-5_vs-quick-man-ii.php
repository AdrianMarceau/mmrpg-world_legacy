<?
// PROTOTYPE BATTLE 5 : VS QUICK MAN
$battle = array(
  'battle_name' => 'Quick Man Battle',
  'battle_button' => 'Quick Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-quick-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Quick Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'underground-laboratory'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2005, 'robot_token' => 'quick-man', 'robot_points' => 4000, 'robot_abilities' => array('quick-boomerang', 'buster-shot', 'attack-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>