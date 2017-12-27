<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/top-root.php');

// Define the headers for this file
$html_title_text = 'Some Legacy Content 001/004 | '.$html_title_text;
$html_content_title = $html_content_title.' | Some Legacy Content 001/004';
$html_content_description = 'A short description about this collection legacy content. This is a specific of those things.';

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">

    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();

/*
// Start the ouput buffer to collect styles
ob_start();
    ?>
    <style type="text/css">

    </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
*/

/*
// Start the ouput buffer to collect scripts
ob_start();
    ?>
    <script type="text/javascript">

    </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();
*/

// Require the page template
require(LEGACY_MMRPG_ROOT_DIR.'markup/html-wrapper.php');


?>