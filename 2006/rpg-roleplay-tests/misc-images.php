<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Define the headers for this HTML page
$html->addTitle('RPG Roleplay Forum')->addTitle('Misc Game Images');
$html->setContentDescription(
    'One of the first ideas for the Mega Man RPG revolved around a play-by-post forum game '.
    'with premade mechanics and abilities.  Here are some of those ability images: '
    );

// Define the base directory and URL
$image_base_dir = LEGACY_MMRPG_ROOT_DIR.'2006/rpg-roleplay-tests/';
$image_base_url = LEGACY_MMRPG_ROOT_URL.'2006/rpg-roleplay-tests/';

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

// Add a gallery section to the HTML page
$html->addContentGallery($image_folders, $image_base_dir, $image_base_url);

// Print out the final HTML page markup
$html->printHtmlPage();

?>