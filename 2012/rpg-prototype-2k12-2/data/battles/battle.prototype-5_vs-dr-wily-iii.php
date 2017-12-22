<?
// PROTOTYPE BATTLE 5 : VS DR. WILY III
$battle = array(
  'battle_name' => 'Dr. Wily III Battle',
  'battle_button' => 'Dr. Wily III',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-dr-wily-iii',
  'battle_description' => 'Defeat Dr. Wily\'s Robots!',
  'battle_turns' => 32,
  'battle_points' => 10000,
  'battle_robot_limit' => 8,
  'battle_field_base' => array('field_id' => 100, 'field_token' => 'wily-castle'),
  'battle_target_player' => array(
    'player_id' => 2000,
    'player_token' => 'dr-wily',
    'player_robots' => array(
      array('robot_id' => 2002, 'robot_token' => 'metal-man', 'robot_points' => 14000, 'robot_abilities' => array('metal-blade', 'buster-shot', 'speed-boost', 'attack-break', 'defense-break', 'attack-mode', 'defense-mode', 'energy-boost')),
      array('robot_id' => 2003, 'robot_token' => 'air-man', 'robot_points' => 14000, 'robot_abilities' => array('air-shooter', 'buster-shot', 'defense-boost', 'attack-break', 'speed-break', 'attack-mode', 'speed-mode', 'energy-boost')),
      array('robot_id' => 2004, 'robot_token' => 'bubble-man', 'robot_points' => 14000, 'robot_abilities' => array('bubble-lead', 'buster-shot', 'defense-boost', 'speed-break', 'bubble-bomb', 'speed-mode', 'attack-mode', 'energy-boost')),
      array('robot_id' => 2005, 'robot_token' => 'quick-man', 'robot_points' => 14000, 'robot_abilities' => array('quick-boomerang', 'buster-shot', 'attack-boost', 'speed-break', 'defense-break', 'speed-mode', 'defense-mode', 'energy-boost')),
      array('robot_id' => 2006, 'robot_token' => 'crash-man', 'robot_points' => 14000, 'robot_abilities' => array('crash-bomber', 'buster-shot', 'speed-boost', 'defense-break', 'attack-break', 'defense-mode', 'attack-mode', 'energy-boost')),
      array('robot_id' => 2007, 'robot_token' => 'flash-man', 'robot_points' => 14000, 'robot_abilities' => array('flash-stopper', 'buster-shot', 'defense-boost', 'speed-break', 'attack-break', 'speed-mode', 'attack-mode', 'energy-boost')),
      array('robot_id' => 2008, 'robot_token' => 'heat-man', 'robot_points' => 14000, 'robot_abilities' => array('atomic-fire', 'buster-shot', 'attack-boost', 'defense-burn', 'speed-break', 'defense-mode', 'speed-mode', 'energy-boost')),
      array('robot_id' => 2009, 'robot_token' => 'wood-man', 'robot_points' => 14000, 'robot_abilities' => array('leaf-shield', 'buster-shot', 'speed-boost', 'defense-break', 'attack-break', 'defense-mode', 'attack-mode', 'energy-boost'))
      )
    ),
  'battle_rewards' => array(
    )
  );
?>