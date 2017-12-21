<?php
// Include the TOP file
require('_top.php');
// Require the appropriate index file
if ($this_current_page == 'prototype'){ define('MMRPG_INDEX_GAME', true); require_once('indexes/game.php'); }
else { define('MMRPG_INDEX_BASE', true); require_once('indexes/base.php'); }
// Unset the database variable
unset($db);
?>