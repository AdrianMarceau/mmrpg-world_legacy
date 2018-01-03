<?php
/*
 * Filename : engine-test-002.php
 * Title	:
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 10, 2009
 *
 * Description:
 *
 */

// Require the top file
require_once('apptop.php');

// Define the function for using the display text of an ability
function display_action_usetext($ability, $user, $target) {
  // Evaluate the use text
  $string = '';
  eval('$string .= "<b>$ability->ability_name</b> : '.$ability->ability_text_usetext.'<br />\r\n";');
  return $string;
}

// Require the database connect function & everything else
require_once("{$FUNCTIONROOT}database_connect.php");
require_once("{$CLASSROOT}ability.class.php");
require_once("{$CLASSROOT}robot.class.php");
require_once("{$CLASSROOT}android.class.php");
require_once("{$INCLUDESROOT}define_types.php");
require_once("{$INCLUDESROOT}define_abilities.php");

// Create a new android (Rock)
$user_request = isset($_GET['user']) && preg_match('/^[-_a-z0-9]+$/i', $_GET['user']) ? $_GET['user'] : 'DLN-001R';
$user = new android($type_library);
$user->load_robot($user_request);
$user->load_profile(10, $ability_library);

// Create a new android (Roll)
$target_request = isset($_GET['target']) && preg_match('/^[-_a-z0-9]+$/i', $_GET['target']) ? $_GET['target'] : 'DLN-002';
$target = new android($type_library);
$target->load_robot($target_request);
$target->load_profile(10, $ability_library);

// If the user and target weren't defined, redirect
if (empty($_GET['user']) || empty($_GET['target'])){
  $redirect = ROOTURL.'engine-test-002.php';
  $redirect .= '?user='.$user_request;
  $redirect .= '&target='.$target_request;
  header('Location: '.$redirect);
  exit();
}

// Define the headers for this HTML page
$html->addTitle('RPG Engine Tests')->addTitle('Robot Profiles');
$html->setContentDescription(
    'Several small battle engine tests and components were written to gauge the feasibility of a PHP-based Mega Man RPG. '.
    'This is the second of those early tests. '
    );

// Start the ouput buffer to collect content
ob_start();

  // Print out the guy
  $typelibrary_printout = "<h4>Type Library</h4>\r\n<pre style=\"font-size: 90%;\">\r\n".print_r($type_library, true)."\r\n</pre>\r\n";
  $abilitylibrary_printout = "<h4>Ability Library</h4>\r\n<pre style=\"font-size: 90%;\">\r\n".print_r($ability_library, true)."\r\n</pre>\r\n";

  $ability_usetext = "<h4>Ability UseText</h4>\r\n<div style=\"font-size: 90%;\">\r\n";
  // Loop through all abilities and display the usetext for each of them
  foreach ($ability_library AS $ability) {
  	// Have the user attack the target
    $ability_usetext .= display_action_usetext($ability, $user, $target);
  }
  $ability_usetext .= "\r\n</div>\r\n";

  $user_printout = print_android($user, $type_library, true);
  $target_printout = print_android($target, $type_library, true);

  // Create a function for printing a robot's profile
  function print_android($android, $type_library, $return = false) {
    $html = '';
    // Display Header
    $html .= "<h4>{$android->info_active['name']}<sup>Lv.{$android->profile_active['LV']}</sup></h4>\r\n";
    // Display Image
    $html .= "<img class=\"android\" src=\"images/robot_profiles/{$android->info_active['name_clean']}_profile.png\" alt=\"{$android->info_active['name']}\" />\r\n";
    // Display Info
    $html .= "<span class=\"infobar\"><label>Name</label><span>{$android->info_active['name']}<sup>[{$android->info_active['gender']}]</sup></span></span>\r\n";
    $html .= "<span class=\"infobar\"><label>Serial</label><span>{$android->info_active['serial']}</span></span>\r\n";
    $html .= "<span class=\"infobar\"><label>Class</label><span>{$android->info_active['robot_class']}</span></span>\r\n";
    // Display Main Stats
    $energy_percent = ceil(($android->stats_active['life_energy'] / 1) * 100); $energy_bar = ceil(($energy_percent/100) * 74);//$energy_percent * 2;
    $ammo_percent = ceil(($android->stats_active['weapon_energy'] / 1) * 100); $ammo_bar = ceil(($ammo_percent/100) * 74);//$ammo_percent * 2;
    $recovery_percent = ceil(($android->stats_active['recovery'] / 1) * 100); $recovery_bar = ceil(($recovery_percent/100) * 74);//$recovery_percent * 2;
    $speed_percent = ceil(($android->stats_active['speed'] / 1) * 100); $speed_bar = ceil(($speed_percent/100) * 74);//$speed_percent * 2;
    $html .= "<span class=\"statbar\"><label>Energy</label><span style=\"width: {$energy_bar}%;\">{$energy_percent}%</span></span>\r\n";
    $html .= "<span class=\"statbar\"><label>Recovery</label><span style=\"width: {$recovery_bar}%;\">{$recovery_percent}%</span></span>\r\n";
    $html .= "<span class=\"statbar\"><label>Speed</label><span style=\"width: {$speed_bar}%;\">{$speed_percent}%</span></span>\r\n";
    $html .= "<span class=\"statbar\"><label>Ammo</label><span style=\"width: {$ammo_bar}%;\">{$ammo_percent}%</span></span>\r\n";
    // Loop through all the attack stats and display them
    foreach ($type_library AS $typeinfo)
    {
    	$attack_percent = ceil(($android->stats_active['attack'][$typeinfo['code']] / 2) * 100); $attack_bar = ceil(($attack_percent/100) * 74);
      //$html .= "<span class=\"statbar\"><label>Atk<sup>[".strtoupper($typeinfo['code'])."]</sup></label><span style=\"width: {$attack_bar}%;\">".($attack_percent > 0 ? "{$attack_percent}%" : '&nbsp;')."</span></span>\r\n";
      $html .= "<span class=\"statbar\"><label>Atk<sup>[".strtoupper($typeinfo['code'])."]</sup></label>".($attack_percent > 0 ? "<span style=\"width: {$attack_bar}%;\">{$attack_percent}%</span>" : '&nbsp;')."</span>\r\n";
    }
    // Loop through all the defense stats and display them
    foreach ($type_library AS $typeinfo)
    {
      $defense_percent = ceil(((2 - $android->stats_active['defense'][$typeinfo['code']]) / 2) * 100); $defense_bar = ceil(($defense_percent/100) * 74);
      //$html .= "<span class=\"statbar\"><label>Dfn<sup>[".strtoupper($typeinfo['code'])."]</sup></label><span style=\"width: {$defense_bar}%;\">".($defense_percent > 0 ? "{$defense_percent}%" : '&nbsp;')."</span></span>\r\n";
      $html .= "<span class=\"statbar\"><label>Dfn<sup>[".strtoupper($typeinfo['code'])."]</sup></label>".($defense_percent > 0 ? "<span style=\"width: {$defense_bar}%;\">{$defense_percent}%</span>" : '&nbsp;')."</span>\r\n";
    }
    //$html .= "<pre>\r\n".print_r($android, true)."</pre>\r\n";
    if ($return) { return $html; }
    else { echo $html; }
  }

  // Generate the actual poge markup
  ?>
  <table>
    <colgroup>
      <col width="40%" />
      <col width="20%" />
      <col width="40%" />
    </colgroup>
    <thead>
      <tr>
        <th class="thead" width="350">User Robot</th>
        <th class="thead">Ability Usetext</th>
        <th class="thead" width="350">Target Robot</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><div class="android_profile"><?= $user_printout ?></div></td>
        <td><?= $ability_usetext ?></td>
        <td><div class="android_profile"><?= $target_printout ?></div></td>
      </tr>
    </tbody>
  </table>
  <?

// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();
$html->addContentMarkup($html_content_markup);

// Start the ouput buffer to collect content
ob_start();

  ?>
  <style type="text/css">
    table {
      border-collapse: collapse;
      margin: 0 auto;
      width: 100%;
    }
    th.thead {
      border: 4px solid #464646;
      border-style: none solid;
      background: #646464;
      color: #FFF;
      padding: 6px;
    }
    td {
      vertical-align: top;
      padding: 10px;
    }
    td .android_profile {
      display: block;
      padding: 5px;
      font-family: Arial;
      text-align: center;
      background-color: #DEDEDE;
      border-right: 4px solid #EFEFEF;
      border-left: 4px solid #CBCBCB;
    }
    td .android_profile h4 {
      display: block;
      margin: 0;
      text-align: center;
      color: #646464;
      font-size: 15pt;
      padding: 5px;
      background-color: #EDEDED;
      border: 2px solid #CBCBCB;
    }
    td .android_profile h4 sup {
      font-size: 50%;
      display: inline-block;
      margin-left: 10px;
    }
    td .android_profile img.android {
      display: block;
      margin: 20px auto;
    }
    td .android_profile span.infobar {
      display: block;
      text-align: left;
      color: #646464;
      font-size: 13pt;
    }
    td .android_profile span.infobar label {
      display: inline-block;
      padding: 2px;
      width: 20%;
      margin: 1px;
      background-color: #EDEDED;
      border: 2px solid #CBCBCB;
      text-align: center;
    }
    td .android_profile span.infobar span {
      display: inline-block;
      padding: 2px;
      width: 74%;
      margin: 1px;
      background-color: #EDEDED;
      border: 2px solid #CBCBCB;
      text-align: center;
    }
    td .android_profile span.infobar span sup {
      font-size: 50%;
      display: inline-block;
      margin-left: 10px;
    }

    td .android_profile span.statbar {
      display: block;
      text-align: left;
      color: #646464;
      font-size: 8pt;
    }
    td .android_profile span.statbar label {
      display: inline-block;
      padding: 1px;
      width: 20%;
      margin: 1px;
      background-color: #F0E1EE;
      border: 2px solid #D0A0C9;
      text-align: center;
    }
    td .android_profile span.statbar span {
      display: inline-block;
      padding: 2px;
      width: 74%;
      margin: 1px;
      background-color: #8f57ae;
      border: 2px solid #533d6c;
      text-align: left;
      color: #FFF;
    }
    td .android_profile span.statbar label sup {
      font-size: 70%;
      display: inline-block;
      margin-left: 4px;
    }

  </style>
  <?

// Collect styles from the ouput buffer
$html_styles_markup = ob_get_clean();
$html->addStyleMarkup($html_styles_markup);

// Print out the final HTML page markup
$html->printHtmlPage();

?>
