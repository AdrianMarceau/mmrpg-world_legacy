<?
// PROTOTYPE BATTLE 5 : VS ICE MAN
$battle = array(
  'battle_name' => 'Ice Man Battle',
  'battle_button' => 'Ice Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-ice-man-ii',
  'battle_description' => 'Defeat Dr. Light\'s Ice Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'arctic-jungle'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1004, 'robot_token' => 'ice-man', 'robot_points' => 4000, 'robot_abilities' => array('ice-slasher', 'buster-shot', 'attack-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>