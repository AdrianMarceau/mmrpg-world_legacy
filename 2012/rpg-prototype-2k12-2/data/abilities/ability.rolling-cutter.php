<?
// ROLLING CUTTER
$ability = array(
  'ability_name' => 'Rolling Cutter',
  'ability_token' => 'rolling-cutter',
  'ability_image' => 'rolling-cutter',
  'ability_description' => 'The user throws a boomerang-like blade that strikes the target up to four times at increasing strength!',
  'ability_type' => 'cutter',
  'ability_damage' => 5,
  'ability_accuracy' => 75,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Target the opposing robot
    $this_ability->target_options_update(array(
      'frame' => 'throw',
      'success' => array(1, 100, 0, 10, $this_robot->print_robot_name().' throws a '.$this_ability->print_ability_name().'!')
      ));
    $this_robot->trigger_target($target_robot, $this_ability);
    
    // Inflict damage on the opposing robot
    $this_ability->damage_options_update(array(
      'kind' => 'energy',
      'kickback' => array(10, 0, 0),
      'success' => array(0, 0, 5, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(0, -50, 5, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $this_ability->recovery_options_update(array(
      'kind' => 'energy',
      'frame' => 'taunt',
      'kickback' => array(0, 0, 0),
      'success' => array(0, 0, 5, 10, 'The '.$this_ability->print_ability_name().' hit the target!'),
      'failure' => array(0, -50, 5, -10, 'The '.$this_ability->print_ability_name().' missed&hellip;')
      ));
    $energy_damage_amount = $this_ability->ability_damage;
    $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);
    

    // If this attack returns and strikes a second time (random chance)
    if ($this_ability->ability_results['this_result'] != 'failure'
      && $target_robot->robot_status != 'disabled'){

      // Inflict damage on the opposing robot
      $this_ability->damage_options_update(array(
        'kind' => 'energy',
        'kickback' => array(20, 0, 0),
        'success' => array(1, -40, 10, 10, 'Oh! It hit again!'),
        'failure' => array(1, -90, 10, -10, '')
        ));
      $this_ability->recovery_options_update(array(
        'kind' => 'energy',
        'kickback' => array(0, 0, 0),
        'frame' => 'taunt',
        'success' => array(1, -40, 10, 10, 'Oh! It hit again!'),
        'failure' => array(1, -90, 10, -10, '')
        ));
      $energy_damage_amount = ceil($energy_damage_amount * 1.10);
      $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

      // If this attack returns and strikes a third time (random chance)
      if ($this_ability->ability_results['this_result'] != 'failure'
        && $target_robot->robot_energy != 'disabled'){
        
        // Inflict damage on the opposing robot
        $this_ability->damage_options_update(array(
          'kind' => 'energy',
          'kickback' => array(30, 0, 0),
          'success' => array(2, 10, 15, -10, 'Wow! A third hit?!?'),
          'failure' => array(2, 60, 15, -10, '')
          ));
        $this_ability->recovery_options_update(array(
          'kind' => 'energy',
          'frame' => 'taunt',
          'kickback' => array(0, 0, 0),
          'success' => array(2, 10, 15, -10, 'Wow! A third hit?!?'),
          'failure' => array(2, 60, 15, -10, '')
          ));
        $energy_damage_amount = ceil($energy_damage_amount * 1.10);
        $target_robot->trigger_damage($this_robot, $this_ability, $energy_damage_amount);

        // If this attack returns and strikes a fourth time (random chance)
        if ($this_ability->ability_results['this_result'] != 'failure'
          && $target_robot->robot_status != 'disabled'){
          
          // Inflict damage on the opposing robot
          $this_ability->damage_options_update(array(
            'kind' => 'energy',
            'kickback' => array(40, 0, 0),
            'success' => array(3, 50, 20, -10, 'Nice! One more time!'),
            'failure' => array(3, 90, 20, -10, '')
            ));
          $this_ability->recovery_options_update(array(
            'kind' => 'energy',
            'frame' => 'taunt',
            'kickback' => array(0, 0, 0),
            'success' => array(3, 50, 20, -10, 'Nice! One more time!'),
            'failure' => array(3, 90, 20, -10, '')
            ));
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