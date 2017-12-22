<?
// PROTOTYPE BATTLE 5 : VS HEAT MAN
$battle = array(
  'battle_name' => 'Heat Man Battle',
  'battle_button' => 'Heat Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-heat-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Heat Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'atomic-furnace'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2008, 'robot_token' => 'heat-man', 'robot_points' => 4000, 'robot_abilities' => array('atomic-fire', 'buster-shot', 'attack-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>