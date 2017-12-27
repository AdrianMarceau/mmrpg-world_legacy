<?php

// Require config file
require('config-root.php');

// Include any global class files
require_once(LEGACY_MMRPG_ROOT_DIR.'classes/DatabaseConnect.class.php');
require_once(LEGACY_MMRPG_ROOT_DIR.'classes/LegacyPage.class.php');

// Start the session
session_start();

// Initialize the global DB object
$db_config = array();
$db_config['db_host'] = LEGACY_MMRPG_DB_HOST;
$db_config['db_name'] = 'legacy_index';
$db_config['db_username'] = LEGACY_MMRPG_DB_USERNAME;
$db_config['db_password'] = LEGACY_MMRPG_DB_PASSWORD;
$db_config['db_charset'] = LEGACY_MMRPG_DB_CHARSET;
$db_config['is_live'] = LEGACY_MMRPG_IS_LIVE ? true : false;
$db_config['is_admin'] = !LEGACY_MMRPG_IS_LIVE ? true : false;
$db_config['is_debug'] = !LEGACY_MMRPG_IS_LIVE ? true : false;
$db = new DatabaseConnect($db_config);

// Initialize the legacy page object
$html_config = array();
$html_config['root_dir'] = LEGACY_MMRPG_ROOT_DIR;
$html_config['root_url'] = LEGACY_MMRPG_ROOT_URL;
$html_config['cache_date'] = LEGACY_MMRPG_CACHE_DATE;
$html_config['ga_accountid'] = LEGACY_MMRPG_GA_ACCOUNTID;
$html = new LegacyPage($html_config);

// Predefine page variables
$html->setSeoTitle('MMRPG-World.NET (Legacy)');
$html->setContentTitle('Mega Man RPG World | Legacy Archive');

// If we're not in the index, add year to titles
if (!defined('IS_LEGACY_INDEX') && isset($_SERVER['PHP_SELF'])){
    $rel_path = ltrim(str_replace($mmrpg_root_url, '', $_SERVER['PHP_SELF']), '/');
    $path_parts = strstr($rel_path, '/') ? explode('/', $rel_path) : array($rel_path);
    if (!empty($path_parts[0])){
        $legacy_year = $path_parts[0];
        $html->addSeoTitle($legacy_year);
        $html->addContentTitle($legacy_year);
    }
}

?>