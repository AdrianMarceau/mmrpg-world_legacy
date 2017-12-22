<?
// PROTOTYPE BATTLE 5 : VS ICE MAN
$battle = array(
  'battle_name' => 'Ice Man Battle',
  'battle_button' => 'Ice Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-ice-man',
  'battle_description' => 'Stop Ice Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'arctic-jungle'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1004, 'robot_token' => 'ice-man', 'robot_points' => 0, 'robot_abilities' => array('ice-slasher'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'ice-man')
      )
    )
  );
?>