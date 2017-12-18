<?
// BUSTER
$ability = array(
  'ability_name' => 'Buster',
  'ability_token' => 'buster',
  'ability_description' => 'The user fires a single energy shot at the target using a buster or gun.',
  'ability_damage' => 10,
  'ability_accuracy' => 95,
  'ability_function' => function($objects){
    
    // Extract all objects into the current scope
    extract($objects);
    
    // Define the local damage amount variable and default to the base value
    $damage_amount = $this_ability->ability_damage;
    
    // Define the damage success/failure text for this attack
    $this_ability->damage_options['success_text'] = "The shot hit the target!";
    $this_ability->damage_options['failure_text'] = "The {$this_ability->print_ability_name()} shot missed!";
    
    // Define and populate this ability event's header text
    $event_header = $this_robot->robot_name.'&#39;s '.$this_ability->ability_name;
    
    // If this robot has a type, use it to upgrade this ability
    if (!empty($this_robot->robot_type) && empty($this_ability->ability_type)){
      $this_robot->trigger_ability_event($target_robot, $this_ability, 'battle_start');
    }

    // Create an event to show the targeting action
    $this_robot->robot_frame = 'attack';
    $event_body = "{$this_robot->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    $event_body .= "{$this_robot->print_robot_name()} fires its {$this_ability->print_ability_name()}!";
    $this_battle->events_create($this_robot, $target_robot, $event_header, $event_body, array('this_ability' => $this_ability));
    
    // Trigger damage to the target robot
    $target_robot->trigger_damage($this_robot, $this_ability, $this_ability->ability_results, $damage_amount, $this_ability->damage_options);

    // Return true on success
    return true;
      
    },
  'ability_events' => array(
    'battle_start' => function($objects){
          
        // Extract all objects into the current scope
        extract($objects);
        
        // If this robot has a type, use it to upgrade this ability
        if (!empty($this_robot->robot_type) && empty($this_ability->ability_type)){
          // Copy over this robot's type to the ability
          $this_ability->ability_type = $this_robot->robot_type;
          // Collect the abilityinfo from the types index
          $this_typeinfo = $this_index['types'][$this_ability->ability_type];
          // Rename the ability by prepending the type
          $this_ability->ability_name = $this_typeinfo['type_name'].' '.$this_ability->ability_name;
          $this_ability->ability_description = str_replace('energy', $this_typeinfo['type_name'].'-type', $this_ability->ability_description);
        }
    
    }
    )
  );
?>