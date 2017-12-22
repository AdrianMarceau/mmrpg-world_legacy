<?php
// Include the TOP file
require_once('top.php');

//$GLOBALS['DEBUG']['checkpoint_line'] = 'battle.php : line 5';

// Automatically unset the session variable
// on index page load (for testing)
//session_unset();

//// Automatically empty all temporary battle variables
//$_SESSION['RPG2k12-2']['BATTLES'] = array();
//$_SESSION['RPG2k12-2']['FIELDS'] = array();
//$_SESSION['RPG2k12-2']['PLAYERS'] = array();
//$_SESSION['RPG2k12-2']['ROBOTS'] = array();
//$_SESSION['RPG2k12-2']['ABILITIES'] = array();

// Collect the battle tokens from the URL
$this_battle_id = isset($_GET['this_battle_id']) ? $_GET['this_battle_id'] : 0;
$this_battle_token = isset($_GET['this_battle_token']) ? $_GET['this_battle_token'] : '';
$this_field_id = isset($_GET['this_field_id']) ? $_GET['this_field_id'] : 0;
$this_field_token = isset($_GET['this_field_token']) ? $_GET['this_field_token'] : '';
$this_player_id = isset($_GET['this_player_id']) ? $_GET['this_player_id'] : 0;
$this_player_token = isset($_GET['this_player_token']) ? $_GET['this_player_token'] : '';
$this_player_robots = isset($_GET['this_player_robots']) ? $_GET['this_player_robots'] : '';
$target_player_id = isset($_GET['target_player_id']) ? $_GET['target_player_id'] : 0;
$target_player_token = isset($_GET['target_player_token']) ? $_GET['target_player_token'] : '';

// Collect the battle index data if available
if (!empty($this_battle_token) && isset($mmrpg_index['battles'][$this_battle_token])){
  $this_battle_data = $mmrpg_index['battles'][$this_battle_token];
  if (empty($this_battle_data['battle_id'])){
    $this_battle_id = !empty($this_battle_id) ? $this_battle_id : 1;
    $this_battle_data['battle_id'] = $this_battle_id;
  }
}
else {
  $this_battle_id = 0;
  $this_battle_token = '';
  $this_battle_data = array();
}

// Collect the field index data if available
if (!empty($this_field_token) && isset($mmrpg_index['fields'][$this_field_token])){
  $this_field_data = $mmrpg_index['fields'][$this_field_token];
  if (empty($this_field_data['field_id'])){
    $this_field_id = !empty($this_field_id) ? $this_field_id : 1;
    $this_field_data['field_id'] = $this_field_id;
  }
}
elseif (!empty($this_battle_data['battle_field_base']['field_token']) && isset($mmrpg_index['fields'][$this_battle_data['battle_field_base']['field_token']])){
  $this_field_data = array_merge($mmrpg_index['fields'][$this_battle_data['battle_field_base']['field_token']], $this_battle_data['battle_field_base']);
  if (empty($this_field_data['field_id'])){
    $this_field_id = !empty($this_field_id) ? $this_field_id : 1;
    $this_field_data['field_id'] = $this_field_id;
  }
}
else {
  $this_field_id = 0;
  $this_field_token = '';
  $this_field_data = array();
}

// Collect this player's index data if available
if (!empty($this_player_token) && isset($mmrpg_index['players'][$this_player_token])){
  $this_player_data = $mmrpg_index['players'][$this_player_token];
  if (empty($this_player_data['user_id'])){
    $this_player_data['user_id'] = 1;
  }
  if (empty($this_player_data['player_id'])){
    $this_player_id = !empty($this_player_id) ? $this_player_id : 1;
    $this_player_data['player_id'] = $this_player_id;
  }
  if (!empty($this_player_robots)){
    $allowed_robots = strstr($this_player_robots, ',') ? explode(',', $this_player_robots) : array($this_player_robots);
    foreach ($this_player_data['player_robots'] AS $key => $data){
      if (!in_array($data['robot_token'], $allowed_robots)){ unset($this_player_data['player_robots'][$key]); }
    }
    $this_player_data['player_robots'] = array_values($this_player_data['player_robots']);
    //die('<pre>'.print_r($this_player_data['player_robots'], true).'</pre>');
  }
}
else {
  $this_player_data = false;
}

// Collect the target player's index data if available
if (!empty($target_player_token) && isset($mmrpg_index['players'][$target_player_token])){
  $target_player_data = $mmrpg_index['players'][$target_player_token];
  if (empty($target_player_data['user_id'])){
    $target_player_data['user_id'] = 2;
  }
  if (empty($target_player_data['player_id'])){
    $target_player_id = !empty($target_player_id) ? $target_player_id : 2;
    $target_player_data['player_id'] = $target_player_id;
  }
}
elseif (!empty($this_battle_data['battle_target_player']['player_token']) && isset($mmrpg_index['players'][$this_battle_data['battle_target_player']['player_token']])){
  $target_player_data = array_merge($mmrpg_index['players'][$this_battle_data['battle_target_player']['player_token']], $this_battle_data['battle_target_player']);
  if (empty($target_player_data['user_id'])){
    $target_player_data['user_id'] = 2;
  }
  if (empty($target_player_data['player_id'])){
    $target_player_id = !empty($target_player_id) ? $target_player_id : 2;
    $target_player_data['player_id'] = $target_player_id;
  }
}
else {
  $target_player_id = 0;
  $target_player_token = '';
  $target_player_data = array();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Mega Man RPG Prototype | Battle Engine | Last Updated <?= preg_replace('#([0-9]{4})([0-9]{2})([0-9]{2})-([0-9]{2})#', '$1/$2/$3', $MMRPG_CONFIG['CACHE_DATE']) ?></title>
<base href="<?=$MMRPG_CONFIG['ROOTURL']?>" />
<meta name="robots" content="noindex,nofollow" />
<meta name="format-detection" content="telephone=no" />
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<?if($flag_wap):?>
<link type="text/css" href="styles/style-mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<?endif;?>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
<script type="text/javascript">
gameSettings.wapFlag = <?= $flag_wap ? 'true' : 'false' ?>;
gameSettings.eventTimeout = <?= $flag_wap ? 700 : 900 ?>;
gameSettings.cacheTime = '<?=$MMRPG_CONFIG['CACHE_DATE']?>';
<?
// Update the event timeout setting if set
$event_timeout = !empty($_SESSION['RPG2k12-2']['GAME']['battle_settings']['eventTimeout']) ? $_SESSION['RPG2k12-2']['GAME']['battle_settings']['eventTimeout'] : 0;
if (!empty($event_timeout)){ echo 'gameSettings.eventTimeout ='.$event_timeout.";\n"; }
?>
$(document).ready(function(){
  // Preload battle related image files
  mmrpg_preload_assets();
  <?if(!empty($this_battle_data)):?>
    mmrpg_preload_field_sprites('<?= $this_field_data['field_background'] ?>');
    mmrpg_preload_field_sprites('<?= $this_field_data['field_foreground'] ?>');
  <?endif;?>
  <?if(!empty($this_player_data) && !empty($this_player_data['player_robots'])):?>
    <?foreach($this_player_data['player_robots'] AS $this_key => $this_robotinfo):?>
      <?if($this_key == 0):?>mmrpg_preload_robot_sprites('<?=$this_robotinfo['robot_token']?>', 'right', 80);<?endif;?>
      mmrpg_preload_robot_sprites('<?=$this_robotinfo['robot_token']?>', 'right', 40);
    <?break;?>
    <?endforeach;?>
  <?endif;?>
  <?if(!empty($target_player_data) && !empty($target_player_data['player_robots'])):?>
    <?foreach($target_player_data['player_robots'] AS $this_key => $this_robotinfo):?>
      <?if($this_key == 0):?>mmrpg_preload_robot_sprites('<?=$this_robotinfo['robot_token']?>', 'left', 80);<?endif;?>
      mmrpg_preload_robot_sprites('<?=$this_robotinfo['robot_token']?>', 'left', 40);
    <?break;?>
    <?endforeach;?>
  <?endif;?>
  // Fade in the battle screen slowly
  var thisContext = $('#battle');
  thisContext.css({opacity:0}).removeClass('hidden').animate({opacity:1.0}, 800, 'swing', function(){
    // Automatically trigger a click on the start button
    //$('#actions_start a[data-action=start]', thisContext).trigger('click');
    // Automatically send the start action to the data api
    return mmrpg_action_trigger('start', false);
    });
});
</script>
</head>
<body id="mmrpg" class="battle">
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k12-2'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
=================================
<?=print_r($_GET, true)?>
</pre>
*/?>
<div id="battle" class="hidden">

  <form id="engine" action="data.php<?= $flag_wap ? '?wap=true' : '' ?>" target="connect" method="post">

    <input type="hidden" name="this_action" value="" />
    <input type="hidden" name="next_action" value="loading" />

    <input type="hidden" name="this_battle_id" value="<?=$this_battle_data['battle_id']?>" />
    <input type="hidden" name="this_battle_token" value="<?=$this_battle_data['battle_token']?>" />

    <input type="hidden" name="this_field_id" value="<?=$this_field_data['field_id']?>" />
    <input type="hidden" name="this_field_token" value="<?=$this_field_data['field_token']?>" />

    <input type="hidden" name="this_user_id" value="<?=$this_player_data['user_id']?>" />
    <input type="hidden" name="this_player_id" value="<?=$this_player_data['player_id']?>" />
    <input type="hidden" name="this_player_token" value="<?=$this_player_data['player_token']?>" />
    <input type="hidden" name="this_player_robots" value="<?=$this_player_robots?>" />
    <input type="hidden" name="this_robot_id" value="auto" />
    <input type="hidden" name="this_robot_token" value="auto" />

    <input type="hidden" name="target_user_id" value="<?=$target_player_data['user_id']?>" />
    <input type="hidden" name="target_player_id" value="<?=$target_player_data['player_id']?>" />
    <input type="hidden" name="target_player_token" value="<?=$target_player_data['player_token']?>" />
    <input type="hidden" name="target_robot_id" value="auto" />
    <input type="hidden" name="target_robot_token" value="auto" />

  </form>

  <div id="canvas">
    <div class="wrapper">
      <div class="event sticky" style="z-index: 1;">
        <?
        // If field data was provided, preload the background/foreground
        if (!empty($this_field_data)){
          $background_animate = array();
          foreach ($this_field_data['field_background_frame'] AS $frame){ $background_animate[] = str_pad($frame, 2, '0', STR_PAD_LEFT);  }
          $background_data_animate = implode(',', $background_animate);
          echo '<div class="background background_'.$background_animate[0].'" data-frame="'.$background_animate[0].'" data-animate="'.$background_data_animate.'" style="background-image: url(images/fields/'.$this_field_data['field_background'].'/battle-field_background_base.png?'.$MMRPG_CONFIG['CACHE_DATE'].');">&nbsp;</div>';
          $foreground_animate = array();
          foreach ($this_field_data['field_foreground_frame'] AS $frame){ $foreground_animate[] = str_pad($frame, 2, '0', STR_PAD_LEFT);  }
          $foreground_data_animate = implode(',', $foreground_animate);
          echo '<div class="foreground foreground_'.$foreground_animate[0].'" data-frame="'.$foreground_animate['0'].'" data-animate="'.$foreground_data_animate.'" style="background-image: url(images/fields/'.$this_field_data['field_foreground'].'/battle-field_foreground_base.png?'.$MMRPG_CONFIG['CACHE_DATE'].');">&nbsp;</div>';
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
        <a class="button action_loading button_disabled" type="button"><label>Loading...</label></a>
      </div>
    </div>
    <?/*
    <div id="actions_start" class="wrapper">
      <div class="main_actions">
        <a class="button action_start" type="button" data-action="start"><label>Start!</label></a>
      </div>
    </div>
    */?>
    <div id="actions_battle" class="wrapper"></div>
    <div id="actions_ability" class="wrapper"></div>
    <div id="actions_switch" class="wrapper"></div>
    <div id="actions_scan" class="wrapper"></div>
    <div id="actions_option" class="wrapper"></div>
    <div id="actions_settings" class="wrapper">
      <div class="main_actions">
        <a class="button action_setting block_1" type="button" data-panel="settings_eventTimeout"><label><span class="multi">Game<br />Speed</span></label></a>
        <a class="button action_setting button_disabled block_2" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_3" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_4" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_5" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_6" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_7" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_8" type="button">&nbsp;</a>
      </div>
      <div class="sub_actions"><a class="button action_back" type="button" data-panel="option"><label>Back</label></a></div>
    </div>
    <div id="actions_settings_autoScan" class="wrapper">
      <div class="main_actions">
        <a class="button action_setting block_1" type="button" data-action="settings_autoScan_true"><label><span class="multi">Auto Scan<br />On</span></label></a>
        <a class="button action_setting block_2" type="button" data-action="settings_autoScan_false"><label><span class="multi">Auto Scan<br />Off</span></label></a>
        <a class="button action_setting button_disabled block_3" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_4" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_5" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_6" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_7" type="button">&nbsp;</a>
        <a class="button action_setting button_disabled block_8" type="button">&nbsp;</a>
      </div>
      <div class="sub_actions"><a class="button action_back" type="button" data-panel="option"><label>Back</label></a></div>
    </div>
    <div id="actions_settings_eventTimeout" class="wrapper">
      <div class="main_actions">
        <a class="button action_setting block_1" type="button" data-action="settings_eventTimeout_1600"><label><span class="multi">Super&nbsp;Slow<br />(1f/1600ms)</span></label></a>
        <a class="button action_setting block_2" type="button" data-action="settings_eventTimeout_1250"><label><span class="multi">Medium&nbsp;Slow<br />(1f/1250ms)</span></label></a>
        <a class="button action_setting block_3" type="button" data-action="settings_eventTimeout_1000"><label><span class="multi">Normal&nbsp;Slow<br />(1f/1000ms)</span></label></a>
        <a class="button action_setting block_4" type="button" data-action="settings_eventTimeout_900"><label><span class="multi">Normal<br />(1f/900ms)</span></label></a>
        <a class="button action_setting block_5" type="button" data-action="settings_eventTimeout_800"><label><span class="multi">Normal&nbsp;Fast<br />(1f/800ms)</span></label></a>
        <a class="button action_setting block_6" type="button" data-action="settings_eventTimeout_700"><label><span class="multi">Medium&nbsp;Fast<br />(1f/700ms)</span></label></a>
        <a class="button action_setting block_7" type="button" data-action="settings_eventTimeout_600"><label><span class="multi">Super&nbsp;Fast<br />(1f/600ms)</span></label></a>
        <a class="button action_setting block_8" type="button" data-action="settings_eventTimeout_500"><label><span class="multi">Ultra&nbsp;Fast<br />(1f/500ms)</span></label></a>
        <?/*
        <a class="button action_setting block_1" type="button" data-action="settings_eventTimeout_1600"><label><span class="multi">Option A<br />(1f/1600ms)</span></label></a>
        <a class="button action_setting block_2" type="button" data-action="settings_eventTimeout_1250"><label><span class="multi">Option B<br />(1f/1250ms)</span></label></a>
        <a class="button action_setting block_3" type="button" data-action="settings_eventTimeout_1000"><label><span class="multi">Option C<br />(1f/1000ms)</span></label></a>
        <a class="button action_setting block_4" type="button" data-action="settings_eventTimeout_900"><label><span class="multi">Option D<br />(1f/900ms)</span></label></a>
        <a class="button action_setting block_5" type="button" data-action="settings_eventTimeout_800"><label><span class="multi">Option E<br />(1f/800ms)</span></label></a>
        <a class="button action_setting block_6" type="button" data-action="settings_eventTimeout_700"><label><span class="multi">Option F<br />(1f/700ms)</span></label></a>
        <a class="button action_setting block_7" type="button" data-action="settings_eventTimeout_600"><label><span class="multi">Option G<br />(1f/600ms)</span></label></a>
        <a class="button action_setting block_8" type="button" data-action="settings_eventTimeout_500"><label><span class="multi">Option H<br />(1f/500ms)</span></label></a>
        */?>
      </div>
      <div class="sub_actions"><a class="button action_back" type="button" data-panel="option"><label>Back</label></a></div>
    </div>
    <div id="actions_event" class="wrapper">
      <div class="main_actions">
        <a class="button action_continue" type="button" data-action="continue"><label>Continue</label></a>
      </div>
    </div>
  </div>

  <iframe id="connect" name="connect" src="about:blank">
  </iframe>

</div>
</body>
</html>