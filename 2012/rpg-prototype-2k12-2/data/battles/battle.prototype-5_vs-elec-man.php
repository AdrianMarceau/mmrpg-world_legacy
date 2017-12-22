<?
// PROTOTYPE BATTLE 5 : VS ELEC MAN
$battle = array(
  'battle_name' => 'Elec Man Battle',
  'battle_button' => 'Elec Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-elec-man',
  'battle_description' => 'Stop Elec Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'electrical-tower'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1007, 'robot_token' => 'elec-man', 'robot_points' => 0, 'robot_abilities' => array('thunder-beam'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'elec-man')
      )
    )
  );
?>