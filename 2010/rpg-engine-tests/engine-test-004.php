<?php
/*
 * Filename : megaman-rpg-engine.php
 * Title	:
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 3, 2009
 *
 * Description:
 *
 */

// Require the top files
require('../../config.php');
require('../../apptop.php');

// Define the headers for this file
$html_title_text = 'RPG Engine Tests 004/004 | '.$html_title_text;
$html_content_title = $html_content_title.' | RPG Engine Tests 004/004';
$html_content_description = 'Several different engines were written to test the feasibility of a PHP-based Mega Man RPG.  This is the fourth of those tests.';

// Start the ouput buffer to collect content
ob_start();

  echo('<div class="wrapper" style="overflow: hidden;">'.PHP_EOL);

  /*
  if (isset($_SESSION['robot1']))
  {
  	echo "<h1>Session Robot 1</h1><br />\r\n";
    echo "<pre style=\"\">\r\n".print_r($_SESSION['robot1'], true)."\r\n</pre>\r\n<br />\r\n";
    echo "<hr />\r\n";
  }
  if (isset($_SESSION['robot2']))
  {
    echo "<h1>Session Robot 2</h1><br />\r\n";
    echo "<pre>\r\n".print_r($_SESSION['robot2'], true)."\r\n</pre>\r\n<br />\r\n";
    echo "<hr />\r\n";
  }
  */

  // Define the available types
  $types = array();
  $types[] = 'none';
  $types[] = 'aqua';
  $types[] = 'bomb';
  $types[] = 'cold';
  $types[] = 'dark';
  $types[] = 'elec';
  $types[] = 'grnd';
  $types[] = 'heat';
  $types[] = 'metl';
  $types[] = 'powr';
  $types[] = 'star';
  $types[] = 'time';
  $types[] = 'wind';
  $types[] = 'natr';

  // Define the "actor" class
  class actor {

    // Create the variables to hold profiles & stats
    protected $profile_base = array(), $profile_active = array();
    protected $stat_base = array(), $stat_active = array();

    // Create the "types" array containing all types
    protected $element_types = array();

    // Create any miscellaneous variables needed for actor creation
    protected $energy_start_value = 100;
    protected $energy_level_modifier = 9;

    // Populate the variables with their default values
    function actor($element_types)
    {
      // Set up the types
      $this->element_types = $element_types;

      // -- SETUP STATS -- //

      // Create the "energy" stat
      $this->stat_base['energy'] = $this->stat_active['energy'] = 1;

      // Create the "recovery" stat
      $this->stat_base['recovery'] = $this->stat_active['recovery'] = 1;

      // Create the "speed" stat
      $this->stat_base['speed'] = $this->stat_active['speed'] = 1;

      // Create the "attack" stat
      $this->stat_base['attack'] = $this->stat_active['attack'] = array();
        // Loop through the various types assigning default values to attack types
        foreach ($this->element_types AS $this_type)
        {
        	// Assign a default value of one to this attack type
          $this->stat_base['attack'][$this_type] = $this->stat_active['attack'][$this_type] = 1;
        }

      // Create the "defense" stat
      $this->stat_base['defense'] = $this->stat_active['defense'] = array();
      // Loop through the various types assigning default values to defense types
        foreach ($this->element_types AS $this_type)
        {
          // Assign a default value of one to this attack type
          $this->stat_base['defense'][$this_type] = $this->stat_active['defense'][$this_type] = 1;
        }
    }

    // Create an base and active profile holding detailed information
    function create_profile($actor_name, $actor_type, $actor_level)
    {
    	// -- POPULATE * CALCULATE PROFILE -- //

      // Set up the actor's details
      $this->profile_base['name'] = $this->profile_active['name'] = $actor_name;
      $this->profile_base['type'] = $this->profile_active['type'] = $actor_type;
      $this->profile_base['level'] = $this->profile_active['level'] = $actor_level;

      // Set up the actor's profile stats
      $this->profile_base['energy'] = $this->profile_active['energy'] = ceil($this->energy_start_value + ($this->stat_active['energy'] * ($this->energy_level_modifier * $this->profile_base['level'])));
    }

    // Create a function for "resetting" the profile to it's initial state based on the base-stats
    function reset_actor()
    {
      // Reset all the profile values to their intial values
      $this->profile_active['name'] = $this->profile_base['name'];
      $this->profile_active['type'] = $this->profile_base['type'];
      $this->profile_active['level'] = $this->profile_base['level'];

      // Recalculate the energy profile stat
      $this->profile_base['energy'] = $this->profile_active['energy'] = ceil($this->energy_start_value + ($this->stat_active['energy'] * ($this->energy_level_modifier * $this->profile_base['level'])));

      // Reset the "energy" stat
      $this->stat_active['energy'] = $this->stat_base['energy'];

      // Reset the "recovery" stat
      $this->stat_active['recovery'] = $this->stat_base['recovery'];

      // Reset the "speed" stat
      $this->stat_active['speed'] = $this->stat_base['speed'];

      // Loop through the various types resetting the attack and defense values back to their bases
      foreach ($this->element_types AS $this_type)
      {
        // Reset the active attack stat back to its default, base value
        $this->stat_active['attack'][$this_type] = $this->stat_base['attack'][$this_type];
        // Reset the active attack stat back to its default, base value
        $this->stat_active['defense'][$this_type] = $this->stat_base['defense'][$this_type];
      }
    }

    // Create a function for resetting only a specific profile attribute
    function reset_actor_profile($request)
    {
    	$this->profile_active[$request] = $this->profile_base[$request];
    }

    // Create the function for resetting only a specific stat
    function reset_actor_stat($request,$request2=false)
    {
    	// If it's any of the normal stats, simply reset the value
      switch ($request)
      {
      	case 'energy': case 'recovery': case 'speed':
        {
        	// Reset the requested stat
          $this->stat_active[$request] = $this->stat_base[$request];
          break;
        }
        case 'attack': case 'defense':
        {
        	// Reset the reqested attack/defense stat
          $this->stat_active[$request][$request2] = $this->stat_base[$request][$request2];
          break;
        }
      }
    }

    // Create the function to pull an entire active profile
    function get_active_profile($request)
    {
      return $this->profile_active[$request];
    }

    // Create the function to pull an entire base profile
    function get_base_profile($request)
    {
      return $this->profile_base[$request];
    }

    // Create the function to pull an active stat
    function get_active_stat($statname)
    {
    	return $this->stat_active[$statname];
    }

    // Create the function to pull a base stat
    function get_base_stat($statname)
    {
      return $this->stat_base[$statname];
    }

    // Create the function to set an active profile stat
    function set_active_profile($attribute, $value)
    {
    	$this->profile_active[$attribute] = $value;
    }

    // Create the function to set an active stat
    function set_active_stat($statname, $value)
    {
      $this->stat_active[$statname] = $value;
    }

    // Create the function to set an base profile stat
    function set_base_profile($attribute, $value)
    {
      $this->profile_base[$attribute] = $value;
    }

    // Create the function to set an base stat
    function set_base_stat($statname, $value)
    {
      $this->stat_base[$statname] = $value;
    }

    // Create a function for calulating damage inflicted with an attack
    function use_ability($ability, $target)
    {
    	// Calculate the damage caused by the ability
      $damage_1 = $ability->ability_damage * $this->stat_active['attack'][$ability->ability_type] * $target->stat_active['defense'][$ability->ability_type];
      $damage_2 = $damage_1 + ($this->profile_active['level']/10 * $damage_1);
      eval("echo $ability->ability_effect;");
      echo $this->profile_active['name'].' hits '.$target->profile_active['name'].' for '.$damage_2." damage!<br />\r\n";
      $target->set_active_profile('energy', ($target->profile_active['energy'] - $damage_2));
    }
  }

  // Define the ability class
  class ability {

    // Creeate the variables that will hold the ability statistics
    public $ability_name, $ability_type, $ability_damage, $ability_class, $ability_effect;

    function ability($name, $type, $damage, $class, $effect)
    {
    	// Populate the ability with it's given values
      $this->ability_name = $name;
      $this->ability_type = $type;
      $this->ability_damage = $damage;
      $this->ability_class = $class;
      $this->ability_effect = $effect;
    }
  }

  // Create some attacks
  $abilties = array();
  $abilities[] = new ability('Buster Arm', 'none', 10, 'offensive', '"A charged shot was released!<br />\r\n"');
  $abilities[] = new ability('Rolling Cutter', 'metl', 10, 'offensive', '"A scissor-boomerang was thrown!<br />\r\n"');
  $abilities[] = new ability('Thunder Beam', 'elec', 30, 'offensive', '"High-voltage electricity was shot from ".$this->profile_active[\'name\']."\'s hands!<br />\r\n"');

  // Create the new actor
  $_SESSION['robot1'] = isset($_SESSION['robot1']) ? $_SESSION['robot1'] : new actor($types);
  $robot1 = &$_SESSION['robot1'];
  $robot1->create_profile('Cut Man', 'metl', 0);
  $robot1->set_base_stat('energy', 0.66);

  // Create the new actor
  $_SESSION['robot2'] = isset($_SESSION['robot2']) ? $_SESSION['robot2'] : new actor($types);
  $robot2 = &$_SESSION['robot2'];
  $robot2->create_profile('Elec Man', 'elec', 50);
  $robot2->set_base_stat('energy', 0.56);
  $robot2->reset_actor();

  // Loop through the different levels so we can see the progression
  for ($i = 1; $i <= 100; $i++)
  {
    // Set the base level to $i and then reset the profile
    $robot1->set_base_profile('level', $i);
    $robot1->reset_actor();

    // Display this new creation :D
    $robot1_name = $robot1->get_active_profile('name');
    $robot1_level = $robot1->get_active_profile('level');
    $robot1_energy_active = $robot1->get_active_profile('energy');
    $robot1_energy_base = $robot1->get_base_profile('energy');
    $robot2_name = $robot2->get_active_profile('name');
    $robot2_level = $robot2->get_active_profile('level');
    $robot2_energy_active = $robot2->get_active_profile('energy');
    $robot2_energy_base = $robot2->get_base_profile('energy');
    echo "<h1>$robot1_name (Lv. $robot1_level) VS. $robot2_name (Lv. $robot2_level)</h1>\r\n";
    echo "<b>$robot1_name Level : </b> $robot1_level<br />\r\n";
    echo "<b>$robot1_name Energy : </b> $robot1_energy_active/$robot1_energy_base<br />\r\n";
    echo "<b>$robot2_name Level : </b> $robot2_level<br />\r\n";
    echo "<b>$robot2_name Energy : </b> $robot2_energy_active/$robot2_energy_base<br />\r\n";
    echo "<br />";
    foreach ($abilities AS $thisability)
    {
    	// Check to see if the target is dead
      if ($robot2->get_active_profile('energy') <= 0)
      {
        echo "<u>$robot2_name has been destroyed!</u><br /><br />\r\n";
        $robot2->set_active_profile('name', $robot2->get_active_profile('name').'X');
        //$robot2->reset_actor();
        break;
      }
      else
      {
      	echo "<b>$robot1_name Attacks!</b><br /><br />\r\n";
        echo "$robot1_name uses ".$thisability->ability_name."!<br />\r\n";
        $robot1->use_ability($thisability, $robot2);
        echo "$robot2_name has ".$robot2->get_active_profile('energy').'/'.$robot2->get_base_profile('energy')." energy units remaining!<br /><br />\r\n";
      }

    }
    echo "<br />\r\n";
    $robot1_name = $robot1->get_active_profile('name');
    $robot1_level = $robot1->get_active_profile('level');
    $robot1_energy_active = $robot1->get_active_profile('energy');
    $robot1_energy_base = $robot1->get_base_profile('energy');
    $robot2_name = $robot2->get_active_profile('name');
    $robot2_level = $robot2->get_active_profile('level');
    $robot2_energy_active = $robot2->get_active_profile('energy');
    $robot2_energy_base = $robot2->get_base_profile('energy');
    echo "<b>$robot1_name Level : </b> $robot1_level<br />\r\n";
    echo "<b>$robot1_name Energy : </b> $robot1_energy_active/$robot1_energy_base<br />\r\n";
    echo "<b>$robot2_name Level : </b> $robot2_level<br />\r\n";
    echo "<b>$robot2_name Energy : </b> $robot2_energy_active/$robot2_energy_base<br />\r\n";
    echo "<hr />\r\n";
  }

  echo('</div>'.PHP_EOL);

// Collect content from the ouput buffer
$html_content_markup = ob_get_clean();

// Require the page template
require('../../html.php');


?>
