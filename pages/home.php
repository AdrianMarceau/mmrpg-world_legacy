<?php

// Define a variable to say yes, this is home
define('IS_LEGACY_INDEX', true);

// Update this page's content variables
$html_title_text = 'Archive Index | '.$html_title_text;
$html_content_title = $html_content_title.' | Archive Index';
$html_content_description = 'Below, please find a collection of tests, experiments, screenshots, assets, and legacy versions of the MMRPG from over the years.';

// Manually define content to display on this index
$legacy_content = array();

// Year 2006
$legacy_content['2006'] = array();
$legacy_content['2006'][] = array(
    'name' => 'RPG Roleplay Forum',
    'paths' => array(
        'rpg-roleplay-tests/misc-images.php' => array('images'),
        'rpg-roleplay-tests/robot-attacks.php' => array('text')
        )
    );


// Start the output buffer to collect markup
ob_start();

    // Loop through legacy content and display links
    foreach($legacy_content AS $year => $items){

        // Print out opening section wrapper
        echo('<div class="section">'.PHP_EOL);

            // Print out the section headers
            echo('<div class="header">'.PHP_EOL);
                echo('<h2>'.$year.' Content</h2>'.PHP_EOL);
            echo('</div>'.PHP_EOL);

            // Print out opening content wrappers
            echo('<div class="content"><ul class="list">'.PHP_EOL);

                // Loop through links and display as list items
                foreach($items AS $key => $item){

                    // Print out opening list item
                    echo('<li class="item">'.PHP_EOL);

                        // Print out the name for this item
                        echo('<strong class="name">'.$item['name'].'</strong>'.PHP_EOL);

                        // Loop through paths and print out each link
                        echo('<ul class="sublist">'.PHP_EOL);
                        foreach ($item['paths'] AS $path => $content){
                            if (strstr($path, '?todo')){ $path = str_replace('?todo', '', $path); $todo = true; }
                            else { $todo = false; }
                            $full_url = $year.'/'.$path;
                            $display_url = str_replace(array('/index.php', '.php'), '', $full_url);
                            echo('<li class="subitem'.($todo ? ' todo' : '').'">'.PHP_EOL);
                                echo('<a class="link" href="'.$mmrpg_root_url.$full_url.'">/'.$display_url.'</a>'.PHP_EOL);
                                if (empty($content)){ $content_text = 'unknown'; }
                                elseif (count($content) == 1 && $content[0] == 'text'){ $content_text = 'text-only'; }
                                else { $content_text = implode(' + ', $content); }
                                $content_text = preg_replace('/(playable|interactive)/', '<strong>$1</strong>', $content_text);
                                echo('<span class="details">'.$content_text.'</span>');
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

// Collect generated content markup
$html_content_markup = ob_get_clean();


?>