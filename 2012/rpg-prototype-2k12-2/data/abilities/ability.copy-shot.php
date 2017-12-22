<?
// COPY SHOT
$ability = array(
  'ability_name' => 'Copy Shot',
  'ability_token' => 'copy-shot',
  'ability_image' => 'copy-shot',
  'ability_description' => 'The user fires a small emulation device at the target that deals minor damage and copies its last used ability!',
  'ability_speed' => 2,
  'ability_damage' => 5,
  'ability_accuracy' => 90,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Update the ability's target options and trigger
    $this_ability->target_options_update(array(
      'frame' => 'shoot',
      'success' => array(0, 105, 0, 10, $this_robot->print_robot_name().' fires a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(0, -70, 0, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(0, -70, 0, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_damage);
    
    // Check to ensure the ability was a success before continuing
    if ($this_ability->ability_results['this_result'] != 'failure'){
      
      // Ensure the target robot has an ability history to draw from
      if (!empty($target_robot->history['triggered_abilities'])){
        
        // Find the position of the current copy-shot ability
        $this_ability_key = $this_ability->ability_id; //array_search($this_ability->ability_token, $this_robot->robot_abilities);
        
        // Loop through the opponent's ability history in reverse
        $num_triggered_abilities = count($target_robot->history['triggered_abilities']);
        $new_ability_token = $target_robot->history['triggered_abilities'][$num_triggered_abilities - 1];
        $new_ability_info = !empty($this_index['abilities'][$new_ability_token]) ? $this_index['abilities'][$new_ability_token] : array();
        
        // If the current robot does not already have this ability
        if (!empty($new_ability_info) && !in_array($new_ability_token, $this_robot->robot_abilities)){
          // Copy the current ability to this robot's list, and update
          $this_robot->robot_frame = 'taunt';
          $this_robot->robot_abilities[$this_ability_key] = $new_ability_token;
          $this_robot->update_session();
          // Create the ability object to trigger data loading
          $this_new_ability = new mmrpg_ability($this_battle, $this_player, $this_robot, $new_ability_info);
          // Create an event displaying the new copied ability
          $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
          $event_body = $this_ability->print_ability_name().' downloads the target&#39;s battle data&hellip;<br />';
          $event_body .= $this_robot->print_robot_name().' learned how to use '.$this_new_ability->print_ability_name().'!';
          $event_options = array();
          $event_options['console_show_target'] = false;
          $event_options['this_ability'] = $this_new_ability;
          $event_options['this_ability_image'] = 'icon';
          $event_options['console_show_this_robot'] = false;
          $event_options['canvas_show_this_ability'] = false;
          $event_options['console_show_this_ability'] = true;
          $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
        }
        
      }
      
    }
    
    
    // Return true on success
    return true;
      
    }
  );
?>