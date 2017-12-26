<?php

// Define a variable to say yes, this is home
define('IS_LEGACY_INDEX', true);

// Require the top files
require('includes/root-config.php');
require($mmrpg_root_dir.'includes/root-top.php');

// Require the home page file
require($mmrpg_root_dir.'pages/home.php');

// Require the page template
require($mmrpg_root_dir.'html.php');

?>