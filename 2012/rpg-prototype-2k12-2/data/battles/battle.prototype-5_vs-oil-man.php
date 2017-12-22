<?
// PROTOTYPE BATTLE 5 : VS OIL MAN
$battle = array(
  'battle_name' => 'Oil Man Battle',
  'battle_button' => 'Oil Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-oil-man',
  'battle_description' => 'Stop Oil Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'oil-wells'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1009, 'robot_token' => 'oil-man', 'robot_points' => 0, 'robot_abilities' => array('oil-slider'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'oil-man')
      )
    )
  );
?>