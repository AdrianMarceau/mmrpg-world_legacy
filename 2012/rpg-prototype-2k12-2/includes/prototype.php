<?php

/*
 * PROTOTYPE FUNCTIONS
 */

// Define a function for displaying prototype battle option markup
function mmrpg_prototype_robot_unlocked($player_token, $robot_token){
  // Check if this battle has been completed and return true is it was
  return !empty($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['robots'][$robot_token]) ? true : false;
}
// Define a function for displaying prototype battle option markup
function mmrpg_prototype_battle_complete($battle_token){
  // Check if this battle has been completed and return true is it was
  return !empty($_SESSION['RPG2k12-2']['GAME']['values']['battle_complete'][$battle_token]) ? true : false;
}
// Define a function for displaying prototype battle option markup
function mmrpg_prototype_options_markup(&$battle_options, &$battle_count, $class_token = ''){
  // Refence the global config and index objects for easy access
  global $MMRPG_CONFIG, $mmrpg_index;
  // Define the variable to collect option markup
  $this_markup = '';
  // Count the number of completed battle options for this group and update the variable
  foreach ($battle_options AS $this_key => $this_info){
    // If the skip flag is set, continue to the next index
    //if (isset($this_info['flag_skip']) && $this_info['flag_skip'] == true){ continue; }
    // Collect the current battle info from the index
    $this_battleinfo = array_replace($mmrpg_index['battles'][$this_info['battle_token']], $this_info);
    // Check the GAME session to see if this battle has been completed, increment the counter if it was
    $this_battleinfo['battle_option_complete'] = mmrpg_prototype_battle_complete($this_info['battle_token']);
    if ($this_battleinfo['battle_option_complete'] && empty($this_info['flag_skip'])){ $battle_count++; }
    // Generate the markup fields for display
    $this_option_token = $this_battleinfo['battle_token'];
    $this_option_limit = !empty($this_battleinfo['battle_robot_limit']) ? $this_battleinfo['battle_robot_limit'] : 1;
    $this_option_frame = !empty($this_battleinfo['battle_sprite_frame']) ? $this_battleinfo['battle_sprite_frame'] : 'base';
    $this_option_status = !empty($this_battleinfo['battle_status']) ? $this_battleinfo['battle_status'] : 'enabled';
    $this_option_complete = $this_battleinfo['battle_option_complete'];
    $this_option_encore = !empty($this_battleinfo['battle_encore']) ? $this_battleinfo['battle_encore'] : false;
    $this_option_disabled = $this_option_complete && !$this_option_encore ? true : false;
    $this_option_class = 'option option_this-'.(!empty($class_token) ? $class_token.'-' : '').'battle-select option_'.$this_battleinfo['battle_size'].' option_'.$this_battleinfo['battle_token'].' option_'.$this_option_status.' block_'.($this_key + 1).' '.($this_option_disabled ? 'option_disabled '.($this_option_encore ? 'option_disabled_clickable ' : '') : '');
    $this_option_style = 'background-position: -'.mt_rand(5, 50).'px -'.mt_rand(5, 50).'px; ';
    $this_option_label = (!empty($this_battleinfo['battle_name']) ? '<span class="multi">'.$this_battleinfo['battle_name'].'<br /><span class="subtext">'.$this_battleinfo['battle_points'].' Points</span></span><span class="arrow"> &#9658;</span>' : '???');
    if (!empty($this_battleinfo['battle_sprite'])){
      if (is_array($this_battleinfo['battle_sprite'])){
        $temp_left = 0;
        $temp_layer = 10;
        foreach ($this_battleinfo['battle_sprite'] AS $this_battle_sprite){
          $temp_opacity = $temp_layer == 10 ? 1 : ($temp_layer * 0.09);
          $this_option_label = '<span class="sprite sprite_40x40 '.($this_option_complete && $this_option_frame == 'base' ? 'sprite_40x40_defeat ' : 'sprite_40x40_'.$this_option_frame.' ').'" style="background-image: url(images/'.$this_battle_sprite.'/sprite_left_40x40.png); bottom: 8px; left: -'.$temp_left.'px; z-index: '.$temp_layer.'; opacity: '.$temp_opacity.';">'.$this_battleinfo['battle_name'].'</span>'.$this_option_label;
          $temp_left += 20;
          $temp_layer -= 1;
        }
      } else {
        $this_option_label = '<span class="sprite sprite_40x40 '.($this_option_complete && $this_option_frame == 'base' ? 'sprite_40x40_defeat ' : 'sprite_40x40_'.$this_option_frame.' ').'" style="background-image: url(images/'.$this_battleinfo['battle_sprite'].'/sprite_left_40x40.png); bottom: 8px; left: 0;">'.$this_battleinfo['battle_name'].'</span>'.$this_option_label;
      }
    }
    // Print out the option button markup with sprite and name
    $this_markup .= '<a class="'.$this_option_class.'" data-token="'.$this_option_token.'" data-next-limit="'.$this_option_limit.'" style="'.$this_option_style.'"><div><label>'.$this_option_label.'</label></div></a>'."\r\n";
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