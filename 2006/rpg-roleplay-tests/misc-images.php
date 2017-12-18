<?php

// Require the top files
require('../../config.php');
require('../../apptop.php');

// Define the headers for this file
$html_title_text = 'Misc Images | Roleplay Game Forum Tests | '.$html_title_text;
$html_content_title = $html_content_title.' | Roleplay Game Forum Tests | Misc Images';
$html_content_description = 'One of the first ideas for the Mega Man RPG revolved around a play-by-post forum game with premade mechanics and abilities.  Here are some of those ability images:';

// Define the base directory and URL
$image_base_dir = $mmrpg_root_dir.'2006/rpg-roleplay-tests/';
$image_base_url = $mmrpg_root_url.'2006/rpg-roleplay-tests/';

// Define the image folders to loop through
$image_folders = array();
$image_folders[] = array('name' => 'Elemental Type Icons', 'path' => 'icons/');
$image_folders[] = array('name' => 'Robot Profile Images', 'path' => 'profiles/');
$image_folders[] = array('name' => 'Post-size Attack Images', 'path' => 'attacks/post-size/');
$image_folders[] = array('name' => 'Signature-size Attack Images', 'path' => 'attacks/sig-size/');
$image_folders[] = array('name' => 'Upgrade Chip Images', 'path' => 'upgrades/');
$image_folders[] = array('name' => 'Post-size Attack Templates', 'path' => 'templates/attacks/post-size/');
$image_folders[] = array('name' => 'Full-size Attack Templates', 'path' => 'templates/attacks/full-size/');
$image_folders[] = array('name' => 'Robot Profile Templates', 'path' => 'templates/profiles/clean/');
$image_folders[] = array('name' => 'Robot Profile Templates (w/ Text)', 'path' => 'templates/profiles/with-text/');
$image_folders[] = array('name' => 'Misc Template Images', 'path' => 'templates/misc/');

// Require the global gallery generators
require('../../pages/gallery.php');

/*
// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">

        ....

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
require('../../html.php');


?>