<?
// PROTOTYPE BATTLE 5 : VS BUBBLE MAN
$battle = array(
  'battle_name' => 'Bubble Man Battle',
  'battle_button' => 'Bubble Man',
  'battle_size' => '1x1',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-bubble-man-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Bubble Man!',
  'battle_turns' => 5,
  'battle_points' => 1500,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'waterfall-institute'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2004, 'robot_token' => 'bubble-man', 'robot_points' => 4000, 'robot_abilities' => array('bubble-lead'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>