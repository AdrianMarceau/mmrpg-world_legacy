<?
// PROTOTYPE BATTLE 5 : VS FIRE MAN
$battle = array(
  'battle_name' => 'Fire Man Battle',
  'battle_button' => 'Fire Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-fire-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Fire Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'steel-mill'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1006, 'robot_token' => 'fire-man', 'robot_points' => 4000, 'robot_abilities' => array('fire-storm', 'buster-shot', 'defense-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>