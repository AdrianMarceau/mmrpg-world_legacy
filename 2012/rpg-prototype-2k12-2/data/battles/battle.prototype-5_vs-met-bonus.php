<?
// PROTOTYPE BATTLE 5 : VS MET BONUS
$battle = array(
  'battle_name' => 'Met Bonus Battle',
  'battle_button' => 'Met Bonus',
  'battle_size' => '1x4',
  'battle_encore' => true,
  'battle_token' => 'prototype-5_vs-met-bonus',
  'battle_description' => 'Defeat The Met Army!',
  'battle_turns' => 30,
  'battle_points' => 9000,
  'battle_robot_limit' => 1,
  'battle_field_base' => array('field_id' => 1000, 'field_token' => 'guts-field'),
  'battle_target_player' => array(
    'player_id' => 100,
    'player_token' => 'player',
    'player_robots' => array(
      array('robot_id' => 1301, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met A'),
      array('robot_id' => 1302, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met B'),
      array('robot_id' => 1303, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met C'),
      array('robot_id' => 1304, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met D'),
      array('robot_id' => 1305, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met E'),
      array('robot_id' => 1306, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met F'),
      array('robot_id' => 1307, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met G'),
      array('robot_id' => 1308, 'robot_token' => 'met', 'robot_points' => 19000, 'robot_name' => 'Met H')
      ),
    'player_quotes' => array(
      'battle_start' => 'They\'re not very strong, but they\'re all I have at the moment...',
      'battle_taunt' => 'Please don\'t hurt any more of my robots...',
      'battle_victory' => 'I... I can\'t believe we made it! Great work, robots!',
      'battle_defeat' => 'I have nothing left to fight with...'
      )
    ),
  'battle_rewards' => array(
    'robots' => array(
      array('token' => 'met')
      )
    )
  );
?>