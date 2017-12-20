<?php
/*
 * Filename : mock-data.php
 * Title	:
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : Jul 6, 2009
 *
 * Description:
 *
 */

// Collect any GET variables that might be present
$player1_robot1 = isset($_GET['player1_robot1']) ? $_GET['player1_robot1'] : 'rock';
$player1_robot2 = isset($_GET['player1_robot2']) ? $_GET['player1_robot2'] : 'roll';
$player1_robot3 = isset($_GET['player1_robot3']) ? $_GET['player1_robot3'] : 'none';
$player2_robot1 = isset($_GET['player2_robot1']) ? $_GET['player2_robot1'] : 'protoman';
$player2_robot2 = isset($_GET['player2_robot2']) ? $_GET['player2_robot2'] : 'none';
$player2_robot3 = isset($_GET['player2_robot3']) ? $_GET['player2_robot3'] : 'none';

// Create a few dummy abilities for playing with
$abilities = array();
$abilities[0] = generate_new_ability('Proto Blast', '60', 'none', 'offensive');
$abilities[1] = generate_new_ability('Mega Buster', '30', 'none', 'offensive');
$abilities[2] = generate_new_ability('Roll Swing', '20', 'none', 'offensive');
$abilities[3] = generate_new_ability('Hyper Bomb', '40', 'bomb', 'offensive');
$abilities[4] = generate_new_ability('Rolling Cutter', '20', 'metl', 'offensive');
$abilities[5] = generate_new_ability('Elec Beam', '33', 'elec', 'offensive');
$abilities[6] = generate_new_ability('Fire Storm', '40', 'heat', 'offensive');
$abilities[7] = generate_new_ability('Super Arm', '50', 'powr', 'offensive');
$abilities[8] = generate_new_ability('Ice Slasher', '30', 'cold', 'offensive');
$abilities[9] = generate_new_ability('Oil Slider', '25', 'erth', 'offensive');
$abilities[10] = generate_new_ability('Time Arrow', '10', 'time', 'offensive');
$abilities[11] = generate_new_ability('Mega Kick', '10', 'none', 'offensive');

// Create a few dummy robot's for playing with
$robots = array();
$robots['rock'] = generate_new_robot('Rock', 'rock', 'none', 'male', '2300', '15', '1350', $abilities[11]);
$robots['roll'] = generate_new_robot('Roll', 'roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['protoman'] = generate_new_robot('Proto Man', 'protoman', 'none', 'male', '3100', '16', '2420', $abilities[0]);
$robots['megaman'] = generate_new_robot('Mega Man', 'megaman', 'none', 'male', '3000', '15', '2100', $abilities[1]);
$robots['bombman'] = generate_new_robot('Bomb Man', 'bombman', 'bomb', 'male', '2900', '28', '1580', $abilities[3]);
$robots['cutman'] = generate_new_robot('Cut Man', 'cutman', 'metl', 'male', '2800', '27', '1450', $abilities[4]);
$robots['elecman'] = generate_new_robot('Elec Man', 'elecman', 'elec', 'male', '3050', '33', '2350', $abilities[5]);
$robots['fireman'] = generate_new_robot('Fire Man', 'fireman', 'heat', 'male', '1950', '17', '1470', $abilities[6]);
$robots['gutsman'] = generate_new_robot('Guts Man', 'gutsman', 'powr', 'male', '3200', '30', '3210', $abilities[7]);
$robots['iceman'] = generate_new_robot('Ice Man', 'iceman', 'cold', 'male', '2550', '6', '620', $abilities[8]);
$robots['oilman'] = generate_new_robot('Oil Man', 'oilman', 'erth', 'male', '2700', '12', '1210', $abilities[9]);
$robots['timeman'] = generate_new_robot('Time Man', 'timeman', 'time', 'male', '2710', '14', '1470', $abilities[10]);
$robots['alley_cat_roll'] = generate_new_robot('Allery Cat Roll', 'alley_cat_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['halloween_roll'] = generate_new_robot('Halloween Roll', 'halloween_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['knight_roll'] = generate_new_robot('Knight Roll', 'knight_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['mm8_roll'] = generate_new_robot('MM8 Roll', 'mm8_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['ninja_roll'] = generate_new_robot('Ninja Roll', 'ninja_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['rainy_day_roll'] = generate_new_robot('Rainy Day Roll', 'rainy_day_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['roll_clause'] = generate_new_robot('Roll Clause', 'roll_clause', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['sports_roll'] = generate_new_robot('Sports Roll', 'sports_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['straw_roll'] = generate_new_robot('Straw Roll', 'straw_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['summer_roll'] = generate_new_robot('Summer Roll', 'summer_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['vacation_roll'] = generate_new_robot('Vacation Roll', 'vacation_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);
$robots['valentine_roll'] = generate_new_robot('Valentine Roll', 'valentine_roll', 'none', 'female', '2800', '15', '1320', $abilities[2]);


// Define the two dummy players
$players = array();
$players[1]['player_name'] = 'Ageman20XX';
$players[1]['player_clear_points'] = '564800';
$players[1]['player_avatar_filename'] = 'ageman20xx_avy_60x60.jpg';
$players[1]['player_number'] = '1';
$players[2]['player_name'] = 'Magitek Angel';
$players[2]['player_clear_points'] = '452150';
$players[2]['player_avatar_filename'] = 'magitek_angel_avy_60x60.jpg';
$players[2]['player_number'] = '2';
// Add the robots to the player profiles
$players[1]['player_robots'] = array();
if ($player1_robot1 != 'none') { $players[1]['player_robots'][] = $robots[$player1_robot1]; }
if ($player1_robot2 != 'none') { $players[1]['player_robots'][] = $robots[$player1_robot2]; }
if ($player1_robot3 != 'none') { $players[1]['player_robots'][] = $robots[$player1_robot3]; }
$players[2]['player_robots'] = array();
if ($player2_robot1 != 'none') { $players[2]['player_robots'][] = $robots[$player2_robot1]; }
if ($player2_robot2 != 'none') { $players[2]['player_robots'][] = $robots[$player2_robot2]; }
if ($player2_robot3 != 'none') { $players[2]['player_robots'][] = $robots[$player2_robot3]; }
// Reverse for display reasons
//$players[1]['player_robots'] = array_reverse($players[1]['player_robots']);

// Define the two team colours
$team_colour_left = 'blue';
$team_colour_right = 'red';

function legacyTime(){ return strtotime((date('Y') - 2010).' Years Ago'); }

// Create a few dummy "turns" for playing with
$turns = array();
$turns[1] = generate_new_turn(1, 'hide', 'complete');
  // Add some bs events to the turn for testing
  $turns[1]['turn_events'][] = generate_new_turn_event($players[2], 'shout', legacyTime(), array('shout_text' => "I challenge you to a battle! With {$players[2]['player_robots'][0]['robot_name']} by my side, there&#39;s no way I can loose!"));
  $turns[1]['turn_events'][] = generate_new_turn_event($players[1], 'shout', legacyTime(), array('shout_text' => "I accept your challenge, but I <b>will</b> defeat you."));
$turns[2] = generate_new_turn(2, 'hide', 'complete');
  // Add some bs events to the turn for testing
  $turns[2]['turn_events'][] = generate_new_turn_event($players[1], 'shout', legacyTime(), array('shout_text' => "Nice moves, but it&#39;s gonna take more than nice moves to save you."));
$turns[3] = generate_new_turn(3, 'hide', 'complete');
  // Add some bs events to the turn for testing
  $turns[3]['turn_events'][] = generate_new_turn_event($players[2], 'shout', legacyTime(), array('shout_text' => "What the?!?!  Oh that&#39;s it - time to take out the big guns!"));
$turns[4] = generate_new_turn(4, 'hide', 'complete');
  // Add some bs events to the turn for testing
  $turns[4]['turn_events'][] = generate_new_turn_event($players[2], 'shout', legacyTime(), array('shout_text' => "Ahhhhhhhhhh! It can&#39;t end like this!"));
  $turns[4]['turn_events'][] = generate_new_turn_event($players[1], 'shout', legacyTime(), array('shout_text' => "Ha!  You call those big guns? Let {$players[1]['player_robots'][0]['robot_name']} show you what big guns really look like."));
$turns[5] = generate_new_turn(5, 'show', 'complete');
  // Add some bs events to the turn for testing
  $turns[5]['turn_events'][] = generate_new_turn_event($players[2], 'shout', legacyTime(), array('shout_text' => "OMG!  Nice work {$players[2]['player_robots'][0]['robot_name']}!"));
  $turns[5]['turn_events'][] = generate_new_turn_event($players[1], 'shout', legacyTime(), array('shout_text' => "Wha?!  How?!"));
  $turns[5]['turn_events'][] = generate_new_turn_event($players[1], 'shout', legacyTime(), array('shout_text' => "That&#39;s it!  It&#39;s time to get serious!"));
$turns[6] = generate_new_turn(6, 'show', 'current');
  // Add some events for the eighth turn
  $rand_winner = mt_rand(1, 2);
  $turns[6]['turn_events'][] = generate_new_turn_event($players[$rand_winner], 'shout', legacyTime(), array('shout_text' => "Yes!  We did it!!  Nice job {$players[$rand_winner]['player_robots'][0]['robot_name']} - there&#39;s no way I could have won without you. :)"));

  // Create events for the last X number of turns
  for ($i = 1; $i <= 5; $i++)
  {
    // Define the turn-order array
    $turn_order = array();
    $turn_order[] = array('player_info' => $players[1], 'robot_info' => $players[1]['player_robots'][0]);
    $turn_order[] = array('player_info' => $players[2], 'robot_info' => $players[2]['player_robots'][0]);
    if (isset($players[1]['player_robots'][1])) { $turn_order[] = array('player_info' => $players[1], 'robot_info' => $players[1]['player_robots'][1]); }
    if (isset($players[2]['player_robots'][1])) { $turn_order[] = array('player_info' => $players[2], 'robot_info' => $players[2]['player_robots'][1]); }
    if (isset($players[1]['player_robots'][2])) { $turn_order[] = array('player_info' => $players[1], 'robot_info' => $players[1]['player_robots'][2]); }
    if (isset($players[2]['player_robots'][2])) { $turn_order[] = array('player_info' => $players[2], 'robot_info' => $players[2]['player_robots'][2]); }
    shuffle($turn_order);

    // Create attack events for each bot in order
    foreach ($turn_order AS $turninfo)
    {
      $this_playerinfo = $turninfo['player_info'];
      $this_robotinfo = $turninfo['robot_info'];
      $this_abilityinfo = $this_robotinfo['robot_ability'];
      $turns[$i]['turn_events'][] = generate_new_turn_event($this_playerinfo, 'ability', legacyTime(), array('ability_user' => $this_robotinfo, 'ability_name' => $this_abilityinfo['ability_name'], 'ability_power' => $this_abilityinfo['ability_power'], 'ability_type' => $this_abilityinfo['ability_type'], 'ability_class' => $this_abilityinfo['ability_class']));
    }
  }

//  // Define the turn-order array
//  $turn_order = array();
//  $turn_order[] = array('player_info' => $players[1], 'robot_info' => $players[1]['player_robots'][0]);
//  $turn_order[] = array('player_info' => $players[2], 'robot_info' => $players[2]['player_robots'][0]);
//  if (isset($players[1]['player_robots'][1])) { $turn_order[] = array('player_info' => $players[1], 'robot_info' => $players[1]['player_robots'][1]); }
//  if (isset($players[2]['player_robots'][1])) { $turn_order[] = array('player_info' => $players[2], 'robot_info' => $players[2]['player_robots'][1]); }
//  if (isset($players[1]['player_robots'][2])) { $turn_order[] = array('player_info' => $players[1], 'robot_info' => $players[1]['player_robots'][2]); }
//  if (isset($players[2]['player_robots'][2])) { $turn_order[] = array('player_info' => $players[2], 'robot_info' => $players[2]['player_robots'][2]); }
//  shuffle($turn_order);
//
//  // Create attack events for each bot in order
//  foreach ($turn_order AS $turninfo)
//  {
//    $this_playerinfo = $turninfo['player_info'];
//    $this_robotinfo = $turninfo['robot_info'];
//    $this_abilityinfo = $this_robotinfo['robot_ability'];
//    $turns[8]['turn_events'][] = generate_new_turn_event($this_playerinfo, 'ability', legacyTime(), array('ability_user' => $this_robotinfo, 'ability_name' => $this_abilityinfo['ability_name'], 'ability_power' => $this_abilityinfo['ability_power'], 'ability_type' => $this_abilityinfo['ability_type'], 'ability_class' => $this_abilityinfo['ability_class']));
//  }

?>