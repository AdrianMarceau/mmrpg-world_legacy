<?
// PROTOTYPE BATTLE 5 : VS WOOD MAN
$battle = array(
  'battle_name' => 'Wood Man Battle',
  'battle_button' => 'Wood Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-wood-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Wood Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'preserved-forest-base'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2009, 'robot_token' => 'wood-man', 'robot_points' => 4000, 'robot_abilities' => array('leaf-shield', 'buster-shot', 'speed-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>