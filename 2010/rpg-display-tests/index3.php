<?php

// Require the root config and top files
$root_path = preg_replace('/^(.*?(?:\\\|\/))(?:19|20)[0-9]{2}(?:\\\|\/)[-a-z0-9]+(?:\\\|\/)(.*?)$/i', '$1', __FILE__);
require_once($root_path.'includes/apptop-root.php');

// Define the headers for this HTML page
$html->addTitle('RPG Display Tests')->addTitle('Battle Layout Template #3');
$html->setContentDescription(
    'Several different layouts for a browser-based Mega Man RPG were experimented with during development. '.
    'This is the last of the early battle system layouts. '
    );

// Require the application top
require_once('application_top3.php');

// Require the different function libraries
require_once('functions/html_generators.php');
require_once('functions/template_functions.php');

// Require the mock-data
require_once('mock-data.php');

// Start the ouput buffer to collect content
ob_start();
    ?>
    <div class="wrapper">

        <div id="page">

            <h2>MegaMan Powered Up RPG</h2>
            <h3>Play-by-Post Text-Adventure Role-Playing Game (PBBG)</h3>
            <h1>Battle Layout Template #3</h1>

            <table id="battle">
            <thead>
            <tr>
            <td class="container_row">
                <table class="battle_header">
                <tr>
                <td class="team_box_container" width="300">
                    <?= generate_team_intro_box($players[1]) ?>
                </td>
                <td class="vs_box_container" width="100">
                    <div class="vs_box"><img src="images/vs_text.png" /></div>
                </td>
                <td class="team_box_container" width="300">
                    <?= generate_team_intro_box($players[2]) ?>
                </td>
                </tr>
                </table>
            </td>
            </tr>
            </thead>
            <?
                // Loop through and display a few rows of turns just for display testing
                foreach ($turns AS $i => $turninfo)
                {
                    // Display a header bar of the current state
                    echo "<tbody class=\"turn_bar_body\" id=\"turn_bar_{$turninfo['turn_display_state']}_{$turninfo['turn_number']}\">\r\n";
                    echo "<tr>\r\n";
                    echo "<td class=\"container_row\">\r\n";
                    echo generate_turn_header_bar($turninfo['turn_number'], $turninfo['turn_display_state']);
                    echo "</td>";
                    echo "</tr>\r\n";
                    echo "</tbody>\r\n";

                    // Display a header bar, hidden, of the opposite state
                    $inverted_display_state = $turninfo['turn_display_state'] == 'show' ? 'hide' : 'show';
                    echo "<tbody class=\"turn_bar_body\" id=\"turn_bar_{$inverted_display_state}_{$turninfo['turn_number']}\" style=\"display: none;\">\r\n";
                    echo "<tr>\r\n";
                    echo "<td class=\"container_row\">\r\n";
                    echo generate_turn_header_bar($turninfo['turn_number'], $inverted_display_state);
                    echo "</td>";
                    echo "</tr>\r\n";
                    echo "</tbody>\r\n";

                    // Start the table body block for this turn
                    echo "<tbody class=\"turn_body\" id=\"turn_body_{$turninfo['turn_number']}\" ".($turninfo['turn_display_state'] == 'show' ? " style=\"display: table-row-group;\"" : " style=\"display: none;\"").">\r\n";

                    // If this turn is showing, display any events
                    if (true)
                    {
                        // Loop through the events and show them
                        foreach ($turninfo['turn_events'] AS $eventnumber => $eventinfo)
                        {
                            // Display the container row
                            echo "<tr>\r\n";
                            echo "<td class=\"container_row\">\r\n";
                            // Display the event container
                            echo "<div class=\"event\">\r\n";

                            // Display the actual event
                            if ($eventinfo['event_type'] == 'shout')
                            {
                                // Display a shout box with the given information
                                echo generate_event_shout_box($eventinfo);
                            }
                            elseif ($eventinfo['event_type'] == 'ability')
                            {
                                // Display a thin horizontal rule above this ability
                                echo "<hr style=\"width: 500px; height: 1px; color: #C7D8EA; background-color: #C7D8EA; border-style: none;\" />\r\n";
                                // Collect the html parts for the attacks
                                $html_ability_box = generate_event_ability_box($eventinfo);
                                $html_impact_boxes = array();
                                $target_player = $eventinfo['player_info']['player_number'] == 1 ? $players[2] : $players[1];
                                $num_target_robots = count($target_player['player_robots']);
                                $main_target = mt_rand(0, ($num_target_robots - 1));
                                foreach ($target_player['player_robots'] AS $key => $target_robotinfo)
                                {
                                    $rand_num = mt_rand(0, 10);
                                    if ($rand_num % 2 == 0 && $key != $main_target) { continue; }
                                    $impact_eventinfo = generate_new_turn_event($eventinfo['player_info'], 'ability_impact', time(), array('target_player' => $target_player, 'ability_target' => $target_robotinfo, 'ability_name' => $eventinfo['ability_name'], 'ability_impact' => '-'.$eventinfo['ability_power']));
                                    $html_impact_boxes[] = generate_event_ability_impact_box($impact_eventinfo);
                                }
                                // Display the event ability in a formatted table
                                switch ($eventinfo['player_info']['player_number'])
                                {
                                    // If this is player one, display the attack on the left
                                    case '1': case 1:
                                    {
                                        // Display the formatting table
                                        echo "<table class=\"invis\">\r\n";
                                        echo "<tr>\r\n";
                                        echo "<td width=\"400\" valign=\"top\">\r\n";
                                            // Display the ability box
                                            echo $html_ability_box;
                                        echo "</td>\r\n";
                                        echo "<td width=\"200\" align=\"right\">\r\n";
                                            // Display the impact boxes
                                            foreach ($html_impact_boxes AS $html_output)
                                            {
                                                echo $html_output;
                                            }
                                        echo "</td>\r\n";
                                        echo "</tr>\r\n";
                                        echo "</table>\r\n";
                                        break;
                                    }
                                    // If this is player two, display the attack on the right
                                    case '2': case 2:
                                    {
                                        // Display the formatting table
                                        echo "<table class=\"invis\">\r\n";
                                        echo "<tr>\r\n";
                                        echo "<td width=\"200\" align=\"left\">\r\n";
                                            // Display the impact boxes
                                            foreach ($html_impact_boxes AS $html_output)
                                            {
                                                echo $html_output;
                                            }
                                        echo "</td>\r\n";
                                        echo "<td width=\"400\" valign=\"top\">\r\n";
                                            // Display the ability box
                                            echo $html_ability_box;
                                        echo "</td>\r\n";
                                        echo "</tr>\r\n";
                                        echo "</table>\r\n";
                                        break;
                                    }
                                }
                                // Display a thin horizontal rule above this ability
                                echo "<hr style=\"width: 500px; height: 1px; color: #C7D8EA; background-color: #C7D8EA; border-style: none;\" />\r\n";
                            }
                            else
                            {
                                // Do nothing
                            }
                            // Display the closing tag for the event container
                            echo "</div>\r\n";
                            // And the closing tags for the container row
                            echo "</td>";
                            echo "</tr>\r\n";
                        }
                    }

                    // And now display a turn footer bar
                    echo "<tr>\r\n";
                    echo "<td class=\"container_row\">\r\n";
                    echo generate_turn_footer_bar($turninfo['turn_number']);
                    echo "</td>";
                    echo "</tr>\r\n";


                    // End the table body block for this turn
                    echo "</tbody>\r\n";
                }
            ?>
            <?
                // Make some stuff happen to the robots
                if (isset($players[1]['player_robots'][0]))
                {
                    $players[1]['player_robots'][0]['robot_current_le'] -= round($players[1]['player_robots'][0]['robot_max_le'] * 0.1);
                    $players[1]['player_robots'][0]['robot_status'] = 'ready';
                }
                if (isset($players[1]['player_robots'][1]))
                {
                    $players[1]['player_robots'][1]['robot_current_le'] = 0;
                    $players[1]['player_robots'][1]['robot_status'] = 'knocked-out';
                }
                if (isset($players[1]['player_robots'][2]))
                {
                    $players[1]['player_robots'][2]['robot_current_le'] -= round($players[1]['player_robots'][2]['robot_max_le'] * 0.63);
                }
                if (isset($players[2]['player_robots'][0]))
                {
                    $players[2]['player_robots'][0]['robot_current_le'] -= round($players[2]['player_robots'][0]['robot_max_le'] * 0.5);
                }
                if (isset($players[2]['player_robots'][1]))
                {
                    $players[2]['player_robots'][1]['robot_current_le'] = 0;
                    $players[2]['player_robots'][1]['robot_status'] = 'knocked-out';
                }
                if (isset($players[2]['player_robots'][2]))
                {
                    $players[2]['player_robots'][2]['robot_current_le'] -= round($players[2]['player_robots'][2]['robot_max_le'] * 0.98);
                }
            ?>
            <tfoot>
            <tr>
            <td class="container_row">
                <table class="battle_footer">
                <tr>
                <td class="team_box_container" width="300">
                    <?= generate_team_status_box($players[1]) ?>
                </td>
                <td class="vs_box_container" width="100">
                    <div class="vs_box"><img src="images/vs_text_smaller.png" /></div>
                </td>
                <td class="team_box_container" width="300">
                    <?= generate_team_status_box($players[2]) ?>
                </td>
                </tr>
                </table>
            </td>
            </tr>
            </tfoot>
            </table>

            <!-- Display the Robot Dropdowns -->
            <?
                // Generate the robot option dropdowns
                $robot_options = '';
                foreach ($robots AS $robotinfo) { $robot_options .= "<option value=\"{$robotinfo['robot_code']}\">{$robotinfo['robot_name']}</option>"; }
            ?>
            <div style="width: 90%; border: 2px solid #DEDEDE; background: #FFF; margin: 0 auto; text-align: center;">
                <form action="index3.php" method="get">
                <table class="invis">
                <tr>
                    <td width="300" align="center" valign="top">
                        <strong>Choose Player 1 Robots</strong><br />
                        Robot 1 : <select name="player1_robot1">
                        <?= str_replace("value=\"{$player1_robot1}\"", "value=\"{$player1_robot1}\" selected=\"selected\"", $robot_options) ?>
                        </select><br />
                        Robot 2 : <select name="player1_robot2">
                        <option value="none">- none -</option>
                        <?= str_replace("value=\"{$player1_robot2}\"", "value=\"{$player1_robot2}\" selected=\"selected\"", $robot_options) ?>
                        </select><br />
                        Robot 3 : <select name="player1_robot3">
                        <option value="none">- none -</option>
                        <?= str_replace("value=\"{$player1_robot3}\"", "value=\"{$player1_robot3}\" selected=\"selected\"", $robot_options) ?>
                        </select><br />
                    </td>
                    <td width="300" align="center" valign="top">
                        <strong>Choose Player 2 Robots</strong><br />
                        Robot 1 : <select name="player2_robot1">
                        <?= str_replace("value=\"{$player2_robot1}\"", "value=\"{$player2_robot1}\" selected=\"selected\"", $robot_options) ?>
                        </select><br />
                        Robot 2 : <select name="player2_robot2">
                        <option value="none">- none -</option>
                        <?= str_replace("value=\"{$player2_robot2}\"", "value=\"{$player2_robot2}\" selected=\"selected\"", $robot_options) ?>
                        </select><br />
                        Robot 3 : <select name="player2_robot3">
                        <option value="none">- none -</option>
                        <?= str_replace("value=\"{$player2_robot3}\"", "value=\"{$player2_robot3}\" selected=\"selected\"", $robot_options) ?>
                        </select><br />
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="middle" colspan="2">
                        <input type="submit" value="Generate"/><br />
                        <a href="index3.php">[reset]</a>
                    </td>
                </tr>
                </table>
                </form>
            </div>

        </div>

    </div>
    <?
// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();
$html->addContentMarkup($html_content_markup);

// Start the ouput buffer to collect styles
ob_start();
    ?>
        <link rel="stylesheet" type="text/css" href="styles/style.css.php" />
        <style type="text/css">

        </style>
    <?
// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);

// Start the ouput buffer to collect scripts
ob_start();
    ?>
    <script type="text/javascript" src="scripts/common_functions.js" ></script>
    <script type="text/javascript">

    </script>
    <?
// Collect scripts from the ouput buffer
$html_scripts_markup = ob_get_clean();
$html->addScriptMarkup($html_scripts_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>