<?
// PROTOTYPE BATTLE 5 : VS BUBBLE MAN
$battle = array(
  'battle_name' => 'Bubble Man Battle',
  'battle_button' => 'Bubble Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-bubble-man',
  'battle_description' => 'Stop Bubble Man!',
  'battle_points' => 500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'waterfall-institute'),
  'battle_turns' => 3,
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2004, 'robot_token' => 'bubble-man', 'robot_points' => 0, 'robot_abilities' => array('bubble-lead'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'bubble-man')
      )
    )
  );
?>