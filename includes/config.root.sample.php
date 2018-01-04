<?php

// Define if this is a live server
define('LEGACY_MMRPG_IS_LIVE', true);

// Define the root path variables for this server
define('LEGACY_MMRPG_ROOT_DIR', '/var/www/html/');
define('LEGACY_MMRPG_ROOT_URL', 'http://www.domain.com/');

// Define the root database credentials for this server
define('LEGACY_MMRPG_DB_HOST', 'localhost');
define('LEGACY_MMRPG_DB_NAME', 'legacy_index');
define('LEGACY_MMRPG_DB_USERNAME', 'legacy_user');
define('LEGACY_MMRPG_DB_PASSWORD', 'P@SSW0RD');
define('LEGACY_MMRPG_DB_CHARSET', 'utf8');

// Define the analytics account ID
define('LEGACY_MMRPG_GA_ACCOUNTID', 'UA-00000000-0');

// Define the cache timestamp for updates
define('LEGACY_MMRPG_CACHE_DATE', '2018-01-03');

// Define the list of administrator-approved IP addresses
$temp_list = array('127.0.0.1');
define('LEGACY_MMRPG_ADMIN_LIST', implode(',', $temp_list));

// Define the PASSWORD SALT and OMEGA SEED string values
define('LEGACY_MMRPG_PASSWORD_SALT', 'saltySALTsalt'); // Change this to something unique
define('LEGACY_MMRPG_OMEGA_SEED', 'c0LL3c710nOFalphaNUMERICchars'); // Change this to something unique

// Define the COPPA email exceptions based on written perission to allow registration
$temp_list = array('approved-user@email-domain.com');
define('LEAGCY_MMRPG_COPPA_PERMISSIONS', implode(',', $temp_list));

// Define the list of BANNED remote addresses
$banned_list = array();
$banned_list[] = '0.0.0.0'; // empty
define('LEGACY_MMRPG_BANNED_LIST', implode(',', $banned_list));

?>