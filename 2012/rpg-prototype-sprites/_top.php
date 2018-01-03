<?

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Include the required config and class files
//require_once('include/config.php');
require_once('include/config.legacy.php');
require_once('include/class.core.php');
require_once('include/class.database.php');

// Start the session
//session_start();

// Define the CMS core object
define('PLUTOCMS_CORE', 'CMS');
${PLUTOCMS_CORE} = new plutocms_core($PLUTOCMS_CONFIG['CORE']);

// Define the DB database object
define('PLUTOCMS_DATABASE', 'DB');
${PLUTOCMS_DATABASE} = new plutocms_database($PLUTOCMS_CONFIG['DB']);

?>