<?php

// Include the TOP file
require_once('top.php');

// Collect header action flags, if set
$this_request_type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : false;
$this_request_token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : false;
$this_request_action = !empty($_REQUEST['action']) ? $_REQUEST['action'] : false;

// Process the game token request, if set
if ($this_request_type == 'game'){
  if ($this_request_action == 'reset'){
    // Reset the game session
    mmrpg_reset_game_session($this_save_filepath);
  }
  header('Location: debug.php#reset');
}
// Process the battle token request, if set
elseif ($this_request_type == 'battles'){
  if ($this_request_action == 'create'){ $_SESSION['GAME']['values']['battle_complete'][$this_request_token] = $this_request_token; }
  elseif ($this_request_action == 'delete'){ unset($_SESSION['GAME']['values']['battle_complete'][$this_request_token]); }
  header('Location: debug.php#battles_'.$this_request_token);
}
// Process the robots token request, if set
elseif ($this_request_type == 'robots'){
  list($this_request_token_player, $this_request_token_robot) = explode('_', $this_request_token);
  if ($this_request_action == 'create'){

    // Collect the player info from the index
    $player_info = $mmrpg_index['players'][$this_request_token_player];

    // Collect or define the player points and player rewards variables
    $this_player_token = $player_info['player_token'];
    $this_player_points = !empty($player_info['player_points']) ? $player_info['player_points'] : 0;
    $this_player_rewards = !empty($player_info['player_rewards']) ? $player_info['player_rewards'] : array();

    // Collect the robot info from the index
    $robot_info = mmrpg_robot::get_index_info($robot_reward_info['token']);

    // Collect or define the robot points and robot rewards variables
    $this_robot_token = $robot_info['robot_token'];
    $this_robot_experience = !empty($robot_info['robot_experience']) ? $robot_info['robot_experience'] : 0;
    $this_robot_rewards = !empty($robot_info['robot_rewards']) ? $robot_info['robot_rewards'] : array();

    // Automatically unlock this robot for use in battle
    $this_reward = array('robot_token' => $this_robot_token, 'robot_experience' => $this_robot_experience);
    $_SESSION['GAME']['values']['battle_rewards'][$this_player_token]['player_robots'][$this_robot_token] = $this_reward;

    // Loop through the ability rewards for this robot if set
    if (!empty($this_robot_rewards['abilities'])){
      $temp_abilities_index = $DB->get_array_list("SELECT * FROM mmrpg_index_abilities WHERE ability_flag_complete = 1;", 'ability_token');
      foreach ($this_robot_rewards['abilities'] AS $ability_reward_key => $ability_reward_info){

        // Check if the required amount of points have been met by this robot
        if ($this_robot_experience >= $ability_reward_info['points']){

          // Collect the ability info from the index
          $ability_info = mmrpg_ability::parse_index_info($temp_abilities_index[$ability_reward_info['token']]);

          // Collect or define the ability variables
          $this_ability_token = $ability_info['ability_token'];

          // Automatically unlock this ability for use in battle
          $this_reward = array('ability_token' => $this_ability_token);
          $_SESSION['GAME']['values']['battle_rewards'][$this_player_token]['player_robots'][$this_robot_token]['robot_abilities'][$this_ability_token] = $this_reward;

        }

      }
    }




    //$_SESSION['GAME']['values']['battle_rewards'][$this_request_token_player]['player_robots'][$this_request_token_robot] = $this_request_token_robot;
  }
  elseif ($this_request_action == 'delete'){ unset($_SESSION['GAME']['values']['battle_rewards'][$this_request_token_player]['player_robots'][$this_request_token_robot]); }
  header('Location: debug.php#robots_'.$this_request_token);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>DEBUG</title>
<link rel="shortcut icon" type="image/x-icon" href="images/assets/favicon<?= !MMRPG_CONFIG_IS_LIVE ? '-local' : '' ?>.ico">
<meta name="robots" content="noindex,nofollow" />
<link type="text/css" href="styles.css" rel="stylesheet" />
<style type="text/css">
body {
  background-color: #FFFFFF;
  overflow: scroll;
  height: 400px;
}
a {
  color: #464646;
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}
</style>
<script type="text/css">
</script>
</head>
<body>
<div id="top" style="margin: 0 0 30px;">
  <h1 style="margin: 0 0 2px;font-size:20px;line-height:20px;">DEBUG MENU</h1>
  <div style="margin: 0;font-size:11px;line-height:11px;">IP : <?=$_SERVER['REMOTE_ADDR']?>, Filename : <?=$this_save_filename?>, Status : <?= file_exists($this_save_filepath) ? 'Save Exists' : 'Save Does Not Exist' ?></div>
  <a style="font-size:11px;line-height:11px;" onclick="window.location='debug.php#battles';">Battle Switches</a> |
  <a style="font-size:11px;line-height:11px;" onclick="window.location='debug.php#robots_dr-light';">Light Robot Switches</a> |
  <a style="font-size:11px;line-height:11px;" onclick="window.location='debug.php#robots_dr-wily';">Wily Robot Switches</a> |
  <a style="font-size:11px;line-height:11px;" onclick="window.location='debug.php?type=game&amp;action=reset#reset';">Reset Game</a> |
  <a style="font-size:11px;line-height:11px;" onclick="window.location='session.php';">Session Page</a> |
  <a style="font-size:11px;line-height:11px;" onclick="window.location='debug.php#mmrpg_index';">MMRPG Index</a> |
  <a style="font-size:11px;line-height:11px;" onclick="window.location='prototype.php';">Back to Prototype Menu</a>
</div>
<hr />
<?
  // BATTLE SWITCHES
  echo '<h2 id="battles" style="margin-bottom: 10px;font-size:16px;line-height:19px;">BATTLE SWITCHES</h2>';
  foreach ($mmrpg_index['battles'] AS $this_token => $this_battleinfo){
    echo '<div id="battles_'.$this_battleinfo['battle_token'].'" style="margin:0;font-family:\'Courier New\';font-size:13px;line-height:16px;">';
    $this_battle_complete = mmrpg_prototype_battle_complete($this_battleinfo['battle_token']);
    echo '<strong>'.$this_battleinfo['battle_name'].'</strong> : <span>'.$this_battleinfo['battle_token'].'</span> : ';
    echo '(';
    echo ($this_battle_complete ? '<span style="color:green;">complete</span>' : '<span style="color:red;">incomplete</span>').' / ';
    if ($this_battle_complete){ echo '<a style="" onclick="window.location=\'debug.php?type=battles&amp;token='.$this_battleinfo['battle_token'].'&amp;action=delete\';">mark as incomplete</a>'; }
    else { echo '<a style="" onclick="window.location=\'debug.php?type=battles&amp;token='.$this_battleinfo['battle_token'].'&amp;action=create\';">mark as complete</a>'; }
    echo ')';
    echo '</div>';
  }
  echo '<a style="display: block; margin: 5px 0 0;" onclick="window.location=\'debug.php#top\';">^ Top</a>';
  echo '<hr style="margin: 20px auto 30px;" />';
?>
<?
  // ROBOT SWITCHES
  echo '<h2 id="robots" style="margin-bottom: 10px;font-size:16px;line-height:19px;">ROBOT SWITCHES</h2>';
  foreach ($mmrpg_index['players'] AS $player_token => $this_playerinfo){
    if ($player_token == 'dr-cossack' || $player_token == 'player'){ continue; }
    echo '<div id="robots_'.$this_playerinfo['player_token'].'" style="margin: 0 auto 10px;">';
    foreach ($this_playerinfo['player_robots'] AS $this_key => $this_robotinfo){
      $robot_token = $this_robotinfo['robot_token'];
      $this_robotindex = mmrpg_robot::get_index_info($robot_token);
      $this_robotinfo = array_replace($this_robotindex, $this_robotinfo);
      echo '<div id="robots_'.$this_playerinfo['player_token'].'_'.$this_robotinfo['robot_token'].'" style="margin:0;font-family:\'Courier New\';font-size:13px;line-height:16px;">';
      $this_robot_unlocked = mmrpg_prototype_robot_unlocked($this_playerinfo['player_token'], $this_robotinfo['robot_token']);
      echo '<strong>'.$this_playerinfo['player_name'].'&#39;s '.$this_robotinfo['robot_name'].'</strong> : <span>'.$this_robotinfo['robot_token'].'</span> : ';
      echo '(';
      echo ($this_robot_unlocked ? '<span style="color:green;">unlocked</span>' : '<span style="color:red;">locked</span>').' / ';
      if ($this_robot_unlocked){ echo '<a style="" onclick="window.location=\'debug.php?type=robots&amp;token='.$this_playerinfo['player_token'].'_'.$this_robotinfo['robot_token'].'&amp;action=delete\';">mark as locked</a>'; }
      else { echo '<a style="" onclick="window.location=\'debug.php?type=robots&amp;token='.$this_playerinfo['player_token'].'_'.$this_robotinfo['robot_token'].'&amp;action=create\';">mark as unlocked</a>'; }
      echo ')';
      echo '</div>';
    }
    echo '<a style="display: block; margin: 5px 0 0;" onclick="window.location=\'debug.php#top\';">^ Top</a>';
    echo '</div>';
  }
  echo '<hr style="margin: 20px auto 30px;" />';
?>
<a onclick="window.location='prototype.php';">&laquo; Back to Prototype Menu</a>
<h2 id="mmrpg_index" style="margin-bottom: 10px;font-size:16px;line-height:19px;">MMRPG INDEX</h2>
<pre>
<?=htmlentities(print_r($mmrpg_index, true))?>
</pre>
<a style="display: block; margin: 5px 0 0;" onclick="window.location='debug.php#top';">^ Top</a>
<a onclick="window.location='prototype.php';">&laquo; Back to Prototype Menu</a>
</body>
</html>