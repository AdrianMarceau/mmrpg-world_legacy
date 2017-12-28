<?php
/*
 * Filename : robot.class.php
 * Title	: MegaMan RPG Engine - Robot Class
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 10, 2009
 *
 * Description:
 * This class is used for creating a robot object with base stats
 */

// Require the database connect function
require_once("{$FUNCTIONROOT}database_connect.php");
require_once("{$INCLUDESROOT}define_types.php");

// Create the robot class
class robot {

  // Define the active and base variables
  public $info_active, $info_base;
  public $stats_active, $stats_base;

  // Create internal-use variables
  protected $database_tables = array();
  protected $type_library;

  // -- Constructor -- //

  // Create the robot, populating it's properties
  function robot($type_library, $robot_info = false, $robot_stats = false) {

    // If any areas have been provided, automatically load them
    if ($robot_info) { $this->load_info_from_array($robot_info); }
    if ($robot_stats) { $this->load_stats_from_array($robot_stats); }

    // Set the default values for all the database tables
    $this->database_tables['robot_details'] = 'robot_details';
    $this->database_tables['robot_types'] = 'robot_types';
    $this->database_tables['robot_abilities'] = 'robot_abilities';
    $this->database_tables['robot_parts'] = 'robot_parts';

    // Pass on the type library
    $this->type_library = $type_library;

  }

  // -- Loading Functions -- //

  // Create the setup function used for setting-up the info
  function load_info_from_array($robot_info) {
    $this->info_active = $this->info_base = $robot_info;
  }

  // Create the setup function used for setting-up the stats
  function load_stats_from_array($robot_stats) {
    $this->stats_active = $this->stats_base = $robot_stats;
  }

  // Create the setup function used for assigning database variables
  function set_database_table($field, $value) {
  	$this->database_tables[$field] = $value;
  }

  // Create the setup function for automatically loading a robot base info
  function load_robot($robot_lookup) {

    // Check to whether we're searching by an ID or a serial
    if (is_numeric($robot_lookup)) { $robotinfo = mysql_fetch_array(database_connect("SELECT * FROM ".$this->database_tables['robot_details']." WHERE robot_id = '$robot_lookup'")); }
    else { $robotinfo = mysql_fetch_array(database_connect("SELECT * FROM ".$this->database_tables['robot_details']." WHERE robot_serial = '$robot_lookup'")); }

    // Pull all info information from the array
    $this->info_active['id'] = $this->info_base['id'] = !empty($robotinfo['robot_id']) ? $robotinfo['robot_id'] : 0; // Robot ID Number
    $this->info_active['name'] = $this->info_base['name'] = !empty($robotinfo['robot_name']) ? $robotinfo['robot_name'] : ''; // Robot Name
    $this->info_active['name_clean'] = $this->info_base['name_clean'] = !empty($robotinfo['robot_name_clean']) ? $robotinfo['robot_name_clean'] : ''; // Robot Name Clean
    $this->info_active['robot_class'] = $this->info_base['robot_class'] = !empty($robotinfo['robot_class']) ? $robotinfo['robot_class'] : ''; // Robot Class
    $this->info_active['serial'] = $this->info_base['serial'] = !empty($robotinfo['robot_serial']) ? $robotinfo['robot_serial'] : ''; // Robot Serial Number
    $this->info_active['type'] = $this->info_base['type'] = !empty($robotinfo['robot_type']) && isset($this->alltypes[$robotinfo['robot_type']]) ? $this->alltypes[$robotinfo['robot_type']] : ''; // Robot Type (Array)
    $this->info_active['gender'] = $this->info_base['gender'] = !empty($robotinfo['robot_gender']) ? $robotinfo['robot_gender'] : ''; // Robot [Assumed] Gender
    $this->info_active['pronoun'] = $this->info_base['pronoun'] = !empty($robotinfo['robot_gender']) && $robotinfo['robot_gender'] == 'female' ? 'she' : 'he'; // Robot Pronoun
    $this->info_active['possessive_pronoun'] = $this->info_base['possessive_pronoun'] = !empty($robotinfo['robot_gender']) && $robotinfo['robot_gender'] == 'female' ? 'her' : 'his'; // Robot Possesive Pronoun
    $this->info_active['abilities_raw'] = $this->info_base['abilities_raw'] = !empty($robotinfo['robot_abilities']) ? $robotinfo['robot_abilities'] : ''; // Robot Serial Number

    // Pull all the main stats from the array
    $this->stats_active['life_energy'] = $this->stats_base['life_energy'] = !empty($robotinfo['robot_life_energy']) ? $robotinfo['robot_life_energy'] : 1; // Life Energy
    $this->stats_active['weapon_energy'] = $this->stats_base['weapon_energy'] = !empty($robotinfo['robot_weapon_energy']) ? $robotinfo['robot_weapon_energy'] : 1; // Weapon Ammo
    $this->stats_active['recovery'] = $this->stats_base['recovery'] = !empty($robotinfo['robot_recovery']) ? $robotinfo['robot_recovery'] : 1; // Recovery Time
    $this->stats_active['speed'] = $this->stats_base['speed'] = !empty($robotinfo['robot_speed']) ? $robotinfo['robot_speed'] : 1; // Speed / Agility

    // Loop through all the types and pull the attack and defense stats from the array
    $this->stats_active['attack'] = $this->stats_base['attack'] = array();
    $this->stats_active['defense'] = $this->stats_base['defense'] = array();
    foreach ($this->type_library AS $typeinfo) {
    	$typecode = $typeinfo['code'];
      $this->stats_active['attack'][$typecode] = $this->stats_base['attack'][$typecode] = $robotinfo["robot_attack_{$typecode}"];
      $this->stats_active['defense'][$typecode] = $this->stats_base['defense'][$typecode] = $robotinfo["robot_defense_{$typecode}"];
    }
  }

  // -- Active Variables -- //

  // Return the robot's active info (all, name, level, etc.)
  function get_active_info($request = 'all') {
    switch ($request) {
      case 'id': case 'name': case 'type': case 'gender': case 'serial': case 'pronoun': case 'posessive_pronoun': {
        return $this->info_active[$request];
        break;
      }
      case 'all': default: {
        return $this->info_active;
        break;
      }
    }
  }

  // Return the robot's active type (all, code or name)
  function get_active_type($request = 'all') {
    switch ($request) {
      case 'id': case 'code': case 'name': {
        return $this->info_active['type'][$request];
        break;
      }
      case 'all': default: {
        return $this->info_active['type'];
        break;
      }
    }
  }

  // Return the robot's active stats (all, energy, recovery, etc.)
  function get_active_stats($request = 'all', $request2 = false) {
    switch ($request) {
      case 'energy': case 'ammo': case 'recovery': case 'speed': {
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

  // Return the robot's base info (all, name, level, etc.)
  function get_base_info($request = 'all') {
    switch ($request) {
      case 'name': case 'level': case 'life':  {
        return $this->info_base[$request];
        break;
      }
      case 'all': default: {
        return $this->info_base;
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

?>
