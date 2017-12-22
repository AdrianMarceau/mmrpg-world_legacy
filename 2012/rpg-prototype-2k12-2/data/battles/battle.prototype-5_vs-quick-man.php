<?
// PROTOTYPE BATTLE 5 : VS QUICK MAN
$battle = array(
  'battle_name' => 'Quick Man Battle',
  'battle_button' => 'Quick Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-quick-man',
  'battle_description' => 'Stop Quick Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'underground-laboratory'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2005, 'robot_token' => 'quick-man', 'robot_points' => 0, 'robot_abilities' => array('quick-boomerang'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'quick-man')
      )
    )
  );
?>