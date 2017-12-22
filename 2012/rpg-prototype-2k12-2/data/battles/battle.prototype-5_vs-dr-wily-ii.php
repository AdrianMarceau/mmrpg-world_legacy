<?
// PROTOTYPE BATTLE 5 : VS DR. WILY II
$battle = array(
  'battle_name' => 'Dr. Wily II Battle',
  'battle_button' => 'Dr. Wily II',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-wily-ii',
  'battle_description' => 'Defeat Dr. Wily\'s Robots!',
  'battle_turns' => 18,
  'battle_points' => 5000,
  'battle_robot_limit' => 4,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'wily-castle'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2006, 'robot_token' => 'crash-man', 'robot_points' => 9000, 'robot_abilities' => array('crash-bomber', 'buster-shot', 'speed-boost', 'defense-break', 'attack-break')),
      array('robot_id' => 2007, 'robot_token' => 'flash-man', 'robot_points' => 9000, 'robot_abilities' => array('flash-stopper', 'buster-shot', 'defense-boost', 'speed-break', 'attack-break')),
      array('robot_id' => 2008, 'robot_token' => 'heat-man', 'robot_points' => 9000, 'robot_abilities' => array('atomic-fire', 'buster-shot', 'attack-boost', 'defense-burn', 'speed-break')),
      array('robot_id' => 2009, 'robot_token' => 'wood-man', 'robot_points' => 9000, 'robot_abilities' => array('leaf-shield', 'buster-shot', 'speed-boost', 'defense-break', 'attack-break'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>