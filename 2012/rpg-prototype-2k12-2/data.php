<?php

// Include the TOP file
require_once('top.php');

//$GLOBALS['DEBUG']['checkpoint_line'] = 'data.php : line 6';

//die('<pre>'.print_r($_REQUEST, true).'</pre>');

/*
 * DEFINE & COLLECT BATTLE VARIABLES
 */

// Collect the global battle variables
$this_battle_id = isset($_REQUEST['this_battle_id']) ? $_REQUEST['this_battle_id'] : 1;
$this_battle_token = isset($_REQUEST['this_battle_token']) ? $_REQUEST['this_battle_token'] : 'battle';
$this_field_id = isset($_REQUEST['this_field_id']) ? $_REQUEST['this_field_id'] : 1;
$this_field_token = isset($_REQUEST['this_field_token']) ? $_REQUEST['this_field_token'] : 'field';
$this_user_id = isset($_REQUEST['this_user_id']) ? $_REQUEST['this_user_id'] : 1;
$this_player_id = isset($_REQUEST['this_player_id']) ? $_REQUEST['this_player_id'] : 1;
$this_player_token = isset($_REQUEST['this_player_token']) ? $_REQUEST['this_player_token'] : 'player';
$this_player_robots = isset($_REQUEST['this_player_robots']) ? $_REQUEST['this_player_robots'] : '';
$this_robot_id = isset($_REQUEST['this_robot_id']) ? $_REQUEST['this_robot_id'] : 1;
$this_robot_token = isset($_REQUEST['this_robot_token']) ? $_REQUEST['this_robot_token'] : 'robot';
$target_user_id = isset($_REQUEST['target_user_id']) ? $_REQUEST['target_user_id'] : 2;
$target_player_id = isset($_REQUEST['target_player_id']) ? $_REQUEST['target_player_id'] : 2;
$target_player_token = isset($_REQUEST['target_player_token']) ? $_REQUEST['target_player_token'] : 'player';
$target_robot_id = isset($_REQUEST['target_robot_id']) ? $_REQUEST['target_robot_id'] : 2;
$target_robot_token = isset($_REQUEST['target_robot_token']) ? $_REQUEST['target_robot_token'] : 'robot';

// Define the current action request variables
$this_action = isset($_REQUEST['this_action']) ? $_REQUEST['this_action'] : 'start';
$this_action_token = isset($_REQUEST['this_action_token']) ? $_REQUEST['this_action_token'] : '';
$target_action = isset($_REQUEST['target_action']) ? $_REQUEST['target_action'] : 'start';
$target_action_token = isset($_REQUEST['target_action_token']) ? $_REQUEST['target_action_token'] : '';

// Define a variable to track the verified state and any errors in data processing
$this_verified = true;
$this_errors = array();

// Ensure all madatory variables were set, and create errors for missing fields
if (empty($this_battle_id) || empty($this_battle_token)){
  $this_verified = false;
  $this_errors[] = 'This battle token was not received! '.
    '$this_battle_id = '.$this_battle_id.'; $this_battle_token = '.$this_battle_token.';';
}
if (empty($this_field_id) || empty($this_field_token)){
  $this_verified = false;
  $this_errors[] = 'This field token was not received! '.
    '$this_field_id = '.$this_field_id.'; $this_field_token = '.$this_field_token.';';
}
if (empty($this_player_id) || empty($this_player_token)){
  $this_verified = false;
  $this_errors[] = 'This player token was not received! '.
    '$this_field_id = '.$this_field_id.'; $this_field_token = '.$this_field_token.';';
}
if (empty($target_player_id) || empty($target_player_token)){
  $this_verified = false;
  $this_errors[] = 'Target player token was not received! '.
    '$target_player_id = '.$target_player_id.'; $target_player_token = '.$target_player_token.';';
}
if (empty($this_robot_id) || empty($this_robot_token)){
  $this_verified = false;
  $this_errors[] = 'This robot token was not received! '.
    '$this_robot_id = '.$this_robot_id.'; $this_robot_token = '.$this_robot_token.';';
}
if (empty($target_robot_id) || empty($target_robot_token)){
  $this_verified = false;
  $this_errors[] = 'Target robot token was not received! '.
    '$target_robot_id = '.$target_robot_id.'; $target_robot_token = '.$target_robot_token.';';
}

// If there were any critcal errors, exit the battle script
if ($this_verified == false || !empty($this_errors)){
  trigger_error('Critical Battle Error<br /><pre>$this_errors : '.print_r($this_errors, true).'</pre>', E_USER_ERROR);
}

/*
 * DEFINE & INITALIZE BATTLE OBJECTS
 */

// Define the battle object using the loaded battle data
$this_battleinfo = array('battle_id' => $this_battle_id, 'battle_token' => $this_battle_token);
$this_battleinfo['flags']['wap'] = $flag_wap ? true : false;
// Define the current field object using the loaded field data
$this_fieldinfo = array('field_id' => $this_field_id, 'field_token' => $this_field_token);
// Define the current player object using the loaded player data
$this_playerinfo = array('user_id' => $this_user_id, 'player_id' => $this_player_id, 'player_token' => $this_player_token, 'player_autopilot' => false);
$this_playerinfo['player_autopilot'] = false;
$this_playerinfo['player_side'] = 'left';
// Define the target player object using the loaded player data
$target_playerinfo = array('user_id' => $target_user_id, 'player_id' => $target_player_id, 'player_token' => $target_player_token);
$target_playerinfo['player_autopilot'] = true;
$target_playerinfo['player_side'] = 'right';

// Define the battle object using the loaded battle data and update session
$this_battle = new mmrpg_battle($this_battleinfo);
$this_battle->update_session();
// Define the current field object using the loaded field data and update session
$this_field = new mmrpg_field($this_battle, $this_fieldinfo);
$this_field->update_session();
// Define the current player object using the loaded player data and update session
$this_player = new mmrpg_player($this_battle, $this_playerinfo);
$this_player->update_session();
// Define the target player object using the loaded player data and update session
$target_player = new mmrpg_player($this_battle, $target_playerinfo);
$target_player->update_session();

// If this is the START action, update objects with preset battle data fields
if ($this_action == 'start'){

  // Update applicable fieldinfo fields with preset battle data
  if (!empty($this_battle->battle_field_base)){
    $this_fieldinfo = array_replace($this_fieldinfo, $this_battle->battle_field_base);
    $this_field = new mmrpg_field($this_battle, $this_fieldinfo);
    $this_field->update_session();
  }

  // Update applicable target playerinfo field with present battle data
  if (!empty($this_battle->battle_target_player)){
    $target_playerinfo = array_replace($target_playerinfo, $this_battle->battle_target_player);
    $target_player = new mmrpg_player($this_battle, $target_playerinfo);
    $target_player->update_session();
  }

  // Ensure the player's robot string was provided
  if (!empty($this_player_robots)){

    //$debug = $this_player->export_array();
    //die('<pre>before:'.print_r($debug['player_robots'], true).'</pre>');

    // Break apart the allowed robots string and unset undefined robots
    $this_player_robots = strstr($this_player_robots, ',') ? explode(',', $this_player_robots) : array($this_player_robots);
    $this_playerinfo = $this_player->export_array();
    $this_playerinfo_robots = array();
    //$debug = $this_player->export_array();
    //die('<pre>after:'.print_r($debug['player_robots'], true).'</pre>');
    foreach ($this_playerinfo['player_robots'] AS $this_key => $this_data){
      $this_info = $mmrpg_index['robots'][$this_data['robot_token']];
      $this_token = $this_data['robot_id'].'_'.$this_data['robot_token'];
      $this_position = array_search($this_token, $this_player_robots);
      // Only allow this robot if it exists in the robot string
      if ($this_position !== false){
        // Check if this robot has any battle points in the session
        $this_points = mmrpg_prototype_robot_points($this_playerinfo['player_token'], $this_data['robot_token']);
        // If this robot has collected points, update stats
        if ($this_points > 0){
          // Create the temporary robot object to load data
          $temp_robot = new mmrpg_robot($this_battle, $this_player, $this_data);
          $temp_level = floor($this_points / 1000) + 1;
          if ($temp_level > 100){ $temp_level = 100;  }
          $temp_modifier = ($temp_level - 1) / 100;
          // If the user's level is greater than one, increase stats
          if ($temp_level > 1){
            // Update the robot energy with a small boost based on battle points
            $temp_robot->robot_base_energy = $temp_robot->robot_energy = $temp_robot->robot_base_energy + ceil($temp_robot->robot_base_energy * $temp_modifier);
            // Update the robot attack with a small boost based on battle points
            $temp_robot->robot_base_attack = $temp_robot->robot_attack = $temp_robot->robot_base_attack + ceil($temp_robot->robot_base_attack * $temp_modifier);
            // Update the robot defense with a small boost based on battle points
            $temp_robot->robot_base_defense = $temp_robot->robot_defense = $temp_robot->robot_base_defense + ceil($temp_robot->robot_base_defense * $temp_modifier);
            // Update the robot speed with a small boost based on battle points
            $temp_robot->robot_base_speed = $temp_robot->robot_speed = $temp_robot->robot_base_speed + ceil($temp_robot->robot_base_speed * $temp_modifier);
          }
          // Update this robot's session data with the recent changes
          $temp_robot->update_session();
          // Update this robot's data in the player array
          $this_playerinfo_robots[$this_position] = $temp_robot->export_array();
        } else {
          // Update this robot's data in the player array
          $this_playerinfo_robots[$this_position] = $this_data;
        }

        //echo '<script type="text/javascript">alert("$temp_robot->robot_energy : '.preg_replace('#\s+#', ' ', print_r($temp_robot->robot_energy, true)).'");</script>';

      }
    }
    // Sort the player robot array by key values and update
    ksort($this_playerinfo_robots);
    $this_playerinfo['player_robots'] = $this_playerinfo_robots;

    //die('<pre>'.print_r($this_player_robots, true)."\n".print_r($this_playerinfo['player_robots'], true).'</pre>');

    // Create the player object using the newly defined details
    $this_player = new mmrpg_player($this_battle, $this_playerinfo);
    $this_player->update_session();

  }

  // Ensure there are target robots to loop through
  if (!empty($target_playerinfo['player_robots'])){

    // Loop through each of the target player's robots
    foreach ($target_playerinfo['player_robots'] AS $this_key => $this_data){
      $this_info = $mmrpg_index['robots'][$this_data['robot_token']];
      $this_token = $this_data['robot_id'].'_'.$this_data['robot_token'];
      // Check if this robot has any battle points in the session
      $this_points = !empty($this_data['robot_points']) ? $this_data['robot_points'] : 0;
      // If this robot has collected points, update stats
      if ($this_points > 0){
        // Create the temporary robot object to load data
        $temp_robot = new mmrpg_robot($this_battle, $target_player, $this_data);
        $temp_level = floor($this_points / 1000) + 1;
        if ($temp_level > 100){ $temp_level = 100;  }
        $temp_modifier = ($temp_level - 1) / 100;
        // If the user's level is greater than one, increase stats
        if ($temp_level > 1){
          // Update the robot energy with a small boost based on battle points
          $temp_robot->robot_base_energy = $temp_robot->robot_energy = $temp_robot->robot_base_energy + ceil($temp_robot->robot_base_energy * $temp_modifier);
          // Update the robot attack with a small boost based on battle points
          $temp_robot->robot_base_attack = $temp_robot->robot_attack = $temp_robot->robot_base_attack + ceil($temp_robot->robot_base_attack * $temp_modifier);
          // Update the robot defense with a small boost based on battle points
          $temp_robot->robot_base_defense = $temp_robot->robot_defense = $temp_robot->robot_base_defense + ceil($temp_robot->robot_base_defense * $temp_modifier);
          // Update the robot speed with a small boost based on battle points
          $temp_robot->robot_base_speed = $temp_robot->robot_speed = $temp_robot->robot_base_speed + ceil($temp_robot->robot_base_speed * $temp_modifier);
        }
        // Update this robot's session data with the recent changes
        $temp_robot->update_session();
        // Update this robot's data in the player array
        $target_playerinfo['player_robots'][$this_key] = $temp_robot->export_array();
      } else {
        // Update this robot's data in the player array
        $target_playerinfo['player_robots'][$this_key] = $this_data;
      }
    }

    // Create the target player object using the newly defined details
    $target_player = new mmrpg_player($this_battle, $target_playerinfo);
    $target_player->update_session();

  }















}




//die('<pre>'.print_r($target_playerinfo, true).'</pre>');


// Ensure this player has robots to start with
if (!empty($this_player->player_robots)){
  // Check if the player robot was set to auto
  if ($this_robot_id == 'auto' || $this_robot_token == 'auto'){
    // Collect the first robot in this player's party
    reset($this_player->player_robots);
    $this_robotinfo = current($this_player->player_robots);
  }
  // Otherwise define the robotinfo array manually
  else {
    // Create the robotinfo array with engine data
    $this_robotinfo = array('robot_id' => $this_robot_id, 'robot_token' => $this_robot_token);
  }
}
// Otherwise, if this player has no robots
else {
  // Trigger a critical error, this shit is not gonna work
  trigger_error('Critical Battle Error<br /><pre>This player has no robots!</pre>', E_USER_ERROR);
}

//echo '<script type="text/javascript">alert("$this_robotinfo : '.preg_replace('#\s+#', ' ', print_r($this_robotinfo, true)).'");</script>';

// Ensure the target player has robots to start with
if (!empty($target_player->player_robots)){
  // Check if the target player robot was set to auto
  if ($target_robot_id == 'auto' || $target_robot_token == 'auto'){
    // Collect the first robot in the target player's party
    reset($target_player->player_robots);
    $target_robotinfo = current($target_player->player_robots);
  }
  // Otherwise define the robotinfo array manually
  else {
    // Create the robotinfo array with engine data
    $target_robotinfo = array('robot_id' => $target_robot_id, 'robot_token' => $target_robot_token);
  }
}
// Otherwise, if the target player has no robots
else {
  // Trigger a critical error, this shit is not gonna work
  trigger_error('Critical Battle Error<br /><pre>The target player has no robots!</pre>', E_USER_ERROR);
}

// Define the current robot object using the loaded robot data
//$GLOBALS['DEBUG']['checkpoint_line'] = 'data.php : line 204';
$this_robot = new mmrpg_robot($this_battle, $this_player, $this_robotinfo);
// Define the target robot object using the loaded robot data
//$GLOBALS['DEBUG']['checkpoint_line'] = 'data.php : line 206';
$target_robot = new mmrpg_robot($this_battle, $target_player, $target_robotinfo);


/*
 * BATTLE START!
 */

// Define the redirect variable in case we need to change screens
$this_redirect = '';

// Define the action queue variable and populate it with this/target pairs
$action_queue = array();


// If the player is has requested the prototype menu
if ($this_action == 'prototype'){

  // Automatically empty all temporary battle variables
  $_SESSION['RPG2k12-2']['BATTLES'] = array();
  $_SESSION['RPG2k12-2']['FIELDS'] = array();
  $_SESSION['RPG2k12-2']['PLAYERS'] = array();
  $_SESSION['RPG2k12-2']['ROBOTS'] = array();
  $_SESSION['RPG2k12-2']['ABILITIES'] = array();

  // Redirect the user back to the prototype screen
  $this_redirect = 'prototype.php?'.($flag_wap ? 'wap=true' : '');

}
// Else if the player is has requested to restart the battle
elseif ($this_action == 'restart'){


  // Define the player's robots string
  $this_player_robots = array();
  if (!empty($this_player->player_robots)){
    foreach ($this_player->player_robots AS $key => $temp_robotinfo){
      $this_player_robots[] = $temp_robotinfo['robot_id'].'_'.$temp_robotinfo['robot_token'];
    }
  }
  $this_player_robots = implode(',', $this_player_robots);

  // Redirect the user back to the prototype screen
  $this_redirect = 'battle.php?'.
    ($flag_wap ? 'wap=true' : 'wap=false').
    '&this_battle_id='.$this_battle->battle_id.
    '&this_battle_token='.$this_battle->battle_token.
    //'&this_field_id='.$this_field->field_id.
    //'&this_field_token='.$this_field->field_token.
    '&this_player_id='.$this_player->player_id.
    '&this_player_token='.$this_player->player_token.
    '&this_player_robots='.$this_player_robots.
    //'&target_player_id='.$target_player->player_id.
    //'&target_player_token='.$target_player->player_token.
    '';

  // Automatically empty all temporary battle variables
  $_SESSION['RPG2k12-2']['BATTLES'] = array();
  $_SESSION['RPG2k12-2']['FIELDS'] = array();
  $_SESSION['RPG2k12-2']['PLAYERS'] = array();
  $_SESSION['RPG2k12-2']['ROBOTS'] = array();
  $_SESSION['RPG2k12-2']['ABILITIES'] = array();

}
// Else if the player is just starting the battle, queue start actions
elseif ($this_action == 'start'){

  // Define the first event body markup, regardless of player type
  $first_event_header = $this_battle->battle_description;
  $first_event_body = $this_battle->battle_name.' <span style="opacity:0.25;">|</span> '.$this_battle->battle_field->print_field_name().'<br />';
  $first_event_body .= 'Goal : '.$this_battle->battle_turns.($this_battle->battle_turns > 1 ? ' Turns' : ' Turn').'  <span style="opacity:0.25;">|</span> Reward : '.$this_battle->battle_points.($this_battle->battle_points > 1 ? ' Points' : ' Point').'<br />';

  // If there is a target player, have this player's robots appear first
  if ($target_player->player_token != 'player'){

    // Create the battle start event, showing the points and amount of turns
    $event_header = $first_event_header;
    $event_body = $first_event_body;
    $event_options = array();
    $event_options['this_header_float'] = $event_options['this_body_float'] = 'center';
    $event_options['canvas_show_this'] = $event_options['console_show_this'] = false;
    $event_options['canvas_show_this_robots'] = false;
    $event_options['canvas_show_target'] = $event_options['console_show_target'] = false;
    $event_options['canvas_show_target_robots'] = false;
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
    $this_battle->events_create(false, false, '', '', $event_options);

    // Create the enter event for this player's robots
    $event_header = "{$this_player->player_name}&#39;s Robots";
    $event_body = $this_player->print_player_name().'&#39;s '.($this_player->counters['robots_active'] > 1 ? 'robots appear' : 'robot appears').' on the battle field!<br />';
    if (isset($this_player->player_quotes['battle_start'])){ $event_body .= '&quot;<em>'.$this_player->player_quotes['battle_start'].'</em>&quot;'; }
    $event_options = array();
    $event_options['this_header_float'] = $event_options['this_body_float'] = 'left';
    $event_options['canvas_show_this'] = false;
    $event_options['canvas_show_target'] = $event_options['console_show_target'] = false;
    $event_options['console_show_this_player'] = true;
    $event_options['console_show_target_player'] = false;
    $event_options['canvas_show_target_robots'] = false;
    $this_player->player_frame = 'taunt';
    $this_player->update_session();
    $this_robot->robot_frame = 'taunt';
    $this_robot->robot_position = 'active';
    $this_robot->update_session();
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
    $this_player->player_frame = 'base';
    $this_player->update_session();
    $this_robot->robot_frame = 'base';
    $this_robot->update_session();
    $this_battle->events_create(false, false, '', '', $event_options);

    // Create the enter event for the target player's robots
    $event_header = $target_player->player_name.'&#39;s '.($target_player->counters['robots_active'] > 1 ? 'Robots' : 'Robot');
    $event_body = $target_player->print_player_name().'&#39;s '.($target_player->counters['robots_active'] > 1 ? 'robots appear' : 'robot appears').' on the battle field!<br />';
    if (isset($target_player->player_quotes['battle_start'])){ $event_body .= '&quot;<em>'.$target_player->player_quotes['battle_start'].'</em>&quot;'; }
    $event_options = array();
    $event_options['this_header_float'] = $event_options['this_body_float'] = 'right';
    $event_options['console_show_this_player'] = true;
    $event_options['console_show_target'] = false;
    $event_options['console_show_target_player'] = false;
    $target_player->player_frame = 'taunt';
    $target_player->update_session();
    $target_robot->robot_frame = 'taunt';
    $target_robot->robot_position = 'active';
    $target_robot->update_session();
    $this_battle->events_create($target_robot, $this_robot, $event_header, $event_body, $event_options);
    $target_player->player_frame = 'base';
    $target_player->update_session();
    $target_robot->robot_frame = 'base';
    $target_robot->update_session();
    $this_battle->events_create(false, false, '', '', $event_options);

    // Queue up this robot's startup action first
    $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'start', '');
    // Then queue up an the target robot's startup action
    $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, 'start', '');

  }
  // Otherwise, if there is no target player, have the target's robots appear first
  elseif ($target_player->player_token == 'player'){

    // Create the battle start event, showing the points and amount of turns
    $event_header = $first_event_header;
    $event_body = $first_event_body;
    $event_options = array();
    $event_options['this_header_float'] = $event_options['this_body_float'] = 'center';
    $event_options['canvas_show_this'] = true;
    $event_options['console_show_this'] = false;
    $event_options['canvas_show_this_robots'] = true;
    $event_options['canvas_show_target'] = true;
    $event_options['console_show_target'] = false;
    $event_options['canvas_show_target_player'] = false;
    $event_options['canvas_show_target_robots'] = false;
    $this_robot->robot_frame = 'defend';
    $this_robot->robot_position = 'active';
    $this_robot->update_session();
    $target_robot->robot_position = 'active';
    $target_robot->update_session();
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
    $this_robot->robot_frame = 'base';
    $this_robot->update_session();
    $this_battle->events_create(false, false, '', '', $event_options);

    /*
    // Create the enter event for this player's robots
    $event_header = "{$this_player->player_name}&#39;s Robots";
    $event_body = $this_player->print_player_name().'&#39;s '.($this_player->counters['robots_active'] > 1 ? 'robots appear' : 'robot appears').' on the battle field!<br />';
    if (isset($this_player->player_quotes['battle_start'])){ $event_body .= '&quot;<em>'.$this_player->player_quotes['battle_start'].'</em>&quot;'; }
    $event_options = array();
    $event_options['this_header_float'] = $event_options['this_body_float'] = 'left';
    $event_options['canvas_show_this'] = false;
    $event_options['canvas_show_target'] = $event_options['console_show_target'] = false;
    $event_options['console_show_this_player'] = true;
    $event_options['console_show_target_player'] = false;
    $event_options['canvas_show_target_robots'] = true;
    $this_player->player_frame = 'taunt';
    $this_player->update_session();
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
    $this_player->player_frame = 'base';
    $this_player->update_session();
    $this_battle->events_create(false, false, '', '', $event_options);
    */

    // Then queue up this robot's startup action first
    //$this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'start', '');

    // Queue up an the target robot's startup action
    $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, 'start', '');


  }

  // Define the battle's turn counter and start at 0
  $this_battle->counters['battle_turn'] = 0;
  $this_battle->update_session();

}
// Else if the player is switching robots, they go first
elseif ($this_action == 'switch'){

  // Define whether to skip the target's turn based on
  // if this player is replacing a fainted robot
  $skip_target_turn = $this_robot->robot_status == 'disabled' || ($this_robot->robot_status == 'active' && $this_robot->robot_position == 'bench') ? true : false;
  // Queue up this robot's switch action first
  $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'switch', $this_action_token);
  // Only queue the enemy action if the skip_turn flag is not true
  if (!$skip_target_turn){
    // Then queue up an the target robot's defined action
    $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, '', '');
  }

  // Increment the battle's turn counter by 1
  $this_battle->counters['battle_turn'] += 1;
  $this_battle->update_session();

}
// Else if the player's robot using a scan
elseif ($this_action == 'scan'){

  // Queue up an this robot's scan action and do nothing else, it's a free move
  $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, $this_action, $this_action_token);

}
// Else if the player's robot using an ability
elseif ($this_action == 'ability'){

  // Create the temporary ability objecy
  $temp_abilityinfo = array();
  list($temp_abilityinfo['ability_id'], $temp_abilityinfo['ability_token']) = explode('_', $this_action_token); //array('ability_token' => $this_action_token);
  $temp_ability = new mmrpg_ability($this_battle, $this_player, $this_robot, $temp_abilityinfo);

  //$this_battle->events_create(false, false, 'DEBUG', '<pre>'.preg_replace('#\s+#', ' ', print_r($temp_abilityinfo, true)).'</pre>');

  // If this robot is faster than the target
  if ($temp_ability->ability_speed > 1 || $this_robot->robot_speed >= $target_robot->robot_speed){

    // Queue up an this robot's action first, because its faster
    $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, $this_action, $this_action_token);
    // Then queue up an the target robot's action second, because its slower
    $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, '', '');

  }
  // Else if the target robot is faster than this one
  else {

    // Then queue up an the target robot's action first, because its faster
    $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, '', '');
    // Queue up an this robot's action second, because its slower
    $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, $this_action, $this_action_token);

  }

  // Increment the battle's turn counter by 1
  $this_battle->counters['battle_turn'] += 1;
  $this_battle->update_session();

}

// Now execute the stored actions (and any created in the process of executing them!)
$this_battle->actions_execute();


/*
 * ACTION PROCESSING
 */

// Define the array to hold action panel markup
$actions_markup = array();

// Ensure the battle is still in progress
if (empty($this_redirect) && $this_battle->battle_status != 'complete'){

  // Generate the markup for the action switch panel
  ob_start();
    // If the current robot is not disabled
    if ($this_robot->robot_energy > 0 && $this_robot->robot_position == 'active'){
      // Display available main actions
      ?><div class="main_actions"><?
      ?><a class="button action_ability" type="button" data-panel="ability"><label>Ability</label></a><?
      ?></div><?
      // Display the available sub options
      ?><div class="sub_actions"><?
      /*?><a class="button action_scan" type="button" data-panel="scan">Scan</a><?*/
      ?><a class="button action_scan" type="button" data-panel="scan"><label>Scan</label></a><?
      ?><a class="button action_option" type="button" data-panel="option"><label>Option</label></a><?
      if ($this_player->counters['robots_total'] > 1):
        ?><a class="button action_switch" type="button" data-panel="switch"><label>Switch</label></a><?
      else:
        ?><a class="button action_switch button_disabled" type="button"><label>Switch</label></a><?
      endif;
      ?></div><?
    }
    // Otherwise if this robot has been disabled
    else {
      // Display available main actions
      ?><div class="main_actions"><?
      ?><a class="button action_ability button_disabled" type="button"><label>Ability</label></a><?
      ?></div><?
      // Display the available sub options
      ?><div class="sub_actions"><?
      ?><a class="button action_scan button_disabled" type="button"><label>Scan</label></a><?
      ?><a class="button action_option" type="button" data-panel="option"><label>Option</label></a><?
      if ($this_player->counters['robots_total'] > 1):
        ?><a class="button action_switch" type="button" data-panel="switch"><label>Switch</label></a><?
      else:
        ?><a class="button action_switch button_disabled" type="button"><label>Switch</label></a><?
      endif;
      ?></div><?
    }
  $actions_markup['battle'] = trim(ob_get_clean());
  $actions_markup['battle'] = preg_replace('#\s+#', ' ', $actions_markup['battle']);

  // Generate the markup for the action option panel
  ob_start();
    // Define the markup for the option buttons
    $temp_options = array();
    // Display the option for returning to the main prototype menu
    $temp_options[] = '<a class="button action_option block_1" type="button" data-action="prototype"><label><span class="multi">Return&nbsp;To<br />Main&nbsp;Menu</span></label></a>';
    // Display an option for restarting this battle from scratch
    $temp_options[] = '<a class="button action_option block_2" type="button" data-action="restart"><label><span class="multi">Restart<br />Mission</span></label></a>';
    // Display an option for changing config settings
    //$temp_options[] = '<a class="button action_option block_3" type="button" data-panel="settings"><label><span class="multi">Settings<br />Menu</span></label></a>';
    $temp_options[] = '<a class="button action_option block_3" type="button" data-panel="settings_eventTimeout"><label><span class="multi">Message<br />Speed</span></label></a>';
    //$temp_options[] = '<a class="button action_option block_3" type="button" data-panel="settings_autoScan"><label><span class="multi">Auto<br />Scan</span></label></a>';

    // Display container for the main actions
    ?><div class="main_actions"><?
    // Ensure there are options to display
    if (!empty($temp_options)){
      // Count the total number of options
      $num_options = count($temp_options);
      // Loop through each option and display its button markup
      foreach ($temp_options AS $key => $option_markup){
        // Display the option button's generated markup
        echo $option_markup;
      }
      // If there were less than 6 options, fill in the empty spaces
      if ($num_options < 8){
        for ($i = $num_options; $i < 8; $i++){
          // Display an empty button placeholder
          ?><a class="button action_option button_disabled block_<?= $i + 1 ?>" type="button">&nbsp;</a><?
        }
      }
    }
    // End the main action container tag
    ?></div><?
    // Display the back button by default
    ?><div class="sub_actions"><a class="button action_back" type="button" data-panel="battle"><label>Back</label></a></div><?
  $actions_markup['option'] = trim(ob_get_clean());
  $actions_markup['option'] = preg_replace('#\s+#', ' ', $actions_markup['option']);

  // Generate the markup for the action ability panel
  ob_start();
    // Display container for the main actions
    ?><div class="main_actions"><?
    // Ensure this robot has abilities to display
    if (!empty($this_robot->robot_abilities)){
      // Count the total number of abilities
      $num_abilities = count($this_robot->robot_abilities);
      $robot_direction = $this_player->player_side == 'left' ? 'right' : 'left';
      // Define the ability display counter
      $unlocked_abilities_count = 0;
      // Loop through each ability and display its button
      foreach ($this_robot->robot_abilities AS $ability_key => $ability_token){
        // Ensure this is an actual ability in the index
        if (isset($mmrpg_index['abilities'][$ability_token])){

          // Check if this ability has been unlocked
          $this_ability_unlocked = mmrpg_prototype_ability_unlocked($this_player->player_token, $this_robot->robot_token, $ability_token);
          if (!$this_ability_unlocked
            && $this_robot->robot_base_abilities[$ability_key] == 'copy-shot'
            && mmrpg_prototype_ability_unlocked($this_player->player_token, $this_robot->robot_token, 'copy-shot')){ $this_ability_unlocked = true;  }
          if ($this_ability_unlocked){ $unlocked_abilities_count++; }
          else { continue; }

          // Create the ability object using the session/index data
          $temp_abilityinfo = array('ability_id' => $ability_key, 'ability_token' => $ability_token);
          $temp_ability = new mmrpg_ability($this_battle, $this_player, $this_robot, $temp_abilityinfo);
          $temp_type = $temp_ability->ability_type;
          $temp_damage = $temp_ability->ability_damage;
          $temp_recovery = $temp_ability->ability_recovery;
          $temp_accuracy = $temp_ability->ability_accuracy;
          $temp_kind = !empty($temp_damage) && empty($temp_recovery) ? 'damage' : (!empty($temp_recovery) && empty($temp_damage) ? 'recovery' : (!empty($temp_damage) && !empty($temp_recovery) ? 'multi' : ''));

          // Define the ability title details text
          $temp_ability_details = $temp_ability->ability_name;
          $temp_ability_details .= ' | '.(!empty($temp_ability->ability_type) ? $mmrpg_index['types'][$temp_ability->ability_type]['type_name'] : 'Neutral');
          if ($temp_kind == 'damage'){ $temp_ability_details .= ' Damage'; }
          elseif ($temp_kind == 'recovery'){ $temp_ability_details .= ' Recovery'; }
          elseif ($temp_kind == 'multi'){ $temp_ability_details .= ' Effects'; }
          else { $temp_ability_details .= ' Special'; }
          if ($temp_kind == 'damage'){ $temp_ability_details .= ' | P:'.$temp_ability->ability_damage; }
          elseif ($temp_kind == 'recovery'){ $temp_ability_details .= ' | P:'.$temp_ability->ability_recovery; }
          elseif ($temp_kind == 'multi'){ $temp_ability_details .= ' | P:'.$temp_ability->ability_damage.'/'.$temp_ability->ability_recovery; }
          else { $temp_ability_details .= ' | P:0'; }
          $temp_ability_details .= ' | A:'.$temp_ability->ability_accuracy.'%';
          $temp_ability_details .= ' | '.$temp_ability->ability_description;

          // Define the ability button text variables
          $temp_ability_label = '<span class="multi">';
          $temp_ability_label .= '<span class="maintext">'.$temp_ability->ability_name.'</span>';
          $temp_ability_label .= '<span class="subtext">';
            $temp_ability_label .= (!empty($temp_type) ? $mmrpg_index['types'][$temp_ability->ability_type]['type_name'].' ' : 'Neutral ');
            $temp_ability_label .= ($temp_kind == 'damage' ? 'Damage' : ($temp_kind == 'recovery' ? 'Recovery' : ($temp_kind == 'multi' ? 'Effects' : 'Special')));
          $temp_ability_label .= '</span>';
          $temp_ability_label .= '<span class="subtext">';
            $temp_ability_label .= 'P:'.($temp_kind == 'damage' ? $temp_damage.' ' : ($temp_kind == 'recovery' ? $temp_recovery.' ' : ($temp_kind == 'multi' ? $temp_damage.'/'.$temp_recovery.' ' : '0')));
            $temp_ability_label .= '&nbsp;';
            $temp_ability_label .= 'A:'.$temp_accuracy.'%';
          $temp_ability_label .= '</span>';
          $temp_ability_label .= '</span>';

          // Define the ability sprite variables
          $temp_ability_sprite = array();
          $temp_ability_sprite['name'] = $temp_ability->ability_name;
          $temp_ability_sprite['url'] = 'images/abilities/'.$temp_ability->ability_token.'/icon_'.$robot_direction.'_40x40.png';
          $temp_ability_sprite['preload'] = 'images/abilities/'.$temp_ability->ability_token.'/sprite_'.$robot_direction.'_80x80.png';
          $temp_ability_sprite['class'] = 'sprite sprite_40x40 sprite_40x40_base ';
          $temp_ability_sprite['style'] = 'background-image: url('.$temp_ability_sprite['url'].'?'.$MMRPG_CONFIG['CACHE_DATE'].');  top: 5px; left: 5px; ';
          $temp_ability_sprite['markup'] = '<span class="'.$temp_ability_sprite['class'].'" style="'.$temp_ability_sprite['style'].'">'.$temp_ability_sprite['name'].'</span>';
          // Now use the new object to generate a snapshot of this ability button
          ?><a class="button action_ability ability_<?= $temp_ability->ability_token ?> type_<?= $temp_ability->ability_type ?> block_<?= $unlocked_abilities_count ?>" type="button" data-action="ability_<?= $temp_ability->ability_id.'_'.$temp_ability->ability_token ?>" title="<?= $temp_ability_details ?>" data-preload="<?= $temp_ability_sprite['preload'] ?>"><label><?= $temp_ability_sprite['markup'] ?><?= $temp_ability_label ?></label></a><?
        }
      }
      // If there were less than 8 abilities, fill in the empty spaces
      if ($unlocked_abilities_count < 8){
        for ($i = $unlocked_abilities_count; $i < 8; $i++){
          // Display an empty button placeholder
          ?><a class="button action_ability button_disabled block_<?= $i + 1 ?>" type="button">&nbsp;</a><?
        }
      }
    }
    // End the main action container tag
    //echo 'Abilities : ['.print_r($this_robot->robot_abilities, true).']';
    ?></div><?
    // Display the back button by default
    ?><div class="sub_actions"><a class="button action_back" type="button" data-panel="battle"><label>Back</label></a></div><?
  $actions_markup['ability'] = trim(ob_get_clean());
  $actions_markup['ability'] = preg_replace('#\s+#', ' ', $actions_markup['ability']);

  // Generate the markup for the action switch panel
  ob_start();
    // Display container for the main actions
    ?><div class="main_actions"><?
    // Ensure there are robots to display
    if (!empty($this_player->player_robots)){
      // Count the total number of robots
      $num_robots = count($this_player->player_robots);
      $robot_direction = $this_player->player_side == 'left' ? 'right' : 'left';
      // Loop through each robot and display its switch button
      foreach ($this_player->player_robots AS $robot_key => $switch_robotinfo){
        // Ensure this is an actual switch in the index
        if (isset($mmrpg_index['robots'][$switch_robotinfo['robot_token']])){
          // Create the switch object using the session/index data
          //$GLOBALS['DEBUG']['checkpoint_line'] = 'data.php : line 591';
          $temp_robot = new mmrpg_robot($this_battle, $this_player, $switch_robotinfo);
          // Default the allow button flag to true
          $allow_button = true;
          // If this robot is already out, disable the button
          if ($temp_robot->robot_position == 'active'){ $allow_button = false; }
          // If this robot is disabled, disable the button
          if ($temp_robot->robot_status == 'disabled'){ $allow_button = false; }
          // Define the title hover for the robot
          $temp_robot_title = $temp_robot->robot_name
            //.' | '.$temp_robot->robot_id.''
            //.' | '.strtoupper($temp_robot->robot_position).''
            .' | '.$temp_robot->robot_energy.'/'.$temp_robot->robot_base_energy.' Energy'
            .' | A:'.$temp_robot->robot_attack
            .' | D:'.$temp_robot->robot_defense
            .' | S:'.$temp_robot->robot_speed
            .'';

          // Define the robot button text variables
          $temp_robot_label = '<span class="multi">';
          $temp_robot_label .= '<span class="maintext">'.$temp_robot->robot_name.'</span>';
          $temp_robot_label .= '<span class="subtext">';
            $temp_robot_label .= $temp_robot->robot_energy.'/'.$temp_robot->robot_base_energy.' Energy';
          $temp_robot_label .= '</span>';
          $temp_robot_label .= '<span class="subtext">';
            $temp_robot_label .= 'A:'.$temp_robot->robot_attack;
            $temp_robot_label .= '&nbsp;';
            $temp_robot_label .= 'D:'.$temp_robot->robot_defense;
            $temp_robot_label .= '&nbsp;';
            $temp_robot_label .= 'S:'.$temp_robot->robot_speed;
          $temp_robot_label .= '</span>';
          $temp_robot_label .= '</span>';

          // Define the robot sprite variables
          $temp_robot_sprite = array();
          $temp_robot_sprite['name'] = $temp_robot->robot_name;
          $temp_robot_sprite['url'] = 'images/robots/'.$temp_robot->robot_token.'/sprite_'.$robot_direction.'_40x40.png';
          $temp_robot_sprite['preload'] = 'images/robots/'.$temp_robot->robot_token.'/sprite_'.$robot_direction.'_80x80.png';
          $temp_robot_sprite['class'] = 'sprite sprite_40x40 sprite_40x40_'.($temp_robot->robot_energy > 0 ? ($temp_robot->robot_energy > ($temp_robot->robot_base_energy/2) ? 'base' : 'defend') : 'defeat').' ';
          $temp_robot_sprite['style'] = 'background-image: url('.$temp_robot_sprite['url'].'?'.$MMRPG_CONFIG['CACHE_DATE'].');  top: 5px; left: 5px; ';
          $temp_energy_percent = ceil(($temp_robot->robot_energy / $temp_robot->robot_base_energy) * 100);
          if ($temp_energy_percent > 50){ $temp_robot_sprite['class'] .= 'sprite_40x40_energy_high ';  }
          elseif ($temp_energy_percent > 25){ $temp_robot_sprite['class'] .= 'sprite_40x40_energy_medium ';  }
          elseif ($temp_energy_percent > 0){ $temp_robot_sprite['class'] .= 'sprite_40x40_energy_low '; }
          $temp_robot_sprite['markup'] = '<span class="'.$temp_robot_sprite['class'].'" style="'.$temp_robot_sprite['style'].'">'.$temp_robot_sprite['name'].'</span>';
          // Now use the new object to generate a snapshot of this switch button
          ?><a title="<?=$temp_robot_title?>" class="button <?= !$allow_button ? 'button_disabled' : '' ?> action_switch switch_<?= $temp_robot->robot_token ?> status_<?= $temp_robot->robot_status ?> block_<?= $robot_key + 1 ?>" type="button" <?if($allow_button):?>data-action="switch_<?= $temp_robot->robot_id.'_'.$temp_robot->robot_token ?>"<?endif;?> data-preload="<?= $temp_robot_sprite['preload'] ?>"><label><?= $temp_robot_sprite['markup'] ?><?= $temp_robot_label ?></label></a><?
        }
      }
      // If there were less than 8 robots, fill in the empty spaces
      if ($num_robots < 8){
        for ($i = $num_robots; $i < 8; $i++){
          // Display an empty button placeholder
          ?><a class="button action_switch button_disabled block_<?= $i + 1 ?>" type="button">&nbsp;</a><?
        }
      }
    }
    // End the main action container tag
    ?></div><?
    // Display the back button by default
    ?><div class="sub_actions"><a class="button action_back <?= $this_robot->robot_energy > 0 ? '' : 'button_disabled' ?>" type="button" <?= $this_robot->robot_energy > 0 ? 'data-panel="battle"' : '' ?>><label>Back</label></a></div><?
  $actions_markup['switch'] = trim(ob_get_clean());
  $actions_markup['switch'] = preg_replace('#\s+#', ' ', $actions_markup['switch']);

  // Generate the markup for the action scan panel
  ob_start();
    // Display container for the main actions
    ?><div class="main_actions"><?
    // Ensure there are robots to display
    if (!empty($target_player->player_robots)){
      // Count the total number of robots
      $num_robots = count($target_player->player_robots);
      $robot_direction = $target_player->player_side == 'left' ? 'right' : 'left';
      // Loop through each robot and display its scan button
      foreach ($target_player->player_robots AS $robot_key => $scan_robotinfo){
        // Ensure this is an actual switch in the index
        if (isset($mmrpg_index['robots'][$switch_robotinfo['robot_token']])){
          // Create the scan object using the session/index data
          //$GLOBALS['DEBUG']['checkpoint_line'] = 'data.php : line 655';
          $temp_robot = new mmrpg_robot($this_battle, $target_player, $scan_robotinfo);
          // Default the allow button flag to true
          $allow_button = true;
          // If this robot is disabled, disable the button
          if ($temp_robot->robot_status == 'disabled'){ $allow_button = false; }
          // If this robot is not active, disable the button
          //if ($temp_robot->robot_position != 'active'){ $allow_button = false; }
          // Define the title hover for the robot
          $temp_robot_title = $temp_robot->robot_name
            //.' | '.$temp_robot->robot_id.''
            //.' | '.strtoupper($temp_robot->robot_position).''
            .' | '.$temp_robot->robot_energy.'/'.$temp_robot->robot_base_energy.' Energy'
            .' | A:'.$temp_robot->robot_attack
            .' | D:'.$temp_robot->robot_defense
            .' | S:'.$temp_robot->robot_speed
            .'';

          // Define the robot button text variables
          $temp_robot_label = '<span class="multi">';
          $temp_robot_label .= '<span class="maintext">'.$temp_robot->robot_name.'</span>';
          $temp_robot_label .= '<span class="subtext">';
            $temp_robot_label .= $temp_robot->robot_energy.'/'.$temp_robot->robot_base_energy.' Energy';
          $temp_robot_label .= '</span>';
          $temp_robot_label .= '<span class="subtext">';
            $temp_robot_label .= 'A:'.$temp_robot->robot_attack;
            $temp_robot_label .= '&nbsp;';
            $temp_robot_label .= 'D:'.$temp_robot->robot_defense;
            $temp_robot_label .= '&nbsp;';
            $temp_robot_label .= 'S:'.$temp_robot->robot_speed;
          $temp_robot_label .= '</span>';
          $temp_robot_label .= '</span>';

          // Define the robot sprite variables
          $temp_robot_sprite = array();
          $temp_robot_sprite['name'] = $temp_robot->robot_name;
          $temp_robot_sprite['url'] = 'images/robots/'.$temp_robot->robot_token.'/sprite_'.$robot_direction.'_40x40.png';
          $temp_robot_sprite['preload'] = 'images/robots/'.$temp_robot->robot_token.'/sprite_'.$robot_direction.'_80x80.png';
          $temp_robot_sprite['class'] = 'sprite sprite_40x40 sprite_40x40_'.($temp_robot->robot_energy > 0 ? ($temp_robot->robot_energy > ($temp_robot->robot_base_energy/2) ? 'base' : 'defend') : 'defeat').' ';
          $temp_robot_sprite['style'] = 'background-image: url('.$temp_robot_sprite['url'].'?'.$MMRPG_CONFIG['CACHE_DATE'].');  top: 6px; left: 5px; ';
          $temp_energy_percent = ceil(($temp_robot->robot_energy / $temp_robot->robot_base_energy) * 100);
          if ($temp_energy_percent > 50){ $temp_robot_sprite['class'] .= 'sprite_40x40_energy_high ';  }
          elseif ($temp_energy_percent > 25){ $temp_robot_sprite['class'] .= 'sprite_40x40_energy_medium ';  }
          elseif ($temp_energy_percent > 0){ $temp_robot_sprite['class'] .= 'sprite_40x40_energy_low '; }
          $temp_robot_sprite['markup'] = '<span class="'.$temp_robot_sprite['class'].'" style="'.$temp_robot_sprite['style'].'">'.$temp_robot_sprite['name'].'</span>';
          // Now use the new object to generate a snapshot of this switch button
          ?><a title="<?=$temp_robot_title?>" class="button <?= !$allow_button ? 'button_disabled' : '' ?> action_scan scan_<?= $temp_robot->robot_token ?> status_<?= $temp_robot->robot_status ?> block_<?= $robot_key + 1 ?>" type="button" <?if($allow_button):?>data-action="scan_<?= $temp_robot->robot_id.'_'.$temp_robot->robot_token ?>"<?endif;?> data-preload="<?= $temp_robot_sprite['preload'] ?>"><label><?= $temp_robot_sprite['markup'] ?><?= $temp_robot_label ?></label></a><?
        }
      }
      // If there were less than 8 robots, fill in the empty spaces
      if ($num_robots < 8){
        for ($i = $num_robots; $i < 8; $i++){
          // Display an empty button placeholder
          ?><a class="button action_scan button_disabled block_<?= $i + 1 ?>" type="button">&nbsp;</a><?
        }
      }
    }
    // End the main action container tag
    ?></div><?
    // Display the back button by default
    ?><div class="sub_actions"><a class="button action_back" type="button" data-panel="battle"><label>Back</label></a></div><?
  $actions_markup['scan'] = trim(ob_get_clean());
  $actions_markup['scan'] = preg_replace('#\s+#', ' ', $actions_markup['scan']);

}
// Otherwise, if the battle has ended
elseif (empty($this_redirect) && $this_battle->battle_status == 'complete'){

  // Generate the markup for the action switch panel
  ob_start();
    // If the current robot is not disabled
    if ($this_player->counters['robots_active'] > 0){
      // Display available main actions
      ?><div class="main_actions"><?
      ?><a class="button action_ability" data-action="prototype" type="button"><label>Mission Complete!</label></a><?
      ?></div><?
      // Display the available sub options
      ?><div class="sub_actions"><?
      ?><a class="button action_scan button_disabled" type="button">&nbsp;</a><?
      ?><a class="button action_option button_disabled" type="button">&nbsp;</a><?
      ?><a class="button action_switch button_disabled" type="button">&nbsp;</a><?
      ?></div><?
    }
    // Otherwise if this robot has been disabled
    else {
      // Display available main actions
      ?><div class="main_actions"><?
      ?><a class="button action_ability" data-action="restart" type="button"><label>Mission Failure&hellip;</label></a><?
      ?></div><?
      // Display the available sub options
      ?><div class="sub_actions"><?
      ?><a class="button action_scan button_disabled" type="button">&nbsp;</a><?
      /*?><a class="button action_option button_disabled" type="button">&nbsp;</a><?*/
      ?><a class="button action_option" type="button" data-panel="option"><label>Option</label></a><?
      ?><a class="button action_switch button_disabled" type="button">&nbsp;</a><?
      ?></div><?
    }
  $actions_markup['battle'] = trim(ob_get_clean());
  $actions_markup['battle'] = preg_replace('#\s+#', ' ', $actions_markup['battle']);

}

// If possible, attempt to save the game to the session with recent changes
if (!empty($this_save_filepath)){
  // Save the game session
  mmrpg_save_game_session($this_save_filepath);
}

// Determine the next action based on everything that's happened
if (empty($this_redirect)){
  $this_next_action = 'battle';
  if (($this_robot->robot_status == 'disabled' || $this_robot->robot_position != 'active')
    && $this_battle->battle_status != 'complete'){
    $this_next_action = 'switch';
  }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Mega Man RPG Prototype | Data API | Last Updated <?= preg_replace('#([0-9]{4})([0-9]{2})([0-9]{2})-([0-9]{2})#', '$1/$2/$3', $MMRPG_CONFIG['CACHE_DATE']) ?></title>
<base href="<?=$MMRPG_CONFIG['ROOTURL']?>" />
<style type="text/css">
</style>
<script type="text/javascript">
// Ensure this script is loaded via iframe
if (window != window.top){
  // Redirect the parent window if necessary
  <?if(!empty($this_redirect)):?>
  parent.window.location.href = '<?=$this_redirect?>';
  <?else:?>
  // Update the global battle engine variables
  parent.mmrpg_engine_update({
    this_battle_id : '<?= $this_battle->battle_id ?>',
    this_battle_token : '<?= $this_battle->battle_token ?>',
    this_field_id : '<?= $this_field->field_id ?>',
    this_field_token : '<?= $this_field->field_token ?>',
    this_player_id : '<?= $this_player->player_id ?>',
    this_player_token : '<?= $this_player->player_token ?>',
    this_robot_id : '<?= $this_robot->robot_id ?>',
    this_robot_token : '<?= $this_robot->robot_token ?>',
    target_player_id : '<?= $target_player->player_id ?>',
    target_player_token : '<?= $target_player->player_token ?>',
    target_robot_id : '<?= $target_robot->robot_id ?>',
    target_robot_token : '<?= $target_robot->robot_token ?>',
    this_battle_status : '<?= $this_battle->battle_status ?>',
    next_action : '<?= $this_next_action ?>'
    });
  <?
    // If action markup exists, loop through it
    if (!empty($actions_markup)){
      // Update any action panel markup changed by the battle
      foreach($actions_markup AS $action_token => $action_markup){
        $action_markup = str_replace("'", "\\'", $action_markup);
        echo "parent.mmrpg_action_panel_update('{$action_token}', '{$action_markup}');\r\n";
      }
    }
    // Collect event markup from the battle object
    $events_markup = $this_battle->events_markup_collect();
    // If event markup exists, loop through it
    if (!empty($events_markup)){
      //Print out any event markup generated by the battle
      foreach($events_markup AS $markup){
        $flags_markup = str_replace("'", "\\'", $markup['flags']);
        $data_markup = str_replace("'", "\\'", $markup['data']);
        $canvas_markup = str_replace("'", "\\'", $markup['canvas']);
        $console_markup = str_replace("'", "\\'", $markup['console']);
        echo "parent.mmrpg_event('{$flags_markup}', '{$data_markup}', '{$canvas_markup}', '{$console_markup}');\r\n";
      }
      echo "parent.setTimeout(function(){ return parent.mmrpg_events(); }, parent.gameSettings.eventTimeout);\r\n";
    }

  ?>
  <?endif;?>
}
<?/*
 else {
  // Redirect the parent window if necessary
  <?if(!empty($this_redirect)):?>
  window.location.href = '<?=$this_redirect?>';
  <?else:?>
  <?
    // If event markup exists, loop through it
    if (!empty($events_markup)){
      //Print out any event markup generated by the battle
      foreach($events_markup AS $markup){
        $canvas_markup = str_replace("'", "\\'", $markup['canvas']);
        $console_markup = str_replace("'", "\\'", $markup['console']);
        echo "document.write('<hr />{$canvas_markup}<br />{$console_markup}<hr />');\r\n";
      }
    }
  ?>
  <?endif;?>
}
*/?>
</script>
</head>
<body>
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
$mmrpg_index['battles']
<?=print_r($mmrpg_index['battles'], true)?>
=================================
$mmrpg_index['players']
<?=print_r($mmrpg_index['players'], true)?>
=================================
$mmrpg_index['robots']
<?=print_r($mmrpg_index['robots'], true)?>
=================================
$mmrpg_index['abilities']
<?=print_r($mmrpg_index['abilities'], true)?>
=================================
$mmrpg_index['types']
<?=print_r($mmrpg_index['types'], true)?>
=================================
$_SESSION['RPG2k12-2']
<?=print_r($_SESSION['RPG2k12-2'], true)?>
</pre>
*/?>
</body>
</html>