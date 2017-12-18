<?php
/*
 * Filename : engine-text-003.php
 * Title	:
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 18, 2009
 *
 * Description:
 *
 */

// Require the top file
require_once('top.php');

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

// Start the ouput buffer to collect content
ob_start();

  ?>
  <table id="battle_screen_top">
    <tr>
      <td width="33%">
        <table class="robot_stat_bar">
          <tr>
            <td rowspan="3" width="60"><img src="images/robot_mugs/cutman_mug.png" class="mug" alt="cutman mug" /></td>
            <td colspan="2" class="robot_name">Cut Man</td>
            <td class="robot_level">Lv.13</td>
          </tr>
          <tr>
            <td class="label">LE</td>
            <td class="bar"><img src="images/gui/energy_bar_left_cap.gif" /><img src="images/gui/energy_bar_middle.gif" width="150" height="15" /><img src="images/gui/energy_bar_right_cap.gif" /></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="label">WE</td>
            <td class="bar"><img src="images/gui/energy_bar_left_cap.gif" /><img src="images/gui/energy_bar_middle.gif" width="90" height="15" /><img src="images/gui/energy_bar_right_cap.gif" /></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </td>
      <td width="33%">&nbsp;</td>
      <td width="33%">&nbsp;</td>
    </tr>
    <tr>
      <td class="battle_view" colspan="3">&nbsp;</td>
    </tr>
  </table>
  <?

// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();


// Start the ouput buffer to collect styles
ob_start();

  ?>
  <style type="text/css">
    #battle_screen_top {
      border-collapse: collapse;
      margin: 0 auto;
      width: 800px; min-width: 800px; max-width: 800px;
    }
    #battle_screen_top td {
      padding: 0;
    }
    table.robot_stat_bar {
      border-collapse: collapse;
      border: 2px solid #DEDEDE;
      margin: 2px;
      background: #FAFAFA;
      width: 100%;
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