<?php

// Require the root config
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
$config_path = $root_path.'config.php';
require($config_path);

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
$MMRPG_CONFIG['CACHE_DATE'] = '20120304-07';

/*
 * FILESYSTEM CONFIG
 * These variables pertain to the physical or
 * virtual location settings for the running
 * scripts
 */

if (strstr($MMRPG_CONFIG['DOMAIN'], 'local.')){
  $MMRPG_CONFIG['ROOTDIR'] = $mmrpg_root_dir.'2012/rpg-prototype-2k12-2/'; // System Root DIR
  $MMRPG_CONFIG['ROOTURL'] = $mmrpg_root_url.'2012/rpg-prototype-2k12-2/'; // System Root URL
  $MMRPG_CONFIG['IS_LIVE'] = false; // System is not LIVE
  $MMRPG_CONFIG['IS_HTACCESS'] = true; // System allows use of .htaccess
}
else {
  $MMRPG_CONFIG['ROOTDIR'] = $mmrpg_root_dir.'2012/rpg-prototype-2k12-2/';; // System Root DIR
  $MMRPG_CONFIG['ROOTURL'] = $mmrpg_root_url.'2012/rpg-prototype-2k12-2/'; // System Root URL
  $MMRPG_CONFIG['IS_LIVE'] = true; // System is LIVE
  $MMRPG_CONFIG['IS_HTACCESS'] = true; // System allows use of .htaccess
  $MMRPG_CONFIG['CACHE_STYLES'] = true; // Turn ON style caching
  $MMRPG_CONFIG['CACHE_SCRIPTS'] = true; // Turn ON script caching
  $MMRPG_CONFIG['CACHE_INDEXES'] = true; // Turn ON index caching
}

?>