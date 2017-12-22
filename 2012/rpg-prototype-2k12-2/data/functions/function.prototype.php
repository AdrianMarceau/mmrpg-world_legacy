<?php

/*
 * PROTOTYPE FUNCTIONS
 */

// Define a function for checking the battle's prototype points total
function mmrpg_prototype_battle_points(){
  // Return the current point total for thisgame
  return $_SESSION['RPG2k12-2']['GAME']['counters']['battle_points'];
}
// Define a function for checking a player's prototype points total
function mmrpg_prototype_player_points($player_token){
  // Return the current point total for this player
  return $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_points'];
}
// Define a function for checking a robot's prototype points total
function mmrpg_prototype_robot_points($player_token, $robot_token){
  // Return the current point total for this robot
  return $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_robots'][$robot_token]['robot_points'];
}
// Define a function for checking if a prototype battle has been completed
function mmrpg_prototype_battle_complete($player_token, $battle_token){
  // Check if this battle has been completed and return true is it was
  return isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_complete'][$player_token][$battle_token]) ? true : false;
}
// Define a function for checking is a prototype player has been unlocked
function mmrpg_prototype_player_unlocked($player_token){
  // Check if this battle has been completed and return true is it was
  return isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]) ? true : false;
}
// Define a function for checking is a prototype robot has been unlocked
function mmrpg_prototype_robot_unlocked($player_token, $robot_token){
  // Check if this battle has been completed and return true is it was
  return isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_robots'][$robot_token]) ? true : false;
}
// Define a function for checking if a prototype ability has been unlocked
function mmrpg_prototype_ability_unlocked($player_token, $robot_token, $ability_token){
  // Check if this battle has been completed and return true is it was
  return isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_robots'][$robot_token]['robot_abilities'][$ability_token]) ? true : false;
}
// Define a function for counting the number of completed prototype battles
function mmrpg_prototype_battles_complete($player_token){
  // Check if this battle has been completed and return true is it was
  return isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_complete'][$player_token]) ? count($_SESSION['RPG2k12-2']['GAME']['values']['battle_complete'][$player_token]) : 0;
}
// Define a function for checking is a prototype player has been unlocked
function mmrpg_prototype_players_unlocked(){
  // Check if this battle has been completed and return true is it was
  return isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards']) ? count($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards']) : 0;
}
// Define a function for checking is a prototype robot has been unlocked
function mmrpg_prototype_robots_unlocked($player_token){
  // Check if this battle has been completed and return true is it was
  return isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_robots']) ? count($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_robots']) : 0;
}
// Define a function for checking if a prototype ability has been unlocked
function mmrpg_prototype_abilities_unlocked($player_token, $robot_token){
  // Check if this battle has been completed and return true is it was
  return isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_robots'][$robot_token]['robot_abilities']) ? count($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_robots'][$robot_token]['robot_abilities']) : 0;
}
// Define a function for displaying prototype battle option markup
function mmrpg_prototype_options_markup(&$battle_options, $player_token, $class_token = ''){
  // Refence the global config and index objects for easy access
  global $MMRPG_CONFIG, $mmrpg_index;
  // Define the variable to collect option markup
  $this_markup = '';
  // Count the number of completed battle options for this group and update the variable
  foreach ($battle_options AS $this_key => $this_info){
    // If the skip flag is set, continue to the next index
    //if (isset($this_info['flag_skip']) && $this_info['flag_skip'] == true){ continue; }
    // Collect the current battle and field info from the index
    $this_battleinfo = array_replace($mmrpg_index['battles'][$this_info['battle_token']], $this_info);
    $this_fieldinfo = array_replace($mmrpg_index['fields'][$this_battleinfo['battle_field_base']['field_token']], $this_battleinfo['battle_field_base']);
    $this_targetinfo = array_replace($mmrpg_index['players'][$this_battleinfo['battle_target_player']['player_token']], $this_battleinfo['battle_target_player']);
    // Check the GAME session to see if this battle has been completed, increment the counter if it was
    $this_battleinfo['battle_option_complete'] = mmrpg_prototype_battle_complete($player_token, $this_info['battle_token']);
    // Generate the markup fields for display
    $this_option_token = $this_battleinfo['battle_token'];
    $this_option_limit = !empty($this_battleinfo['battle_robot_limit']) ? $this_battleinfo['battle_robot_limit'] : 1;
    $this_option_frame = !empty($this_battleinfo['battle_sprite_frame']) ? $this_battleinfo['battle_sprite_frame'] : 'base';
    $this_option_status = !empty($this_battleinfo['battle_status']) ? $this_battleinfo['battle_status'] : 'enabled';
    $this_option_points = !empty($this_battleinfo['battle_points']) ? $this_battleinfo['battle_points'] : 0;
    $this_option_complete = $this_battleinfo['battle_option_complete'];
    $this_option_targets = !empty($this_targetinfo['player_robots']) ? count($this_targetinfo['player_robots']) : 0;
    $this_option_encore = isset($this_battleinfo['battle_encore']) ? $this_battleinfo['battle_encore'] : true;
    $this_option_disabled = $this_option_complete && !$this_option_encore ? true : false;
    $this_option_class = 'option option_this-'.(!empty($class_token) ? $class_token.'-' : '').'battle-select option_'.$this_battleinfo['battle_size'].' option_'.$this_battleinfo['battle_token'].' option_'.$this_option_status.' block_'.($this_key + 1).' '.($this_option_complete ? 'option_complete ' : '').($this_option_disabled ? 'option_disabled '.($this_option_encore ? 'option_disabled_clickable ' : '') : '');
    $this_option_style = 'background-position: -'.mt_rand(5, 50).'px -'.mt_rand(5, 50).'px; ';
    $this_option_label = '';
    $this_option_min_points = false;
    $this_option_max_points = false;
    $this_battleinfo['battle_sprite'] = array();
    if ($this_targetinfo['player_token'] != 'player'){  $this_battleinfo['battle_sprite'][] = 'players/'.$this_targetinfo['player_token'];  }
    if (!empty($this_targetinfo['player_robots'])){
      foreach ($this_targetinfo['player_robots'] AS $this_robotinfo){
        if ($this_robotinfo['robot_token'] == 'robot'){ continue; }
        $this_battleinfo['battle_sprite'][] = 'robots/'.$this_robotinfo['robot_token'];
        $this_robot_points = !empty($this_robotinfo['robot_points']) ? $this_robotinfo['robot_points'] : 0;
        if ($this_option_min_points === false || $this_option_min_points > $this_robot_points){ $this_option_min_points = $this_robot_points; }
        if ($this_option_max_points === false || $this_option_max_points < $this_robot_points){ $this_option_max_points = $this_robot_points; }
      }
    }
    $this_option_min_level = floor($this_option_min_points / 1000) + 1;
    $this_option_max_level = floor($this_option_max_points / 1000) + 1;
    if (!empty($this_battleinfo['battle_sprite'])){
      $temp_left = 0;
      $temp_layer = 10;
      foreach ($this_battleinfo['battle_sprite'] AS $this_battle_sprite){
        $temp_opacity = $temp_layer == 10 ? 1 : ($temp_layer * 0.09);
        $this_option_label .= '<span class="sprite sprite_40x40 '.($this_option_complete && !$this_option_encore && $this_option_frame == 'base' ? 'sprite_40x40_defeat ' : 'sprite_40x40_'.$this_option_frame.' ').'" style="background-image: url(images/'.$this_battle_sprite.'/sprite_left_40x40.png); top: -2px; left: -'.$temp_left.'px; z-index: '.$temp_layer.'; opacity: '.$temp_opacity.';">'.$this_battleinfo['battle_name'].'</span>';
        $temp_left += 18;
        $temp_layer -= 1;
      }
    }
    $this_option_button_text = !empty($this_battleinfo['battle_button']) ? $this_battleinfo['battle_button'] : '';
    $this_option_level_range = $this_option_min_level == $this_option_max_level ? 'Level '.$this_option_min_level : 'Levels '.$this_option_min_level.'-'.$this_option_max_level;
    $this_option_point_amount = $this_option_points.' Point'.($this_option_points != 1 ? 's' : '');
    $this_option_label .= (!empty($this_option_button_text) ? '<span class="multi"><span class="maintext">'.$this_option_button_text.'</span><span class="subtext">'.$this_option_level_range.'</span><span class="subtext2">'.$this_option_point_amount.'</span></span>'.(!$this_option_complete || ($this_option_complete && $this_option_encore) ? '<span class="arrow"> &#9658;</span>' : '') : '<span class="single">???</span>');
    // Print out the option button markup with sprite and name
    $this_markup .= '<a class="'.$this_option_class.'" data-token="'.$this_option_token.'" data-next-limit="'.$this_option_limit.'" style="'.$this_option_style.'"><div><label class="'.(!empty($this_battleinfo['battle_sprite']) ? 'has_image' : 'no_image').'">'.$this_option_label.'</label></div></a>'."\r\n";
    // Update the main battle option array with recent changes
    $this_battleinfo['flag_skip'] = true;
    $battle_options[$this_key] = $this_battleinfo;
  }
  // Return the generated markup
  return $this_markup;
}

// If possible, attempt to save the game to the session
if (!empty($this_save_filepath)){
  // Save the game session
  mmrpg_save_game_session($this_save_filepath);
}
?>