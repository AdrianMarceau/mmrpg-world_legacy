<?

// Require the root config
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
$config_path = $root_path.'config.php';
require($config_path);

// Collect the current domain for environment testing
@preg_match('#^([-~a-z0-9\.]+)#i', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']), $temp_domain);
$temp_domain = isset($temp_domain[0]) ? $temp_domain[0] : false;

// Define the global path variables for this installation
define('MMRPG_CONFIG_ROOTDIR', $mmrpg_root_dir.'2015/rpg-prototype-2k15/');
define('MMRPG_CONFIG_ROOTURL', $mmrpg_root_url.'2015/rpg-prototype-2k15/');
if ($temp_domain == 'localhost' || strstr($temp_domain, 'local.')){
  define('MMRPG_CONFIG_CACHE_INDEXES', false);
  define('MMRPG_CONFIG_IS_LIVE', false);
} else {
  define('MMRPG_CONFIG_CACHE_INDEXES', true);
  define('MMRPG_CONFIG_IS_LIVE', false);
}

// Define the global database credentials for this installation
define('MMRPG_CONFIG_DBHOST', $mmrpg_database_host);
define('MMRPG_CONFIG_DBNAME', 'legacy_mmrpg2k15'); // legacy_mmrpg2k15 / mmrpg_dev
define('MMRPG_CONFIG_DBUSERNAME', $mmrpg_database_username);
define('MMRPG_CONFIG_DBPASSWORD', $mmrpg_database_password);
define('MMRPG_CONFIG_DBCHARSET', $mmrpg_database_charset);

// Define the list of administrator-approved remote addresses
define('MMRPG_CONFIG_ADMIN_LIST', '127.0.0.1,999.999.999.999');

?>