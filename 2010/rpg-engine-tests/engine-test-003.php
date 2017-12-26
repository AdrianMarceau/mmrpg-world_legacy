<?php
/*
 * Filename : engine-text-003.php
 * Title    :
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 18, 2009
 *
 * Description:
 *
 */

// Require the top file
require_once('apptop.php');

// Require the database connect function & everything else
require_once("{$FUNCTIONROOT}database_connect.php");
require_once("{$CLASSROOT}ability.class.php");
require_once("{$CLASSROOT}robot.class.php");
require_once("{$CLASSROOT}android.class.php");
require_once("{$INCLUDESROOT}define_types.php");
require_once("{$INCLUDESROOT}define_abilities.php");

// Require the top files
require('../../config.php');
require('../../apptop.php');

// Define the headers for this file
$html_title_text = 'RPG Engine Tests 003/004 | '.$html_title_text;
$html_content_title = $html_content_title.' | RPG Engine Tests 003/004';
$html_content_description = 'Several different engines were written to test the feasibility of a PHP-based Mega Man RPG.  This is the third of those tests.';

// Define robot names to loop through
$robot_index = array();
$robot_index['rock'] = 'Rock';
$robot_index['roll'] = 'Roll';
$robot_index['megaman'] = 'Mega Man';
$robot_index['cutman'] = 'Cut Man';
$robot_index['gutsman'] = 'Guts Man';
$robot_index['iceman'] = 'Ice Man';
$robot_index['bombman'] = 'Bomb Man';
$robot_index['fireman'] = 'Fire Man';
$robot_index['elecman'] = 'Elec Man';
$robot_index['timeman'] = 'Time Man';
$robot_index['oilman'] = 'Oil Man';

// Start the ouput buffer to collect content
ob_start();

    foreach ($robot_index AS $robot_token => $robot_name){
        $level = mt_rand(1, 100);
        $life_energy = mt_rand(10, 125);
        $weapon_energy = mt_rand(10, 125);
        ?>
        <div class="battle_wrap">
            <table class="robot_stat_bar">
                <colgroup>
                    <col width="60" />
                    <col width="50" />
                    <col width="" />
                    <col width="50" />
                </colgroup>
                <tbody>
                    <tr>
                        <td rowspan="3" width="60"><img src="images/robot_mugs/<?= $robot_token ?>_mug.png" class="mug" alt="<?= $robot_token ?> mug" /></td>
                        <td colspan="2" class="robot_name"><?= $robot_name ?></td>
                        <td class="robot_level">Lv.<?= $level ?></td>
                    </tr>
                    <tr>
                        <td class="label">LE</td>
                        <td class="bar"><img src="images/gui/energy_bar_left_cap.gif" /><img src="images/gui/energy_bar_middle.gif" width="<?= $life_energy ?>" height="15" /><img src="images/gui/energy_bar_right_cap.gif" /></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="label">WE</td>
                        <td class="bar"><img src="images/gui/energy_bar_left_cap.gif" /><img src="images/gui/energy_bar_middle.gif" width="<?= $weapon_energy ?>" height="15" /><img src="images/gui/energy_bar_right_cap.gif" /></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?
    }

// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();


// Start the ouput buffer to collect styles
ob_start();

    ?>
    <style type="text/css">
        .wrapper {
            display: block;
        }
        .wrapper:after {
            content: "";
            display: block;
            clear: both;
            float: none;
            height: 0;
        }
        .battle_wrap {
            margin: 0 20px 20px 0;
            width: auto;
            float: left;
        }
        table.robot_stat_bar {
            table-layout: fixed;
            border-collapse: collapse;
            border: 2px solid #DEDEDE;
            margin: 0;
            background: #FAFAFA;
            width: 300px;
        }
        table.robot_stat_bar tr {
            border: 1px dotted green;
        }
        table.robot_stat_bar td {
            vertical-align: middle;
            padding: 0;
            border: 1px dotted red;
            text-align: center;
        }
        table.robot_stat_bar img.mug {
            margin: 2px;
            border: 1px solid #DEDEDE;
            width: 50px;
            height: 50px;
        }
        table.robot_stat_bar td.robot_name {
            color: #767676;
            font-weight: bold;
            font-size: 14px;
            text-align: left;
        }
        table.robot_stat_bar td.robot_level {
            color: #767676;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
        }
        table.robot_stat_bar td.label {
            color: #767676;
            font-weight: bold;
            font-size: 11px;
            text-align: center;
            padding: 5px;
        }
        table.robot_stat_bar td.bar {
            text-align: left;
        }
    </style>
    <?

// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();

// Require the page template
require('../../html.php');

?>