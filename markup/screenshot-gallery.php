<?

// Define the headers for this HTML page
$html->addTitle('Prototype Screenshots')->addTitle('Screenshots '.$this_year_code);
$html->setContentDescription(
    'Miscellaneous screenshots of the Mega Man RPG taken during development sometime in the year '.$this_year.': '
    );

// Define the base directory and URL
$image_base_dir = LEGACY_MMRPG_ROOT_DIR.$this_year.'/'.$this_dir.'/screenshots/';
$image_base_url = LEGACY_MMRPG_ROOT_URL.$this_year.'/'.$this_dir.'/screenshots/';

// Find all the screenshots folders in this dir
$raw_image_folders = scandir($image_base_dir);
$raw_image_folders = array_filter($raw_image_folders, function($d){ return (substr($d, -1, 1) !== '.') ? true : false; });
sort($raw_image_folders);
//$raw_image_folders = array_reverse($raw_image_folders);

// Loop through and generate proper image folder data for display
$image_folders = array();
foreach ($raw_image_folders AS $folder_key => $folder_name){
    list($yyyy, $mm, $dd) = explode('/', preg_replace('/^([0-9]{4})([0-9]{2})([0-9]{2})$/i', '$1/$2/$3', $folder_name));
    $date_string = date('F jS, Y', mktime(0, 0, 0, $mm, $dd, $yyyy));
    $image_folders[] = array('name' => 'Screenshots from '.$date_string, 'path' => $folder_name.'/', 'link' => true);
}

// Add a gallery section to the HTML page
$html->addContentGallery($image_folders, $image_base_dir, $image_base_url, 'screenshots');

// Print out the final HTML page markup
$html->printHtmlPage();

?>