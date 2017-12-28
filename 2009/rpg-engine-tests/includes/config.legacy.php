<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Define the CURRENTDOMAIN, ISLIVE and FUNCTIONROOT
$host_name = !empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (!empty($_SERVER['HOST_NAME']) ? $_SERVER['HOST_NAME'] : '');
define('CURRENTDOMAIN', strstr($host_name, 'local.') ? 'localhost' : 'remote');

// Define the ROOT DIRs for this project
if (strstr(CURRENTDOMAIN, 'local.')){ define('ISLIVE', false); }
else { define('ISLIVE', true); }
define('ROOTDIR', LEGACY_MMRPG_ROOT_DIR.'2010/rpg-engine-tests/');
define('ROOTURL', LEGACY_MMRPG_ROOT_URL.'2010/rpg-engine-tests/');

// Define the database details for this project
define('DBHOST', LEGACY_MMRPG_DB_HOST);
define('DBNAME', 'legacy_mmpurpg');
define('DBUSERNAME', LEGACY_MMRPG_DB_USERNAME);
define('DBPASSWORD', LEGACY_MMRPG_DB_PASSWORD);

?>