<?
// HYPER BOMB
$ability = array(
  'ability_name' => 'Hyper Bomb',
  'ability_token' => 'hyper-bomb',
  'ability_image' => 'hyper-bomb',
  'ability_description' => 'The user throws a large bomb at the target that explodes for massive damage.',
  'ability_type' => 'explode',
  'ability_damage' => 18,
  'ability_accuracy' => 80,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // If this ability is attached, remove it
    $this_attachment_backup = false;
    $this_attachment_token = 'ability_'.$this_ability->ability_token;
    if (isset($this_robot->robot_attachments[$this_attachment_token])){
      $this_attachment_backup = $this_robot->robot_attachments[$this_attachment_token];
      unset($this_robot->robot_attachments[$this_attachment_token]);
      $this_robot->update_session();
    }
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(0, 85, 35, 10, $this_robot->print_robot_name().' thows a '.$this_ability->print_ability_name().'!'),
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 5, 0),
      'success' => array(2, 30, 0, 10, 'The '.$this_ability->print_ability_name().' exploded on contact!'),
      'failure' => array(1, -65, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(2, 30, 0, 10, 'The '.$this_ability->print_ability_name().' exploded on contact!'),
      'failure' => array(1, -65, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // If there was a removed attachment, put it back
    if (!empty($this_attachment_backup)){
      $this_robot->robot_attachments[$this_attachment_token] = $this_attachment_backup;
      $this_robot->update_session();
    }
    
    // Return true on success
    return true;
        
  },
  'attachment_frame' => array(1),
  'attachment_frame_offset' => array('x' => -55, 'y' => 1, 'z' => -10)
  );
?>