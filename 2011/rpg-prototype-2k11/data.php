<?php

// Include the TOP file
require_once('top.php');

/*
 * DEFINE & COLLECT BATTLE VARIABLES
 */

// Collect the global battle variables
$this_battle_id = isset($_REQUEST['this_battle_id']) ? $_REQUEST['this_battle_id'] : 0;
$this_battle_token = isset($_REQUEST['this_battle_token']) ? $_REQUEST['this_battle_token'] : 0;
$this_user_id = isset($_REQUEST['this_user_id']) ? $_REQUEST['this_user_id'] : 0;
$this_player_id = isset($_REQUEST['this_player_id']) ? $_REQUEST['this_player_id'] : 0;
$this_player_token = isset($_REQUEST['this_player_token']) ? $_REQUEST['this_player_token'] : 0;
$this_robot_id = isset($_REQUEST['this_robot_id']) ? $_REQUEST['this_robot_id'] : 0;
$this_robot_token = isset($_REQUEST['this_robot_token']) ? $_REQUEST['this_robot_token'] : 0;
$target_user_id = isset($_REQUEST['target_user_id']) ? $_REQUEST['target_user_id'] : 0;
$target_player_id = isset($_REQUEST['target_player_id']) ? $_REQUEST['target_player_id'] : 0;
$target_player_token = isset($_REQUEST['target_player_token']) ? $_REQUEST['target_player_token'] : 0;
$target_robot_id = isset($_REQUEST['target_robot_id']) ? $_REQUEST['target_robot_id'] : 0;
$target_robot_token = isset($_REQUEST['target_robot_token']) ? $_REQUEST['target_robot_token'] : 0;

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
  $this_errors[] = 'This battle token was not received!';
}
if (empty($this_player_id) || empty($this_player_token)){
  $this_verified = false;
  $this_errors[] = 'This player token was not received!';
}
if (empty($target_player_id) || empty($target_player_token)){
  $this_verified = false;
  $this_errors[] = 'Target player token was not received!';
}
if (empty($this_robot_id) || empty($this_robot_token)){
  $this_verified = false;
  $this_errors[] = 'This robot token was not received!';
}
if (empty($target_robot_id) || empty($target_robot_token)){
  $this_verified = false;
  $this_errors[] = 'Target robot token was not received!';
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
$this_battle = new mmrpg_battle($this_battleinfo);

// Define the current player object using the loaded player data
$this_playerinfo = array('player_id' => $this_player_id, 'player_token' => $this_player_token);
$this_player = new mmrpg_player($this_battle, $this_playerinfo);
// Force this player's autopilot off to require input
$this_player->player_autopilot = false;
// Force this player to the left side of the field
$this_player->player_side = 'left';

// Define the target player object using the loaded player data
$target_playerinfo = array('player_id' => $target_player_id, 'player_token' => $target_player_token);
$target_player = new mmrpg_player($this_battle, $target_playerinfo);
// Force the target player's autopilot on to automate input
$target_player->player_autopilot = true;
// Force target player to the right side of the field
$target_player->player_side = 'right';

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
$this_robot = new mmrpg_robot($this_battle, $this_player, $this_robotinfo);
// Define the target robot object using the loaded robot data
$target_robot = new mmrpg_robot($this_battle, $target_player, $target_robotinfo);


/*
 * BATTLE START!
 */

// Define the action queue variable and populate it with this/target pairs
$action_queue = array();

// If the player is just starting the battle, queue start actions
if ($this_action == 'start'){

  // Create the enter event for the battle start
  $event_header = "{$this_battle->battle_name}";
  $event_body = "{$this_player->print_player_name()} vs. {$target_player->print_player_name()}<br />";
  $event_body .= "{$this_battle->battle_field['field_name']}<br />";
  $event_options = array();
  $event_options['this_header_float'] = $event_options['this_body_float'] = 'center';
  $event_options['canvas_show_this'] = $event_options['console_show_this'] = false;
  $event_options['canvas_show_target'] = $event_options['console_show_target'] = false;
  $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
  // Queue up this robot's startup action first
  $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'start', '');
  // Then queue up an the target robot's startup action
  $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, 'start', '');

}
// Else if the player is switching robots, they go first
elseif ($this_action == 'switch'){

  // Define whether to skip the target's turn based on
  // if this player is replacing a fainted robot
  $skip_target_turn = $this_robot->robot_status == 'disabled' ? true : false;
  // Queue up this robot's switch action first
  $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'switch', $this_action_token);
  // Only queue the enemy action if the skip_turn flag is not true
  if (!$skip_target_turn){
    // Then queue up an the target robot's defined action
    $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, '', '');
  }
}
// Else if the player's robot using an ability and is faster than the target, they go first
elseif ($this_action == 'ability'){

  // If this robot is faster than the target
  if ($this_robot->robot_speed >= $target_robot->robot_speed){

    // Queue up an this robot's action first, because its faster
    $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'ability', $this_action_token);
    // Then queue up an the target robot's action second, because its slower
    $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, '', '');

  }
  // Else if the target robot is faster than this one
  else {

    // Then queue up an the target robot's action first, because its faster
    $this_battle->actions_append($target_player, $target_robot, $this_player, $this_robot, '', '');
    // Queue up an this robot's action second, because its slower
    $this_battle->actions_append($this_player, $this_robot, $target_player, $target_robot, 'ability', $this_action_token);

  }
}

// Now execute the stored actions (and any created in the process of executing them!)
$this_battle->actions_execute();


/*
 * ACTION PROCESSING
 */

// Define the array to hold action panel markup
$actions_markup = array();

// Ensure the battle is still in progress
if ($this_battle->battle_status != 'complete'){

  // Generate the markup for the action switch panel
  ob_start();
    // If the current robot is not disabled
    if ($this_robot->robot_energy > 0){
      // Display available main actions
      ?><div class="main_actions"><?
      ?><a class="button action_ability" type="button" data-panel="ability">Ability</a><?
      ?></div><?
      // Display the available sub options
      ?><div class="sub_actions"><?
      ?><a class="button action_scan button_disabled" type="button">Scan</a><?
      ?><a class="button action_assist button_disabled" type="button">Assist</a><?
      ?><a class="button action_switch" type="button" data-panel="switch">Switch</a><?
      ?></div><?
    }
    // Otherwise if this robot has been disabled
    else {
      // Display available main actions
      ?><div class="main_actions"><?
      ?><a class="button action_ability button_disabled" type="button">Ability</a><?
      ?></div><?
      // Display the available sub options
      ?><div class="sub_actions"><?
      ?><a class="button action_scan button_disabled" type="button">Scan</a><?
      ?><a class="button action_assist button_disabled" type="button">Assist</a><?
      ?><a class="button action_switch" type="button" data-panel="switch">Switch</a><?
      ?></div><?
    }
  $actions_markup['battle'] = trim(ob_get_clean());
  $actions_markup['battle'] = preg_replace('#\s+#', ' ', $actions_markup['battle']);

  // Generate the markup for the action ability panel
  ob_start();
    // Display container for the main actions
    ?><div class="main_actions"><?
    // Ensure this robot has abilities to display
    if (!empty($this_robot->robot_abilities)){
      // Count the total number of abilities
      $num_abilities = count($this_robot->robot_abilities);
      // Loop through each ability and display its button
      foreach ($this_robot->robot_abilities AS $ability_key => $ability_token){
        // Ensure this is an actual ability in the index
        if (isset($mmrpg_index['abilities'][$ability_token])){
          // Create the ability object using the session/index data
          $temp_abilityinfo = array('ability_id' => $ability_key, 'ability_token' => $ability_token);
          $temp_ability = new mmrpg_ability($this_battle, $this_player, $this_robot, $temp_abilityinfo);
          // Define the ability title details text
          $temp_ability_details = $temp_ability->ability_name;
          $temp_ability_details .= ' | '.(!empty($temp_ability->ability_type) ? $mmrpg_index['types'][$temp_ability->ability_type]['type_name'] : 'None');
          $temp_ability_details .= ' | '.$temp_ability->ability_damage;
          $temp_ability_details .= ' | '.$temp_ability->ability_accuracy.'%';
          $temp_ability_details .= ' | '.$temp_ability->ability_description;
          // Now use the new object to generate a snapshot of this ability button
          ?><a class="button action_ability ability_<?= $temp_ability->ability_token ?> type_<?= $temp_ability->ability_type ?>" type="button" data-action="ability_<?= $temp_ability->ability_id.'_'.$temp_ability->ability_token ?>" title="<?= $temp_ability_details ?>"><?= $temp_ability->ability_name ?></a><?
        }
      }
      // If there were less than 6 abilities, fill in the empty spaces
      if ($num_abilities < 6){
        for ($i = $num_abilities; $i < 6; $i++){
          // Display an empty button placeholder
          ?><a class="button action_ability button_disabled" type="button">&nbsp;</a><?
        }
      }
    }
    // End the main action container tag
    echo 'Abilities : ['.print_r($this_robot->robot_abilities, true).']';
    ?></div><?
    // Display the back button by default
    ?><div class="sub_actions"><a class="button action_back" type="button" data-panel="battle">Back</a></div><?
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
      // Loop through each robot and display its switch button
      foreach ($this_player->player_robots AS $key => $switch_robotinfo){
        // Ensure this is an actual switch in the index
        if (isset($mmrpg_index['robots'][$switch_robotinfo['robot_token']])){
          // Create the switch object using the session/index data
          $temp_robot = new mmrpg_robot($this_battle, $this_player, $switch_robotinfo);
          // Default the allow button flag to false
          $allow_button = true;
          // If this robot is already out, disable the button
          if ($this_robot->robot_id == $temp_robot->robot_id){ $allow_button = false; }
          // If this robot is disabled, disable the button
          if ($temp_robot->robot_status == 'disabled'){ $allow_button = false; }
          // Define the title hover for the robot
          $temp_robot_title = $temp_robot->robot_name
            .' | '.$temp_robot->robot_id.''
            .' | '.strtoupper($temp_robot->robot_position).''
            .' | '.$temp_robot->robot_energy.' LE'
            .' | '.$temp_robot->robot_attack.' AT'
            .' | '.$temp_robot->robot_defense.' DF'
            .' | '.$temp_robot->robot_speed.' SP';

          // Now use the new object to generate a snapshot of this switch button
          ?><a title="<?=$temp_robot_title?>" class="button <?= !$allow_button ? 'button_disabled' : '' ?> action_switch switch_<?= $temp_robot->robot_token ?> status_<?= $temp_robot->robot_status ?>" type="button" <?if($allow_button):?>data-action="switch_<?= $temp_robot->robot_id.'_'.$temp_robot->robot_token ?>"<?endif;?>><?= $temp_robot->robot_name ?></a><?
        }
      }
      // If there were less than 8 robots, fill in the empty spaces
      if ($num_robots < 8){
        for ($i = $num_robots; $i < 8; $i++){
          // Display an empty button placeholder
          ?><a class="button action_switch button_disabled" type="button">&nbsp;</a><?
        }
      }
    }
    // End the main action container tag
    ?></div><?
    // Display the back button by default
    ?><div class="sub_actions"><a class="button action_back <?= $this_robot->robot_energy > 0 ? '' : 'button_disabled' ?>" type="button" <?= $this_robot->robot_energy > 0 ? 'data-panel="battle"' : '' ?>>Back</a></div><?
  $actions_markup['switch'] = trim(ob_get_clean());
  $actions_markup['switch'] = preg_replace('#\s+#', ' ', $actions_markup['switch']);

}
// Otherwise, if the battle has ended
else {

  // Generate the markup for the action switch panel
  ob_start();
    // If the current robot is not disabled
    if ($this_player->counters['robots_active'] > 0){
      // Display available main actions
      ?><div class="main_actions"><?
      ?><a class="button action_ability" type="button">You Win!</a><?
      ?></div><?
      // Display the available sub options
      ?><div class="sub_actions"><?
      ?><a class="button action_scan button_disabled" type="button">&nbsp;</a><?
      ?><a class="button action_assist button_disabled" type="button">&nbsp;</a><?
      ?><a class="button action_switch button_disabled" type="button">&nbsp;</a><?
      ?></div><?
    }
    // Otherwise if this robot has been disabled
    else {
      // Display available main actions
      ?><div class="main_actions"><?
      ?><a class="button action_ability" type="button">You Loose&hellip;</a><?
      ?></div><?
      // Display the available sub options
      ?><div class="sub_actions"><?
      ?><a class="button action_scan button_disabled" type="button">&nbsp;</a><?
      ?><a class="button action_assist button_disabled" type="button">&nbsp;</a><?
      ?><a class="button action_switch button_disabled" type="button">&nbsp;</a><?
      ?></div><?
    }
  $actions_markup['battle'] = trim(ob_get_clean());
  $actions_markup['battle'] = preg_replace('#\s+#', ' ', $actions_markup['battle']);

}

// Determine the next action based on everything that's happened
$this_next_action = 'battle';
if ($this_robot->robot_status == 'disabled'
  && $this_battle->battle_status != 'complete'){
  $this_next_action = 'switch';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>MegaMan RPG Test 2k11 : Data</title>
<style type="text/css">

</style>
<script type="text/javascript">

// Ensure this script is loaded via iframe
if (window != window.top){
  // Update the global battle engine variables
  parent.mmrpg_engine_update({
    this_battle_id : '<?= $this_battle->battle_id ?>',
    this_battle_token : '<?= $this_battle->battle_token ?>',
    this_player_id : '<?= $this_player->player_id ?>',
    this_player_token : '<?= $this_player->player_token ?>',
    this_robot_id : '<?= $this_robot->robot_id ?>',
    this_robot_token : '<?= $this_robot->robot_token ?>',
    target_player_id : '<?= $target_player->player_id ?>',
    target_player_token : '<?= $target_player->player_token ?>',
    target_robot_id : '<?= $target_robot->robot_id ?>',
    target_robot_token : '<?= $target_robot->robot_token ?>',
    next_action : '<?= $this_next_action ?>',
    });
  <?
    // Collect event markup from the battle object
    $events_markup = $this_battle->events_markup();
    // If event markup exists, loop through it
    if (!empty($events_markup)){
      //Print out any event markup generated by the battle
      foreach($events_markup AS $markup){
        $data_markup = str_replace("'", "\\'", $markup['data']);
        $canvas_markup = str_replace("'", "\\'", $markup['canvas']);
        $console_markup = str_replace("'", "\\'", $markup['console']);
        echo "parent.mmrpg_event('{$data_markup}', '{$canvas_markup}', '{$console_markup}');\r\n";
      }
      echo "parent.mmrpg_events();\r\n";
    }
    // If action markup exists, loop through it
    if (!empty($actions_markup)){
      // Update any action panel markup changed by the battle
      foreach($actions_markup AS $action_token => $action_markup){
        $action_markup = str_replace("'", "\\'", $action_markup);
        echo "parent.mmrpg_action_panel_update('{$action_token}', '{$action_markup}');\r\n";
      }
    }
  ?>
} else {
  <?
    // If event markup exists, loop through it
    if (!empty($events_markup)){
      //Print out any event markup generated by the battle
      foreach($events_markup AS $markup){
        $canvas_markup = str_replace("'", "\\'", $markup['canvas']);
        $console_markup = str_replace("'", "\\'", $markup['console']);
        echo "document.write('{$canvas_markup}<br />{$console_markup}<hr />');\r\n";
      }
    }
  ?>
}
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
$_SESSION['RPG2k11']
<?=print_r($_SESSION['RPG2k11'], true)?>
</pre>
*/?>
</body>
</html>
