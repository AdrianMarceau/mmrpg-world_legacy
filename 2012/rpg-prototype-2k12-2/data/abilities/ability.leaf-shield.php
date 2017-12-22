<?
// LEAF SHIELD
$ability = array(
  'ability_name' => 'Leaf Shield',
  'ability_token' => 'leaf-shield',
  'ability_image' => 'leaf-shield',
  'ability_description' => 'The user raises a shield of sharp, metal leaves to greatly raise defense! This shield can also be thrown at the target.',
  'ability_type' => 'nature',
  'ability_damage' => 30,
  'ability_recovery' => 30,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Define this ability's attachment token
    $this_attachment_token = 'ability_'.$this_ability->ability_token;
    $this_attachment_info = array('class' => 'ability', 'ability_id' => $this_ability->ability_id, 'ability_token' => $this_ability->ability_token);
    
    // If the ability flag was not set, leaf shield raises defense by 30%
    if (!isset($this_robot->robot_attachments[$this_attachment_token])){
      
      // Target this robot's self
      $this_ability->target_options_update(array(
        'frame' => 'summon',
        'success' => array(0, -10, 0, -10, $this_robot->print_robot_name().' raises a '.$this_ability->print_ability_name().'!')
        ));
      $this_robot->trigger_target($this_robot, $this_ability);
      
      // Increase this robot's defense stat
      $this_ability->recovery_options_update(array(
        'kind' => 'defense',
        'frame' => 'taunt',
        'rates' => array(100, 0, 0),
        'success' => array(1, -10, 0, -10, $this_robot->print_robot_name().'&#39;s shields were bolstered!'),
        'failure' => array(1, -10, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
        ));
      $this_ability->damage_options_update(array(
        'kind' => 'defense',
        'frame' => 'defend',
        'rates' => array(100, 0, 0),
        'success' => array(1, -10, 0, -10, $this_robot->print_robot_name().'&#39;s shields were damaged!'),
        'failure' => array(1, -10, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
        ));
      $defense_recovery_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_recovery / 100));
      $this_robot->trigger_recovery($this_robot, $this_ability, $defense_recovery_amount);
      
      // Attach this ability attachment to the robot using it
      $this_robot->robot_attachments[$this_attachment_token] = $this_attachment_info;
      $this_robot->update_session();
      
      // Update the is_active flag to true, shield is up
      //$this_ability->flags['is_active'] = true;
    }
    // Else if the ability flag was set, leaf shield is thrown and defense is lowered by 30%
    else {
      
      // Remove this ability attachment to the robot using it
      unset($this_robot->robot_attachments[$this_attachment_token]);
      $this_robot->update_session();
      
      // Target the opposing robot
      $this_ability->target_options_update(array(
        'frame' => 'summon',
        'success' => array(0, 85, -10, -10, $this_robot->print_robot_name().' releases the '.$this_ability->print_ability_name().'!')
        ));
      $this_robot->trigger_target($target_robot, $this_ability);
      
      // Inflict damage on the opposing robot
      $this_ability->damage_options_update(array(
        'kind' => 'energy',
        'kickback' => array(5, 0, 0),
        'success' => array(1, -75, 0, -10, 'The '.$this_ability->print_ability_name().' crashed into the target!'),
        'failure' => array(1, -85, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'energy',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(1, -75, 0, -10, 'The '.$this_ability->print_ability_name().' crashed into the target!'),
        'failure' => array(1, -85, 0, -10, 'The '.$this_ability->print_ability_name().' missed the target&hellip;')
        ));
      $energy_damage_amount = $this_ability->ability_damage;
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
      
      // Decrease this robot's defense stat
      $this_ability->damage_options_update(array(
        'kind' => 'defense',
        'frame' => 'defend',
        'rates' => array(100, 0, 0),
        'success' => array(2, -2, 0, -10,  'The '.$this_ability->print_ability_name().'&#39;s protection was lost&hellip;'),
        'failure' => array(2, -2, 0, -10, $this_robot->print_robot_name().'&#39;s shields were not effected&hellip;')
        ));
      $defense_damage_amount = ceil($this_robot->robot_base_defense * ($this_ability->ability_recovery / 100));
      $this_robot->trigger_damage($this_robot, $this_ability, $defense_damage_amount);
      
      // Update the is_active flag to false, shield is down
      //unset($this_ability->flags['is_active']);
    }
    
    
    // Return true on success
    return true;
        
  },
  'attachment_frame' => array(0, 1),
  'attachment_frame_offset' => array('x' => -10, 'y' => 0, 'z' => -10)
  );
?>