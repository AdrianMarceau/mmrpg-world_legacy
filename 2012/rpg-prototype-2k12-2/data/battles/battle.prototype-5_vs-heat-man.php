<?
// PROTOTYPE BATTLE 5 : VS HEAT MAN
$battle = array(
  'battle_name' => 'Heat Man Battle',
  'battle_button' => 'Heat Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-heat-man',
  'battle_description' => 'Stop Heat Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'atomic-furnace'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2008, 'robot_token' => 'heat-man', 'robot_points' => 0, 'robot_abilities' => array('atomic-fire'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'heat-man')
      )
    )
  );
?>