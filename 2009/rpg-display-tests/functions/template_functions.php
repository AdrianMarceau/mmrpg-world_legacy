<?php
/*
 * Filename : template_functions.php
 * Title	: 
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : Jul 5, 2009
 *
 * Description:
 * 
 */

// Create a quick function for making an associative robotinfo array
function generate_new_robot($name, $code, $type, $gender, $points, $level, $max_le, $ability)
{
  $robotinfo = array();
  $robotinfo['robot_name'] = $name;
  $robotinfo['robot_code'] = $code;
  $robotinfo['robot_type'] = $type;
  $robotinfo['robot_gender'] = $gender;
  $robotinfo['robot_points'] = $points;
  $robotinfo['robot_level'] = $level;
  $robotinfo['robot_current_le'] = $max_le;
  $robotinfo['robot_max_le'] = $max_le;
  $robotinfo['robot_status'] = 'normal';
  $robotinfo['robot_action'] = 'waiting';
  $robotinfo['robot_ability'] = $ability;
  return $robotinfo;
} 

// Create a quick function for making an associative abilityinfo array
function generate_new_ability($ability_name, $ability_power, $ability_type, $ability_class)
{
  $abilityinfo = array();
  $abilityinfo['ability_name'] = $ability_name;
  $abilityinfo['ability_power'] = $ability_power;
  $abilityinfo['ability_type'] = $ability_type;
  $abilityinfo['ability_class'] = $ability_class;
  return $abilityinfo;
}

// Create a quick function for making an associative turninfo array
function generate_new_turn($turn_number, $display_state, $turn_status)
{
  $turninfo = array();
  $turninfo['turn_number'] = $turn_number;
  $turninfo['turn_display_state'] = $display_state;
  $turninfo['turn_status'] = $turn_status;
  $turninfo['turn_events'] = array();
  return $turninfo;
}

// Create a quick function for making an associative eventinfo array
function generate_new_turn_event($player_info, $event_type, $event_time, $additional_info)
{
  $eventinfo = array();
  $eventinfo['event_type'] = $event_type;
  $eventinfo['event_time'] = $event_time;
  $eventinfo['player_info'] = $player_info;
  $eventinfo = array_merge($eventinfo, $additional_info);
  return $eventinfo;
}
 
?>
