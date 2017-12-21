<?php

// Require the root config
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
$config_path = $root_path.'config.php';
require($config_path);

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

/*
 * FILESYSTEM CONFIG
 * These variables pertain to the physical or
 * virtual location settings for the running
 * scripts
 */

// Define the ROOT DIR, URL, and environment variables
if (strstr($PLUTOCMS_CONFIG['CORE']['DOMAIN'], '.local')){
  $PLUTOCMS_CONFIG['CORE']['ROOTDIR'] = $mmrpg_root_dir.'2012/rpg-battle-tests/'; // System Root DIR
  $PLUTOCMS_CONFIG['CORE']['ROOTURL'] = $mmrpg_root_url.'2012/rpg-battle-tests/'; // System Root URL
  $PLUTOCMS_CONFIG['CORE']['IS_LIVE'] = false; // System is not LIVE
}
else {
  $PLUTOCMS_CONFIG['CORE']['ROOTDIR'] = $mmrpg_root_dir.'2012/rpg-battle-tests/'; // System Root DIR
  $PLUTOCMS_CONFIG['CORE']['ROOTURL'] = $mmrpg_root_url.'2012/rpg-battle-tests/'; // System Root URL
  $PLUTOCMS_CONFIG['CORE']['IS_LIVE'] = true; // System is LIVE
}

/*
 * DATABASE CONFIG
 * These variables pertain to the database
 * connection settings
 */

// Define database connection details
$PLUTOCMS_CONFIG['DB']['HOST'] = $mmrpg_database_host; // Database Host
$PLUTOCMS_CONFIG['DB']['NAME'] = $mmrpg_database_name; // Database Name
$PLUTOCMS_CONFIG['DB']['USERNAME'] = $mmrpg_database_username; // Database UserName
$PLUTOCMS_CONFIG['DB']['PASSWORD'] = $mmrpg_database_password; // Database Password
$PLUTOCMS_CONFIG['DB']['CHARSET'] = $mmrpg_database_charset; // Database Charset

?>