<?
// PROTOTYPE BATTLE 5 : VS FIRE MAN
$battle = array(
  'battle_name' => 'Fire Man Battle',
  'battle_button' => 'Fire Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-fire-man',
  'battle_description' => 'Stop Fire Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'steel-mill'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1006, 'robot_token' => 'fire-man', 'robot_points' => 0, 'robot_abilities' => array('fire-storm'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'fire-man')
      )
    )
  );
?>