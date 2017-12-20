<?php
// Include the TOP file
require_once('top.php');

// Automatically unset the session variable
// on index page load (for testing)
session_unset();

// Collect the battle tokens from the URL
$this_battle_token = isset($_GET['this_battle_token']) ? $_GET['this_battle_token'] : 'prototype-1';
$this_field_id = isset($_GET['this_field_id']) ? $_GET['this_field_id'] : 1;
$this_field_token = isset($_GET['this_field_token']) ? $_GET['this_field_token'] : 'field';
$this_player_id = isset($_GET['this_player_id']) ? $_GET['this_player_id'] : 1;
$this_player_token = isset($_GET['this_player_token']) ? $_GET['this_player_token'] : 'dr-light';
$target_player_id = isset($_GET['target_player_id']) ? $_GET['target_player_id'] : 2;
$target_player_token = isset($_GET['target_player_token']) ? $_GET['target_player_token'] : 'dr-wily';

// Collect the battle index data if available
if (isset($mmrpg_index['battles'][$this_battle_token])){ $this_battle_data = &$mmrpg_index['battles'][$this_battle_token];  }
else { $this_battle_data = false;  }
if (isset($mmrpg_index['fields'][$this_field_token])){ $this_field_data = &$mmrpg_index['fields'][$this_field_token];  }
else { $this_field_data = false;  }
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
<meta name="robots" content="noindex,nofollow" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<link rel="stylesheet" href="styles/mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" media="only screen and (max-device-width: 768px)" type="text/css" />
<?if($flag_wap):?><link type="text/css" href="styles/mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" /><?endif;?>
<script type="text/javascript">
gameWAP = <?= $flag_wap ? 'true' : 'false' ?>;
gameCache = '<?=$MMRPG_CONFIG['CACHE_DATE']?>';
$(document).ready(function(){
  // Preload battle related image files
  <?if(!empty($this_battle_data)):?>
    mmrpg_preload_field_sprites('<?= $this_field_data['field_background'] ?>');
    mmrpg_preload_field_sprites('<?= $this_field_data['field_foreground'] ?>');
  <?endif;?>
  <?if(!empty($this_player_data) && !empty($this_player_data['player_robots'])):?>
    <?foreach($this_player_data['player_robots'] AS $this_robotinfo):?>
    mmrpg_preload_robot_sprites('<?=$this_robotinfo['robot_token']?>', 'right');
    <?break;?>
    <?endforeach;?>
  <?endif;?>
  <?if(!empty($target_player_data) && !empty($target_player_data['player_robots'])):?>
    <?foreach($target_player_data['player_robots'] AS $this_robotinfo):?>
    mmrpg_preload_robot_sprites('<?=$this_robotinfo['robot_token']?>', 'left');
    <?break;?>
    <?endforeach;?>
  <?endif;?>
});
</script>
</head>
<body class="battle">
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k12'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
=================================
<?=print_r($_GET, true)?>
</pre>
*/?>
<div id="mmrpg">

  <form id="engine" action="data.php<?= $flag_wap ? '?wap=true' : '' ?>" target="connect" method="post">

    <input type="hidden" name="this_action" value="" />
    <input type="hidden" name="next_action" value="start" />

    <input type="hidden" name="this_battle_id" value="1" />
    <input type="hidden" name="this_battle_token" value="<?=$this_battle_token?>" />

    <input type="hidden" name="this_field_id" value="<?=$this_field_id?>" />
    <input type="hidden" name="this_field_token" value="<?=$this_field_token?>" />

    <input type="hidden" name="this_user_id" value="1" />
    <input type="hidden" name="this_player_id" value="<?=$this_player_id?>" />
    <input type="hidden" name="this_player_token" value="<?=$this_player_token?>" />
    <input type="hidden" name="this_robot_id" value="auto" />
    <input type="hidden" name="this_robot_token" value="auto" />

    <input type="hidden" name="target_user_id" value="2" />
    <input type="hidden" name="target_player_id" value="<?=$target_player_id?>" />
    <input type="hidden" name="target_player_token" value="<?=$target_player_token?>" />
    <input type="hidden" name="target_robot_id" value="auto" />
    <input type="hidden" name="target_robot_token" value="auto" />

  </form>

  <div id="canvas">
    <div class="wrapper">
      <div class="event">
        <?
        // If field data was provided, preload the background/foreground
        if (!empty($this_field_data)){
          echo '<div class="background" style="opacity: 0.5; background-image: url(images/fields/'.$this_field_data['field_background'].'/battle-field_background_base.png?'.$MMRPG_CONFIG['CACHE_DATE'].');">&nbsp;</div>';
          echo '<div class="foreground" style="background-image: url(images/fields/'.$this_field_data['field_foreground'].'/battle-field_foreground_base.png?'.$MMRPG_CONFIG['CACHE_DATE'].');">&nbsp;</div>';
        }
        // Otherwise, simply print the ready message
        else {
          echo 'Ready?';
        }
        ?>
      </div>
    </div>
  </div>

  <div id="console">
    <div class="wrapper">
    </div>
  </div>

  <div id="actions">
    <div id="actions_loading" class="wrapper">
      <div class="main_actions">
        <a class="button action_loading button_disabled" type="button">Loading...</a>
      </div>
    </div>
    <div id="actions_start" class="wrapper">
      <div class="main_actions">
        <a class="button action_start" type="button" data-action="start">Start!</a>
      </div>
    </div>
    <div id="actions_battle" class="wrapper"></div>
    <div id="actions_ability" class="wrapper"></div>
    <div id="actions_switch" class="wrapper"></div>
    <div id="actions_scan" class="wrapper"></div>
    <div id="actions_option" class="wrapper"></div>
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