<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop.root.php');

// Define the headers for this HTML page
$html->addTitle('RPG Roleplay Forum')->addTitle('Robot Attack Ideas');
$html->setContentDescription(
    'One of the first ideas for the Mega Man RPG revolved around a play-by-post forum game with '.
    'premade mechanics and abilities.  Here are some of the planned abilities: '
    );

// Read the contents of the ability document
$robot_ability_file = LEGACY_MMRPG_ROOT_DIR.'2006/rpg-roleplay-tests/documents/EveryRobot.txt';
$robot_ability_list = file_exists($robot_ability_file) ? file($robot_ability_file) : array();

// If not empty, loop through each line of file and group into robots
if (!empty($robot_ability_list)){

    // Group lines into robots using empty line as deliminator
    $raw_ability_list = $robot_ability_list;
    $robot_ability_list = array();
    $robot_text = array();
    foreach ($raw_ability_list AS $k => $l){
        $l = trim($l);
        if (!empty($l)){
            $robot_text[] = $l;
        } else {
            $robot_ability_list[] = $robot_text;
            $robot_text = array();
        }
    }

}

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">
        <?
        // Loop through and print out robot blocks
        if (!empty($robot_ability_list)){
            foreach ($robot_ability_list AS $key => $details){

                // Print out this robot block
                echo('<div class="block robot">'.PHP_EOL);
                    echo('<strong class="name">#'.str_pad(($key + 1), 2, '0', STR_PAD_LEFT).' '.$details[0].'</strong>'.PHP_EOL);
                    echo('<ul class="sublist">'.PHP_EOL);
                        echo('<li class="subitem">'.$details[1].'</li>'.PHP_EOL);
                        echo('<li class="subitem">'.$details[2].'</li>'.PHP_EOL);
                        echo('<li class="subitem">'.$details[3].'</li>'.PHP_EOL);
                    echo('</ul>'.PHP_EOL);
                echo('</div>'.PHP_EOL);

            }
        } else {

            // Print out an empty robot block
            echo('<div class="block robot">'.PHP_EOL);
                echo('- no robots count be found -'.PHP_EOL);
            echo('</div>'.PHP_EOL);

        }
        ?>
    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();
$html->addContentMarkup($html_content_markup);

// Start the ouput buffer to collect styles
ob_start();
    ?>
    <style type="text/css">
        .block.robot {
            display: block;
            background-color: #333333;
            float: left;
            box-sizing: border-box;
            margin: 0 10px 10px 0;
            width: 32%;
            width: calc(33.33% - 10px);
            padding: 9px 12px;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            border-radius: 6px;
        }
    </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);

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