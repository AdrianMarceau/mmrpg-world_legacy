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

// Year 2010
$legacy_content['2010'] = array();
$legacy_content['2010'][] = array(
    'name' => 'RPG Display Tests',
    'paths' => array(
        'rpg-display-tests/index1.php' => array('text', 'images'),
        'rpg-display-tests/index2.php' => array('text', 'images'),
        'rpg-display-tests/index3.php' => array('text', 'images', 'interactive')
        )
    );
$legacy_content['2010'][] = array(
    'name' => 'RPG Engine Tests',
    'paths' => array(
        'rpg-engine-tests/engine-test-001.php' => array('text'),
        'rpg-engine-tests/engine-test-002.php' => array('text', 'images'),
        'rpg-engine-tests/engine-test-004.php' => array('text')
        )
    );
$legacy_content['2010'][] = array(
    'name' => 'RPG iPhone Tests',
    'paths' => array(
        'rpg-iphone-tests/iphone-test.php' => array('text', 'images')
        )
    );

// Year 2011
$legacy_content['2011'] = array();
$legacy_content['2011'][] = array(
    'name' => 'RPG Prototype v0.1',
    'paths' => array(
        'rpg-prototype-2k11/index.php' => array('text', 'images', 'playable')
        )
    );

// Year 2012
$legacy_content['2012'] = array();
$legacy_content['2012'][] = array(
    'name' => 'RPG Battle Tests',
    'paths' => array(
        'rpg-battle-tests/loading.php' => array('text', 'images'),
        'rpg-battle-tests/loading2.php' => array('text', 'images'),
        'rpg-battle-tests/battle.php' => array('text', 'images', 'interactive'),
        'rpg-battle-tests/canvas.php' => array('text', 'images'),
        'rpg-battle-tests/canvas2.php' => array('text', 'images'),
        )
    );
$legacy_content['2012'][] = array(
    'name' => 'RPG Ability Generators',
    'paths' => array(
        'rpg-ability-tests/generator.php' => array('text'),
        'rpg-ability-tests/generator2.php' => array('text')
        )
    );
$legacy_content['2012'][] = array(
    'name' => 'RPG Prototype v0.2',
    'paths' => array(
        'rpg-prototype-2k12/index.php' => array('text', 'images', 'playable')
        )
    );

// Year 2013
$legacy_content['2013'] = array();
$legacy_content['2013'][] = array(
    'name' => 'RPG Animation Tests',
    'paths' => array(
        'rpg-prototype-sprites/index.php' => array('text', 'images', 'interactive')
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