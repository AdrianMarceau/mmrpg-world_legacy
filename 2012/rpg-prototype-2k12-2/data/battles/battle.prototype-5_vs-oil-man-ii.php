<?
// PROTOTYPE BATTLE 5 : VS OIL MAN
$battle = array(
  'battle_name' => 'Oil Man Battle',
  'battle_button' => 'Oil Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-oil-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Oil Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'oil-wells'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1009, 'robot_token' => 'oil-man', 'robot_points' => 4000, 'robot_abilities' => array('oil-slider', 'buster-shot', 'attack-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>