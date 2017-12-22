<?
// SUPER THROW
$ability = array(
  'ability_name' => 'Super Throw',
  'ability_token' => 'super-throw',
  'ability_image' => 'super-throw',
  'ability_description' => 'The grabs hold of the target and throws them across the field, forcing the opponent to switch.',
  'ability_accuracy' => 100,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $target_robot->robot_position = 'bench';
    $target_robot->robot_frame = 'damage';
    $target_robot->update_session();
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(0, 0, 0, 10, $target_robot->print_robot_name().' is thrown to the bench!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Trigger a switch on the opponent immediately
    $this_battle->actions_prepend(
      $target_player,
      $target_robot,
      $this_player,
      $this_robot,
      'switch',
      ''
      );
    
    // Return true on success
    return true;
        
  }
  );
?>