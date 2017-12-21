<?
// BASS BUSTER
$ability = array(
  'ability_name' => 'Bass Buster',
  'ability_token' => 'bass-buster',
  'ability_game' => 'MM07',
  'ability_group' => 'MM00/Weapons/Bass',
  'ability_description' => 'The user charges on the first turn to build power and raise attack by {RECOVERY2}%, then releases a powerful energy shot on the second to inflict massive damage!',
  'ability_energy' => 2,
  'ability_damage' => 34,
  'ability_recovery2' => 10,
  'ability_recovery2_percent' => true,
  'ability_accuracy' => 98,
  'ability_target' => 'select_target',
  'ability_function' => function($objects){

    // Extract all objects into the current scope
    extract($objects);

    // Define this ability's attachment token
    $this_attachment_token = 'ability_'.$this_ability->ability_token;
    $this_attachment_info = array(
    	'class' => 'ability',
    	'ability_token' => $this_ability->ability_token,
      'ability_frame' => 0,
      'ability_frame_animate' => array(1, 2, 1, 0),
      'ability_frame_offset' => array('x' => -10, 'y' => -10, 'z' => -20)
      );
    // Loop through each existing attachment and alter the start frame by one
    foreach ($this_robot->robot_attachments AS $key => $info){ array_push($this_attachment_info['ability_frame_animate'], array_shift($this_attachment_info['ability_frame_animate'])); }

    // Define the charge required flag based on existing attachments of this ability
    $this_charge_required = !isset($this_robot->robot_attachments[$this_attachment_token]) ? true : false;
    // If this robot is holding a Charge Module, bypass changing and set to false
    if ($this_robot->robot_item == 'item-charge-module'){ $this_charge_required = false; }

    // If the ability flag was not set, this ability begins charging
    if ($this_charge_required){

      // Target this robot's self
      $this_ability->target_options_update(array(
        'frame' => 'defend',
        'success' => array(1, -10, 0, -10, $this_robot->print_robot_name().' charges the '.$this_ability->print_ability_name().'&hellip;')
        ));
      $this_robot->trigger_target($this_robot, $this_ability);

      // Increase this robot's defense stat slightly
      $this_ability->recovery_options_update(array(
        'kind' => 'attack',
        'percent' => true,
        'rates' => array(100, 0, 0),
        'success' => array(2, -10, 0, -10, $this_robot->print_robot_name().'&#39;s weapons improved!'),
        'failure' => array(2, -10, 0, -10, $this_robot->print_robot_name().'&#39;s weapons were not affected&hellip;')
        ));
      $attack_recovery_amount = ceil($this_robot->robot_attack * 0.10);
      $this_robot->trigger_recovery($this_robot, $this_ability, $attack_recovery_amount);

      // Attach this ability attachment to the robot using it
      $this_robot->robot_attachments[$this_attachment_token] = $this_attachment_info;
      $this_robot->update_session();

    }
    // Else if the ability flag was set, the ability is released at the target
    else {

      // Remove this ability attachment to the robot using it
      unset($this_robot->robot_attachments[$this_attachment_token]);
      $this_robot->update_session();

      // Update this ability's target options and trigger
      $this_ability->target_options_update(array(
        'frame' => 'shoot',
        'kickback' => array(-5, 0, 0),
        'success' => array(3, 100, -15, 10, $this_robot->print_robot_name().' fires the '.$this_ability->print_ability_name().'!'),
        ));
      $this_robot->trigger_target($target_robot, $this_ability);

      // Inflict damage on the opposing robot
      $this_ability->damage_options_update(array(
        'kind' => 'energy',
        'kickback' => array(20, 0, 0),
        'success' => array(3, -110, -15, 10, 'A massive energy shot hit the target!'),
        'failure' => array(3, -110, -15, -10, 'The '.$this_ability->print_ability_name().' shot missed&hellip;')
        ));
      $energy_damage_amount = $this_ability->ability_damage;
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

    }

    // Return true on success
    return true;

    },
  'ability_function_onload' => function($objects){

    // Extract all objects into the current scope
    extract($objects);

    // Define this ability's attachment token
    $this_attachment_token = 'ability_'.$this_ability->ability_token;

    // If the ability flag had already been set, reduce the weapon energy to zero
    if (isset($this_robot->robot_attachments[$this_attachment_token])){ $this_ability->ability_energy = 0; }
    // Otherwise, return the weapon energy back to default
    else { $this_ability->ability_energy = $this_ability->ability_base_energy; }

    // If this robot is holding a Charge Module, reduce the power of the ability
    if ($this_robot->robot_item == 'item-charge-module'){
      $temp_item_info = mmrpg_ability::get_index_info($this_robot->robot_item);
      $this_ability->ability_damage = ceil($this_ability->ability_base_damage * ($temp_item_info['ability_damage2'] / $temp_item_info['ability_recovery2']));
    } else {
      $this_ability->ability_damage = $this_ability->ability_base_damage;
    }

    // Define the charge required flag based on existing attachments of this ability
    $this_charge_required = !isset($this_robot->robot_attachments[$this_attachment_token]) ? true : false;
    // If this robot is holding a Charge Module, bypass changing and set to false
    if ($this_robot->robot_item == 'item-charge-module'){ $this_charge_required = false; }

    // If the ability attachment is already there, change target to select
    if (!$this_charge_required){

      // Update this ability's targetting setting
      $this_ability->ability_target = 'select_target';
      $this_ability->update_session();

    }
    // Else if the ability attachment is not there, change the target back to auto
    else {

      // Update this ability's targetting setting
      $this_ability->ability_target = 'auto';
      $this_ability->update_session();

    }

    // Return true on success
    return true;

    }
  );
?>