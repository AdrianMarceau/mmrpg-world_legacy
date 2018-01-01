<?php

// Include the TOP file
require_once('top.php');

?>
<!DOCTYPE html>
<html manifest="manifest.php?20110925">
<head>
<meta charset="UTF-8" />
<title>MegaMan RPG Test 2k11 : Index</title>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?20110917"></script>
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?20110924s" rel="stylesheet" />

<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link rel="apple-touch-icon" href="images/assets/iphone-icon_57x57.png" />
<link rel="apple-touch-startup-image" href="images/assets/iphone-startup_320x460.png" />
<link rel="stylesheet" href="styles/mobile.css?20110924s" media="only screen and (max-device-width: 480px)" type="text/css" />
<?if($flag_wap):?>
<link type="text/css" href="styles/mobile.css?20110924s" rel="stylesheet" />
<script type="text/javascript">
function updateMobileCache(event){ window.applicationCache.swapCache(); }
window.applicationCache.addEventListener('updateready', updateMobileCache, false);
</script>
<?endif;?>
</head>
<body class="index">

<div id="window">
  <iframe name="battle" src="about:blank" width="502" height="569" frameborder="1" scrolling="no">
  </iframe>
</div>

<div id="debug">
  <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-1&this_player_token=dr-light&target_player_token=dr-wily">Light vs Wily<br />Ice Field</a>
  <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-1&this_player_token=dr-wily&target_player_token=dr-light">Wily vs Light<br />Ice Field</a>
  <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-2&this_player_token=dr-light&target_player_token=dr-wily">Light vs Wily<br />Guts Field</a>
  <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-2&this_player_token=dr-wily&target_player_token=dr-light">Wily vs Light<br />Guts Field</a>


  <a class="battle" target="battle" href="battle.php?<?= $flag_wap ? 'wap=true&' : '' ?>this_battle_token=prototype-3&this_player_token=debug-one&target_player_token=debug-two">TEST</a>
</div>

<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k11'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
</pre>
*/?>

</body>
</html>