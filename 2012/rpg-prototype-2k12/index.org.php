<?php

// Include the TOP file
require_once('top.php');

?>
<!DOCTYPE html>
<html not-manifest="manifest.php?<?=$MMRPG_CONFIG['CACHE_DATE']?>">
<head>
<meta charset="UTF-8" />
<title>MegaMan RPG Test 2k11 (Last Updated 2012/01/09)</title>
<meta name="robots" content="noindex,nofollow" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?<?=$MMRPG_CONFIG['CACHE_DATE']?>"></script>
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, width=768, height=1004">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="images/assets/iphone-icon_57x57.png" />
<link rel="apple-touch-startup-image" href="images/assets/ipad-startup_768x1004.png" />
<?/*<link rel="stylesheet" href="styles/mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" media="only screen and (max-device-width: 768px)" type="text/css" />*/?>
<?if($flag_wap):?>
<link type="text/css" href="styles/mobile.css?<?=$MMRPG_CONFIG['CACHE_DATE']?>" rel="stylesheet" />
<script type="text/javascript">
// Define the key client variables
gameWAP = <?= $flag_wap ? 'true' : 'false' ?>;
gameCache = '<?=$MMRPG_CONFIG['CACHE_DATE']?>';
// When the document is ready for event binding
$(document).ready(function(){

  // Check if we're running the game in mobile mode
  if (gameWAP){

    // Let the user know about the full-screen option for mobile browsers
    if (('standalone' in window.navigator) && !window.navigator.standalone){
      alert('Please use "Add to Home Screen" option for best view! :)');
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
<script type="text/javascript">
</script>
</head>
<body class="index">
<div id="window">
  <?if(!$flag_wap):?>
  <iframe name="battle" src="prototype.php?wap=false" width="768" height="1004" frameborder="1" scrolling="no"></iframe>
  <?else:?>
  <iframe name="battle" src="prototype.php?wap=true" width="768" height="684" frameborder="0" scrolling="no"></iframe>
  <?endif;?>
</div>
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k12'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
</pre>
*/?>
</body>
</html>