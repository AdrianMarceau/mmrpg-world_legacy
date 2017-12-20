<?php

// Define a variable to say yes, this is home
define('IS_LEGACY_INDEX', true);

// Require the top files
require('config.php');
require('apptop.php');

// Require the home page file
require('pages/home.php');

// Require the page template
require('html.php');

?>