<?php

// Require the config file
//require('includes/config.php');
require('includes/config.legacy.php');

// Define the various file roots
$FUNCTIONROOT = isset($FUNCTIONROOT) ? $FUNCTIONROOT : ROOTDIR.'functions/';
$CLASSROOT = isset($CLASSROOT) ? $CLASSROOT : ROOTDIR.'classes/';
$INCLUDESROOT = isset($INCLUDESROOT) ? $INCLUDESROOT : ROOTDIR.'includes/';

?>