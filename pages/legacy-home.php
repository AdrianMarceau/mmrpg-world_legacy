<?php

// Update this page's content variables
//$html->addSeoTitle('Archive Index');
//$html->addContentTitle('Archive Index');
$html->setContentDescription(
    'Legacy builds, experiments, screenshots, assets, and concept art for the Mega Man RPG.  '.
    'Basically, any old and/or scrapped ideas for the RPG will end up here eventually. '
    );

// Pull an index of legacy content categories
$legacy_categories = $db->getArrayList("SELECT
    categories.category_id,
    categories.category_token,
    categories.category_name,
    categories.category_description,
    categories.category_is_published,
    categories.category_order
    FROM legacy_content_categories AS categories
    WHERE
    categories.category_is_published = 1
    ORDER BY
    categories.category_order ASC,
    categories.category_token ASC
    ;", 'category_id');

// Pull an index of legacy content from the database
$legacy_content = array();
$legacy_content_raw = $db->getArrayList("SELECT
    content.content_id,
    content.category_id,
    content.content_group,
    content.content_name,
    content.content_path,
    content.content_description,
    content.content_year,
    content.content_month,
    content.content_has_text,
    content.content_has_images,
    content.content_has_sprites,
    content.content_has_artwork,
    content.content_is_interactive,
    content.content_is_playable,
    content.content_is_todo
    FROM legacy_content AS content
    LEFT JOIN legacy_content_categories AS categories ON categories.category_id = content.category_id
    ORDER BY
    content.category_id ASC,
    content.content_year DESC,
    content.content_month DESC,
    content.content_group ASC,
    content.content_path DESC
    ;", 'content_id');

// Loop through and nest legacy content by category and group
if (!empty($legacy_content_raw)){
    foreach ($legacy_content_raw AS $content_id => $content_info){
        $category_id = $content_info['category_id'];
        $group_name = $content_info['content_group'];
        if (!isset($legacy_content[$category_id])){ $legacy_content[$category_id] = array(); }
        if (!isset($legacy_content[$category_id][$group_name])){ $legacy_content[$category_id][$group_name] = array(); }
        $legacy_content[$category_id][$group_name][] = $content_info;
    }
}


// Start the output buffer to collect markup
ob_start();

    // Loop through legacy categories to display sections
    foreach($legacy_categories AS $category_id => $category_info){

        // Print out opening section wrapper
        echo('<div class="section">'.PHP_EOL);

            // Print out the section headers
            echo('<div class="header">'.PHP_EOL);
                echo('<h2>'.$category_info['category_name'].'</h2>'.PHP_EOL);
                echo('<p>'.$category_info['category_description'].'</p>'.PHP_EOL);
            echo('</div>'.PHP_EOL);

            // Print out opening content wrappers
            echo('<div class="content"><ul class="list">'.PHP_EOL);

                // Predefine an empty content group name
                $group_name = '';

                // Loop through group items in this category (if any) and list them below
                $this_legacy_content = isset($legacy_content[$category_id]) ? $legacy_content[$category_id] : array();
                foreach($this_legacy_content AS $content_group_name => $content_group_items){

                    // Print out opening list item
                    echo('<li class="item">'.PHP_EOL);

                        // Print out the name for this item
                        echo('<div class="title">'.PHP_EOL);
                            echo('<strong class="name">'.$content_group_name.'</strong>'.PHP_EOL);
                            //$content_year = !empty($content_group_items[0]['content_year']) ? $content_group_items[0]['content_year'] : false;
                            //$content_month = !empty($content_group_items[0]['content_month']) ? $content_group_items[0]['content_month'] : false;
                            //if (!empty($content_month)){ $date_text = date('F', mktime(0, 0, 0, $content_month, 1, $content_year)).' '.$content_year; }
                            //else { $date_text = $content_year; }
                            //echo('<span class="date">('.$date_text.')</span>'.PHP_EOL);
                            //echo('<span class="date">('.$content_year.')</span>'.PHP_EOL);
                        echo('</div>'.PHP_EOL);

                        // Loop through paths and print out each link
                        echo('<ul class="sublist">'.PHP_EOL);
                        foreach ($content_group_items AS $content_key => $content_info){

                            // Define string var for content classes
                            $content_classes = '';

                            // Define flag vars for boolean triggers
                            $flag_todo = !empty($content_info['content_is_todo']) ? true : false;

                            // Generate the URL vars based on path and year
                            $full_url = $content_info['content_year'].'/'.$content_info['content_path'];
                            $display_url = str_replace(array('/index.php', '.php'), '', $full_url);
                            $link_url = str_replace('/index.php', '/', $full_url);

                            // Collect the display ame
                            $display_name = $content_info['content_name'];

                            // Generate the date text for this piece of content
                            $year = !empty($content_info['content_year']) ? $content_info['content_year'] : false;
                            $month = !empty($content_info['content_month']) ? $content_info['content_month'] : false;
                            if (!empty($month)){ $date_text = date('F', mktime(0, 0, 0, $month, 1, $year)).' '.$year; }
                            //if (!empty($month)){ $date_text = date('F', mktime(0, 0, 0, $month, 1, $year)); }
                            else { $date_text = $year; }

                            // Check if file exists and update flags/classes
                            if (!file_exists(LEGACY_MMRPG_ROOT_DIR.$full_url)){ $flag_todo = true; }
                            if ($flag_todo == true){ $content_classes .= ' todo'; }

                            // Define what types of content this item has
                            $content_types = array();
                            foreach ($content_info AS $key => $val){
                                if (strstr($key, 'content_is_') || strstr($key, 'content_has_')){
                                    $key2 = str_replace(array('content_is_', 'content_has_'), '', $key);
                                    if (!empty($val)){ $content_types[] = $key2; }
                                }
                            }

                            // Generate the content type text to be displayed
                            if (empty($content_types)){ $content_type_text = 'unknown'; }
                            elseif (count($content_types) == 1 && $content_types[0] == 'text'){ $content_type_text = 'text-only'; }
                            else { $content_type_text = implode(' + ', $content_types); }
                            $content_type_text = preg_replace('/(playable|interactive)/', '<strong>$1</strong>', $content_type_text);

                            // Print the markup for this item with details
                            echo('<li class="subitem'.$content_classes.'">'.PHP_EOL);
                                //echo('<a class="link" href="'.LEGACY_MMRPG_ROOT_URL.$link_url.'" target="_blank">/'.$display_url.'</a>'.PHP_EOL);
                                echo('<a class="link" href="'.LEGACY_MMRPG_ROOT_URL.$link_url.'" target="_blank">'.$display_name.'</a>'.PHP_EOL);
                                echo('<span class="details date">'.$date_text.'</span>'.PHP_EOL);
                                echo('<span class="details types">'.$content_type_text.'</span>'.PHP_EOL);
                            echo('</li>'.PHP_EOL);

                        }
                        echo('</ul>'.PHP_EOL);

                    // Print out closing list item
                    echo('</li>'.PHP_EOL);

                }

            // Print out closing content wrappers
            echo('</ul></div>'.PHP_EOL);

        // Print out closing section wrapper
        echo('</div>'.PHP_EOL);

    }

//echo('<hr />'.PHP_EOL);
//echo('<pre>$legacy_categories = '.print_r($legacy_categories, true).'</pre>'.PHP_EOL);
//echo('<pre>$legacy_content = '.print_r($legacy_content, true).'</pre>'.PHP_EOL);
//exit();

// Collect generated content markup
$html_content_markup = ob_get_clean();
$html->addContentMarkup($html_content_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>