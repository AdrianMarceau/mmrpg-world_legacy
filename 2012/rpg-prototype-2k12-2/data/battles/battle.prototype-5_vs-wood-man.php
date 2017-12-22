<?
// PROTOTYPE BATTLE 5 : VS WOOD MAN
$battle = array(
  'battle_name' => 'Wood Man Battle',
  'battle_button' => 'Wood Man',
  'battle_size' => '1x1',
  'battle_encore' => false,
  'battle_token' => 'prototype-5_vs-wood-man',
  'battle_description' => 'Stop Wood Man!',
  'battle_turns' => 6,
  'battle_points' => 750,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'preserved-forest-base'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 2009, 'robot_token' => 'wood-man', 'robot_points' => 0, 'robot_abilities' => array('leaf-shield'))
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'wood-man')
      )
    )
  );
?>