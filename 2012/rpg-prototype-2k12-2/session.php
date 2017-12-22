<?php

// Include the TOP file
require_once('top.php');

// Create or increment the session tester variable
if (isset($_SESSION['RPG2k12-2']['mmrpg_session_tester'])){
  $_SESSION['RPG2k12-2']['mmrpg_session_tester']++;
} else {
  $_SESSION['RPG2k12-2']['mmrpg_session_tester'] = 1;
}

//session_destroy();

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
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k12-2'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
=================================
<?=print_r($_GET, true)?>
</pre>
*/?>
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k12-2'], true)?>
</pre>
</body>
</html>