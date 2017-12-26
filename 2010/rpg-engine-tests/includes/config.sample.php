<?php

// Require the root config
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
$config_path = $root_path.'config.php';
require($config_path);

// Define the CURRENTDOMAIN, ISLIVE and FUNCTIONROOT
$host_name = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (!empty($_SERVER['HOST_NAME']) ? $_SERVER['HOST_NAME'] : '');
define('CURRENTDOMAIN', strstr($host_name, 'local.') ? 'localhost' : 'remote');

// Define the ROOT DIRs for this project
if (strstr(CURRENTDOMAIN, 'local.')){ define('ISLIVE', false); }
else { define('ISLIVE', true); }
define('ROOTDIR', $mmrpg_root_dir.'2010/rpg-engine-tests/');
define('ROOTURL', $mmrpg_root_url.'2010/rpg-engine-tests/');

// Define the database details for this project
define('DBHOST', $mmrpg_database_host);
define('DBNAME', 'legacy_mmpurpg');
define('DBUSERNAME', $mmrpg_database_username);
define('DBPASSWORD', $mmrpg_database_password);

?>