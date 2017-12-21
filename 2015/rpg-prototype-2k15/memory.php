<?php

// Include the TOP file
define('MMRPG_INDEX_SESSION', true);
require_once('top.php');
if (!MMRPG_CONFIG_ADMIN_MODE){ die('Forbidden'); }


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Mega Man RPG Test 2k11 : Session Debug</title>
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/script.js?20110917"></script>
<link type="text/css" href="styles/reset.css" rel="stylesheet" />
<link type="text/css" href="styles/style.css?20110917" rel="stylesheet" />
</head>
<body class="debug">
<a style="font-size:11px;line-height:11px;" onclick="window.location='prototype.php';">Back to Prototype Menu</a>
<pre style="width: auto; margin: 10px 50px; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?
// TEMP DEBUG
if (true){
  echo 'memory_limit() = '.ini_get('memory_limit')."\n";
  echo 'memory_get_usage() = '.round(((memory_get_usage() / 1024) / 1024), 2).'M'."\n";
  echo 'memory_get_peak_usage() = '.round((memory_get_peak_usage() / 1024) / 1024, 2).'M'."\n";
  //echo 'memory_get_peak_usage_peak() = '.memory_get_peak_usage_peak().'<br />';
}
?>
</pre>
</body>
</html>