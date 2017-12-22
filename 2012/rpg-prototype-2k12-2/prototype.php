<?php
// Include the TOP file
require_once('top.php');

// Check if a reset request has been placed
if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'reset'){
  // Reset the game session and reload the page
  mmrpg_reset_game_session($this_save_filepath);
  //header('Location: prototype.php');
  exit('success');
}

// Define the battle options and counter for Dr. Light mode
$light_battles_complete = mmrpg_prototype_battles_complete('dr-light');
$light_battle_options = array();
$light_battle_options['prototype-5_vs-cut-man'] = array('battle_token' => 'prototype-5_vs-cut-man');
$light_battle_options['prototype-5_vs-guts-man'] = array('battle_token' => 'prototype-5_vs-guts-man');
$light_battle_options['prototype-5_vs-ice-man'] = array('battle_token' => 'prototype-5_vs-ice-man');
$light_battle_options['prototype-5_vs-bomb-man'] = array('battle_token' => 'prototype-5_vs-bomb-man');
$light_battle_options['prototype-5_vs-fire-man'] = array('battle_token' => 'prototype-5_vs-fire-man');
$light_battle_options['prototype-5_vs-elec-man'] = array('battle_token' => 'prototype-5_vs-elec-man');
$light_battle_options['prototype-5_vs-time-man'] = array('battle_token' => 'prototype-5_vs-time-man');
$light_battle_options['prototype-5_vs-oil-man'] = array('battle_token' => 'prototype-5_vs-oil-man');
$light_battle_options['battle'] = array('battle_token' => 'battle');

// Define the robot options and counter for Dr. Light mode
$light_robots_unlocked = mmrpg_prototype_robots_unlocked('dr-light');
$light_points_unlocked = mmrpg_prototype_player_points('dr-light');
$light_robot_options = !empty($mmrpg_index['players']['dr-light']['player_robots']) ? $mmrpg_index['players']['dr-light']['player_robots'] : array();
foreach ($light_robot_options AS $key => $info){
  if (!mmrpg_prototype_robot_unlocked('dr-light', $info['robot_token'])){ unset($light_robot_options[$key]); }
}
$light_robot_options = array_values($light_robot_options);

// If the first 20 Dr. Light battles are complete, unlock Dr. Wily!
if ($light_battles_complete >= 20 && !mmrpg_prototype_player_unlocked('dr-wily')){
  mmrpg_game_unlock_player($mmrpg_index['players']['dr-wily'], true);
}

// If Dr. Wily has been unlocked, create his options
if (mmrpg_prototype_player_unlocked('dr-wily')){
  // Define the battle options and counter for Dr. Wily mode
  $wily_battles_complete = mmrpg_prototype_battles_complete('dr-wily');
  $wily_battle_options = array();
  $wily_battle_options['prototype-5_vs-air-man'] = array('battle_token' => 'prototype-5_vs-air-man');
  $wily_battle_options['prototype-5_vs-bubble-man'] = array('battle_token' => 'prototype-5_vs-bubble-man');
  $wily_battle_options['prototype-5_vs-crash-man'] = array('battle_token' => 'prototype-5_vs-crash-man');
  $wily_battle_options['prototype-5_vs-flash-man'] = array('battle_token' => 'prototype-5_vs-flash-man');
  $wily_battle_options['prototype-5_vs-heat-man'] = array('battle_token' => 'prototype-5_vs-heat-man');
  $wily_battle_options['prototype-5_vs-metal-man'] = array('battle_token' => 'prototype-5_vs-metal-man');
  $wily_battle_options['prototype-5_vs-quick-man'] = array('battle_token' => 'prototype-5_vs-quick-man');
  $wily_battle_options['prototype-5_vs-wood-man'] = array('battle_token' => 'prototype-5_vs-wood-man');
  $wily_battle_options['battle'] = array('battle_token' => 'battle');

  // Define the robot options and counter for Dr. Wily mode
  $wily_robots_unlocked = mmrpg_prototype_robots_unlocked('dr-wily');
  $wily_points_unlocked = mmrpg_prototype_player_points('dr-wily');
  $wily_robot_options = !empty($mmrpg_index['players']['dr-wily']['player_robots']) ? $mmrpg_index['players']['dr-wily']['player_robots'] : array();
  foreach ($wily_robot_options AS $key => $info){
    if (!mmrpg_prototype_robot_unlocked('dr-wily', $info['robot_token'])){ unset($wily_robot_options[$key]); }
  }
  $wily_robot_options = array_values($wily_robot_options);
}

// If possible, attempt to save the game to the session
if (!empty($this_save_filepath)){
  // Save the game session
  mmrpg_save_game_session($this_save_filepath);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Mega Man RPG Prototype | Prototype Menu | Last Updated <?= preg_replace('#([0-9]{4})([0-9]{2})([0-9]{2})-([0-9]{2})#', '$1/$2/$3', $MMRPG_CONFIG['CACHE_DATE']) ?></title>
<base href="<?=$MMRPG_CONFIG['ROOTURL']?>" />
<meta name="robots" content="noindex,nofollow" />
<meta name="format-detection" content="telephone=no" />
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<link type="text/css" href="styles/prototype.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<?if($flag_wap):?>
<link type="text/css" href="styles/style-mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<link type="text/css" href="styles/prototype-mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<?endif;?>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
<script type="text/javascript" src="scripts/prototype.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
<script type="text/javascript">
// Define the game WAP and cache flags/values
gameSettings.wapFlag = <?= $flag_wap ? 'true' : 'false' ?>;
gameSettings.cacheTime = '<?=$MMRPG_CONFIG['CACHE_DATE']?>';
// Define any preset menu selections
<?if(!empty($_SESSION['RPG2k12-2']['GAME']['battle_settings']['this_player_token'])
  && mmrpg_prototype_battles_complete($_SESSION['RPG2k12-2']['GAME']['battle_settings']['this_player_token']) < 20):?>
battleOptions['this_player_token'] = '<?=$_SESSION['RPG2k12-2']['GAME']['battle_settings']['this_player_token']?>';
<?endif;?>
</script>
</head>
<body id="mmrpg" class="prototype">

<div id="prototype" class="hidden">

  <div class="banner" title="Mega Man RPG Prototype">
    <div class="sprite background" style="background-image: url(images/menus/menu-banner_this-battle-select.png);">&nbsp;</div>
    <? $temp_prototype_banners = array('air-man', 'cut-man', 'guts-man', 'wood-man', 'ice-man', 'bubble-man'); ?>
    <div class="sprite foreground" style="background-image: url(images/menus/menu-banner_this-battle-select_prototype-4_<?= $temp_prototype_banners[array_rand($temp_prototype_banners)] ?>.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>);">&nbsp;</div>
    <div class="sprite credits" style="background-image: url(images/menus/menu-banner_credits.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>);">Mega Man RPG Prototype | PlutoLighthouse.NET</div>
    <div class="title">Mega Man RPG Prototype</div>
    <div class="points">
      <label class="label">Battle Points</label>
      <span class="amount"><?= preg_replace('#^([0]+)([0-9]+)$#', '<span class="padding">$1</span><span class="value">$2</span>', str_pad((!empty($_SESSION['RPG2k12-2']['GAME']['counters']['battle_points']) ? $_SESSION['RPG2k12-2']['GAME']['counters']['battle_points'] : 0), 13, '0', STR_PAD_LEFT)) ?>
    </div>
    <?/*<a class="debug" onclick="window.location='debug.php';">DEBUG</a>*/?>
    <div class="options">
      <a class="data"><label>data</label></a><span class="pipe">|</span><a class="reset"><label>reset</label></a>
    </div>

  </div>

  <div class="menu select_this_player" data-step="1" data-title="Player Select" data-select="this_player_token">
    <span class="header block_1">Player Select</span>
    <?if(!mmrpg_prototype_player_unlocked('dr-wily')):?>
      <a class="option option_1x4 option_this-light-player-select option_dr-light block_1" data-token="dr-light"><div><label class="has_image"><span class="sprite sprite_40x40 sprite_40x40_base" style="background-image: url(images/players/dr-light/sprite_right_40x40.png); top: -2px; left: 0;">Dr. Light</span><span class="multi"><span class="maintext">Dr. Light</span><span class="subtext"><?= $light_robots_unlocked ?> Robot<?= $light_robots_unlocked != 1 ? 's' : '' ?></span><span class="subtext2"><?= $light_points_unlocked ?> Point<?= $light_points_unlocked != 1 ? 's' : '' ?></span></span><span class="arrow">&#9658;</span></label></div></a>
    <?else:?>
      <a class="option option_1x2 option_this-light-player-select option_dr-light block_1" data-token="dr-light"><div><label class="has_image"><span class="sprite sprite_40x40 sprite_40x40_base" style="background-image: url(images/players/dr-light/sprite_right_40x40.png); top: -2px; left: 0;">Dr. Light</span><span class="multi"><span class="maintext">Dr. Light</span><span class="subtext"><?= $light_robots_unlocked ?> Robot<?= $light_robots_unlocked != 1 ? 's' : '' ?></span><span class="subtext2"><?= $light_points_unlocked ?> Point<?= $light_points_unlocked != 1 ? 's' : '' ?></span></span><span class="arrow">&#9658;</span></label></div></a>
      <a class="option option_1x2 option_this-wily-player-select option_dr-wily block_2" data-token="dr-wily"><div><label class="has_image"><span class="sprite sprite_40x40 sprite_40x40_base" style="background-image: url(images/players/dr-wily/sprite_right_40x40.png); top: -2px; left: 0;">Dr. Wily</span><span class="multi"><span class="maintext">Dr. Wily</span><span class="subtext"><?= $wily_robots_unlocked ?> Robot<?= $wily_robots_unlocked != 1 ? 's' : '' ?></span><span class="subtext2"><?= $wily_points_unlocked ?> Point<?= $wily_points_unlocked != 1 ? 's' : '' ?></span></span><span class="arrow">&#9658;</span></label></div></a>
    <?endif;?>
  </div>

  <div class="menu menu_hide select_this_battle" data-step="2" data-title="Battle Select" data-select="this_battle_token">
    <span class="header block_1">Mission Select</span>

    <div class="option_wrapper" data-condition="this_player_token=dr-light">
      <?

      // Generate and display the markup for these battle options
      $phase_one_markup = mmrpg_prototype_options_markup($light_battle_options, 'dr-light', 'light');

      // If phase one has not been completed, display its markup
      if ($light_battles_complete <= 8){

        // If the first 8 battles are complete, unlock the ninth and recollect markup
        if ($light_battles_complete == 8){
          // Unlock the ninth battle and regenerate markup
          unset($light_battle_options['battle']);
          $light_battle_options['prototype-5_vs-proto-man'] = array('battle_token' => 'prototype-5_vs-proto-man');
          $phase_one_markup = mmrpg_prototype_options_markup($light_battle_options, 'dr-light', 'light');
        }

        echo $phase_one_markup;

      }
      // Otherwise, prepare the options for phase two
      elseif ($light_battles_complete >= 9){

        // Empty the phase one battle options
        $light_battle_options = array();
        // Populate the battle options with round two data
        $light_battle_options['prototype-5_vs-air-man-ii'] = array('battle_token' => 'prototype-5_vs-air-man-ii');
        $light_battle_options['prototype-5_vs-bubble-man-ii'] = array('battle_token' => 'prototype-5_vs-bubble-man-ii');
        $light_battle_options['prototype-5_vs-crash-man-ii'] = array('battle_token' => 'prototype-5_vs-crash-man-ii');
        $light_battle_options['prototype-5_vs-flash-man-ii'] = array('battle_token' => 'prototype-5_vs-flash-man-ii');
        $light_battle_options['prototype-5_vs-heat-man-ii'] = array('battle_token' => 'prototype-5_vs-heat-man-ii');
        $light_battle_options['prototype-5_vs-metal-man-ii'] = array('battle_token' => 'prototype-5_vs-metal-man-ii');
        $light_battle_options['prototype-5_vs-quick-man-ii'] = array('battle_token' => 'prototype-5_vs-quick-man-ii');
        $light_battle_options['prototype-5_vs-wood-man-ii'] = array('battle_token' => 'prototype-5_vs-wood-man-ii');
        $light_battle_options['battle'] = array('battle_token' => 'battle');

        // Generate and display the markup for the phase two battle options
        $phase_two_markup = mmrpg_prototype_options_markup($light_battle_options, 'dr-light', 'wily');

        // Check if the first 8 battles of this phase are done
        if ($light_battles_complete >= 17){
          // Unset the placeholder battle
          unset($light_battle_options['battle']);
          // Define the extra battle options based on specific game conditions
          if (!mmrpg_prototype_battle_complete('dr-light', 'prototype-5_vs-dr-wily-i')){
            $light_battle_options['prototype-5_vs-dr-wily-i'] = array('battle_token' => 'prototype-5_vs-dr-wily-i');
          }
          elseif (!mmrpg_prototype_battle_complete('dr-light', 'prototype-5_vs-dr-wily-ii')){
            $light_battle_options['prototype-5_vs-dr-wily-ii'] = array('battle_token' => 'prototype-5_vs-dr-wily-ii');
          }
          elseif (!mmrpg_prototype_battle_complete('dr-light', 'prototype-5_vs-dr-wily-iii')){
            $light_battle_options['prototype-5_vs-dr-wily-iii'] = array('battle_token' => 'prototype-5_vs-dr-wily-iii');
          }
          else {
            $light_battle_options['prototype-5_vs-met-bonus'] = array('battle_token' => 'prototype-5_vs-met-bonus');
          }
          // Generate and display the markup for the phase two battle options
          $phase_two_markup = mmrpg_prototype_options_markup($light_battle_options, 'dr-light', 'wily');
        }

        // Generate and display the markup for the phase two battle options
        echo $phase_two_markup;

      }

      ?>
    </div>

    <?if(mmrpg_prototype_player_unlocked('dr-wily')):?>

    <div class="option_wrapper" data-condition="this_player_token=dr-wily">
      <?

      // Generate and display the markup for these battle options
      $phase_one_markup = mmrpg_prototype_options_markup($wily_battle_options, 'dr-wily', 'wily');

      // If phase one has not been completed, display its markup
      if ($wily_battles_complete <= 8){

        // If the first 8 battles are complete, unlock the ninth and recollect markup
        if ($wily_battles_complete == 8){
          // Unlock the ninth battle and regenerate markup
          unset($wily_battle_options['battle']);
          $wily_battle_options['prototype-5_vs-mega-man'] = array('battle_token' => 'prototype-5_vs-mega-man');
          $phase_one_markup = mmrpg_prototype_options_markup($wily_battle_options, 'dr-wily', 'wily');
        }

        echo $phase_one_markup;

      }
      // Otherwise, prepare the options for phase two
      elseif ($wily_battles_complete >= 9){

        // Empty the phase one battle options
        $wily_battle_options = array();
        // Populate the battle options with round two data
        $wily_battle_options['prototype-5_vs-cut-man-ii'] = array('battle_token' => 'prototype-5_vs-cut-man-ii');
        $wily_battle_options['prototype-5_vs-guts-man-ii'] = array('battle_token' => 'prototype-5_vs-guts-man-ii');
        $wily_battle_options['prototype-5_vs-ice-man-ii'] = array('battle_token' => 'prototype-5_vs-ice-man-ii');
        $wily_battle_options['prototype-5_vs-bomb-man-ii'] = array('battle_token' => 'prototype-5_vs-bomb-man-ii');
        $wily_battle_options['prototype-5_vs-fire-man-ii'] = array('battle_token' => 'prototype-5_vs-fire-man-ii');
        $wily_battle_options['prototype-5_vs-elec-man-ii'] = array('battle_token' => 'prototype-5_vs-elec-man-ii');
        $wily_battle_options['prototype-5_vs-time-man-ii'] = array('battle_token' => 'prototype-5_vs-time-man-ii');
        $wily_battle_options['prototype-5_vs-oil-man-ii'] = array('battle_token' => 'prototype-5_vs-oil-man-ii');
        $wily_battle_options['battle'] = array('battle_token' => 'battle');

        // Generate and display the markup for the phase two battle options
        $phase_two_markup = mmrpg_prototype_options_markup($wily_battle_options, 'dr-wily', 'light');

        // Check if the first 8 battles of this phase are done
        if ($wily_battles_complete >= 17){
          // Unset the placeholder battle
          unset($wily_battle_options['battle']);
          // Define the extra battle options based on specific game conditions
          if (!mmrpg_prototype_battle_complete('dr-wily', 'prototype-5_vs-dr-light-i')){
            $wily_battle_options['prototype-5_vs-dr-light-i'] = array('battle_token' => 'prototype-5_vs-dr-light-i');
          }
          elseif (!mmrpg_prototype_battle_complete('dr-wily', 'prototype-5_vs-dr-light-ii')){
            $wily_battle_options['prototype-5_vs-dr-light-ii'] = array('battle_token' => 'prototype-5_vs-dr-light-ii');
          }
          elseif (!mmrpg_prototype_battle_complete('dr-wily', 'prototype-5_vs-dr-light-iii')){
            $wily_battle_options['prototype-5_vs-dr-light-iii'] = array('battle_token' => 'prototype-5_vs-dr-light-iii');
          }
          else {
            $wily_battle_options['prototype-5_vs-met-bonus'] = array('battle_token' => 'prototype-5_vs-met-bonus');
          }
          // Generate and display the markup for the phase two battle options
          $phase_two_markup = mmrpg_prototype_options_markup($wily_battle_options, 'dr-wily', 'light');
        }

        // Generate and display the markup for the phase two battle options
        echo $phase_two_markup;

      }

      ?>
    </div>

    <?endif;?>

    <a class="option option_back block_1" data-back="1">&#9668; Back</a>
  </div>

  <div class="menu menu_hide select_this_player_robots" data-step="3" data-limit="" data-title="Robot Select" data-select="this_player_robots">
    <span class="header block_1">Robot Select</span>

    <div class="option_wrapper" data-condition="this_player_token=dr-light">
      <?
      // Loop through and display the available robot options for Dr. Light
      foreach ($light_robot_options AS $key => $info){
        $info = array_replace($mmrpg_index['robots'][$info['robot_token']], $info);
        $this_option_class = 'option option_this-light-robot-select option_'.($light_robots_unlocked == 1 ? '1x4' : ($light_robots_unlocked <= 2 ? '1x2' : '1x1')).' option_'.$info['robot_token'].' block_'.($key + 1);
        $this_option_style = '';
        $this_option_token = $info['robot_id'].'_'.$info['robot_token'];
        $this_robot_points = mmrpg_prototype_robot_points('dr-light', $info['robot_token']);
        $this_robot_abilities = mmrpg_prototype_abilities_unlocked('dr-light', $info['robot_token']);
        $this_option_label = '<span class="sprite sprite_40x40 sprite_40x40_base" style="background-image: url(images/robots/'.$info['robot_token'].'/sprite_right_40x40.png); top: -2px; left: 0;">'.$info['robot_name'].'</span><span class="multi"><span class="maintext">'.$info['robot_name'].'</span><span class="subtext">Level '.(floor($this_robot_points / 1000) + 1).'</span><span class="subtext2">'.$this_robot_points.' '.($this_robot_points == 1 ? 'Point' : 'Points').'</span></span><span class="arrow">&#9658;</span>';
        echo '<a class="'.$this_option_class.'" data-child="true" data-token="'.$this_option_token.'" style="'.$this_option_style.'"><div><label class="has_image">'.$this_option_label.'</label></div></a>'."\r\n";
      }
      // Loop through and display any option padding cells
      if ($light_robots_unlocked >= 3){
        $light_robots_padding = $light_robots_unlocked % 4;
        if (!empty($light_robots_padding)){
          $counter = ($light_robots_unlocked % 4) + 1;
          for ($counter; $counter <= 4; $counter++){
            $this_option_class = 'option option_this-light-robot-select option_1x1 option_disabled block_'.$counter;
            $this_option_style = '';
            echo '<a class="'.$this_option_class.'" style="'.$this_option_style.'"><div><label>&nbsp;</label></div></a>'."\r\n";
          }
        }
      }
      ?>
      <a class="option option_1x4 option_this-team-select option_disabled block_9" data-parent="true" data-token="" style=""><div><label class="has_image" style="width: 80px; padding-left: 0;"><span class="single"><span class="count">&nbsp;</span><span class="arrow">&nbsp;</span></span></label></div></a>
    </div>

    <div class="option_wrapper" data-condition="this_player_token=dr-wily">
      <?
      // Loop through and display the available robot options for Dr. Wily
      foreach ($wily_robot_options AS $key => $info){
        $info = array_replace($mmrpg_index['robots'][$info['robot_token']], $info);
        $this_option_class = 'option option_this-wily-robot-select option_'.($wily_robots_unlocked == 1 ? '1x4' : ($wily_robots_unlocked <= 2 ? '1x2' : '1x1')).' option_'.$info['robot_token'].' block_'.($key + 1);
        $this_option_style = '';
        $this_option_token = $info['robot_id'].'_'.$info['robot_token'];
        $this_robot_points = mmrpg_prototype_robot_points('dr-wily', $info['robot_token']);
        $this_robot_abilities = mmrpg_prototype_abilities_unlocked('dr-wily', $info['robot_token']);
        $this_option_label = '<span class="sprite sprite_40x40 sprite_40x40_base" style="background-image: url(images/robots/'.$info['robot_token'].'/sprite_right_40x40.png); top: -2px; left: 0;">'.$info['robot_name'].'</span><span class="multi"><span class="maintext">'.$info['robot_name'].'</span><span class="subtext">Level '.(floor($this_robot_points / 1000) + 1).'</span><span class="subtext2">'.$this_robot_points.' '.($this_robot_points == 1 ? 'Point' : 'Points').'</span></span><span class="arrow">&#9658;</span>';
        echo '<a class="'.$this_option_class.'" data-child="true" data-token="'.$this_option_token.'" style="'.$this_option_style.'"><div><label class="has_image">'.$this_option_label.'</label></div></a>'."\r\n";
      }
     // Loop through and display any option padding cells
      if ($wily_robots_unlocked >= 3){
        $wily_robots_padding = $wily_robots_unlocked % 4;
        if (!empty($wily_robots_padding)){
          $counter = ($wily_robots_unlocked % 4) + 1;
          for ($counter; $counter <= 4; $counter++){
            $this_option_class = 'option  option_this-wily-robot-select option_1x1 option_disabled block_'.$counter;
            $this_option_style = '';
            echo '<a class="'.$this_option_class.'" style="'.$this_option_style.'"><div><label>&nbsp;</label></div></a>'."\r\n";
          }
        }
      }
      ?>
      <a class="option option_1x4 option_this-team-select option_disabled block_9" data-parent="true" data-token="" style=""><div><label class="has_image" style="width: 80px; padding-left: 0;"><span class="single"><span class="count">&nbsp;</span><span class="arrow">&nbsp;</span></span></label></div></a>
    </div>

    <a class="option option_back block_1" data-back="2">&#9668; Back</a>
  </div>

</div>

</body>
</html>