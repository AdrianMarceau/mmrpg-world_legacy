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

?>