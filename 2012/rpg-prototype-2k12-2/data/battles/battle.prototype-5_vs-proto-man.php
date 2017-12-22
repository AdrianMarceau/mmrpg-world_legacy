<?
// PROTOTYPE BATTLE 5 : VS PROTO MAN
$battle = array(
  'battle_name' => 'Dr. Wily Battle',
  'battle_button' => 'Dr. Wily?',
  'battle_size' => '1x4',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-proto-man',
  'battle_description' => 'Defeat Dr. Wily\'s Proto Man!',
  'battle_turns' => 10,
  'battle_points' => 1500,
  'battle_robot_limit' => 2,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'field'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2001, 'robot_token' => 'proto-man', 'robot_points' => 9000, 'robot_abilities' => array('proto-buster', 'atomic-fire', 'leaf-shield', 'quick-boomerang', 'metal-blade', 'crash-bomber', 'air-shooter', 'energy-boost')),
      array('robot_id' => 1301, 'robot_token' => 'met', 'robot_points' => 4000, 'robot_abilities' => array('buster-shot', 'defense-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>