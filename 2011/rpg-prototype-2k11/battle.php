<?php
// Include the TOP file
require_once('top.php');

// Automatically unset the session variable
// on index page load (for testing)
session_unset();

// Collect the battle tokens from the URL
$this_battle_token = isset($_GET['this_battle_token']) ? $_GET['this_battle_token'] : 'prototype-1';
$this_player_token = isset($_GET['this_player_token']) ? $_GET['this_player_token'] : 'dr-light';
$target_player_token = isset($_GET['target_player_token']) ? $_GET['target_player_token'] : 'dr-wily';

// Collect the battle index data if available
if (isset($mmrpg_index['battles'][$this_battle_token])){ $this_battle_data = &$mmrpg_index['battles'][$this_battle_token];  }
else { $this_battle_data = false;  }
if (isset($mmrpg_index['players'][$this_player_token])){ $this_player_data = &$mmrpg_index['players'][$this_player_token];  }
else { $this_player_data = false;  }
if (isset($mmrpg_index['players'][$target_player_token])){ $target_player_data = &$mmrpg_index['players'][$target_player_token];  }
else { $target_player_data = false;  }

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>MegaMan RPG Test 2k11 : Battle</title>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?20110917"></script>
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?20110917" rel="stylesheet" />

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="images/assets/iphone-icon_57x57.png" />
<link rel="apple-touch-startup-image" href="images/assets/iphone-startup_320x460.png" />
<link rel="stylesheet" href="styles/mobile.css" media="only screen and (max-device-width: 480px)" type="text/css" />
<?if($flag_wap):?>
<link type="text/css" href="styles/mobile.css?20110924s" rel="stylesheet" />
<?endif;?>

<script type="text/javascript">
$(document).ready(function(){
  // Preload battle related image files
  <?if(!empty($this_battle_data)):?>
    mmrpg_preload_field_sprites('<?= $this_battle_data['battle_field']['field_background'] ?>');
    mmrpg_preload_field_sprites('<?= $this_battle_data['battle_field']['field_foreground'] ?>');
  <?endif;?>
  <?if(!empty($this_player_data) && !empty($this_player_data['player_robots'])):?>
    <?foreach($this_player_data['player_robots'] AS $robot_token):?>
    mmrpg_preload_robot_sprites('<?=$robot_token?>', 'right');
    <?break;?>
    <?endforeach;?>
  <?endif;?>
  <?if(!empty($target_player_data) && !empty($target_player_data['player_robots'])):?>
    <?foreach($target_player_data['player_robots'] AS $robot_token):?>
    mmrpg_preload_robot_sprites('<?=$robot_token?>', 'left');
    <?break;?>
    <?endforeach;?>
  <?endif;?>
});
</script>

</head>
<body class="battle">
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k11'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
=================================
<?=print_r($_GET, true)?>
</pre>
*/?>
<div id="mmrpg">

  <form id="engine" action="data.php" target="connect" method="post">

    <input type="hidden" name="this_action" value="" />
    <input type="hidden" name="next_action" value="start" />

    <input type="hidden" name="this_battle_id" value="1" />
    <input type="hidden" name="this_battle_token" value="<?=$this_battle_token?>" />

    <input type="hidden" name="this_user_id" value="1" />
    <input type="hidden" name="this_player_id" value="<?= isset($_GET['this_player_id']) ? $_GET['this_player_id'] : 1 ?>" />
    <input type="hidden" name="this_player_token" value="<?= isset($_GET['this_player_token']) ? $_GET['this_player_token'] : 'dr-light' ?>" />
    <input type="hidden" name="this_robot_id" value="auto" />
    <input type="hidden" name="this_robot_token" value="auto" />

    <input type="hidden" name="target_user_id" value="2" />
    <input type="hidden" name="target_player_id" value="<?= isset($_GET['target_player_id']) ? $_GET['target_player_id'] : 2 ?>" />
    <input type="hidden" name="target_player_token" value="<?= isset($_GET['target_player_token']) ? $_GET['target_player_token'] : 'dr-wily' ?>" />
    <input type="hidden" name="target_robot_id" value="auto" />
    <input type="hidden" name="target_robot_token" value="auto" />

  </form>

  <div id="canvas">
    <div class="wrapper">
      <div class="event">
        Ready?
      </div>
    </div>
  </div>

  <div id="console">
    <div class="wrapper">
    </div>
  </div>

  <div id="actions">
    <div id="actions_loading" class="wrapper">
      <img class="loading_graphic" src="images/ajax-loader<?= $flag_wap ? '_mobile' : '' ?>.gif" alt="Loading&hellip;" />
    </div>
    <div id="actions_start" class="wrapper">
      <div class="main_actions">
        <a class="button action_start" type="button" data-action="start">Start!</a>
      </div>
    </div>
    <div id="actions_battle" class="wrapper">

    </div>
    <div id="actions_ability" class="wrapper">

    </div>
    <div id="actions_switch" class="wrapper">

    </div>
    <div id="actions_event" class="wrapper">
      <div class="main_actions">
        <a class="button action_continue" type="button" data-action="continue">Continue</a>
      </div>
    </div>
  </div>

  <iframe id="connect" name="connect" src="about:blank">
  </iframe>

</div>
</body>
</html>