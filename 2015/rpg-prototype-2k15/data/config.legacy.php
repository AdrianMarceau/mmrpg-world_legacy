<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/config.root.php');

// Collect the current domain for environment testing
@preg_match('#^([-~a-z0-9\.]+)#i', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']), $temp_domain);
$temp_domain = isset($temp_domain[0]) ? $temp_domain[0] : false;

// Define the global path variables for this installation
define('MMRPG_CONFIG_IS_LIVE', LEGACY_MMRPG_IS_LIVE);
define('MMRPG_CONFIG_ROOTDIR', LEGACY_MMRPG_ROOT_DIR.'2015/rpg-prototype-2k15/');
define('MMRPG_CONFIG_ROOTURL', LEGACY_MMRPG_ROOT_URL.'2015/rpg-prototype-2k15/');
define('MMRPG_CONFIG_CACHE_INDEXES', MMRPG_CONFIG_IS_LIVE ? true : false);

// Define the global database credentials for this installation
define('MMRPG_CONFIG_DBHOST', LEGACY_MMRPG_DB_HOST);
define('MMRPG_CONFIG_DBNAME', 'legacy_mmrpg2k15'); // legacy_mmrpg2k15 / mmrpg_dev
define('MMRPG_CONFIG_DBUSERNAME', LEGACY_MMRPG_DB_USERNAME);
define('MMRPG_CONFIG_DBPASSWORD', LEGACY_MMRPG_DB_PASSWORD);
define('MMRPG_CONFIG_DBCHARSET', LEGACY_MMRPG_DB_CHARSET);

// Define the global credentials for any web analytics accounts
define('MMRPG_ANALYTICS_ACCOUNT', LEGACY_MMRPG_GA_ACCOUNTID);
define('MMRPG_ANALYTICS_DOMAIN', 'legacy.mmrpg-world.net');

// Define the list of administrator-approved remote addresses
define('MMRPG_CONFIG_ADMIN_LIST', LEGACY_MMRPG_ADMIN_LIST);

?>