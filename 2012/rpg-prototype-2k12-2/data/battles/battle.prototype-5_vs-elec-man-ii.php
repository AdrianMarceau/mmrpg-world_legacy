<?
// PROTOTYPE BATTLE 5 : VS ELEC MAN
$battle = array(
  'battle_name' => 'Elec Man Battle',
  'battle_button' => 'Elec Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-elec-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Elec Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'electrical-tower'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1007, 'robot_token' => 'elec-man', 'robot_points' => 4000, 'robot_abilities' => array('thunder-beam', 'buster-shot', 'defense-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>