<?php

// Define the headers for this HTML page
$html->addTitle('Some Legacy Content');
$html->setContentDescription(
    'A description about this page in the legacy archive. '.
    'More details are also encouraged if they fit. '
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