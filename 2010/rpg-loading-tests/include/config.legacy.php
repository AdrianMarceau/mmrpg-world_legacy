<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/config.root.php');

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
$PLUTOCMS_CONFIG['CORE']['IS_LIVE'] = LEGACY_MMRPG_IS_LIVE; // System is LIVE/LOCAL
$PLUTOCMS_CONFIG['CORE']['ROOTDIR'] = LEGACY_MMRPG_ROOT_DIR.'2012/rpg-battle-tests/'; // System Root DIR
$PLUTOCMS_CONFIG['CORE']['ROOTURL'] = LEGACY_MMRPG_ROOT_URL.'2012/rpg-battle-tests/'; // System Root URL
$PLUTOCMS_CONFIG['CORE']['IS_HTACCESS'] = true; // System allows use of htaccess

/*
 * DATABASE CONFIG
 * These variables pertain to the database
 * connection settings
 */

// Define database connection details
$PLUTOCMS_CONFIG['DB']['HOST'] = LEGACY_MMRPG_DB_HOST; // Database Host
$PLUTOCMS_CONFIG['DB']['NAME'] = 'legacy_mmrpg'; // Database Name
$PLUTOCMS_CONFIG['DB']['USERNAME'] = LEGACY_MMRPG_DB_USERNAME; // Database UserName
$PLUTOCMS_CONFIG['DB']['PASSWORD'] = LEGACY_MMRPG_DB_PASSWORD; // Database Password
$PLUTOCMS_CONFIG['DB']['CHARSET'] = LEGACY_MMRPG_DB_CHARSET; // Database Charset

?>