<?php
/*
 * Filename : html_generators.php
 * Title	:
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : Jul 5, 2009
 *
 * Description:
 *
 */

// Create function for displaying the robot intro box
function generate_robot_intro_box($robotinfo)
{
  // Create the variable to hold the generated HTML
  $html = '';
  // Generate the robot into box
  $html .= "<div class=\"sprite_box\"><img src=\"images/character_profiles/$robotinfo[robot_code]_100x100.png\" width=\"100\" height=\"100\" alt=\"$robotinfo[robot_name]\" /></div>\r\n";
  $html .= "<div class=\"sprite_name\">$robotinfo[robot_name]</div>\r\n";
  $html .= "<div class=\"sprite_stats\">{$robotinfo['robot_max_le']} LE / Lv. $robotinfo[robot_level]</div>\r\n";
  // Return the generated HTML
  return $html;
}

// Create function for displaying the robot status box
function generate_robot_status_box($robotinfo)
{
  // Determine the robot stat colour
  $stat_colour = '#646464';
  $le_percent = $robotinfo['robot_current_le'] == 0 ? 0 : round(($robotinfo['robot_current_le']/$robotinfo['robot_max_le'])*100);
  if ($le_percent >= 50) { $stat_colour = '#646464';  }
  elseif ($le_percent <= 49 && $le_percent >= 20) { $stat_colour = '#CC9900'; }
  elseif ($le_percent <= 19 && $le_percent >= 1) { $stat_colour = '#990000'; }
  elseif ($le_percent <= 0) { $stat_colour = '#CACACA'; }
  // Determine the action text
  $action_text = '';
  if ($robotinfo['robot_status'] == 'knocked-out') { $action_text = '[knocked-out]'; }
  else { $action_text = "[$robotinfo[robot_action]]"; }
  // Create the variable to hold the generated HTML
  $html = '';
  // Generate the robot into box
  $html .= "<div class=\"sprite_name\">$robotinfo[robot_name]</div>\r\n";
  $html .= "<div class=\"sprite_box\"><img class=\"$robotinfo[robot_status]\" src=\"images/character_profiles/$robotinfo[robot_code]_60x60.png\" width=\"60\" height=\"60\" alt=\"$robotinfo[robot_name]\" /></div>\r\n";
  $html .= "<div class=\"sprite_stats\" style=\"color: $stat_colour;\">$robotinfo[robot_current_le] / $robotinfo[robot_max_le] LE</div>\r\n";
  $html .= "<div class=\"sprite_action\">$action_text</div>\r\n";
  // Return the generated HTML
  return $html;
}

// Create function for displaying the team intro box area
function generate_team_intro_box($player)
{
  // Find how many robots there are
  $robots = $player['player_number'] == 1 ? array_reverse($player['player_robots']) : $player['player_robots'];
  $num_robots = count($robots);
  $column_width = round(300 / $num_robots);
  $orientation = $player['player_number'] == 1 ? 'left' : 'right';
  $colour = $player['player_number'] == 1 ? 'blue' : 'red';
  // Create the variable to hold the generated HTML
  $html = '';
  //$html .= "<div style=\"margin: 0; padding: 0; background: transparent url(images/team_intro_background_{$colour}.png) scroll no-repeat top center;\">\r\n";
  $html .= "<table class=\"player_box\" >\r\n";
  $html .= "<tr>\r\n";
    $avatar_row = "<td class=\"{$orientation}\"><div class=\"avatar\"><img src=\"images/avatars/$player[player_avatar_filename]\" alt=\"$player[player_name]\" /></div></td>\r\n";
    $info_row = "<td class=\"{$orientation}\"><div class=\"name\">$player[player_name]</div><div class=\"info\">$player[player_clear_points] POINTS</div></td>\r\n";
    if ($player['player_number'] == 1)
    {
    	$html .= $avatar_row;
      $html .= $info_row;
    }
    elseif ($player['player_number'] == 2)
    {
      $html .= $info_row;
      $html .= $avatar_row;
    }
  $html .= "</tr>\r\n";
  $html .= "</table>";
  // Create the team box table
  $html .= "<table class=\"team_box\" style=\"height: 135px; background: transparent url(images/team_intro_box_{$colour}.png) scroll no-repeat top center;\">\r\n";
  $html .= "<tbody class=\"team_row\">\r\n";
  $html .= "<tr>\r\n";
    // Loop through each robot and display a column for them
    foreach ($robots AS $robotinfo)
    {
      $html .= "<td width=\"$column_width\">\r\n";
      $html .= generate_robot_intro_box($robotinfo);
      $html .= "</td>\r\n";
    }
  $html .= "</tr>\r\n";
  $html .= "</tbody>\r\n";
  $html .= "</table>";
  $html .= "</div>\r\n";
  // Return the generated HTML
  return $html;
}

// Create function for displaying the team status box area
function generate_team_status_box($playerinfo)
{
  // Find how many robots there are
  $colour = $playerinfo['player_number'] == 1 ? 'blue' : 'red';
  $robots = $playerinfo['player_number'] == 1 ? array_reverse($playerinfo['player_robots']) : $playerinfo['player_robots'];
  //$robot_status = '';
  $num_robots = count($robots);
  $column_width = round(300 / $num_robots);
  // Create the variable to hold the generated HTML
  $html = '';
  // Create the team box table
  $html .= "<table class=\"team_box\" style=\"height: 135px; background: transparent url(images/team_intro_box_{$colour}.png) scroll no-repeat top center;\">\r\n";
  $html .= "<tbody>\r\n";
  $html .= "<tr>\r\n";
    // Loop through each robot and display a column for them
    foreach ($robots AS $robotinfo)
    {
      if (!$robots) { continue; }
      $html .= "<td width=\"$column_width\">\r\n";
      $html .= generate_robot_status_box($robotinfo);
      $html .= "</td>\r\n";
    }
  $html .= "</tr>\r\n";
  $html .= "</tbody>\r\n";
  $html .= "</table>";
  // Return the generated HTML
  return $html;
}

// Create function for displaying the turn header bar
function generate_turn_header_bar($turn_number, $current_display_state)
{
  // Create text for the html bar
  $class_text = $current_display_state == 'show' ? 'hide' : 'show';
  $link_text = $current_display_state == 'show' ? 'Hide' : 'Show';
  // Create the variable to hold the generated HTML
  $html = '';
  // Create the turn header bar turn_bar_show_3
  $html .= "<table class=\"turn_header\">\r\n";
  $html .= "<tr>\r\n";
  $html .= "<td width=\"200\" class=\"left\">\r\n";
  $html .= "<div class=\"$class_text\"><a href=\"javascript:;\" onclick=\"javascript:toggle_display('turn_body_{$turn_number}');toggle_display('turn_bar_{$class_text}_{$turn_number}');toggle_display('turn_bar_{$current_display_state}_{$turn_number}');\">$link_text Turn #$turn_number</a></div>\r\n";
  $html .= "</td>\r\n";
  $html .= "<td width=\"300\" class=\"turn_title_$class_text\">\r\n";
  $html .= "<a href=\"javascript:;\" onclick=\"javascript:toggle_display('turn_body_{$turn_number}');toggle_display('turn_bar_{$class_text}_{$turn_number}');toggle_display('turn_bar_{$current_display_state}_{$turn_number}');\">".($current_display_state == 'show' ? 'START OF ' : 'SHOW ')."TURN #$turn_number</a>\r\n";
  $html .= "</td>\r\n";
  $html .= "<td width=\"200\" class=\"right\">\r\n";
  $html .= "<div class=\"$class_text\"><a href=\"javascript:;\" onclick=\"javascript:toggle_display('turn_body_{$turn_number}');toggle_display('turn_bar_{$class_text}_{$turn_number}');toggle_display('turn_bar_{$current_display_state}_{$turn_number}');\">$link_text Turn #$turn_number</a></div>\r\n";
  $html .= "</td>\r\n";
  $html .= "</tr>\r\n";
  $html .= "</table>\r\n";
  // Return the generated HTML
  return $html;
}

// Create the function for generating the turn footer bar

// Create function for displaying the turn footer bar
function generate_turn_footer_bar($turn_number)
{
  // Create the variable to hold the generated HTML
  $html = '';
  // Create the turn header bar
  $html .= "<table class=\"turn_footer\">\r\n";
  $html .= "<tr>\r\n";
  $html .= "<td width=\"200\" class=\"left\">\r\n";
  $html .= "<div>&nbsp;</div>\r\n";
  $html .= "</td>\r\n";
  $html .= "<td width=\"300\" class=\"turn_title\">\r\n";
  $html .= "End of Turn #$turn_number\r\n";
  $html .= "</td>\r\n";
  $html .= "<td width=\"200\" class=\"right\">\r\n";
  $html .= "<div><a onclick=\"javascript:window.scrollTo(0, 0);\">^ Top</a></div>\r\n";
  $html .= "</td>\r\n";
  $html .= "</tr>\r\n";
  $html .= "</table>\r\n";
  // Return the generated HTML
  return $html;
}

// Create the function for generating an event "Shout Box"
function generate_event_shout_box($eventinfo)
{
  // Pull the playerinfo into a separate array
  $playerinfo = $eventinfo['player_info'];
  $colour = $playerinfo['player_number'] == 1 ? 'blue' : 'red';
  // Create the variable to hold the generated HTML
  $html = '';
  // Create the actual shout box table
  $html .= "<table class=\"event_shout_box\" style=\"height: 82px; background: transparent url(images/shout_box_{$colour}.png) scroll no-repeat center center;\">\r\n";
  // Display on the left if this is player 1
  if ($playerinfo['player_number'] == 1)
  {
    // Add the avatar colum
    $html .= "<tr>\r\n";
    $html .= "<td class=\"player_info\" rowspan=\"3\" width=\"100\">\r\n";
    $html .= "<img src=\"images/avatars/{$playerinfo['player_avatar_filename']}\" class=\"player_avatar\" alt=\"{$playerinfo['player_name']}\" />\r\n";
    $html .= "</td>\r\n";
    // Add the actual text column
    $html .= "<td class=\"shout_text_top\" width=\"500\" style=\"border-right-style: none;\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"shout_text_middle\" width=\"500\">\r\n";
    $html .= "<span class=\"title\"><strong>{$playerinfo['player_name']}</strong> says :</span>\r\n";
    $html .= "<span class=\"text\">{$eventinfo['shout_text']}</span>\r\n";
    $html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
    $html .= "</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"shout_text_bottom\" width=\"500\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
  }
  // Otherwise, display on the right if it's player number 2
  if ($playerinfo['player_number'] == 2)
  {
    // Add the actual text column
    $html .= "<tr>\r\n";
    $html .= "<td class=\"shout_text_top\" width=\"500\">&nbsp;</td>\r\n";
    // Add the avatar colum
    $html .= "<td class=\"player_info\" rowspan=\"3\" width=\"100\">\r\n";
    $html .= "<img src=\"images/avatars/{$playerinfo['player_avatar_filename']}\" class=\"player_avatar\" alt=\"{$playerinfo['player_name']}\" />\r\n";
    $html .= "</td>\r\n";
    // Finish the rest of the text columns
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"shout_text_middle\" width=\"500\">\r\n";
    $html .= "<span class=\"title\"><strong>{$playerinfo['player_name']}</strong> says :</span>\r\n";
    $html .= "<span class=\"text\">{$eventinfo['shout_text']}</span>\r\n";
    $html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
    $html .= "</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"shout_text_bottom\" width=\"500\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
  }
  // Finalize the actual shout box table
  $html .= "</table>\r\n";
  // And now return the generated HTML
  return $html;
}


// Create the function for generating an event "Ability Box"
function generate_event_ability_box($eventinfo)
{
  // Pull the playerinfo into a separate array
  $playerinfo = $eventinfo['player_info'];
  $robotinfo = $eventinfo['ability_user'];
  // Create the variable to hold the generated HTML
  $html = '';
  // Create the actual shout box table
  $html .= "<table class=\"event_ability_box\" style=\"height: 110px; background: transparent url(images/ability_background_".($playerinfo['player_number'] == 1 ? 'blue' : 'red').".png) scroll no-repeat center center;\">\r\n";
  // Display on the left if this is player 1
  if ($playerinfo['player_number'] == 1)
  {
    // Add the avatar colum
    $html .= "<tr>\r\n";
    $html .= "<td class=\"robot_info\" rowspan=\"3\" width=\"140\">\r\n";
    $html .= "<div class=\"robot_avatar\">\r\n";
    $html .= "<img src=\"images/character_profiles/{$robotinfo['robot_code']}_100x100.png\" class=\"robot_avatar\" alt=\"{$robotinfo['robot_name']}\" />\r\n";
    $html .= "</div>\r\n";
    $html .= "</td>\r\n";
    // Add the actual text column
    $html .= "<td class=\"ability_text_top\" width=\"140\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"ability_text_middle\" width=\"260\">\r\n";
    $html .= "<span class=\"title\"><strong>{$robotinfo['robot_name']}</strong> ".($eventinfo['ability_class'] == 'offensive' ? 'attacks!' : 'defends.')."</span>\r\n";
    $html .= "<span class=\"ability\"  title=\"".strtoupper($eventinfo['ability_type'])." Type\" style=\"background: transparent url(images/type_backgrounds/background_{$eventinfo['ability_type']}.png) repeat-x center center;\"><img class=\"type_icon\" src=\"images/type_icons/{$eventinfo['ability_type']}_icon_25x25.png\" title=\"".strtoupper($eventinfo['ability_type'])." Type\" /><strong>{$eventinfo['ability_name']}</strong><em>{$eventinfo['ability_power']}</em></span>\r\n";
    //$html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
    $html .= "</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"ability_text_bottom\" width=\"140\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
    //images/blue_gradient_30_inverted.gif
  }
  // Otherwise, display on the right if it's player number 2
  if ($playerinfo['player_number'] == 2)
  {
    // Add the actual text column
    $html .= "<tr>\r\n";
    $html .= "<td class=\"ability_text_top\" width=\"140\">&nbsp;</td>\r\n";
    // Add the avatar colum
    $html .= "<td class=\"robot_info\" rowspan=\"3\" width=\"140\">\r\n";
    $html .= "<div class=\"robot_avatar\">\r\n";
    $html .= "<img src=\"images/character_profiles/{$robotinfo['robot_code']}_100x100.png\" class=\"robot_avatar\" alt=\"{$robotinfo['robot_name']}\" />\r\n";
    $html .= "</div>\r\n";
    $html .= "</td>\r\n";
    // Finish the rest of the text columns
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"ability_text_middle\" width=\"260\">\r\n";
    $html .= "<span class=\"title\"><strong>{$robotinfo['robot_name']}</strong> ".($eventinfo['ability_class'] == 'offensive' ? 'attacks!' : 'defends.')."</span>\r\n";
    $html .= "<span class=\"ability\" title=\"".strtoupper($eventinfo['ability_type'])." Type\" style=\"background: transparent url(images/type_backgrounds/background_{$eventinfo['ability_type']}.png) repeat-x center center;\"><img class=\"type_icon\" src=\"images/type_icons/{$eventinfo['ability_type']}_icon_25x25.png\" title=\"".strtoupper($eventinfo['ability_type'])." Type\" /><strong>{$eventinfo['ability_name']}</strong><em>{$eventinfo['ability_power']}</em></span>\r\n";
    //$html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
    $html .= "</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"ability_text_bottom\" width=\"140\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
    //images/red_gradient_30_inverted.gif
  }
  // Finalize the actual shout box table
  $html .= "</table>\r\n";
  // And now return the generated HTML
  return $html;
}

// Create the function for generating an event "Ability Impact Box"
function generate_event_ability_impact_box($eventinfo)
{
  // Pull the playerinfo into a separate array
  $playerinfo = $eventinfo['target_player'];
  $robotinfo = $eventinfo['ability_target'];
  // Create the variable to hold the generated HTML
  $html = '';
  // Create the actual shout box table
  $html .= "<table class=\"event_ability_impact_box\" style=\"height: 60px; background: transparent url(images/impact_background_".($playerinfo['player_number'] == 1 ? 'blue' : 'red').".png) scroll no-repeat center center;\">\r\n";
  // Display on the left if this is player 1
  if ($playerinfo['player_number'] == 1)
  {
    // Add the avatar colum
    $html .= "<tr>\r\n";
    $html .= "<td class=\"robot_info\" rowspan=\"3\" width=\"90\">\r\n";
    $html .= "<div class=\"robot_avatar\">\r\n";
    $html .= "<img src=\"images/character_profiles/{$robotinfo['robot_code']}_60x60.png\" class=\"robot_avatar\" alt=\"{$robotinfo['robot_name']}\" />\r\n";
    $html .= "</div>\r\n";
    $html .= "</td>\r\n";
    // Add the actual text column
    $html .= "<td class=\"impact_text_top\" width=\"100\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"impact_text_middle\" width=\"100\">\r\n";
    $html .= "<span class=\"title\"><strong>{$robotinfo['robot_name']}</strong> is hit!</span>\r\n";
    $html .= "<span class=\"impact\">{$eventinfo['ability_impact']} LE</span>\r\n";
    //$html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
    $html .= "</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"impact_text_bottom\" width=\"100\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
  }
  // Otherwise, display on the right if it's player number 2
  if ($playerinfo['player_number'] == 2)
  {
    // Add the actual text column
    $html .= "<tr>\r\n";
    $html .= "<td class=\"impact_text_top\" width=\"100\">&nbsp;</td>\r\n";
    // Add the avatar colum
    $html .= "<td class=\"robot_info\" rowspan=\"3\" width=\"90\">\r\n";
    $html .= "<div class=\"robot_avatar\">\r\n";
    $html .= "<img src=\"images/character_profiles/{$robotinfo['robot_code']}_60x60.png\" class=\"robot_avatar\" alt=\"{$robotinfo['robot_name']}\" />\r\n";
    $html .= "</div>\r\n";
    $html .= "</td>\r\n";
    // Finish the rest of the text columns
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"impact_text_middle\" width=\"100\">\r\n";
    $html .= "<span class=\"title\"><strong>{$robotinfo['robot_name']}</strong> is hit!</span>\r\n";
    $html .= "<span class=\"impact\">{$eventinfo['ability_impact']} LE</span>\r\n";
    //$html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
    $html .= "</td>\r\n";
    $html .= "</tr>\r\n";
    $html .= "<tr>\r\n";
    $html .= "<td class=\"impact_text_bottom\" width=\"100\">&nbsp;</td>\r\n";
    $html .= "</tr>\r\n";
  }
  // Finalize the actual shout box table
  $html .= "</table>\r\n";
  // And now return the generated HTML
  return $html;
}

//// Create the function for generating an event "Ability Box"
//function generate_event_ability_box($eventinfo)
//{
//  // Pull the playerinfo into a separate array
//  $playerinfo = $eventinfo['player_info'];
//  $robotinfo = $eventinfo['ability_user'];
//  // Create the variable to hold the generated HTML
//  $html = '';
//  // Create the actual shout box table
//  $html .= "<table class=\"event_ability_box\">\r\n";
//  // Display on the left if this is player 1
//  if ($playerinfo['player_number'] == 1)
//  {
//    // Add the avatar colum
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"robot_info\" rowspan=\"3\" width=\"140\" style=\"border-right-style: none; background: #FFF url(images/blue_gradient_30.gif) repeat-x top left;\">\r\n";
//    $html .= "<div class=\"robot_avatar\">\r\n";
//    $html .= "<img src=\"images/character_profiles/{$robotinfo['robot_code']}_100x100.png\" class=\"robot_avatar\" alt=\"{$robotinfo['robot_name']}\" />\r\n";
//    $html .= "</div>\r\n";
//    $html .= "</td>\r\n";
//    // Add the actual text column
//    $html .= "<td class=\"ability_text_top\" width=\"400\" style=\"border-right-style: none;\">&nbsp;</td>\r\n";
//    $html .= "</tr>\r\n";
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"ability_text_middle\" width=\"260\" style=\"border-left-style: none; background: #FFF url(images/blue_gradient_30.gif) repeat-x top left;\">\r\n";
//    $html .= "<span class=\"title\"><strong>{$robotinfo['robot_name']}</strong> ".($eventinfo['ability_class'] == 'offensive' ? 'attacks!' : 'defends.')."</span>\r\n";
//    $html .= "<span class=\"ability\" style=\"background: transparent url(images/type_backgrounds/background_{$eventinfo['ability_type']}.png) repeat-x center center;\"><img class=\"type_icon\" src=\"images/type_icons/{$eventinfo['ability_type']}_icon_25x25.png\" alt=\"".strtoupper($eventinfo['ability_type'])." Type\" title=\"".strtoupper($eventinfo['ability_type'])." Type\" /><strong>{$eventinfo['ability_name']}</strong><em>{$eventinfo['ability_power']}</em></span>\r\n";
//    //$html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
//    $html .= "</td>\r\n";
//    $html .= "</tr>\r\n";
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"ability_text_bottom\" width=\"400\" style=\"border-right-style: none;\">&nbsp;</td>\r\n";
//    $html .= "</tr>\r\n";
//    //images/blue_gradient_30_inverted.gif
//  }
//  // Otherwise, display on the right if it's player number 2
//  if ($playerinfo['player_number'] == 2)
//  {
//    // Add the actual text column
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"ability_text_top\" width=\"400\" style=\"border-left-style: none;\">&nbsp;</td>\r\n";
//    // Add the avatar colum
//    $html .= "<td class=\"robot_info\" rowspan=\"3\" width=\"140\" style=\"border-left-style: none; background: #FFF url(images/red_gradient_30.gif) repeat-x top left;\">\r\n";
//    $html .= "<div class=\"robot_avatar\">\r\n";
//    $html .= "<img src=\"images/character_profiles/{$robotinfo['robot_code']}_100x100.png\" class=\"robot_avatar\" alt=\"{$robotinfo['robot_name']}\" />\r\n";
//    $html .= "</div>\r\n";
//    $html .= "</td>\r\n";
//    // Finish the rest of the text columns
//    $html .= "</tr>\r\n";
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"ability_text_middle\" width=\"260\" style=\"border-right-style: none; background: #FFF url(images/red_gradient_30.gif) repeat-x top left;\">\r\n";
//    $html .= "<span class=\"title\"><strong>{$robotinfo['robot_name']}</strong> ".($eventinfo['ability_class'] == 'offensive' ? 'attacks!' : 'defends.')."</span>\r\n";
//    $html .= "<span class=\"ability\" style=\"background: transparent url(images/type_backgrounds/background_{$eventinfo['ability_type']}.png) repeat-x center center;\"><img class=\"type_icon\" src=\"images/type_icons/{$eventinfo['ability_type']}_icon_25x25.png\" alt=\"".strtoupper($eventinfo['ability_type'])." Type\" title=\"".strtoupper($eventinfo['ability_type'])." Type\" /><strong>{$eventinfo['ability_name']}</strong><em>{$eventinfo['ability_power']}</em></span>\r\n";
//    //$html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
//    $html .= "</td>\r\n";
//    $html .= "</tr>\r\n";
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"ability_text_bottom\" width=\"400\" style=\"border-left-style: none;\">&nbsp;</td>\r\n";
//    $html .= "</tr>\r\n";
//    //images/red_gradient_30_inverted.gif
//  }
//  // Finalize the actual shout box table
//  $html .= "</table>\r\n";
//  // And now return the generated HTML
//  return $html;
//}

//// Create the function for generating an event "Ability Impact Box"
//function generate_event_ability_impact_box($eventinfo)
//{
//  // Pull the playerinfo into a separate array
//  $playerinfo = $eventinfo['target_player'];
//  $robotinfo = $eventinfo['ability_target'];
//  // Create the variable to hold the generated HTML
//  $html = '';
//  // Create the actual shout box table
//  $html .= "<table class=\"event_ability_impact_box\">\r\n";
//  // Display on the left if this is player 1
//  if ($playerinfo['player_number'] == 1)
//  {
//    // Add the avatar colum
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"robot_info\" rowspan=\"3\" width=\"90\" style=\"border-right-style: none; background: #FFF url(images/blue_gradient_30.gif) repeat-x top left;\">\r\n";
//    $html .= "<div class=\"robot_avatar\">\r\n";
//    $html .= "<img src=\"images/character_profiles/{$robotinfo['robot_code']}_60x60.png\" class=\"robot_avatar\" alt=\"{$robotinfo['robot_name']}\" />\r\n";
//    $html .= "</div>\r\n";
//    $html .= "</td>\r\n";
//    // Add the actual text column
//    $html .= "<td class=\"impact_text_top\" width=\"100\" style=\"border-right-style: none;\">&nbsp;</td>\r\n";
//    $html .= "</tr>\r\n";
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"impact_text_middle\" width=\"100\" style=\"border-left-style: none; background: #FFF url(images/blue_gradient_30.gif) repeat-x top left;\">\r\n";
//    $html .= "<span class=\"title\"><strong>{$robotinfo['robot_name']}</strong> is hit!</span>\r\n";
//    $html .= "<span class=\"impact\">{$eventinfo['ability_impact']} LE</span>\r\n";
//    //$html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
//    $html .= "</td>\r\n";
//    $html .= "</tr>\r\n";
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"impact_text_bottom\" width=\"100\" style=\"border-right-style: none;\">&nbsp;</td>\r\n";
//    $html .= "</tr>\r\n";
//  }
//  // Otherwise, display on the right if it's player number 2
//  if ($playerinfo['player_number'] == 2)
//  {
//    // Add the actual text column
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"impact_text_top\" width=\"100\" style=\"border-left-style: none;\">&nbsp;</td>\r\n";
//    // Add the avatar colum
//    $html .= "<td class=\"robot_info\" rowspan=\"3\" width=\"90\" style=\"border-left-style: none; background: #FFF url(images/red_gradient_30.gif) repeat-x top left;\">\r\n";
//    $html .= "<div class=\"robot_avatar\">\r\n";
//    $html .= "<img src=\"images/character_profiles/{$robotinfo['robot_code']}_60x60.png\" class=\"robot_avatar\" alt=\"{$robotinfo['robot_name']}\" />\r\n";
//    $html .= "</div>\r\n";
//    $html .= "</td>\r\n";
//    // Finish the rest of the text columns
//    $html .= "</tr>\r\n";
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"impact_text_middle\" width=\"100\" style=\"border-right-style: none; background: #FFF url(images/red_gradient_30.gif) repeat-x top left;\">\r\n";
//    $html .= "<span class=\"title\"><strong>{$robotinfo['robot_name']}</strong> is hit!</span>\r\n";
//    $html .= "<span class=\"impact\">{$eventinfo['ability_impact']} LE</span>\r\n";
//    //$html .= "<span class=\"date\">".date('Y/m/d H:i:s', $eventinfo['event_time'])."</span>\r\n";
//    $html .= "</td>\r\n";
//    $html .= "</tr>\r\n";
//    $html .= "<tr>\r\n";
//    $html .= "<td class=\"impact_text_bottom\" width=\"100\" style=\"border-left-style: none;\">&nbsp;</td>\r\n";
//    $html .= "</tr>\r\n";
//  }
//  // Finalize the actual shout box table
//  $html .= "</table>\r\n";
//  // And now return the generated HTML
//  return $html;
//}

?>
