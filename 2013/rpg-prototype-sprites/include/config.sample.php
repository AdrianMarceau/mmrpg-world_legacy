<?php

// Require the root config
require('../../config.php');

// Initialize the config array
define('PLUTOCMS_CONFIG', 'PLUTOCMS_CONFIG');
${PLUTOCMS_CONFIG} = array();

/*
 * SYSTEM/ENVIRONMENT CONFIG
 * These variables pertain to the environment and
 * system settings for the running scripts
 */

// Define the core domain, locale, timezone, error reporting and cache settings
@preg_match('#^([-~a-z0-9\.]+)#i', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']), $THIS_DOMAIN);
$PLUTOCMS_CONFIG['CORE']['DOMAIN'] = isset($THIS_DOMAIN[0]) ? $THIS_DOMAIN[0] : false;
$PLUTOCMS_CONFIG['CORE']['LOCALE'] = 'en_US.UTF8'; // System Locale
$PLUTOCMS_CONFIG['CORE']['TIMEZONE'] = 'Canada/Eastern'; // System Timezone
$PLUTOCMS_CONFIG['CORE']['DISPLAY_ERRORS'] = true; // Error Display Switch
$PLUTOCMS_CONFIG['CORE']['ERROR_REPORTING'] = 2147483647; // Error Reporting Level
$PLUTOCMS_CONFIG['CORE']['DISABLE_CACHING'] = true;
$PLUTOCMS_CONFIG['CORE']['IS_LIVE'] = false;
$PLUTOCMS_CONFIG['CORE']['IS_HTACCESS'] = false;
$PLUTOCMS_CONFIG['CORE']['CACHE_TIME'] = mktime(14, 19, 0, 05, 19, 2012);

/*
 * FILESYSTEM CONFIG
 * These variables pertain to the physical or
 * virtual location settings for the running
 * scripts
 */

if (strstr($MMRPG_CONFIG['DOMAIN'], 'local.')){
  $PLUTOCMS_CONFIG['CORE']['ROOTDIR'] = $mmrpg_root_dir.'2013/rpg-prototype-sprites/'; // System Root DIR
  $PLUTOCMS_CONFIG['CORE']['ROOTURL'] = $mmrpg_root_url.'2013/rpg-prototype-sprites/'; // System Root URL
  $PLUTOCMS_CONFIG['CORE']['IS_LIVE'] = false; // System is not LIVE
  $PLUTOCMS_CONFIG['CORE']['IS_HTACCESS'] = true; // System allows use of .htaccess
}
else {
  $PLUTOCMS_CONFIG['CORE']['ROOTDIR'] = $mmrpg_root_dir.'2013/rpg-prototype-sprites/';; // System Root DIR
  $PLUTOCMS_CONFIG['CORE']['ROOTURL'] = $mmrpg_root_url.'2013/rpg-prototype-sprites/'; // System Root URL
  $PLUTOCMS_CONFIG['CORE']['IS_LIVE'] = true; // System is LIVE
  $PLUTOCMS_CONFIG['CORE']['IS_HTACCESS'] = true; // System allows use of .htaccess
  $PLUTOCMS_CONFIG['CORE']['CACHE_STYLES'] = true; // Turn ON style caching
  $PLUTOCMS_CONFIG['CORE']['CACHE_SCRIPTS'] = true; // Turn ON script caching
  $PLUTOCMS_CONFIG['CORE']['CACHE_INDEXES'] = true; // Turn ON index caching
}

/*
 * DATABASE CONFIG
 * These variables pertain to the database
 * connection settings
 */

$PLUTOCMS_CONFIG['DB']['HOST'] = $mmrpg_database_host; // Database Host
$PLUTOCMS_CONFIG['DB']['NAME'] = $mmrpg_database_name; // Database Name
$PLUTOCMS_CONFIG['DB']['USERNAME'] = $mmrpg_database_username; // Database Name
$PLUTOCMS_CONFIG['DB']['PASSWORD'] = $mmrpg_database_password; // Database Password
$PLUTOCMS_CONFIG['DB']['CHARSET'] = $mmrpg_database_charset; // Database Charset

?>