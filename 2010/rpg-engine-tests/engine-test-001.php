<?php
/*
 * Filename : engine-test-001.php
 * Title	:
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 10, 2009
 *
 * Description:
 *
 */

// Require the top file
require_once('apptop.php');

// Require necessary files
require_once('functions/database_connect.php');

// Create the robot class
class robot {

  // Define the active and base variables
  protected $profile_active, $profile_base, $type_active, $type_base, $stats_active, $stats_base;

  // -- Constructor -- //

  // Create the robot, populating it's properties
  function robot($robot_profile, $robot_type, $robot_stats) {
  	$this->profile_active = $this->profile_base = $robot_profile;
    $this->type_active = $this->type_base = $robot_type;
    $this->stats_active = $this->stats_base = $robot_stats;
  }

  // -- Active Variables -- //

  // Return the robot's active profile (all, name, level, etc.)
  function get_active_profile($request = 'all') {
    switch ($request) {
      case 'name': case 'level': case 'life': case 'gender': case 'serial': {
        return $this->profile_active[$request];
        break;
      }
      case 'all': default: {
        return $this->profile_active;
        break;
      }
    }
  }

  // Return the robot's active type (all, code or name)
  function get_active_type($request = 'all') {
  	switch ($request) {
  		case 'code': case 'name': {
        return $this->type_active[$request];
        break;
      }
      case 'all': default: {
      	return $this->type_active;
        break;
      }
  	}
  }

  // Return the robot's active stats (all, energy, recovery, etc.)
  function get_active_stats($request = 'all', $request2 = false) {
  	switch ($request) {
  		case 'energy': case 'recovery': case 'speed': {
  			return $this->stats_active[$request];
        break;
  		}
      case 'attack': case 'defense': {
      	if ($request2 == false) { return false; break; }
        return $this->stats_active[$request][$request2];
        break;
      }
      case 'all': default: {
        return $this->stats_active;
        break;
      }
  	}
  }

  // -- Base Variables -- //

  // Return the robot's base profile (all, name, level, etc.)
  function get_base_profile($request = 'all') {
    switch ($request) {
      case 'name': case 'level': case 'life':  {
        return $this->profile_base[$request];
        break;
      }
      case 'all': default: {
        return $this->profile_base;
        break;
      }
    }
  }

  // Return the robot's base type (all, code or name)
  function get_base_type($request = 'all') {
    switch ($request) {
      case 'code': case 'name': {
        return $this->type_base[$request];
        break;
      }
      case 'all': default: {
        return $this->type_base;
        break;
      }
    }
  }

  // Return the robot's base stats (all, energy, recovery, etc.)
  function get_base_stats($request = 'all', $request2 = false) {
    switch ($request) {
      case 'energy': case 'recovery': case 'speed': {
        return $this->stats_base[$request];
        break;
      }
      case 'attack': case 'defense': {
        if ($request2 == false) { return false; break; }
        return $this->stats_base[$request][$request2];
        break;
      }
      case 'all': default: {
        return $this->stats_base;
        break;
      }
    }
  }

}

// Require the top files
require('../../config.php');
require('../../apptop.php');

// Define the headers for this file
$html_title_text = 'RPG Engine Tests 001/004 | '.$html_title_text;
$html_content_title = $html_content_title.' | RPG Engine Tests 001/004';
$html_content_description = 'Several different engines were written to test the feasibility of a PHP-based Mega Man RPG.  This is the first of those tests.';

// Start the ouput buffer to collect content
ob_start();

  // Pull all the types from the database and create am array for each of 'em
  echo "Creating types...<br />\r\n";
  $query_result = database_connect("SELECT * FROM robot_types ORDER BY type_id ASC");
  $robot_types = array();
  while ($typeinfo = mysql_fetch_array($query_result))
  {
    echo "Creating $typeinfo[type_name] type.<br />\r\n";
    $robot_types[$typeinfo['type_id']] = array('id' => $typeinfo['type_id'], 'name' => $typeinfo['type_name'], 'code' => $typeinfo['type_code']);
  }
  @mysql_free_result($query_result);
  echo "Types have been collected.<br />\r\n";

  // Pull all the robots from the database and create objects from each of them
  echo "Creating robots...<br />\r\n";
  $query_result = database_connect("SELECT * FROM robot_details ORDER BY robot_id ASC");
  $robot_characters = array();
  while ($robotinfo = mysql_fetch_array($query_result)) {
    // First create the faux profile
    $this_profile = array();
    $this_profile['name'] = $robotinfo['robot_name'];
    $this_profile['gender'] = $robotinfo['robot_gender'];
    $this_profile['serial'] = $robotinfo['robot_serial'];
    $this_profile['pronoun'] = $robotinfo['robot_gender'] == 'male' ? 'he' : ($robotinfo['robot_gender'] == 'female' ? 'she' : 'it');
    $this_profile['pronoun_possesive'] = $robotinfo['robot_gender'] == 'male' ? 'his' : ($robotinfo['robot_gender'] == 'female' ? 'her' : 'its');
    $this_profile['level'] = $this_profile['life'] = false;
    // Then create the main stats
    $this_stats = array();
    $this_stats['energy'] = $robotinfo['robot_energy'];
    $this_stats['recovery'] = $robotinfo['robot_recovery'];
    $this_stats['speed'] = $robotinfo['robot_speed'];
    // Create arrays for attack and defense
    $this_stats['attack'] = array();
    $this_stats['defense'] = array();
    // Loop through all types collecting the attack and defense for each
    foreach ($robot_types AS $typeinfo) {
      $this_stats['attack']["$typeinfo[code]"] = $robotinfo["robot_attack_$typeinfo[code]"];
      $this_stats['defense']["$typeinfo[code]"] = $robotinfo["robot_defense_$typeinfo[code]"];
    }
    // Create the new robot object now that everything is ready
    $robot_characters[] = new robot($this_profile, $robot_types[$robotinfo['robot_type']], $this_stats);
    echo "Created a character!<br />";
  }
  @mysql_free_result($query_result);


  // Display each of the robot character objects
  foreach ($robot_characters AS $i => $charinfo)
  {
    // Print the character info
    echo "<h4>Robot #$i - ".$charinfo->get_active_profile('name')."</h4>\r\n<pre>\r\n".print_r($charinfo, true)."\r\n</pre>\r\n";
  }


// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();

// Require the page template
require('../../html.php');


?>
