<?
// METAL BLADE
$ability = array(
  'ability_name' => 'Super Arm',
  'ability_token' => 'super-arm',
  'ability_image' => 'super-arm',
  'ability_description' => 'The user finds a nearby heavy object and hurls it at the target for massive damage.',
  'ability_type' => 'impact',
  'ability_damage' => 15,
  'ability_accuracy' => 75,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Define the ability frames based on field
    $this_field_token = $this_battle->battle_field->field_token;
    $this_target_frame = 0;
    $this_impact_frame = 1;
    $this_object_name = 'boulder';
    if ($this_field_token == 'guts-field'){
      $this_target_frame = 0;
      $this_impact_frame = 1;
      $this_object_name = 'rocky boulder';
    }
    elseif ($this_field_token == 'ice-field'){
      $this_target_frame = 2;
      $this_impact_frame = 3;
      $this_object_name = 'frozen snowball';
    }
    elseif ($this_field_token == 'elec-field'){
      $this_target_frame = 4;
      $this_impact_frame = 5;
      $this_object_name = 'metal heap';
    }
    elseif ($this_field_token == 'base-field'){
      $this_target_frame = 6;
      $this_impact_frame = 7;
      $this_object_name = 'pile of debris';
    }
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array($this_target_frame, 115, 15, 10, $this_ability->print_ability_name().' throws a '.$this_object_name.'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(20, 0, 0),
      'success' => array($this_impact_frame, -85, 0, 10, 'The '.$this_object_name.' crashed into the target!'),
      'failure' => array($this_target_frame, -110, 0, -10, 'The '.$this_object_name.' missed the target&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array($this_impact_frame, -85, 0, 10, 'The '.$this_object_name.' crashed into the target!'),
      'failure' => array($this_target_frame, -110, 0, -10, 'The '.$this_object_name.' missed the target&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Return true on success
    return true;
        
  }
  );
?>