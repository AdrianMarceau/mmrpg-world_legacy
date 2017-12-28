<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Define the headers for this HTML page
$html->addTitle('Some Legacy Content')->addTitle('Sub Name');
$html->setContentDescription(
    'A short description about this collection legacy content as a whole. '.
    'Then describe what this one piece is about specifically. '
    );

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">

    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();
$html->addContentMarkup($html_content_markup);

/*
// Start the ouput buffer to collect styles
ob_start();
    ?>
    <style type="text/css">

    </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);
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
$html->addScriptMarkup($html_scripts_markup);
*/

// Print out the final HTML page markup
$html->printHtmlPage();


?>