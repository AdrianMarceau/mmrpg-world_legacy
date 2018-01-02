<?php

/*
 * GLOBAL INCLUDES
 */

// Include mandatory config files
//require_once('data/config.php');

// Include the legacy config and apptop root
require_once('data/config.legacy.php');
require_once(LEGACY_MMRPG_ROOT_DIR.'includes/apptop.root.php');

// Include mandatory function files
require_once('data/functions/function.game.php');
require_once('data/functions/function.prototype.php');

// Include mandatory class files
require_once('data/classes/class.battle.php');
require_once('data/classes/class.field.php');
require_once('data/classes/class.player.php');
require_once('data/classes/class.robot.php');
require_once('data/classes/class.ability.php');


/*
 * LIBRARY INDEXES
 */

// Start the session
@ini_set('session.gc_maxlifetime', 24*60*60);
@ini_set('session.gc_probability', 1);
@ini_set('session.gc_divisor', 1);
if (session_id() == ''){ session_start(); }
if (!isset($_SESSION['RPG2k12-2'])){ $_SESSION['RPG2k12-2'] = array(); }

// Include mandatory library files
$mmrpg_index = array();
require_once('data/battles/index.php');
require_once('data/fields/index.php');
require_once('data/players/index.php');
require_once('data/robots/index.php');
require_once('data/abilities/index.php');
require_once('data/types/index.php');


/*
 * SESSION VARIABLES
 */

// Create mandatory session variables if they do not exist
$_SESSION['RPG2k12-2']['BATTLES'] = isset($_SESSION['RPG2k12-2']['BATTLES']) ? $_SESSION['RPG2k12-2']['BATTLES'] : array();
$_SESSION['RPG2k12-2']['FIELDS'] = isset($_SESSION['RPG2k12-2']['FIELDS']) ? $_SESSION['RPG2k12-2']['FIELDS'] : array();
$_SESSION['RPG2k12-2']['PLAYERS'] = isset($_SESSION['RPG2k12-2']['PLAYERS']) ? $_SESSION['RPG2k12-2']['PLAYERS'] : array();
$_SESSION['RPG2k12-2']['ROBOTS'] = isset($_SESSION['RPG2k12-2']['ROBOTS']) ? $_SESSION['RPG2k12-2']['ROBOTS'] : array();
$_SESSION['RPG2k12-2']['ABILITIES'] = isset($_SESSION['RPG2k12-2']['ABILITIES']) ? $_SESSION['RPG2k12-2']['ABILITIES'] : array();

/*
 * BROWSER FLAGS
 */

// Define a function for checking if using iPhone
function is_browser_iphone($user_agent = NULL){
  if(!isset($user_agent)){ $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ''; }
  return (strpos($user_agent, 'iPhone') !== FALSE);
}
// Define a function for checking if using iPad
function is_browser_ipad($user_agent = NULL){
	if(!isset($user_agent)){ $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';	}
	return (strpos($user_agent, 'iPad') !== FALSE);
}

// Define the WAP flag to false
$flag_wap = false;
// Collect the WAP flag if set in the URL query
if (isset($_GET['wap'])){ $flag_wap = $_GET['wap'] == 'true' ? true : false; }
//Otherwise, check if this is an iPhone browser
// elseif (is_browser_iphone()){ $flag_wap = true; }
// Otherwise, check if this is an iPad browser
elseif (is_browser_ipad()){	$flag_wap = true; }

//$GLOBALS['DEBUG']['checkpoint_line'] = 'top.php : line 70';

/*
 * GAME SAVING AND LOADING
 */

// Define the game save location path
$this_save_dir = $MMRPG_CONFIG['ROOTDIR'].'data/saves/';
// Collect the user's IP address, if they have one
$this_save_address = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

// Generate a save filename and filepath based on the IP address
if (!empty($this_save_address)){
  $this_save_filename = 'game.'.preg_replace('#([^0-9]+)#', '', $this_save_address).'-'.$MMRPG_CONFIG['CACHE_DATE'].'.sav';
  $this_save_filepath = $this_save_dir.$this_save_filename;
} else {
  $this_save_filename = false;
  $this_save_filepath = false;
}

?>