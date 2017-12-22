<?php

// Start the session
session_start();

// Predefine page variables
$html_title_text = 'MMRPG-World.NET (Legacy)';
$html_content_title = 'Mega Man RPG World | Legacy Archive';
$html_content_description = '';
$html_content_markup = '';
$html_styles_markup = '';
$html_scripts_markup = '';

// If we're not in the index, add year to titles
if (!defined('IS_LEGACY_INDEX') && isset($_SERVER['PHP_SELF'])){
    $rel_path = ltrim(str_replace($mmrpg_root_url, '', $_SERVER['PHP_SELF']), '/');
    $path_parts = strstr($rel_path, '/') ? explode('/', $rel_path) : array($rel_path);
    if (!empty($path_parts[0])){
        $legacy_year = $path_parts[0];
        $html_title_text = $legacy_year.' | '.$html_title_text;
        $html_content_title = $html_content_title.' | '.$legacy_year;
    }
}

?>