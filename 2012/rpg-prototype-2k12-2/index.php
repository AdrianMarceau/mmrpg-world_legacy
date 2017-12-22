<?php
// Include the TOP file
require_once('top.php');

// If a reset was intentionally called
if (!empty($_GET['reset'])){
  // Reset the game session
  mmrpg_reset_game_session($this_save_filepath);
}
// Check if the session has not been created or the cache date has changed
elseif (!isset($_SESSION['RPG2k12-2']['GAME']['CACHE_DATE'])
  || $_SESSION['RPG2k12-2']['GAME']['CACHE_DATE'] != $MMRPG_CONFIG['CACHE_DATE']){

  // Ensure there is a save file to load
  if (!empty($this_save_filepath) && file_exists($this_save_filepath)){
    // Load the save file into memory and overwrite the session
    mmrpg_load_game_session($this_save_filepath);
  }
  // Otherwise, simply reset the game
  else {
    // Reset the game session
    mmrpg_reset_game_session($this_save_filepath);
  }

}

// Automatically empty all temporary battle variables
//$_SESSION['RPG2k12-2']['GAME'] = array();
$_SESSION['RPG2k12-2']['BATTLES'] = array();
$_SESSION['RPG2k12-2']['FIELDS'] = array();
$_SESSION['RPG2k12-2']['PLAYERS'] = array();
$_SESSION['RPG2k12-2']['ROBOTS'] = array();
$_SESSION['RPG2k12-2']['ABILITIES'] = array();

//// If possible, attempt to save the game to the session
//if (!empty($this_save_filepath)){
//  // Save the game session
//  mmrpg_save_game_session($this_save_filepath);
//}

?>
<!DOCTYPE html>
<html not-manifest="manifest.php?<?=$MMRPG_CONFIG['CACHE_DATE']?>">
<head>
<meta charset="UTF-8" />
<title>RPG Prototype 2k12-2 | MMRPG-World.NET (Legacy) | Last Updated <?= preg_replace('#([0-9]{4})([0-9]{2})([0-9]{2})-([0-9]{2})#', '$1/$2/$3', $MMRPG_CONFIG['CACHE_DATE']) ?></title>
<meta name="keywords" content="megaman,mega man,protoman,proto man,rpg,prototype,dr.light,dr.wily,battle,browser,ipad" />
<meta name="description" content="Battle through more than sixteen robot masters in classic RPG style with either Dr. Light and Mega Man or Dr. Wily and Proto Man!" />
<meta name="robots" content="noindex,nofollow" />
<meta name="format-detection" content="telephone=no" />
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<?if($flag_wap):?>
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, width=768, height=1004">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" sizes="72x72" href="images/assets/ipad-icon_72x72.png" />
<link rel="apple-touch-startup-image" href="images/assets/ipad-startup_768x1004_portrait.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)" />
<link rel="apple-touch-startup-image" href="images/assets/ipad-startup_748x1024_landscape.png?<?=$MMRPG_CONFIG['CACHE_DATE']?>" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)" />
<link type="text/css" href="styles/style-mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<?endif;?>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
<script type="text/javascript">
// Define the key client variables
gameSettings.wapFlag = <?= $flag_wap ? 'true' : 'false' ?>;
gameSettings.cacheTime = '<?=$MMRPG_CONFIG['CACHE_DATE']?>';
</script>
<?if($flag_wap):?>
<script type="text/javascript">
// When the document is ready for event binding
$(document).ready(function(){
  // Check if we're running the game in mobile mode
  if (gameWAP){
    // Let the user know about the full-screen option for mobile browsers
    if (('standalone' in window.navigator) && !window.navigator.standalone){
      //alert('launched from full-screen ready browser, but not in full screen...');
      alert('Use the "Add to Home Screen" option for fullscreen view! :)');
      } else if (('standalone' in window.navigator) && window.navigator.standalone){
      //alert('launched from full-screen ready browser, and in full screen!');
      } else {
      //alert('launched from a regular old browser...');
      }
  }
  // DEBUG : Alert the user of the cache date
  //alert('gameCache : '+gameCache);
});
//function updateMobileCache(event){ window.applicationCache.swapCache(); }
</script>
<?endif;?>
</head>
<body class="index">
<? include('legacy_header.php'); ?>
<div id="window">
  <?if(!$flag_wap):?>
  <iframe name="battle" src="prototype.php?wap=false" width="768" height="1004" frameborder="1" scrolling="no"></iframe>
  <?else:?>
  <iframe name="battle" src="prototype.php?wap=true" width="768" height="748" frameborder="0" scrolling="no"></iframe>
  <?endif;?>
</div>
<?if(!$flag_wap):?>
<div id="credits">
<a href="http://plus.google.com/u/0/113336469005774860291/" target="_blank" rel="me">Adrian Marceau</a> |
<a href="http://plutolighthouse.net/" target="_blank" rel="author">PlutoLighthouse.NET</a>
</div>
<?endif;?>
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k12-2'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
</pre>
*/?>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-28757226-1']);
_gaq.push(['_trackPageview']);
(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
</body>
</html>