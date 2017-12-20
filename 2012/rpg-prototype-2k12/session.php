<?php
// Include the TOP file
require_once('top.php');
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
</head>
<body class="debug">
<?/*
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
<?=print_r($_SESSION['RPG2k12'], true)?>
=================================
<?=print_r($mmrpg_index['robots'], true)?>
=================================
<?=print_r($_GET, true)?>
</pre>
*/?>
<pre style="width: 500px; margin: 10px auto; background-color: #FAFAFA; color: #464646; text-align: left; padding: 20px;">
$_SESSION['RPG2k12'] = <?=print_r($_SESSION['RPG2k12'], true)?>
</pre>
</body>
</html>