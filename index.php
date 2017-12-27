<?php

// Define a variable to say yes, this is home
define('IS_LEGACY_INDEX', true);

// Require the config and top files
require('includes/apptop-root.php');

// Require the home page file by default
require(LEGACY_MMRPG_ROOT_DIR.'pages/legacy-home.php');

?>