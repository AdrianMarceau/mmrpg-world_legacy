<?php
// Define a function for making a javascript-based alert
function mmrpg_debug_alert($alert_string, $echo = true){
  $alert_string = str_replace("\n", '\\n', str_replace('"', '\"', htmlentities($alert_string)));
  $script_string = '<script type="text/javascript">alert("'.$alert_string.'");</script>';
  if ($echo){ echo $script_string;  }
  return $script_string;
}

// Define a function for unlocking a game player for use in battle
function mmrpg_game_unlock_player($player_info, $unlock_robots = true){
  // Reference the global variables
  global $mmrpg_index;
  // Collect the player info from the index
  $player_info = array_replace($mmrpg_index['players'][$player_info['player_token']], $player_info);
  // Collect or define the player points and player rewards variables
  $this_player_token = $player_info['player_token'];
  $this_player_points = !empty($player_info['player_points']) ? $player_info['player_points'] : 0;
  $this_player_rewards = !empty($player_info['player_rewards']) ? $player_info['player_rewards'] : array();
  // Automatically unlock this player for use in battle
  $this_reward = array('player_token' => $this_player_token, 'player_points' => $this_player_points);
  $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$this_player_token] = $this_reward;
  // Loop through the robot rewards for this player if set
  if ($unlock_robots && !empty($this_player_rewards['robots'])){
    foreach ($this_player_rewards['robots'] AS $robot_reward_key => $robot_reward_info){
      // Check if the required amount of points have been met by this player
      if ($this_player_points >= $robot_reward_info['points']){
        // Unlock this robot and all abilities
        $this_robot_info = array('robot_token' => $robot_reward_info['token'], 'robot_points' => $robot_reward_info['points']);
        mmrpg_game_unlock_robot($player_info, $this_robot_info, true);
      }
    }
  }
  // Return true on success
  return true;
}
// Define a function for unlocking a game robot for use in battle
function mmrpg_game_unlock_robot($player_info, $robot_info, $unlock_abilities = true){
  // Reference the global variables
  global $mmrpg_index;
  // Collect the robot info from the inde
  $robot_info = array_replace($mmrpg_index['robots'][$robot_info['robot_token']], $robot_info);
  // Collect or define the robot points and robot rewards variables
  $this_robot_token = $robot_info['robot_token'];
  $this_robot_points = !empty($robot_info['robot_points']) ? $robot_info['robot_points'] : 0;
  $this_robot_rewards = !empty($robot_info['robot_rewards']) ? $robot_info['robot_rewards'] : array();
  // Automatically unlock this robot for use in battle
  $this_reward = array('robot_token' => $this_robot_token, 'robot_points' => $this_robot_points);
  $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_info['player_token']]['player_robots'][$this_robot_token] = $this_reward;
  // Loop through the ability rewards for this robot if set
  if ($unlock_abilities && !empty($this_robot_rewards['abilities'])){
    foreach ($this_robot_rewards['abilities'] AS $ability_reward_key => $ability_reward_info){
      // Check if the required amount of points have been met by this robot
      if ($this_robot_points >= $ability_reward_info['points']){
        // Unlock this ability
        $this_ability_info = array('ability_token' => $ability_reward_info['token'], 'ability_points' => $ability_reward_info['points']);
        mmrpg_game_unlock_ability($player_info, $robot_info, $this_ability_info);
      }
    }
  }
  // Add this robot to the global robot database array
  $_SESSION['RPG2k12-2']['GAME']['values']['robot_database'][$this_robot_token] = array('robot_token' => $robot_info['robot_token']);
  // Return true on success
  return true;
}
// Define a function for unlocking a game ability for use in battle
function mmrpg_game_unlock_ability($player_info, $robot_info, $ability_info){
  // Reference the global variables
  global $mmrpg_index;
  // Collect the ability info from the index
  $ability_info = array_replace($mmrpg_index['abilities'][$ability_info['ability_token']], $ability_info);
  // Collect or define the ability variables
  $this_ability_token = $ability_info['ability_token'];
  // Automatically unlock this ability for use in battle
  $this_reward = array('ability_token' => $this_ability_token);
  $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_info['player_token']]['player_robots'][$robot_info['robot_token']]['robot_abilities'][$this_ability_token] = $this_reward;
  // Return true on success
  return true;
}

// Define a function for resetting the game session
function mmrpg_reset_game_session($this_save_filepath){
  // DEBUG
  //echo '<script type="text/javascript">alert("mmrpg_reset_game_session('.$this_save_filepath.')");</script>';
  // Reference global variables
  global $MMRPG_CONFIG, $mmrpg_index;
  // Automatically unset the session variable entirely
  session_unset();
  // Automatically create the cache date
  $_SESSION['RPG2k12-2']['GAME'] = array();
  $_SESSION['RPG2k12-2']['GAME']['CACHE_DATE'] = $MMRPG_CONFIG['CACHE_DATE'];
  // Automatically create the battle points counter and start at zero
  $_SESSION['RPG2k12-2']['GAME']['counters']['battle_points'] = 0;
  // Automatically create the battle complete array and start at empty
  $_SESSION['RPG2k12-2']['GAME']['values']['battle_complete'] = array();
  // Automatically create the robot database array and start at empty
  $_SESSION['RPG2k12-2']['GAME']['values']['robot_database'] = array();
  // Automatically unlock Dr. Light only
  mmrpg_game_unlock_player($mmrpg_index['players']['dr-light'], true);
//  // Automatically unlock any player robots at or below the current point total
//  foreach ($mmrpg_index['players'] AS $player_token => $player_info){
//    // Unlock this player and all robots
//    mmrpg_game_unlock_player($player_info, true);
//  }
  // Destroy the cached save file
  if (!empty($this_save_filepath) && file_exists($this_save_filepath)){ @unlink($this_save_filepath); }
  // Return true on success
  return true;
}
// Define a function for saving the game session
function mmrpg_save_game_session($this_save_filepath){
  // Generate the save data by serializing the session variable
  $this_save_content = serialize($_SESSION['RPG2k12-2']['GAME']);
  // Write the index to a cache file, if caching is enabled
  $this_save_file = fopen($this_save_filepath, 'w');
  fwrite($this_save_file, $this_save_content);
  fclose($this_save_file);
  // Return true on success
  return true;
}
// Define a function for loading the game session
function mmrpg_load_game_session($this_save_filepath){
  // Read the save file into memory and collecy it's data
  $this_save_content = file_get_contents($this_save_filepath);
  // Ensure the save content was not empty
  if (!empty($this_save_content)){
    // Unserialize the data into a GAME array
    $this_save_content = unserialize($this_save_content);
    // Import the game content into the session
    $_SESSION['RPG2k12-2']['GAME'] = $this_save_content;
    // Return true on success
    return true;
  }
  // Otherwise, if the save content was empty
  else {
    // Return false on failure
    return false;
  }
}
?>