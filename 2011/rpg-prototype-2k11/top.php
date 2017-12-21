<?php

/*
 * GLOBAL INCLUDES
 */

// Include mandatory config files
require_once('data/config.php');

// Include mandatory class files
require_once('data/classes/class.battle.php');
require_once('data/classes/class.player.php');
require_once('data/classes/class.robot.php');
require_once('data/classes/class.ability.php');


/*
 * LIBRARY INDEXES
 */

// Start the session
if (session_id() == ''){ session_start(); }
if (!isset($_SESSION['RPG2k11'])){ $_SESSION['RPG2k11'] = array(); }

// Include mandatory library files
$mmrpg_index = array();
require_once('data/battles/index.php');
require_once('data/players/index.php');
require_once('data/robots/index.php');
require_once('data/abilities/index.php');
require_once('data/types/index.php');
//echo('<pre>$mmrpg_index = '.print_r($mmrpg_index, true).'</pre>');
//exit();


/*
 * SESSION VARIABLES
 */

// Create mandatory session variables if they do not exist
$_SESSION['RPG2k11']['BATTLES'] = isset($_SESSION['RPG2k11']['BATTLES']) ? $_SESSION['RPG2k11']['BATTLES'] : array();
$_SESSION['RPG2k11']['PLAYERS'] = isset($_SESSION['RPG2k11']['PLAYERS']) ? $_SESSION['RPG2k11']['PLAYERS'] : array();
$_SESSION['RPG2k11']['ROBOTS'] = isset($_SESSION['RPG2k11']['ROBOTS']) ? $_SESSION['RPG2k11']['ROBOTS'] : array();
$_SESSION['RPG2k11']['ABILITIES'] = isset($_SESSION['RPG2k11']['ABILITIES']) ? $_SESSION['RPG2k11']['ABILITIES'] : array();

/*
 * BROWSER FLAGS
 */

// Define a function for checking if using iPhone
function is_browser_iphone($user_agent = NULL){
  if(!isset($user_agent)){ $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''; }
  return (strpos($user_agent, 'iPhone') !== FALSE);
}

// Define the WAP flag to false
$flag_wap = false;
// Collect the WAP flag if set in the URL query
if (isset($_GET['wap'])){ $flag_wap = $_GET['wap'] == 'true' ? true : false; }
// Otherwise, check if this is an iPhone browser
elseif (is_browser_iphone()){ $flag_wap = true; }

?>