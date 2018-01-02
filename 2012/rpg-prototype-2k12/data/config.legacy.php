<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/config.root.php');

// Initialize the config array
define('MMRPG_CONFIG', 'MMRPG_CONFIG');
${MMRPG_CONFIG} = array();

/*
 * SYSTEM/ENVIRONMENT CONFIG
 * These variables pertain to the environment and
 * system settings for the running scripts
 */

// Define the core domain, locale, timezone, error reporting and cache settings
@preg_match('#^([-~a-z0-9\.]+)#i', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']), $THIS_DOMAIN);
$MMRPG_CONFIG['DOMAIN'] = isset($THIS_DOMAIN[0]) ? $THIS_DOMAIN[0] : false;
$MMRPG_CONFIG['LOCALE'] = 'en_US.UTF8'; // System Locale
$MMRPG_CONFIG['TIMEZONE'] = 'Canada/Eastern'; // System Timezone
$MMRPG_CONFIG['DISPLAY_ERRORS'] = true; // Error Display Switch
$MMRPG_CONFIG['ERROR_REPORTING'] = 2147483647; // Error Reporting Level
$MMRPG_CONFIG['DISABLE_CACHING'] = true;
$MMRPG_CONFIG['IS_LIVE'] = false;
$MMRPG_CONFIG['IS_HTACCESS'] = false;
$MMRPG_CONFIG['CACHE_STYLES'] = false;
$MMRPG_CONFIG['CACHE_SCRIPTS'] = false;
$MMRPG_CONFIG['CACHE_INDEXES'] = false;
$MMRPG_CONFIG['CACHE_DATE'] = '20120108-09';
$MMRPG_CONFIG['ANALYTICS_ACCOUNT'] = LEGACY_MMRPG_GA_ACCOUNTID;

/*
 * FILESYSTEM CONFIG
 * These variables pertain to the physical or
 * virtual location settings for the running
 * scripts
 */

// Define the filesystem config variables
$MMRPG_CONFIG['IS_LIVE'] = LEGACY_MMRPG_IS_LIVE; // System is LIVE/LOCAL
$MMRPG_CONFIG['ROOTDIR'] = LEGACY_MMRPG_ROOT_DIR.'2012/rpg-prototype-2k12/'; // System Root DIR
$MMRPG_CONFIG['ROOTURL'] = LEGACY_MMRPG_ROOT_URL.'2012/rpg-prototype-2k12/'; // System Root URL
$MMRPG_CONFIG['IS_HTACCESS'] = true; // System allows use of .htaccess
if ($MMRPG_CONFIG['IS_LIVE']){
  $MMRPG_CONFIG['CACHE_STYLES'] = true; // Turn ON style caching
  $MMRPG_CONFIG['CACHE_SCRIPTS'] = true; // Turn ON script caching
  $MMRPG_CONFIG['CACHE_INDEXES'] = true; // Turn ON index caching
}

?>