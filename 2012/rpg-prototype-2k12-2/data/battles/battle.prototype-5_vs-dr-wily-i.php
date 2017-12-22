<?
// PROTOTYPE BATTLE 5 : VS DR. WILY I
$battle = array(
  'battle_name' => 'Dr. Wily Battle',
  'battle_button' => 'Dr. Wily',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-wily-i',
  'battle_description' => 'Defeat Dr. Wily\'s Robots!',
  'battle_turns' => 18,
  'battle_points' => 5000,
  'battle_robot_limit' => 4,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'wily-castle'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2002, 'robot_token' => 'metal-man', 'robot_points' => 9000, 'robot_abilities' => array('metal-blade', 'buster-shot', 'speed-boost', 'attack-break', 'defense-break')),
      array('robot_id' => 2003, 'robot_token' => 'air-man', 'robot_points' => 9000, 'robot_abilities' => array('air-shooter', 'buster-shot', 'defense-boost', 'attack-break', 'speed-break')),
      array('robot_id' => 2004, 'robot_token' => 'bubble-man', 'robot_points' => 9000, 'robot_abilities' => array('bubble-lead', 'buster-shot', 'defense-boost', 'speed-break', 'bubble-bomb')),
      array('robot_id' => 2005, 'robot_token' => 'quick-man', 'robot_points' => 9000, 'robot_abilities' => array('quick-boomerang', 'buster-shot', 'attack-boost', 'speed-break', 'defense-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>