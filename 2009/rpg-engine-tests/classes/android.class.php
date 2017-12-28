<?php
/*
 * Filename : android.class.php
 * Title	: MegaMan RPG Engine - Android Class EXTENDS Robot Class
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 10, 2009
 *
 * Description:
 * This class is used for creating a robot object with base stats
 */

// Require the database connect function
require_once("{$FUNCTIONROOT}database_connect.php");
require_once("{$CLASSROOT}robot.class.php");
require_once("{$INCLUDESROOT}define_types.php");

// Create the robot class
class android extends robot {

  // Define the active and base variables
  public $profile_active, $profile_base;

  // Create any miscellaneous, internal variables needed for actor creation
  private $life_start_value = 100;
  private $life_level_modifier = 9;
  private $ammo_level_modifier = 10;

  // -- Constructor -- //

  // Create the robot, populating it's properties
  function android(&$type_library) {
    $this->robot($type_library);
  }

  // Create the function for setting up the profile
  function load_profile($android_level, &$ability_library) {
  	$this->profile_active['LV'] = $this->profile_base['LV'] = is_numeric($android_level) ? $android_level : 1;
    $this->profile_active['LE'] = $this->profile_base['LE'] = ceil($this->life_start_value + ($this->stats_active['life_energy'] * ($this->life_level_modifier * $this->profile_base['LV'])));
    $this->profile_active['WE'] = $this->profile_base['WE'] = ceil($this->profile_base['LV'] * ($this->stats_active['weapon_energy'] * $this->ammo_level_modifier));
  }


}

?>
