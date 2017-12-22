<?
// BUBBLE BOMB
$ability = array(
  'ability_name' => 'Bubble Bomb',
  'ability_token' => 'bubble-bomb',
  'ability_image' => 'bubble-bomb',
  'ability_description' => 'The user throws a large bobble at the target that explodes on contact and for massive damage.',
  'ability_type' => 'water',
  'ability_damage' => 20,
  'ability_accuracy' => 90,
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
      'kickback' => array(0, 0, 0),
      'success' => array(2, -10, -10, 10, 'The '.$this_ability->print_ability_name().' burst on contact!'),
      'failure' => array(1, -65, -10, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(2, -10, -10, 10, 'The '.$this_ability->print_ability_name().' burst on contact!'),
      'failure' => array(1, -65, -10, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    
    // Randomly inflict a speed break on critical chance 30%
    if ($target_robot->robot_status != 'disabled'
      && $this_ability->ability_results['this_result'] != 'failure'
      && $this_battle->critical_chance(99)){
      // Decrease the target robot's speed stat
      $this_ability->damage_options_update(array(
        'kind' => 'attack',
        'frame' => 'defend',
        'kickback' => array(0, 0, 0),
        'success' => array(1, -10, -10, -10, $target_robot->print_robot_name().'&#39;s weapons were damaged!'),
        'failure' => array(1, -65, -10, -10, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'attack',
        'frame' => 'taunt',
        'kickback' => array(0, 0, 0),
        'success' => array(1, -10, -10, -10, $target_robot->print_robot_name().'&#39;s weapons improved!'),
        'failure' => array(1, -65, -10, -9999, '')
        ));
      $attack_damage_amount = ceil($target_robot->robot_base_attack * (($this_ability->ability_damage / 2) / 100));
      $target_robot->trigger_damage($this_robot, $this_ability, $attack_damage_amount);
    }
    
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