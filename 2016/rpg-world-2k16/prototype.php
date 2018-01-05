<?php
// Include the TOP file
require_once('_top.php');
/*
// MAINTENANCE
if (!in_array($_SERVER['REMOTE_ADDR'], array('99.226.253.166', '127.0.0.1', '99.226.238.61'))){
  die('<div style="margin: 0; padding: 10px 25%; background-color: rgb(122, 0, 0); color: #FFFFFF; text-align: left; border-bottom: 1px solid #090909;">
    ATTENTION!<br /> Mega Man RPG World is currently being updated.  Please stand by until further notice.  Several parts of the website are being taken offline during this process and any progress made during will likely be lost, so please hold tight before trying to log in again.  I apologize for the inconvenience.  Thank you and look forward to lots of new stuff!<br /> - Adrian
    </div>');
}
*/

// Require the robot database for... stuff?
//require_once('includes/database.php');

// Collect the game's session token
$session_token = rpg_game::session_token();

// Automatically empty all temporary battle variables
$_SESSION['RPG2k16']['BATTLES'] = array();
$_SESSION['RPG2k16']['FIELDS'] = array();
$_SESSION['RPG2k16']['PLAYERS'] = array();
$_SESSION['RPG2k16']['ROBOTS'] = array();
$_SESSION['RPG2k16']['ABILITIES'] = array();
$_SESSION['RPG2k16']['PROTOTYPE_TEMP'] = array();
unset($_SESSION['RPG2k16']['GAME']['debug_mode']);

// Collect the prototype start link if provided
$prototype_start_link = !empty($_GET['start']) ? $_GET['start'] : 'home';

// Define the arrays for holding potential prototype messages
$prototype_window_event_canvas = array();
$prototype_window_event_messages = array();

// Check if a reset request has been placed
if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'reset'){

  // Reset the game session and reload the page
  rpg_game::reset_session();

  // Update the appropriate session variables
  $_SESSION['RPG2k16']['GAME']['USER'] = $this_user;

  // Load the save file into memory and overwrite the session
  rpg_game::save_session();
  exit('success');

}
// Check if a reset request has been placed
if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'reset-missions' && !empty($_REQUEST['player'])){

  // Reset the appropriate session variables
  if (!empty($mmrpg_index['players'][$_REQUEST['player']])){
    $temp_session_key = $_REQUEST['player'].'_target-robot-omega_prototype';
    $_SESSION['RPG2k16']['GAME']['values']['battle_complete'][$_REQUEST['player']] = array();
    $_SESSION['RPG2k16']['GAME']['values']['battle_failure'][$_REQUEST['player']] = array();
    $_SESSION['RPG2k16']['GAME']['values'][$temp_session_key] = array();
  }

  // Load the save file into memory and overwrite the session
  rpg_game::save_session();
  exit('success');

}
// Check if a exit request has been placed
if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'exit'){

  // Auto-generate the user and file info based on their IP
  $this_user = array();
  $this_user['userid'] = MMRPG_SETTINGS_GUEST_ID;
  $this_user['username'] = 'demo';
  $this_user['username_clean'] = 'demo';
  $this_user['imagepath'] = '';
  $this_user['colourtoken'] = '';
  $this_user['gender'] = 'male';
  $this_user['password'] = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'demo';
  $this_user['password_encoded'] = md5($this_user['password']);

  // Update the session with these demo variables
  $_SESSION['RPG2k16']['GAME']['DEMO'] = 1;
  $_SESSION['RPG2k16']['GAME']['USER'] = $this_user;
  $_SESSION['RPG2k16']['GAME']['counters']['battle_points'] = 0;

  // Reset the game session and reload the page
  rpg_game::reset_session();

  // Exit on success
  exit('success');

}

// Cache the currently online players
if (!isset($_SESSION['RPG2k16']['LEADERBOARD']['online_timestamp'])
  || (time() - $_SESSION['RPG2k16']['LEADERBOARD']['online_timestamp']) > 1){ // 600sec = 10min
  $_SESSION['RPG2k16']['LEADERBOARD']['online_players'] = rpg_prototype::leaderboard_online();
  $_SESSION['RPG2k16']['LEADERBOARD']['online_timestamp'] = time();
}


// Require the prototype data file
require_once('includes/prototype.php');


/*
 * PASSWORD PROCESSING
 */

// Collect the game flags for easier password processing
$temp_flags = !empty($_SESSION['RPG2k16']['GAME']['flags']) ? $_SESSION['RPG2k16']['GAME']['flags'] : array();

// Include the prototype awards file to check stuff
require('prototype/awards.php');

// If possible, attempt to save the game to the session
if (empty($_SESSION['RPG2k16'][$session_token]['USER']['userid'])
  && $_SESSION['RPG2k16'][$session_token]['USER']['userid'] != MMRPG_SETTINGS_GUEST_ID){
  rpg_game::save_session();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Mega Man RPG World | Prototype Menu | Last Updated <?= preg_replace('#([0-9]{4})([0-9]{2})([0-9]{2})-([0-9]{2})#', '$1/$2/$3', MMRPG_CONFIG_CACHE_DATE) ?></title>
<base href="<?= MMRPG_CONFIG_ROOTURL?>" />
<meta name="robots" content="noindex,nofollow" />
<meta name="format-detection" content="telephone=no" />
<link rel="shortcut icon" type="image/x-icon" href="images/assets/favicon<?= !MMRPG_CONFIG_IS_LIVE ? '-local' : '' ?>.ico">
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/master.css?<?= MMRPG_CONFIG_CACHE_DATE?>" rel="stylesheet" />
<link type="text/css" href="styles/prototype.css?<?= MMRPG_CONFIG_CACHE_DATE?>" rel="stylesheet" />
<?if($flag_wap):?>
<link type="text/css" href="styles/mobile.css?<?= MMRPG_CONFIG_CACHE_DATE?>" rel="stylesheet" />
<link type="text/css" href="styles/prototype_mobile.css?<?= MMRPG_CONFIG_CACHE_DATE?>" rel="stylesheet" />
<?endif;?>
</head>
<body id="mmrpg" class="prototype">

<div id="prototype" class="hidden">

  <div class="banner">
    <div class="sprite background banner_background" style="background-image: url(images/assets/menu-banner_this-battle-select.png);">&nbsp;</div>
    <div class="sprite foreground banner_foreground banner_dynamic" style="background-image: url(images/assets/prototype-banners_title-screen_01.gif?<?= MMRPG_CONFIG_CACHE_DATE?>); background-position: center -10px;">&nbsp;</div>
    <div class="sprite credits banner_credits" style="background-image: url(images/assets/menu-banner_credits2.png?<?= MMRPG_CONFIG_CACHE_DATE?>);">Mega Man RPG World | PlutoLighthouse.NET</div>
    <div class="sprite overlay overlay_hidden banner_overlay">&nbsp;</div>
    <div class="title">Mega Man RPG World</div>

      <?php
      // Define tooltips for the game options
      // Define the menu options array to be populated
      $this_menu_tooltips = array();
      $this_menu_tooltips['leaderboard'] = '&laquo; Battle Points Leaderboard &raquo; &lt;br /&gt;Live leaderboards rank all players by their total Battle Point scores from highest to lowest. Keep an eye on your Battle Points by checking here at the top-right of the main menu and try to work your way up to the first page!';
      $this_menu_tooltips['save'] = '&laquo; '.(!empty($_SESSION['RPG2k16']['GAME']['USER']['displayname']) ? $_SESSION['RPG2k16']['GAME']['USER']['displayname'] : $_SESSION['RPG2k16']['GAME']['USER']['username']).' Game Profile &raquo; &lt;br /&gt;Review and configure save file options including display name, theme and colour settings, robot avatars, missions resets, and more.  Please note that this game uses auto-save functionality and manual file updates are not required.';
      $this_menu_tooltips['database'] = '&laquo; Robot Database &raquo; &lt;br /&gt;A comprehensive list of all robots encountered in battle so far including their name, details, and records. Scanning robots adds their stats and weaknesses to the database and unlocking them adds a complete list of their level-up abilities.';
      $this_menu_tooltips['starforce'] = '&laquo; Starforce &raquo; &lt;br /&gt;A detailed list of all Field and Fusion Stars collected so far as well as a percentage-based breakdown of your current Starforce and its elemental affinities. Starforce increases the amount of damage inflicted by all elemental abilities of the same type!';
      $this_menu_tooltips['help'] = '&laquo; Battle Tips &raquo; &lt;br /&gt;A bullet-point list covering both basic and advanced battle tips to help you progress through the game and level up faster.';
      $this_menu_tooltips['demo'] = '&laquo; Demo Menu &raquo; &lt;br /&gt;Select your mission from the demo menu and prepare for battle! Please note that progress cannot be saved in this mode.';
      $this_menu_tooltips['home'] = '&laquo; Home Menu &raquo; &lt;br /&gt;Select your mission from the home menu and prepare for battle! Complete missions in fewer turns to earn more battle points!';
      $this_menu_tooltips['reset'] = '&laquo; Reset Game &raquo; &lt;br /&gt;Reset the demo mode back to the beginning and restart your adventure over from the first level.';
      $this_menu_tooltips['load'] = '&laquo; Load Game &raquo; &lt;br /&gt;Load an existing game file into memory and pick up where you left off during your last save.';
      //$this_menu_tooltips['new'] = '&laquo; New Game &raquo; &lt;br /&gt;Create a new game file with a username and password to save progress and access the full version of the game.';
      $this_menu_tooltips['new'] = '&laquo; New Game &raquo; &lt;br /&gt;New registrations are no longer being accepted on this build of the Mega Man RPG! Sorry!';
      $this_menu_tooltips['exit'] = '&laquo; Exit Game &raquo; &lt;br /&gt;Exit your save game and unload it from memory to return to the demo screen.';
      $this_menu_tooltips['robots'] = '&laquo; Robot Editor &raquo; &lt;br /&gt;Review detailed stats about your battle robots, equip them with new abilities, and transfer them to other players in your save file.';
      $this_menu_tooltips['players'] = '&laquo; Player Editor &raquo; &lt;br /&gt;Review detailed stats about your player characters and reconfigure chapter two battle fields to generate new field and fusion stars.';
      $this_menu_tooltips['abilities'] = '&laquo; Ability Viewer &raquo; &lt;br /&gt;...';
      $this_menu_tooltips['items'] = '&laquo; Item Inventory &raquo; &lt;br /&gt;...';
      $this_menu_tooltips['shop'] = '&laquo; Item Shop &raquo; &lt;br /&gt;Trade in your extra inventory for zenny in the shop and then put your earnings towards new items, new abilities, and new battle fields.';
      $temp_prototype_complete = rpg_prototype::campaign_complete();
      $temp_data_index = 0;
      ?>

    <div class="points field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>">
      <a class="wrapper link link_leaderboard" data-step="leaderboard" data-index="99" data-source="frames/leaderboard.php" data-music="misc/leader-board" data-tooltip="<?= $this_menu_tooltips['leaderboard'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>">
        <label class="label">Battle Points</label>
        <span class="amount">
          <?php /*= preg_replace('#^([0]+)([0-9]+)$#', '<span class="padding">$1</span><span class="value">$2</span>', str_pad((!empty($_SESSION['RPG2k16']['GAME']['counters']['battle_points']) ? $_SESSION['RPG2k16']['GAME']['counters']['battle_points'] : 0), 13, '0', STR_PAD_LEFT)) */ ?>
          <?= number_format($_SESSION['RPG2k16']['GAME']['counters']['battle_points'], 0, '.', ',') ?>
          <?php if(rpg_game::is_user() && !empty($this_boardinfo['board_rank'])): ?>
            <span class="pipe">|</span>
            <span class="place"><?= rpg_website::number_suffix($this_boardinfo['board_rank']) ?></span>
          <?php endif; ?>
        </span>
      </a>
    </div>
    <div class="zenny field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>">
      <div class="wrapper">
        <span class="amount">
          <?= number_format($_SESSION['RPG2k16']['GAME']['counters']['battle_zenny'], 0, '.', ',') ?> z
        </span>
      </div>
    </div>

    <div class="options options_userinfo field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>">

      <?php
      // Define the avatar class and path variables
      $temp_avatar_path = !empty($_SESSION['RPG2k16']['GAME']['USER']['imagepath']) ? $_SESSION['RPG2k16']['GAME']['USER']['imagepath'] : 'robots/mega-man/40';
      $temp_colour_token = !empty($_SESSION['RPG2k16']['GAME']['USER']['colourtoken']) ? $_SESSION['RPG2k16']['GAME']['USER']['colourtoken'] : '';
      list($temp_avatar_kind, $temp_avatar_token, $temp_avatar_size) = explode('/', $temp_avatar_path);
      $temp_sprite_class = 'sprite sprite_'.$temp_avatar_size.'x'.$temp_avatar_size.' sprite_'.$temp_avatar_size.'x'.$temp_avatar_size.'_00';
      $temp_sprite_offset = $temp_avatar_size == 80 ? 'margin-left: -20px; margin-top: -40px; ' : '';
      $temp_sprite_path = 'images/sprites/'.$temp_avatar_kind.'/'.$temp_avatar_token.'/sprite_left_'.$temp_avatar_size.'x'.$temp_avatar_size.'.png?'.MMRPG_CONFIG_CACHE_DATE;
      $temp_shadow_path = 'images/sprites/'.$temp_avatar_kind.'_shadows/'.preg_replace('/_(.*?)$/i', '', $temp_avatar_token).'/sprite_left_'.$temp_avatar_size.'x'.$temp_avatar_size.'.png?'.MMRPG_CONFIG_CACHE_DATE;
      $temp_avatar_markup = '<span class="sprite sprite_40x40" style="bottom: 6px; right: 4px; z-index: 100; "><span class="'.$temp_sprite_class.'" style="background-image: url('.$temp_sprite_path.'); '.$temp_sprite_offset.'"></span></span>';
      $temp_avatar_markup .= '<span class="sprite sprite_40x40" style="bottom: 5px; right: 3px; z-index: 99; "><span class="'.$temp_sprite_class.'" style="background-image: url('.$temp_shadow_path.'); '.$temp_sprite_offset.'"></span></span>';
      ?>

      <?php if(rpg_game::is_user()): ?>
        <a class="wrapper link link_save" data-step="file_save" data-index="98" data-source="frames/file.php?action=save" data-music="misc/file-menu" data-tooltip="<?= $this_menu_tooltips['save'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>">
          <span class="info info_userinfo">
            <span class="mode">
              <?php
              // Print the prototype complete awards if they exist
              echo rpg_prototype::campaign_complete('dr-light') ? '<span style="position: relative; bottom: 1px;">&hearts;</span>' : '';
              echo rpg_prototype::campaign_complete('dr-wily') ? '<span style="position: relative; bottom: 1px;">&clubs;</span>' : '';
              echo rpg_prototype::campaign_complete('dr-cossack') ? '<span style="position: relative; bottom: 1px;">&diams;</span>' : '';
              // Print the player's rank based on leaderboard position
              if ($this_boardinfo['board_rank'] == 1){ echo ' Champion Rank'; }
              elseif ($this_boardinfo['board_rank'] <= 3){ echo ' Elite Rank'; }
              elseif ($this_boardinfo['board_rank'] <= 50){ echo ' Master Rank'; }
              elseif ($this_boardinfo['board_rank'] <= 100){ echo ' Golden Rank'; }
              elseif ($this_boardinfo['board_rank'] <= 200){ echo ' Silver Rank'; }
              elseif ($this_boardinfo['board_rank'] <= 400){ echo ' Bronze Rank'; }
              else { echo 'Normal Rank'; }
              ?>
            </span>
            <span class="name"><?= !empty($_SESSION['RPG2k16']['GAME']['USER']['displayname']) ? $_SESSION['RPG2k16']['GAME']['USER']['displayname'] : $_SESSION['RPG2k16']['GAME']['USER']['username'] ?></span>
          </span>
          <?= $temp_avatar_markup ?>
        </a>
      <?php else: ?>
        <div class="wrapper">
          <span class="info info_username info_demo">
            <span class="mode">Welcome to the</span>
            <label title="Demo Mode : Progess cannot be saved!">Demo Mode</label>
          </span>
          <?= $temp_avatar_markup ?>
        </div>
      <?php endif; ?>
    </div>

    <?php
    // Check if the prototype has been completed before continuing
    $temp_prototype_complete = rpg_prototype::campaign_complete();
    ?>
    <div class="options options_fullmenu field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>">
      <div class="wrapper">
      <?php
      // If we're in the DEMO MODE, define the available options and their attributes
      if (rpg_game::is_demo()){
        ?>
        <a class="link link_home link_active" data-step="2" data-index="<?= $temp_data_index++ ?>" data-music="misc/stage-select-dr-light" data-tooltip="<?= $this_menu_tooltips['demo'] ?>"><label>demo</label></a> <span class="pipe">|</span>
        <a class="link link_data" data-step="database" data-index="<?= $temp_data_index++ ?>" data-source="frames/database.php" data-music="misc/data-base" data-tooltip="<?= $this_menu_tooltips['database'] ?>"><label>database</label></a> <span class="pipe">|</span>
        <a class="link link_load" data-step="file_load" data-index="<?= $temp_data_index++ ?>" data-source="frames/file.php?action=load" data-music="misc/file-menu" data-tooltip="<?= $this_menu_tooltips['load'] ?>"><label>load</label></a> <span class="pipe">|</span>
        <? /*  <a class="link link_new" href="file/new/" target="_blank"data-tooltip="<?= $this_menu_tooltips['new'] ?>"><label>new</label></a> */  ?>
        <span class="link link_new" data-tooltip="<?= $this_menu_tooltips['new'] ?>"><label>new</label></span>
        <span class="pipe">|</span>
        <a class="link link_reset" data-index="<?= $temp_data_index++ ?>" data-tooltip="<?= $this_menu_tooltips['reset'] ?>"><label>reset</label></a>
        <?php
      }
      // Otherwise, if we're in NORMAL MODE, we process the main menu differently
      else {
        ?>
        <a class="link link_home link_active" data-step="<?= $unlock_count_players == 1 ? 2 : 1 ?>" data-index="<?= $temp_data_index++ ?>" data-music="misc/<?= $unlock_count_players == 1 ? 'stage-select-dr-light' : 'player-select' ?>" data-tooltip="<?= $this_menu_tooltips['home'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>"><label>home</label></a> <span class="pipe">|</span>
        <?php if(rpg_game::screws_unlocked() !== false && rpg_prototype::battles_complete() >= 3){ ?>
          <a class="link link_shop" data-step="shop" data-index="<?= $temp_data_index++ ?>" data-source="frames/shop.php" data-music="misc/shop-music" data-tooltip="<?= $this_menu_tooltips['shop'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>"><label>shop</label></a> <span class="pipe">|</span>
        <?php } ?>
        <?php if (rpg_prototype::event_complete('completed-chapter_dr-light_one')){ ?>
          <a class="link link_robots" data-step="edit_robots" data-index="<?= $temp_data_index++ ?>" data-source="frames/robots.php?action=robots" data-music="misc/robot-editor" data-tooltip="<?= $this_menu_tooltips['robots'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>"><label>robots</label></a> <span class="pipe">|</span>
        <?php } ?>
        <?if (rpg_prototype::event_complete('completed-chapter_dr-wily_one')){ ?>
          <a class="link link_players" data-step="edit_players" data-index="<?= $temp_data_index++ ?>" data-source="frames/players.php?action=players" data-music="misc/player-editor" data-tooltip="<?= $this_menu_tooltips['players'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>"><label>players</label></a> <span class="pipe">|</span>
        <?php } ?>
        <?php if (false && rpg_game::items_unlocked() >= 1){ ?>
          <a class="link link_items" data-step="items" data-index="<?= $temp_data_index++ ?>" data-source="frames/items.php" data-music="misc/item-viewer" data-tooltip="<?= $this_menu_tooltips['items'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>"><label>items</label></a> <span class="pipe">|</span>
        <?php } ?>
        <?php if (false && rpg_game::abilities_unlocked() >= 3){ ?>
          <a class="link link_abilities" data-step="abilities" data-index="<?= $temp_data_index++ ?>" data-source="frames/abilities.php" data-music="misc/ability-viewer" data-tooltip="<?= $this_menu_tooltips['abilities'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>"><label>abilities</label></a> <span class="pipe">|</span>
        <?php } ?>
        <?php if(rpg_prototype::event_complete('completed-chapter_dr-light_three')
          && rpg_prototype::event_complete('completed-chapter_dr-wily_three')
          && rpg_prototype::event_complete('completed-chapter_dr-cossack_three')){ /* rpg_game::stars_unlocked() >= 1 */ ?>
          <a class="link link_stars" data-step="starforce" data-index="<?= $temp_data_index++ ?>" data-source="frames/starforce.php" data-music="misc/star-force" data-tooltip="<?= $this_menu_tooltips['starforce'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>"><label>starforce</label></a> <span class="pipe">|</span>
        <?php } ?>
        <?php if(rpg_game::database_unlocked() >= 2){ ?>
          <a class="link link_data" data-step="database" data-index="<?= $temp_data_index++ ?>" data-source="frames/database.php" data-music="misc/data-base" data-tooltip="<?= $this_menu_tooltips['database'] ?>" data-tooltip-type="field_type field_type_<?= MMRPG_SETTINGS_CURRENT_FIELDTYPE ?>"><label>database</label></a> <span class="pipe">|</span>
        <?php } ?>
        <a class="link link_exit" data-index="<?= $temp_data_index++ ?>" data-tooltip="<?= $this_menu_tooltips['exit'] ?>"><label>exit</label></a>
        <?php
      }
      ?>
      </div>
    </div>

  </div>

  <div class="menu select_this_player" data-step="1" data-title="Player Select (<?= rpg_game::is_demo() || $unlock_count_players == 1 ? '1 Player' : $unlock_count_players.' Players' ?>)" data-select="this_player_token">
    <span class="header block_1">
      <span class="count">Player Select (<?= rpg_game::is_demo() || $unlock_count_players == 1 ? '1 Player' : $unlock_count_players.' Players' ?>)</span>
      <?/*<span class="reload">&#8634;</span>*/?>
    </span>
    <?php
    // Require the prototype players display file
    require_once(MMRPG_CONFIG_ROOTDIR.'prototype/players.php');
    ?>
  </div>

  <div class="menu menu_hide select_this_battle" data-step="2" data-title="Battle Select" data-select="this_battle_token">
    <span class="header block_1">
      <span class="count"><?= rpg_game::is_demo() ? 'Mega Man RPG World' : 'Mission Select' ?></span>
    </span>
    <?php

    // Require the prototype missions display file
    require_once(MMRPG_CONFIG_ROOTDIR.'prototype/missions.php');

    // If we're NOT in demo mode, maybe add a back button
    if (rpg_game::is_user()){
      // Print out the back button for going back to player select
      if ($unlock_count_players > 1){
        echo '<a class="option option_back block_1" data-back="1">&#9668; Back</a>'."\n";
      }
    }

    ?>
  </div>

  <?php
    /*
     * DEMO ROBOT SELECT
     */
    if (rpg_game::is_demo()){

      // Only show robot select if the player has more than two robots
      if (rpg_game::robots_unlocked('dr-light') > 3){

        // Print out the opening tags for the robot select container
        echo '<div class="menu menu_hide select_this_player_robots" data-step="3" data-limit="" data-title="Robot Select" data-select="this_player_robots">'."\n";
        echo '<span class="header block_1"><span class="count">Robot Select</span></span>'."\n";

        // Require the prototype robots display file
        require_once(MMRPG_CONFIG_ROOTDIR.'prototype/robots.php');

        // Print out the back button for going back to player select
        echo '<a class="option option_back block_1" data-back="2">&#9668; Back</a>'."\n";

        // Print out the closing tags for the robot select container
        echo '</div>'."\n";

      }

    }
    /*
     * NORMAL ROBOT SELECT
     */
    else {

      // Print out the opening tags for the robot select container
      echo '<div class="menu menu_hide select_this_player_robots" data-step="3" data-limit="" data-title="Robot Select" data-select="this_player_robots">'."\n";
      echo '<span class="header block_1"><span class="count">Robot Select</span></span>'."\n";

      // Require the prototype robots display file
      require_once(MMRPG_CONFIG_ROOTDIR.'prototype/robots.php');

      // Print out the back button for going back to player select
      echo '<a class="option option_back block_1" data-back="2">&#9668; Back</a>'."\n";

      // Print out the closing tags for the robot select container
      echo '</div>'."\n";

    }
  ?>

  <div class="menu menu_hide menu_file_new" data-step="file_new" data-source="frames/file.php?action=new"></div>

  <div class="menu menu_hide menu_file_load" data-step="file_load" data-source="frames/file.php?action=load"></div>

  <div class="menu menu_hide menu_file_save" data-step="file_save" data-source="frames/file.php?action=save"></div>

  <div class="menu menu_hide menu_shop" data-step="shop" data-source="frames/shop.php"></div>

  <div class="menu menu_hide menu_edit_robots" data-step="edit_robots" data-source="frames/robots.php?action=robots"></div>

  <div class="menu menu_hide menu_edit_players" data-step="edit_players" data-source="frames/players.php?action=players"></div>

  <div class="menu menu_hide menu_leaderboard" data-step="leaderboard" data-source="frames/leaderboard.php"></div>

  <div class="menu menu_hide menu_database" data-step="database" data-source="frames/database.php"></div>

  <div class="menu menu_hide menu_starforce" data-step="starforce" data-source="frames/starforce.php"></div>

  <div class="menu menu_hide menu_help" data-step="help" data-source="frames/help.php"></div>

  <div class="menu menu_hide menu_loading" data-step="loading" style="min-height: 600px;">
    <div class="option_wrapper option_wrapper_noscroll" style="color: white; font-weight: bold; line-height: 150px; letter-spacing: 4px; opacity: 0.75; margin-right: 0; background-color: rgba(0, 0, 0, 0.10); border-radius: 0.5em; -moz-border-radius: 0.5em; -webkit-border-radius: 0.5em; overflow: hidden; min-height: 600px; ">
      <div style="line-height: 40px; margin-top: 50px;">
        <span class="sprite sprite_40x40 sprite_40x40_left_00 " style="display: inline-block; position: static; background-image: url(images/assets/robot-loader_mega-man.gif); ">&nbsp;</span><br />
        <span class="label" style="display: inline-block;">loading</span>
      </div>
    </div>
  </div>

</div>

<div id="falloff" class="falloff_bottom">&nbsp;</div>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/master.js?<?= MMRPG_CONFIG_CACHE_DATE?>"></script>
<script type="text/javascript" src="scripts/prototype.js?<?= MMRPG_CONFIG_CACHE_DATE?>"></script>
<script type="text/javascript">
// Define the game WAP and cache flags/values
gameSettings.passwordUnlocked = 0;
gameSettings.pointsUnlocked = <?= !empty($_SESSION['RPG2k16']['GAME']['counters']['battle_points']) ? $_SESSION['RPG2k16']['GAME']['counters']['battle_points'] : 0 ?>;
gameSettings.fadeIn = true;
gameSettings.demo = <?= $_SESSION['RPG2k16']['GAME']['DEMO'] ?>;
gameSettings.wapFlag = <?= $flag_wap ? 'true' : 'false' ?>;
gameSettings.cacheTime = '<?= MMRPG_CONFIG_CACHE_DATE?>';
gameSettings.startLink = '<?= $prototype_start_link ?>';
gameSettings.windowEventsCanvas = [];
gameSettings.windowEventsMessages = [];
gameSettings.totalPlayerOptions = <?= $unlock_count_players ?>;
gameSettings.prototypeBannerKey = 0;
gameSettings.prototypeBanners = ['prototype-banners_title-screen_01.gif'];
// Define any preset menu selections
battleOptions['this_player_id'] = <?= $this_userid ?>;
<?php if(rpg_game::is_demo()): ?>
  battleOptions['this_player_token'] = 'dr-light';
  <?php if(rpg_game::robots_unlocked('dr-light') == 3): ?>
    battleOptions['this_player_robots'] = '103_mega-man,104_bass,105_proto-man';
  <?endif;?>
<?php else: ?>
  <?php if(!empty($_SESSION['RPG2k16']['GAME']['battle_settings']['this_player_token'])): ?>
    battleOptions['this_player_token'] = '<?= $_SESSION['RPG2k16']['GAME']['battle_settings']['this_player_token']?>';
  <?php elseif($unlock_count_players < 2): ?>
    battleOptions['this_player_token'] = 'dr-light';
  <?php endif; ?>
<?php endif; ?>
// Create the document ready events
$(document).ready(function(){

  <?php if($prototype_start_link == 'home' && empty($_SESSION['RPG2k16']['GAME']['battle_settings']['this_player_token'])): ?>
    // Start playing the title screen music
    parent.mmrpg_music_load('misc/player-select', true, false);
  <?php elseif($prototype_start_link != 'home'): ?>
    <?php if(!empty($_SESSION['RPG2k16']['GAME']['battle_settings']['this_player_token'])): ?>
      // Start playing the appropriate stage select music
      parent.mmrpg_music_load('misc/stage-select-<?= $_SESSION['RPG2k16']['GAME']['battle_settings']['this_player_token'] ?>', true, false);
    <?php else: ?>
      // Start playing the title screen music
      parent.mmrpg_music_load('misc/player-select', true, false);
    <?php endif; ?>
  <?php endif; ?>

  <?php
  // If there were any prototype window events created, display them
  if (!empty($_SESSION['RPG2k16']['GAME']['EVENTS'])){
    foreach ($_SESSION['RPG2k16']['GAME']['EVENTS'] AS $temp_key => $temp_event){
      $temp_canvas_markup = str_replace('"', '\"', $temp_event['canvas_markup']);
      $temp_messages_markup =  str_replace('"', '\"', $temp_event['console_markup']);
      echo 'gameSettings.windowEventsCanvas.push("'.$temp_canvas_markup.'");'."\n";
      echo 'gameSettings.windowEventsMessages.push("'.$temp_messages_markup.'");'."\n";
    }
  }
  ?>

});
</script>
<?php
// Require the remote bottom in case we're in viewer mode
require(MMRPG_CONFIG_ROOTDIR.'/data/analytics.php');
?>
</body>
</html>
<?php
// If there were any events in the session, automatically add remove them from the session
if (!empty($_SESSION['RPG2k16']['GAME']['EVENTS'])){ $_SESSION['RPG2k16']['GAME']['EVENTS'] = array(); }
// Unset the database variable
unset($db);
?>