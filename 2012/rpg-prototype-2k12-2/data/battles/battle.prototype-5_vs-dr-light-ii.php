<?
// PROTOTYPE BATTLE 5 : VS DR. LIGHT II
$battle = array(
  'battle_name' => 'Dr. Light II Battle',
  'battle_button' => 'Dr. Light II',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-light-ii',
  'battle_description' => 'Defeat Dr. Light\'s Robots!',
  'battle_turns' => 18,
  'battle_points' => 5000,
  'battle_robot_limit' => 4,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'light-laboratory'),
  'battle_target_player' => array(
    'player_id' => 1000,
    'player_token' => 'dr-light',
    'player_robots' => array(
      array('robot_id' => 1006, 'robot_token' => 'fire-man', 'robot_points' => 9000, 'robot_abilities' => array('fire-storm', 'buster-shot', 'defense-burn', 'attack-boost', 'speed-boost')),
      array('robot_id' => 1007, 'robot_token' => 'elec-man', 'robot_points' => 9000, 'robot_abilities' => array('thunder-beam', 'buster-shot', 'defense-break', 'speed-boost', 'attack-boost')),
      array('robot_id' => 1008, 'robot_token' => 'time-man', 'robot_points' => 9000, 'robot_abilities' => array('time-arrow', 'buster-shot', 'speed-break', 'attack-boost', 'defense-boost')),
      array('robot_id' => 1009, 'robot_token' => 'oil-man', 'robot_points' => 9000, 'robot_abilities' => array('oil-slider', 'buster-shot', 'attack-break', 'speed-boost', 'defense-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>