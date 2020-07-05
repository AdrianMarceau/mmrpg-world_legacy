<?php

// Define image folders if not already set
if (empty($image_folders) || !is_array($image_folders)){ $image_folders = array(); }

// Define paths if not already set
if (empty($image_base_dir) || !is_string($image_base_dir)){ $image_base_dir = $this->root_dir; }
if (empty($image_base_url) || !is_string($image_base_url)){ $image_base_url = $this->root_url; }

// Define a function for collecting gallery images
function get_directory_images($base_dir){
    $file_list = file_exists($base_dir) && is_dir($base_dir) ? scandir($base_dir) : array();
    if (empty($file_list)){ return $file_list; }
    natcasesort($file_list);
    $image_list = array();
    foreach ($file_list AS $key => $name){
        if ($name === '.' || $name === '..'){ continue; }
        elseif (!preg_match('/\.(jpg|jpeg|png|gif)$/i', $name)){ continue; }
        $image_list[] = $name;
    }
    return $image_list;
}

// Generate and print out image gallery markup
?>
<div class="wrapper image-gallery">

    <?
    // If not empty, loop through folders and generate markup
    if (!empty($image_folders)){
        foreach ($image_folders AS $folder_key => $folder_info){

            // Print out opening section wrapper
            echo('<div class="section">'.PHP_EOL);

                // Generate the current folder's paths
                $folder_base_dir = $image_base_dir.$folder_info['path'];
                $folder_base_url = $image_base_url.$folder_info['path'];
                $rel_path = '/'.trim(str_replace($this->root_url, '', $folder_base_url), '/').'/';

                // Print out the section headers
                echo('<div class="header">'.PHP_EOL);
                    echo('<h2>'.$folder_info['name'].'</h2>'.PHP_EOL);
                    echo('<p class="pre">'.$rel_path.'</p>'.PHP_EOL);
                echo('</div>'.PHP_EOL);

                // Scan this folder and loop through any images that exist
                $folder_image_files = get_directory_images($folder_base_dir);
                if (!empty($folder_image_files)){

                    // Print out opening content wrappers
                    echo('<div class="content"><ul class="list gallery'.(!empty($gallery_class) ? ' '.$gallery_class : '').'">'.PHP_EOL);

                        // Loop through the folder images to display them
                        foreach ($folder_image_files AS $image_key => $image_name){

                            // Define the full image URL
                            $image_src = $folder_base_url.$image_name;

                            // Print out opening list item
                            echo('<li class="item">'.PHP_EOL);

                                // Print out the name for this item
                                echo('<strong class="name">'.$image_name.'</strong>'.PHP_EOL);

                                // Print out the name for this item
                                $wrap_with_link = !empty($folder_info['link']) ? true : false;
                                if ($wrap_with_link){ echo('<a class="image-link" href="'.$image_src.'" target="_blank">'.PHP_EOL); }
                                echo('<img class="image" src="'.$image_src.'" alt="'.$image_name.'" />'.PHP_EOL);
                                if ($wrap_with_link){ echo('</a>'.PHP_EOL); }

                            // Print out closing list item
                            echo('</li>'.PHP_EOL);

                        }

                    // Print out closing content wrappers
                    echo('</ul></div>'.PHP_EOL);

                } else {
                    echo('<div class="block section">'.PHP_EOL);
                        echo('<span class="error">Image files count not be found at <span class="pre">'.$rel_path.'</span></span>'.PHP_EOL);
                    echo('</div>'.PHP_EOL);
                }

            // Print out closing section wrapper
            echo('</div>'.PHP_EOL);

        }
    } else {
        echo('<div class="block section">'.PHP_EOL);
            $rel_path = '/'.trim(str_replace($this->root_url, '', $image_base_url), '/').'/';
            echo('<span class="error">Image directories were not defined! Unable to generate gallery!</span>'.PHP_EOL);
        echo('</div>'.PHP_EOL);
    }
    ?>

</div>