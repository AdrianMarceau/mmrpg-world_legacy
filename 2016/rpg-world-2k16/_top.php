<?php

// If this file has already been included, return
if (defined('MMRPG_TOP_INCLUDED')){ return; }
else { define('MMRPG_TOP_INCLUDED', true); }

/*
 * GLOBAL INCLUDES
 */

// Include the legacy config and apptop root
require_once('includes/config.legacy.php');

// Start the session
@date_default_timezone_set('Canada/Eastern');
//@ini_set('session.gc_maxlifetime', 24*60*60);
//@ini_set('session.gc_probability', 1);
//@ini_set('session.gc_divisor', 1);
if (session_id() == ''){ session_start(); }
if (!isset($_SESSION['RPG2k16'])){ $_SESSION['RPG2k16'] = array(); }

// Include mandatory config files
define('MMRPG_BUILD', 'mmrpg2k16');
define('MMRPG_VERSION', '3.0.0');
//require('includes/config.php');
require('includes/settings.php');

// Turn on error reporting
if (MMRPG_CONFIG_ADMIN_MODE){
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);
}

// Include mandatory core class files
require('classes/cms_website.php');
require('classes/cms_database.php');
require('classes/rpg_functions.php');

// Create the global database object
if (!defined('MMRPG_INDEX_SESSION')){
    if (MMRPG_CONFIG_DEBUG_MODE){ $_SESSION['RPG2k16']['DEBUG'] = array(); }
    $db = new cms_database();
    // If the database could not be created, critical error mode!
    if ($db->CONNECT === false){
        define('MMRPG_CRITICAL_ERROR', true);
        $_GET = array();
        $_GET['page'] = 'error';
    }
}

// Include mandatory user class files
require('classes/rpg_user.php');
require('classes/rpg_user_role.php');

// Include mandatory game class files
require('classes/rpg_game.php');
require('classes/rpg_prototype.php');
require('classes/rpg_mission.php');

// Include mandatory object class files
require('classes/rpg_type.php');
require('classes/rpg_object.php');
require('classes/rpg_battle.php');
require('classes/rpg_field.php');
require('classes/rpg_player.php');
require('classes/rpg_robot.php');
require('classes/rpg_ability.php');
require('classes/rpg_attachment.php');
require('classes/rpg_item.php');


/*
 * LIBRARY INDEXES
 */

// If we're in a file page, prevent userinfo caching
if (preg_match('/file.php$/i', basename(__FILE__))){
    // Prevent userinfo caching for this page
    unset($_SESSION['RPG2k16']['GAME']['USER']['userinfo']);
}

// Turn off magic quotes before it causes any problems
if (get_magic_quotes_gpc()){
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

// Fix the unusual formatting of the FILES array if not empty
$new_files = array();
if (!empty($_FILES)){
    // Loop through the files array and parse info
    foreach ($_FILES AS $input_name => $input_fields){
        if (!is_array($input_fields['name'])){ break; }
        $new_files[$input_name] = array();
        foreach ($input_fields AS $field_name => $field_values){
            foreach ($field_values AS $input_key => $input_values){
                foreach ($input_values AS $value_key => $value_value){
                    $new_files[$input_name][$input_key][$value_key][$field_name] = $value_value;
                }
            }
        }
    }
    // Update the file input with new formatting
    if (!empty($new_files)){
        $_FILES = $new_files;
    }
}


/*
 * SESSION VARIABLES
 */

// Create mandatory session variables if they do not exist
if (!isset($_SESSION['RPG2k16']['BATTLES'])){ $_SESSION['RPG2k16']['BATTLES'] = array(); }
if (!isset($_SESSION['RPG2k16']['FIELDS'])){ $_SESSION['RPG2k16']['FIELDS'] = array(); }
if (!isset($_SESSION['RPG2k16']['PLAYERS'])){ $_SESSION['RPG2k16']['PLAYERS'] = array(); }
if (!isset($_SESSION['RPG2k16']['ROBOTS'])){ $_SESSION['RPG2k16']['ROBOTS'] = array(); }
if (!isset($_SESSION['RPG2k16']['ABILITIES'])){ $_SESSION['RPG2k16']['ABILITIES'] = array(); }

// Define the COMMUNITY session trackers if they do not exist
if (!isset($_SESSION['RPG2k16']['COMMUNITY'])){ $_SESSION['RPG2k16']['COMMUNITY']['threads_viewed'] = array(); }


/*
 * BROWSER FLAGS
 */

// Define the WAP flag to false
$flag_wap = false;
$flag_ipad = false;
$flag_iphone = false;
// Collect the WAP flag if set in the URL query
$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
if (isset($_GET['wap'])){ $flag_wap = $_GET['wap'] == 'true' ? true : false; }
//Otherwise, check if this is an iPhone or iPad browser
elseif (!empty($_GET['iphone']) || strpos($user_agent, 'iPhone') !== FALSE){ $flag_iphone = true; }
elseif (!empty($_GET['ipad']) || strpos($user_agent, 'iPad')){  $flag_ipad = $flag_wap = true; }
unset($user_agent);


/*
 * GAME SAVING AND LOADING
 */

// Only continue with saving/loading functions if we're NOT in critical mode
if (!defined('MMRPG_CRITICAL_ERROR')){

    // Define the first load boolean variable
    $this_first_load = false;
    // Define the game cache location path
    $this_cache_dir = MMRPG_CONFIG_CACHE_PATH;

    // If the user and file details have already been loaded to the session
    if (!empty($_SESSION['RPG2k16']['GAME']['USER']['userid'])
        && $_SESSION['RPG2k16']['GAME']['USER']['userid'] != MMRPG_SETTINGS_GUEST_ID){

        // Pull the user and file info from the session
        $this_user = $_SESSION['RPG2k16']['GAME']['USER'];

    }
    // Otherwise, if we're in demo mode, populate manually
    else {

        // Auto-generate the user and file info based on their IP
        $this_user = array();
        $this_user['userid'] = MMRPG_SETTINGS_GUEST_ID;
        $this_user['username'] = 'demo';
        $this_user['username_clean'] = 'demo';
        $this_user['imagepath'] = '';
        $this_user['colourtoken'] = '';
        $this_user['gender'] = '';
        $this_user['password'] = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'demo';
        $this_user['password_encoded'] = md5($this_user['password']);

        // Update the session with these demo variables
        $_SESSION['RPG2k16']['GAME']['DEMO'] = 1;
        $_SESSION['RPG2k16']['GAME']['USER'] = $this_user;

        // Update the first load to indicate true
        $this_first_load = true;

    }

}


/*
 * PAGE REQUESTS
 */

// Collect the current page from the header if set
$this_allowed_pages = array('home', 'about', 'gallery', 'database', 'leaderboard', 'community', 'prototype', 'credits', 'contact', 'file', 'admin', 'error');
$this_current_page = !empty($_GET['page']) ? strtolower($_GET['page']) : false;
$this_current_sub = !empty($_GET['sub']) ? strtolower($_GET['sub']) : false;
$this_current_num = !empty($_GET['num']) ? $_GET['num'] : 1;
$this_current_token = !empty($_GET['token']) ? $_GET['token'] : '';
$this_current_cat = !empty($_GET['cat']) ? $_GET['cat'] : '';
$this_current_id = !empty($_GET['id']) ? $_GET['id'] : 0;

// Redirect the stupid friggin home pages to their friggin not home page versions (UGH!)
//die('<pre>'.print_r($_GET, true).'</pre>');
$this_current_uri = !empty($this_current_page) && $this_current_page != 'home' ? $this_current_page.'/' : '';
$this_current_uri .= !empty($this_current_sub) && $this_current_sub != 'home' ? $this_current_sub.'/' : '';
if ($this_current_page != 'community'){ $this_current_uri .= !empty($this_current_num) && $this_current_num > 1 ? $this_current_num.'/' : ''; }
if (isset($_GET['home']) || $this_current_sub == 'home' || $this_current_page == 'home'){
    $_GET['this_redirect'] = $this_current_url;
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: '.$this_current_url);
    exit();
} elseif ($this_current_page == 'about'){
    $this_current_sub = !empty($_GET['sub']) ? strtolower($_GET['sub']) : '';
    if (!empty($this_current_sub)){
        $this_current_uri .= $this_current_sub.'/';
    }
} elseif ($this_current_page == 'admin'){
    $this_current_sub = !empty($_GET['sub']) ? strtolower($_GET['sub']) : '';
    if (!empty($this_current_sub)){
        $this_current_uri .= $this_current_sub.'/';
    }
} elseif ($this_current_page == 'updates'){
    $this_current_id = !empty($_GET['id']) ? strtolower($_GET['id']) : 0;
    $this_current_token = !empty($_GET['token']) ? $_GET['token'] : '';
    if ($this_current_id !== false && !empty($this_current_token)){
        $this_current_uri .= $this_current_id.'/'.$this_current_token.'/';
    }
} elseif ($this_current_page == 'community'){
    $this_current_cat = !empty($_GET['cat']) ? strtolower($_GET['cat']) : '';
    $this_current_id = !empty($_GET['id']) ? strtolower($_GET['id']) : 0;
    $this_current_token = !empty($_GET['token']) ? $_GET['token'] : '';
    $this_current_target = !empty($_GET['target']) ? $_GET['target'] : '';
    if (!empty($this_current_cat) && $this_current_id !== false && !empty($this_current_token)){
        $this_current_uri .= $this_current_cat.'/'.$this_current_id.'/'.$this_current_token.'/';
    } elseif (!empty($this_current_cat) && !empty($this_current_sub)){
        $this_current_uri = $this_current_page.'/'.$this_current_cat.'/'.$this_current_sub.'/';
    } elseif (!empty($this_current_cat)){
        $this_current_uri .= $this_current_cat.'/';
    }
    if (!empty($this_current_target)){
        //$this_current_uri .= $this_current_target.'/';
    }
    if (!empty($this_current_num) && $this_current_num != 1){
        $this_current_uri .= $this_current_num.'/';
    }
} elseif ($this_current_page == 'database'){
    $this_current_token = !empty($_GET['token']) ? $_GET['token'] : '';
    $temp_type_token = rpg_type::get_index_info($this_current_token);
    if (!empty($this_current_token) && !empty($temp_type_token) || in_array($this_current_token, array('multi', 'bonus'))){
        $this_current_filter = $_GET['filter'] = $this_current_token;
        $this_current_filter_name = $this_current_filter == 'none' ? 'Neutral' : ucfirst($this_current_filter);
        $this_current_uri .= $this_current_filter.'/';
        $this_current_token = $_GET['token'] = '';
    } elseif (!empty($this_current_token)){
        $this_current_uri .= $this_current_token.'/';
    }
} elseif ($this_current_page == 'leaderboard'){
    $this_current_token = !empty($_GET['token']) ? $_GET['token'] : '';
    if (!empty($this_current_token)){
        $this_current_uri .= $this_current_token.'/';
    }
} elseif ($this_current_page == 'file'){
    $this_current_token = !empty($_GET['token']) ? $_GET['token'] : '';
    if (!empty($this_current_token)){
        $this_current_uri .= $this_current_token.'/';
    }
}
$this_current_url = MMRPG_CONFIG_ROOTURL.$this_current_uri;
$_GET['this_current_uri'] = $this_current_uri; //urlencode($this_current_uri);
$_GET['this_current_url'] = $this_current_url; //urlencode($this_current_url);
//die('<pre>'.print_r($_GET, true).'</pre>');

// Now that all the redirecting is done, if the current page it totally empty, it's ACTUALLY home
if (empty($this_current_page) || !in_array($this_current_page, $this_allowed_pages)){ $this_current_page = 'home'; }


/*
 * USERINFO COLLECTION
 */

// If we're NOT viewing the session info
if (!defined('MMRPG_CRITICAL_ERROR') && !defined('MMRPG_INDEX_SESSION') && !defined('MMRPG_INDEX_SESSION') && !defined('MMRPG_INDEX_STYLES')){

    // If the user session is already in progress, collect the details
    if (!empty($_SESSION['RPG2k16']['GAME']['USER']['userid']) && $_SESSION['RPG2k16']['GAME']['USER']['userid'] != MMRPG_SETTINGS_GUEST_ID){

        // Collect this userinfo from the database
        $this_userid = (int)($_SESSION['RPG2k16']['GAME']['USER']['userid']);
        if (empty($_SESSION['RPG2k16']['GAME']['USER']['userinfo'])){
            $this_userinfo = $db->get_array("SELECT users.*, roles.* FROM mmrpg_users AS users LEFT JOIN mmrpg_roles AS roles ON roles.role_id = users.role_id WHERE users.user_id = '{$this_userid}' LIMIT 1");
            $_SESSION['RPG2k16']['GAME']['USER']['userinfo'] = $this_userinfo;
        } else {
            $this_userinfo = $_SESSION['RPG2k16']['GAME']['USER']['userinfo'];
        }

        if (!defined('MMRPG_SCRIPT_REQUEST')){
            $this_boardinfo = $db->get_array("SELECT * FROM mmrpg_leaderboard WHERE user_id = {$this_userid}");
            $this_boardid = $this_boardinfo['board_id'];
            $this_boardinfo['board_rank'] = !empty($_SESSION['RPG2k16']['GAME']['BOARD']['boardrank']) ? $_SESSION['RPG2k16']['GAME']['BOARD']['boardrank'] : 0;
            //if (empty($this_boardinfo['board_rank'])){ require('includes/leaderboard.php'); $_SESSION['RPG2k16']['GAME']['BOARD']['boardrank'] = $this_boardinfo['board_rank']; }
            if (empty($this_boardinfo['board_rank'])){ $_SESSION['RPG2k16']['GAME']['BOARD']['boardrank'] = $this_boardinfo['board_rank'] = rpg_prototype::leaderboard_rank($this_userid); }
        }

    }
    // Otherwise, generate some details user details
    else {

        // Collect the guest userinfo from the database
        $this_userid = MMRPG_SETTINGS_GUEST_ID;
        if (empty($_SESSION['RPG2k16']['GAME']['USER']['userinfo'])){
            $this_userinfo = $db->get_array("SELECT users.* FROM mmrpg_users AS users WHERE users.user_id = '{$this_userid}' LIMIT 1");
            $_SESSION['RPG2k16']['GAME']['USER']['userinfo'] = $this_userinfo;
        } else {
            $this_userinfo = $_SESSION['RPG2k16']['GAME']['USER']['userinfo'];
        }

        if (!defined('MMRPG_SCRIPT_REQUEST')){
            $this_boardinfo = array();
            $this_boardinfo['board_rank'] = 0;
            $this_boardid = 0;
        }

    }

} else {
    // Create the userinfo array anyway to prevent errors
    $this_userinfo = array();
}


/*
 * WEBSITE THEME GENERATION
 */

// If we're NOT viewing the session info
if (!defined('MMRPG_INDEX_SESSION') && !defined('MMRPG_INDEX_STYLES')){

    // If this user is a member, collect background and type settings from the account
    if (rpg_user::is_member()){
        // Collect theme settings from the user's profile settings
        $temp_field_path = !empty($this_userinfo['user_background_path']) ? $this_userinfo['user_background_path'] : 'fields/intro-field';
        $temp_field_type = !empty($this_userinfo['user_colour_token']) ? $this_userinfo['user_colour_token'] : '';
    }
    // Otherwise if guest we need to select a randomized field background for a time interval
    else {
        // Define the theme timeout for auto updating
        $theme_timeout = 60 * 60 * 1; // 60s x 60m = 1 hr
        if (!isset($_SESSION['RPG2k16']['INDEX']['theme_cache']) || (time() - $_SESSION['RPG2k16']['INDEX']['theme_cache']) > $theme_timeout){
            // Hard code the type to none but collect a ranzomized field token
            $temp_field_info = $db->get_array("SELECT
                field_token,
                CONCAT('fields/', field_token) AS field_path,
                field_type
                FROM mmrpg_index_fields
                WHERE field_flag_complete = 1 AND field_flag_published = 1 AND field_flag_hidden = 0 AND field_game IN ('MM01', 'MM02', 'MM03', 'MM04')
                ORDER BY RAND() LIMIT 1
                ;");
            $temp_field_type = 'none';
            $temp_field_path = $temp_field_info['field_path'];
            $temp_mecha_tokens = $db->get_array_list("SELECT
                robot_token AS mecha_token
                FROM mmrpg_index_robots
                WHERE robot_flag_complete = 1 AND robot_flag_published = 1 AND robot_flag_hidden = 0 AND robot_class = 'mecha' AND robot_core = '{$temp_field_info['field_type']}' AND robot_game IN ('MM01', 'MM02', 'MM03', 'MM04')
                ORDER BY RAND()
                ;", 'mecha_token');
            $temp_mecha_tokens = !empty($temp_mecha_tokens) ? array_keys($temp_mecha_tokens) : array();
            // Update the session with these settings
            $_SESSION['RPG2k16']['INDEX']['theme_cache'] = time();
            $_SESSION['RPG2k16']['INDEX']['theme_field_path'] = $temp_field_path;
            $_SESSION['RPG2k16']['INDEX']['theme_field_type'] = $temp_field_type;
            $_SESSION['RPG2k16']['INDEX']['theme_mecha_tokens'] = $temp_mecha_tokens;
        } else {
            // Collect existing theme settings from the session
            $temp_field_path = $_SESSION['RPG2k16']['INDEX']['theme_field_path'];
            $temp_field_type = $_SESSION['RPG2k16']['INDEX']['theme_field_type'];
            $temp_mecha_tokens = $_SESSION['RPG2k16']['INDEX']['theme_mecha_tokens'];
        }
    }

    // Collect the info for the chosen temp field
    list($temp_field_kind, $temp_field_token) = explode('/', $temp_field_path);
    $temp_field_data = rpg_field::get_index_info($temp_field_token);
    if (!empty($temp_mecha_tokens)){
        $temp_field_data['field_mechas'] = array_merge($temp_field_data['field_mechas'], $temp_mecha_tokens);
        $temp_field_data['field_mechas'] = array_unique($temp_field_data['field_mechas']);
    }

    // Define the current field token for the index
    define('MMRPG_SETTINGS_CURRENT_FIELDTOKEN', $temp_field_data['field_token']);
    define('MMRPG_SETTINGS_CURRENT_FIELDTYPE', (!empty($temp_field_type) ? $temp_field_type : (!empty($temp_field_data['field_type']) ? $temp_field_data['field_type'] : 'none')));
    define('MMRPG_SETTINGS_CURRENT_FIELDFRAMES', count($temp_field_data['field_background_frame']));
    define('MMRPG_SETTINGS_CURRENT_FIELDMECHA', (!empty($temp_field_data['field_mechas']) ? $temp_field_data['field_mechas'][0] : 'met'));

}

?>