<?
// ROLLING CUTTER
$ability = array(
  'ability_name' => 'Rolling Cutter',
  'ability_token' => 'rolling-cutter',
  'ability_description' => 'The user throws a boomerang-like blade that strikes the target up to four times at increasing strength!',
  'ability_type' => 'cutter',
  'ability_damage' => 10,
  'ability_accuracy' => 75,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options['target_kind'] = 'attack';
    $this_ability->target_options['target_frame'] = 'throw';
    $this_ability->target_options['ability_success_frame'] = 1;
    $this_ability->target_options['ability_success_frame_offset']['x'] = 100;
    $this_ability->target_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->target_options['ability_failure_frame'] = 1;
    $this_ability->target_options['ability_failure_frame_offset']['x'] = 100;
    $this_ability->target_options['ability_failure_frame_offset']['z'] = 10;
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['ability_success_frame'] = 2;
    $this_ability->damage_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->damage_options['ability_success_frame_offset']['y'] = 5;
    $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->damage_options['ability_failure_frame'] = 2;
    $this_ability->damage_options['ability_failure_frame_offset']['x'] = -30;
    $this_ability->damage_options['ability_failure_frame_offset']['y'] = 5;
    $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->damage_options['success_text'] = 'It hit the target!';
    $this_ability->damage_options['failure_text'] = $this_ability->print_ability_name().' missed!';
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['ability_success_frame'] = 2;
    $this_ability->recovery_options['ability_success_frame_offset']['x'] = 0;
    $this_ability->recovery_options['ability_success_frame_offset']['y'] = 5;
    $this_ability->recovery_options['ability_success_frame_offset']['z'] = 10;
    $this_ability->recovery_options['ability_failure_frame'] = 2;
    $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -30;
    $this_ability->recovery_options['ability_failure_frame_offset']['y'] = 5;
    $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
    $this_ability->recovery_options['success_text'] = 'It hit the target!';
    $this_ability->recovery_options['failure_text'] = $this_ability->print_ability_name().' missed!';
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    

    // If this attack returns and strikes a second time (random chance)
    if ($this_ability->ability_results['this_result'] != 'failure'
      && $target_robot->robot_status != 'disabled'){

      // Inflict damage on the opposing robot
      $this_ability->damage_options['ability_success_frame'] = 3;
      $this_ability->damage_options['ability_success_frame_offset']['x'] = -40;
      $this_ability->damage_options['ability_success_frame_offset']['y'] = 10;
      $this_ability->damage_options['ability_success_frame_offset']['z'] = 10;
      $this_ability->damage_options['ability_failure_frame'] = 3;
      $this_ability->damage_options['ability_failure_frame_offset']['x'] = -60;
      $this_ability->damage_options['ability_failure_frame_offset']['y'] = 10;
      $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->damage_options['success_text'] = 'Oh! It hit again!';
      $this_ability->damage_options['failure_text'] = '';
      $this_ability->recovery_options['ability_success_frame'] = 3;
      $this_ability->recovery_options['ability_success_frame_offset']['x'] = -40;
      $this_ability->recovery_options['ability_success_frame_offset']['y'] = 10;
      $this_ability->recovery_options['ability_failure_frame'] = 3;
      $this_ability->recovery_options['ability_failure_frame_offset']['x'] = -60;
      $this_ability->recovery_options['ability_failure_frame_offset']['y'] = 10;
      $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
      $this_ability->recovery_options['success_text'] = 'Oh! It hit again!';
      $this_ability->recovery_options['failure_text'] = '';
      $energy_damage_amount = ceil($energy_damage_amount * 1.10);
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

      // If this attack returns and strikes a third time (random chance)
      if ($this_ability->ability_results['this_result'] != 'failure'
        && $target_robot->robot_energy != 'disabled'){
        
        // Inflict damage on the opposing robot
        $this_ability->damage_options['ability_success_frame'] = 4;
        $this_ability->damage_options['ability_success_frame_offset']['x'] = 10;
        $this_ability->damage_options['ability_success_frame_offset']['y'] = 15;
        $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
        $this_ability->damage_options['ability_failure_frame'] = 4;
        $this_ability->damage_options['ability_failure_frame_offset']['x'] = 10;
        $this_ability->damage_options['ability_failure_frame_offset']['y'] = 15;
        $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
        $this_ability->damage_options['success_text'] = 'Wow! A third hit?!?';
        $this_ability->damage_options['failure_text'] = '';
        $this_ability->recovery_options['ability_success_frame'] = 4;
        $this_ability->recovery_options['ability_success_frame_offset']['x'] = 10;
        $this_ability->recovery_options['ability_success_frame_offset']['y'] = 15;
        $this_ability->recovery_options['ability_success_frame_offset']['y'] = -10;
        $this_ability->recovery_options['ability_failure_frame'] = 4;
        $this_ability->recovery_options['ability_failure_frame_offset']['x'] = 10;
        $this_ability->recovery_options['ability_failure_frame_offset']['y'] = 15;
        $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
        $this_ability->recovery_options['success_text'] = 'Wow! A third hit?!?';
        $this_ability->recovery_options['failure_text'] = '';
        $energy_damage_amount = ceil($energy_damage_amount * 1.10);
        $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

        // If this attack returns and strikes a fourth time (random chance)
        if ($this_ability->ability_results['this_result'] != 'failure'
          && $target_robot->robot_status != 'disabled'){
          
          // Inflict damage on the opposing robot
          $this_ability->damage_options['ability_success_frame'] = 1;
          $this_ability->damage_options['ability_success_frame_offset']['x'] = 50;
          $this_ability->damage_options['ability_success_frame_offset']['y'] = 20;
          $this_ability->damage_options['ability_success_frame_offset']['z'] = -10;
          $this_ability->damage_options['ability_failure_frame'] = 1;
          $this_ability->damage_options['ability_failure_frame_offset']['x'] = 50;
          $this_ability->damage_options['ability_failure_frame_offset']['y'] = 20;
          $this_ability->damage_options['ability_failure_frame_offset']['z'] = -10;
          $this_ability->damage_options['success_text'] = 'One more time!';
          $this_ability->damage_options['failure_text'] = '';
          $this_ability->recovery_options['ability_success_frame'] = 1;
          $this_ability->recovery_options['ability_success_frame_offset']['x'] = 50;
          $this_ability->recovery_options['ability_success_frame_offset']['y'] = 20;
          $this_ability->recovery_options['ability_success_frame_offset']['z'] = -10;
          $this_ability->recovery_options['ability_failure_frame'] = 1;
          $this_ability->recovery_options['ability_failure_frame_offset']['x'] = 50;
          $this_ability->recovery_options['ability_failure_frame_offset']['z'] = -10;
          $this_ability->recovery_options['success_text'] = 'One more time!';
          $this_ability->recovery_options['failure_text'] = '';
          $energy_damage_amount = ceil($energy_damage_amount * 1.10);
          $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
          
        }
        
      }
    
    }
    
    // Return true on success
    return true;
      
  }
  );
?>