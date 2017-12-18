<?
// Define a class for the battles
class mmrpg_battle {

  // Define global class variables
  private $index;
  public $flags;
  public $counters;
  public $values;
  public $events;
  public $actions;
  public $history;

  // Define the constructor class
  public function mmrpg_battle(){

    // Define the internal index pointer
    $this->index = &$GLOBALS['mmrpg_index'];

    // Collect any provided arguments
    $args = func_get_args();

    // Collect current battle data from the function if available
    $this_battleinfo = isset($args[0]) ? $args[0] : array('battle_id' => 0, 'battle_token' => 'battle');

    // Now load the battle data from the session or index
    $this->battle_load($this_battleinfo);

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function battle_load($this_battleinfo){

    // Collect current battle data from the session if available
    $this_battleinfo_backup = $this_battleinfo;
    if (isset($_SESSION['RPG2k11']['BATTLES'][$this_battleinfo['battle_id']])){
      $this_battleinfo = $_SESSION['RPG2k11']['BATTLES'][$this_battleinfo['battle_id']];
    }
    // Otherwise, collect battle data from the index
    else {
      //die(print_r($this_battleinfo, true));
      $this_battleinfo = $this->index['battles'][$this_battleinfo['battle_token']];
    }
    $this_battleinfo = array_merge($this_battleinfo, $this_battleinfo_backup);

    // Define the internal ability values using the provided array
    $this->flags = isset($this_battleinfo['flags']) ? $this_battleinfo['flags'] : array();
    $this->counters = isset($this_battleinfo['counters']) ? $this_battleinfo['counters'] : array();
    $this->values = isset($this_battleinfo['values']) ? $this_battleinfo['values'] : array();
    $this->history = isset($this_battleinfo['history']) ? $this_battleinfo['history'] : array();
    $this->events = isset($this_battleinfo['events']) ? $this_battleinfo['events'] : array();
    $this->battle_id = isset($this_battleinfo['battle_id']) ? $this_battleinfo['battle_id'] : 0;
    $this->battle_name = isset($this_battleinfo['battle_name']) ? $this_battleinfo['battle_name'] : 'Default';
    $this->battle_token = isset($this_battleinfo['battle_token']) ? $this_battleinfo['battle_token'] : 'default';
    $this->battle_description = isset($this_battleinfo['battle_description']) ? $this_battleinfo['battle_description'] : '';
    $this->battle_field = isset($this_battleinfo['battle_field']) ? $this_battleinfo['battle_field'] : array();
    $this->battle_status = isset($this_battleinfo['battle_status']) ? $this_battleinfo['battle_status'] : 'active';
//    if (empty($this->battle_id)){
//      $this->battle_id = md5(time());
//    }

    // Define the internal robot base values using the robots index array
    $this->battle_base_name = isset($this_battleinfo['battle_base_name']) ? $this_battleinfo['battle_base_name'] : $this->battle_name;
    $this->battle_base_token = isset($this_battleinfo['battle_base_token']) ? $this_battleinfo['battle_base_token'] : $this->battle_token;
    $this->battle_base_description = isset($this_battleinfo['battle_base_description']) ? $this_battleinfo['battle_base_description'] : $this->battle_description;
    $this->battle_base_field = isset($this_battleinfo['battle_base_field']) ? $this_battleinfo['battle_base_field'] : $this->battle_field;

    // Update the session variable
    $this->update_session();

    // Return true on success
    return true;

  }

  // Define public print functions for markup generation
  public function print_battle_name(){ return '<span class="battle_name">'.$this->battle_name.'</span>'; }
  public function print_battle_token(){ return '<span class="battle_token">'.$this->battle_token.'</span>'; }
  public function print_battle_description(){ return '<span class="battle_description">'.$this->battle_description.'</span>'; }

  // Define a public function for prepending to the action array
  public function actions_prepend(&$this_player, &$this_robot, &$target_player, &$target_robot, $this_action, $this_action_token){

    // Prepend the new action to the array
    array_unshift($this->actions, array(
      'this_player' => &$this_player,
      'this_robot' => &$this_robot,
      'target_player' => &$target_player,
      'target_robot' => &$target_robot,
      'this_action' => $this_action,
      'this_action_token' => $this_action_token
      ));

    // Return the resulting array
    return $this->actions;

  }

  // Define a public function for appending to the action array
  public function actions_append(&$this_player, &$this_robot, &$target_player, &$target_robot, $this_action, $this_action_token){

    // Append the new action to the array
    $this->actions[] = array(
      'this_player' => &$this_player,
      'this_robot' => &$this_robot,
      'target_player' => &$target_player,
      'target_robot' => &$target_robot,
      'this_action' => $this_action,
      'this_action_token' => $this_action_token
      );

    // Return the resulting array
    return $this->actions;

  }

  // Define a public function for emptying the actions array
  public function actions_empty(){

    // Empty the internal actions array
    $this->actions = array();

    // Return the resulting array
    return $this->actions;

  }

  // Define a public function for execution queued items in the actions array
  public function actions_execute(){

    // Loop through the non-empty action queue and trigger actions
    while (!empty($this->actions) && $this->battle_status != 'complete'){

      // Shift and collect the oldest action from the queue
      $current_action = array_shift($this->actions);

      // If the robot's player is on autopilot and the action is empty, automate input
      if (empty($current_action['this_action']) && $current_action['this_player']->player_autopilot == true){

        // Define the switch change based on remaining energy
        $energy_percent = ceil(($current_action['this_robot']->robot_energy / $current_action['this_robot']->robot_base_energy) * 100);

        // Collect this player's last action if it exists
        if (isset($current_action['this_player']->history['actions']) && !empty($current_action['this_player']->history['actions'])){
          end($current_action['this_player']->history['actions']);
          $this_last_action = current($current_action['this_player']->history['actions']);
        }
        // Otherwise define an empty action
        else {
          $this_last_action = array('this_action' => '', 'this_action_token' => '');
        }

        // One in ten chance of switching
        if ($current_action['this_player']->counters['robots_active'] > 1
          && $this_last_action['this_action'] != 'switch'
          && $this->critical_chance($energy_percent)){
          $current_action['this_action'] = 'switch';
          //$this->events_create(false, false, 'DEBUG', 'switch event automatically chosen on line 150!');
        }
        // Otherwise default to ability
        else {
          $current_action['this_action'] = 'ability';
        }

      }

      // Based on the action type, trigger the appropriate battle function
      switch ($current_action['this_action']){
        // If the battle start action was called
        case 'start': {
          // Initiate the battle start event for this robot
          $battle_action = $this->actions_trigger(
            $current_action['this_player'],
            $current_action['this_robot'],
            $current_action['target_player'],
            $current_action['target_robot'],
            'start',
            ''
            );
          break;
        }
        // If the robot ability action was called
        case 'ability': {
          // Initiate the ability event for this player's robot
          $battle_action = $this->actions_trigger(
            $current_action['this_player'],
            $current_action['this_robot'],
            $current_action['target_player'],
            $current_action['target_robot'],
            'ability',
            $current_action['this_action_token']
            );
          break;
        }
        // If the robot switch action was called
        case 'switch': {
          // Initiate the switch event  for this player's robot
          $battle_action = $this->actions_trigger(
            $current_action['this_player'],
            $current_action['this_robot'],
            $current_action['target_player'],
            $current_action['target_robot'],
            'switch',
            $current_action['this_action_token']
            );
          break;
        }
      }

    }

    // Create a closing event with robots in base frames, if the battle is not over
    if ($this->battle_status != 'complete'){
      $current_action['this_robot']->robot_frame = 'base';
      $current_action['target_robot']->robot_frame = 'base';
      $this->events_create($current_action['this_robot'], $current_action['target_robot'], '', '');
    }

    // Return true on loop completion
    return true;
  }

  // Define a public function for triggering battle actions
  public function actions_trigger(&$this_player, &$this_robot, &$target_player, &$target_robot, $this_action, $this_token = ''){

    // Default the return variable to false
    $this_return = false;

    // Create the action array in the history object if not exist
    if (!isset($this_player->history['actions'])){
      $this_player->history['actions'] = array();
    }

    // Update the session with recent changes
    $this_player->update_session();

    // Start the battle loop to allow breaking
    $battle_loop = true;
    while ($battle_loop == true){

      // If the battle is just starting
      if ($this_action == 'start'){

        // Create the enter event for this robot
        $event_header = "{$this_player->player_name}&#39;s {$this_robot->robot_name}";
        $event_body = "{$this_robot->print_robot_name()} enters the battle!<br />";
        if (isset($this_robot->robot_quotes['battle_start'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_start'].'</em>&quot;'; }
        $this_robot->robot_position = 'active';
        $this_robot->robot_frame = 'base';
        $this->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false));

        // Ensure this robot has abilities to loop through
        if (!empty($this_robot->robot_abilities)){
          // Loop through each of this robot's abilities and trigger the start event
          foreach ($this_robot->robot_abilities AS $this_key => $this_token){
            // Define the current ability object using the loaded ability data
            $temp_abilityinfo = array('ability_id' => $this_key, 'ability_token' => $this_token);
            $temp_ability = new mmrpg_ability($this, $this_player, $this_robot, $temp_abilityinfo);
            // Trigger this abilities start event, if it has one
            $this_robot->trigger_ability_event($target_robot, $temp_ability, 'battle_start');
            // Update or create this abilities session object
            $temp_ability->update_session();
          }
        }

        // Return from the battle function with the start results
        $this_return = true;
        break;

      }
      // Else if the player has chosen to use an ability
      elseif ($this_action == 'ability'){

        // If an ability token was not collected
        if (empty($this_token)){
          // Decide which ability this robot should use (random)
          $temp_ability_count = count($this_robot->robot_abilities);
          if ($temp_ability_count == 1){
            $temp_id = 0;
            $temp_token = $this_robot->robot_abilities[$temp_id];
          }
          elseif ($temp_ability_count > 1) {
            $temp_id = mt_rand(0, ($temp_ability_count - 1));
            $temp_token = $this_robot->robot_abilities[$temp_id];
          }
          else {
            $temp_id = 0;
            $temp_token = 'ability';
          }
          $this_token = array('ability_id' => $temp_id, 'ability_token' => $temp_token);
        }
        // Otherwise, parse the token for data
        else {
          list($temp_id, $temp_token) = explode('_', $this_token);
          $this_token = array('ability_id' => $temp_id, 'ability_token' => $temp_token);
        }

        // If the current robot has been already disabled
        if ($this_robot->robot_status == 'disabled'){
          // Break from this queued action as the robot cannot fight
          break;
        }

        // Define the current ability object using the loaded ability data
        $this_ability = new mmrpg_ability($this, $this_player, $this_robot, $this_token);
        // Trigger this robot's ability
        $this_ability->ability_results = $this_robot->trigger_ability($target_robot, $this_ability);

        // If this was a finishing blow, trigger the disabled event
        if ($target_robot->robot_status == 'disabled'){

          // Create the robot disabled event
          $event_header = $target_player->player_name.'&#39; '.$target_robot->robot_name;
          $event_body = "{$target_player->print_player_name()}&#39;s {$target_robot->print_robot_name()} was disabled!<br />";
          if (isset($target_robot->robot_quotes['battle_defeat'])){ $event_body .= '&quot;<em>'.$target_robot->robot_quotes['battle_defeat'].'</em>&quot;'; }
          $this_robot->robot_frame = 'base';
          $target_robot->robot_frame = 'defend';
          $this->events_create($target_robot, $this_robot, $event_header, $event_body, array('console_show_target' => false));

          // Calculate the amount of experience points awarded
          $experience_points = 1000;
          $experience_points += ceil(100 * $this_ability->ability_results['this_overkill']);
          // Award the current robot their experience points
          $this_robot->robot_experience += $experience_points;

          // Create the robot bonus events event
          $event_header = $this_player->player_name.'&#39; '.$this_robot->robot_name;
          $event_body = "{$this_robot->print_robot_name()} gains {$experience_points} experience points!<br />";
          if (isset($this_robot->robot_quotes['battle_victsory'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_victory'].'</em>&quot;'; }
          $this_robot->robot_frame = 'base';
          $target_robot->robot_frame = 'base';
          $this->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false));

          // Ensure player and robot variables are updateded
          $this_robot->update_session();
          $this_player->update_session();
          $target_robot->update_session();
          $target_player->update_session();

          // If the target player noes NOT have remaining robots to switch to
          if ($target_player->counters['robots_active'] == 0){

            $event_header = $target_player->player_name.' Defeated';
            $event_body = $target_player->player_name.' has run out of robots!<br />';
            $event_body .= $target_player->player_name.' was defeated!';
            $this->events_create(false, false, $event_header, $event_body);
            // Update the battle status to complete
            $this->battle_status = 'complete';

          }
          // Otherwise, if the player has replacement robots
          else {

            // If the target player is not on autopilot, require input
            if ($target_player->player_autopilot == false){
              // Empty the action queue to allow the player switch time
              $this->actions = array();
            }
            // Otherwise, if the target player is on autopilot, automate input
            elseif ($target_player->player_autopilot == true){

              // Queue up a switch action for the target robot
              $this->actions_prepend(
                $target_player,
                $target_robot,
                $this_player,
                $this_robot,
                'switch',
                ''
                );
            }

          }

        }
        // Otherwise, trigger the taunt event
        else {

          // Check to ensure this robot hasn't taunted already
          if (!isset($this_robot->flags['robot_quotes']['battle_taunt'])
            && isset($this_robot->robot_quotes['battle_taunt'])
            && $this_ability->ability_results['this_amount'] > 0
            && $this->critical_chance(3)){
            // Generate this robot's taunt event after dealing damage, which only happens once per battle
            $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
            $event_body = '&quot;<em>'.$this_robot->robot_quotes['battle_taunt'].'</em>&quot;';
            $this_robot->robot_frame = 'base';
            $target_robot->robot_frame = 'base';
            $this->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false));
            // Create the quote flag to ensure robots don't repeat themselves
            $this_robot->flags['robot_quotes']['battle_taunt'] = true;
          }

        }

        // Return from the battle function with the used ability
        $this_return = &$this_ability;
        break;

      }
      // Else if the player has chosen to switch
      elseif ($this_action == 'switch'){

        // If a robot token was not collected
        if (empty($this_token)){
          // Decide which robot the target should use (random)
          $temp_active_robots = $this_player->values['robots_active'];
          $temp_robot_count = count($temp_active_robots);
          if ($temp_robot_count == 1){ $this_token = $temp_active_robots[0]; }
          elseif ($temp_robot_count > 1) { $this_token = $temp_active_robots[mt_rand(0, ($temp_robot_count - 1))]; }
          else { $this_token = array('robot_id' => 0, 'robot_token' => 'robot'); }
        }
        // Otherwise, parse the token for data
        else {
          list($temp_id, $temp_token) = explode('_', $this_token);
          $this_token = array('robot_id' => $temp_id, 'robot_token' => $temp_token);
        }

        // Update this player and robot's session data before switching
        $this_player->update_session();
        $this_robot->update_session();

        // Withdraw the player's robot and display an event for it
        $this_robot->robot_position = 'bench';
        $this_robot->update_session();
        $event_header = $this_player->player_name.'&#39; '.$this_robot->robot_name;
        $event_body = "{$this_robot->print_robot_name()} is withdrawn from battle!";
        if ($this_robot->robot_status != 'disabled' && isset($this_robot->robot_quotes['battle_retreat'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_retreat'].'</em>&quot;'; }
        $this->events_create($this_robot, $target_robot, $event_header, $event_body, array('canvas_show_this' => false, 'console_show_this' => false));

        // Switch in the player's new robot and display an event for it
        $this_robot->robot_load($this_token);
        $this_robot->robot_position = 'active';
        $this_robot->update_session();
        $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
        $event_body = "{$this_robot->print_robot_name()} enters the battle!<br />";
        if (isset($this_robot->robot_quotes['battle_start'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_start'].'</em>&quot;'; }
        $this->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false));

        // Ensure this robot has abilities to loop through
        if (!empty($this_robot->robot_abilities)){
          // Loop through each of this robot's abilities and trigger the start event
          foreach ($this_robot->robot_abilities AS $this_key => $this_token){
            // Define the current ability object using the loaded ability data
            $temp_abilityinfo = array('ability_id' => $this_key, 'ability_token' => $this_token);
            $temp_ability = new mmrpg_ability($this, $this_player, $this_robot, $temp_abilityinfo);
            // Trigger this abilities start event, if it has one
            $this_robot->trigger_ability_event($target_robot, $temp_ability, 'battle_start');
            // Update or create this abilities session object
            $temp_ability->update_session();
          }
        }

        // Return from the battle function
        $this_return = true;
        break;
      }

      // Break out of the battle loop by default
      break;
    }

    // Update this player's history object with this action
    $this_player->history['actions'][] = array(
        'this_action' => $this_action,
        'this_action_token' => $this_token
        );

    // Update this battle's session data
    $this->update_session();

    // Update this player's session data
    $this_player->update_session();
    // Update the target player's session data
    $target_player->update_session();

    // Update this robot's session data
    $this_robot->update_session();
    // Update the target robot's session data
    $target_robot->update_session();

    // Update the current ability's session data
    if (isset($this_ability)){ $this_ability->update_session(); }

    // Return the result for this battle function
    return $this_return;

  }

  // Define a publicfunction for adding to the event array
  public function events_create($this_robot, $target_robot, $event_header, $event_body, $event_options = array()){

    // Append the new event to the array
    $this->events[] = array(
      'this_battle' => clone $this,
//      'this_player' => !empty($this_robot) && isset($this->values['players'][$this_robot->player_id])
//        ? $this->values['players'][$this_robot->player_id]
//        : false,
      'this_robot' => !empty($this_robot) ? clone $this_robot : false,
//      'target_player' => !empty($target_robot) && isset($this->values['players'][$target_robot->player_id])
//        ? $this->values['players'][$target_robot->player_id] : false,
      'target_robot' => !empty($target_robot) ? clone $target_robot : false,
      'event_header' => $event_header,
      'event_body' => $event_body,
      'event_options' => $event_options
      );

    // Return the resulting array
    return $this->events;

  }

  // Define a public function for emptying the events array
  public function events_empty(){

    // Empty the internal events array
    $this->events = array();

    // Return the resulting array
    return $this->events;

  }

  public function events_markup_console_message(){

  }

  // Define a function for generating robot console variables
  public function events_markup_console_robot($this_robot){

    // Define the variable to hold the console robot data
    $this_data = array();

    // Define and calculate the simpler markup and positioning variables for this robot
    $this_data['robot_frame'] = !empty($this_robot->robot_frame) ? $this_robot->robot_frame : 'base';
    $this_data['robot_title'] = $this_robot->robot_name
      .' | ID '.str_pad($this_robot->robot_id, 3, '0', STR_PAD_LEFT).''
      .' | '.$this_robot->robot_energy.' LE'
      .' | '.$this_robot->robot_attack.' AT'
      .' | '.$this_robot->robot_defense.' DF'
      .' | '.$this_robot->robot_speed.' SP';
    $this_data['robot_token'] = $this_robot->robot_token;
    $this_data['robot_float'] = $this_robot->player->player_side;
    $this_data['robot_direction'] = $this_robot->player->player_side == 'left' ? 'right' : 'left';
    $this_data['robot_status'] = $this_robot->robot_status;

    // Calculate the energy bar amount and display properties
    $this_data['energy_fraction'] = $this_robot->robot_energy.' / '.$this_robot->robot_base_energy;
    $this_data['energy_percent'] = ceil(($this_robot->robot_energy / $this_robot->robot_base_energy) * 100);
    // Calculate the energy bar positioning variables based on float
    if ($this_data['robot_float'] == 'left'){
      // Define the x position of the energy bar background
      if ($this_data['energy_percent'] == 100){ $this_data['energy_x_position'] = -82; }
      elseif ($this_data['energy_percent'] > 1){ $this_data['energy_x_position'] = -119 + floor(37 * ($this_data['energy_percent'] / 100));  }
      elseif ($this_data['energy_percent'] == 1){ $this_data['energy_x_position'] = -119; }
      else { $this_data['energy_x_position'] = -120; }
      // Define the y position of the energy bar background
      if ($this_data['energy_percent'] > 50){ $this_data['energy_y_position'] = 0; }
      elseif ($this_data['energy_percent'] > 30){ $this_data['energy_y_position'] = -5;}
      else { $this_data['energy_y_position'] = -10; }
    }
    elseif ($this_data['robot_float'] == 'right'){
      // Define the x position of the energy bar background
      if ($this_data['energy_percent'] == 100){ $this_data['energy_x_position'] = -40; }
      elseif ($this_data['energy_percent'] > 1){ $this_data['energy_x_position'] = -3 - floor(37 * ($this_data['energy_percent'] / 100)); }
      elseif ($this_data['energy_percent'] == 1){ $this_data['energy_x_position'] = -3; }
      else { $this_data['energy_x_position'] = -2; }
      // Define the y position of the energy bar background
      if ($this_data['energy_percent'] > 50){ $this_data['energy_y_position'] = 0; }
      elseif ($this_data['energy_percent'] > 30){ $this_data['energy_y_position'] = -5; }
      else { $this_data['energy_y_position'] = -10; }
    }

    // Define the rest of the display variables
    $this_data['container_class'] = 'this_sprite sprite_'.$this_data['robot_float'];
    $this_data['container_style'] = '';
    $this_data['robot_class'] = 'sprite sprite_robot_'.$this_data['robot_status'];
    $this_data['robot_style'] = '';
    $this_data['robot_size'] = 40;
    $this_data['robot_image'] = 'images/robots/'.$this_data['robot_token'].'/robot-sprite_'.$this_data['robot_direction'].'_'.$this_data['robot_frame'].'_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'.gif';
    $this_data['energy_title'] = $this_data['energy_fraction'].' LE';
    $this_data['energy_class'] = 'energy';
    $this_data['energy_style'] = 'background-position: '.$this_data['energy_x_position'].'px '.$this_data['energy_y_position'].'px;';

    // Generate the final markup for the console robot
    ob_start();
    echo '<div class="'.$this_data['container_class'].'" style="'.$this_data['container_style'].'">';
    echo '<img class="'.$this_data['robot_class'].'" style="'.$this_data['robot_style'].'" src="'.$this_data['robot_image'].'" width="'.$this_data['robot_size'].'" height="'.$this_data['robot_size'].'" alt="'.$this_data['robot_title'].'" title="'.$this_data['robot_title'].'" />';
    echo '<div class="'.$this_data['energy_class'].'" style="'.$this_data['energy_style'].'" title="'.$this_data['energy_title'].'">'.$this_data['energy_title'].'</div>';
    echo '</div>';
    $this_data['robot_markup'] = trim(ob_get_clean());

    // Return the robot console data
    return $this_data;

  }

  // Define a public function for generating event markup
  public function events_markup(){

    // Loop through all the events and generate markup for them
    $events_markup = array();
    if (!empty($this->events)){
      foreach ($this->events AS $key => $eventinfo){

      // Define defaults for event options
      $this_header_float = isset($eventinfo['event_options']['this_header_float']) ? $eventinfo['event_options']['this_header_float'] : '';
      $this_body_float = isset($eventinfo['event_options']['this_body_float']) ? $eventinfo['event_options']['this_body_float'] : '';
      $option_canvas_show_this = isset($eventinfo['event_options']['canvas_show_this']) ? $eventinfo['event_options']['canvas_show_this'] : true;
      $option_canvas_show_this_team = isset($eventinfo['event_options']['canvas_show_this_team']) ? $eventinfo['event_options']['canvas_show_this_team'] : true;
      $option_canvas_show_target = isset($eventinfo['event_options']['canvas_show_target']) ? $eventinfo['event_options']['canvas_show_target'] : true;
      $option_canvas_show_target_team = isset($eventinfo['event_options']['canvas_show_target_team']) ? $eventinfo['event_options']['canvas_show_target_team'] : true;
      $option_console_show_this = isset($eventinfo['event_options']['console_show_this']) ? $eventinfo['event_options']['console_show_this'] : true;
      $option_console_show_target = isset($eventinfo['event_options']['console_show_target']) ? $eventinfo['event_options']['console_show_target'] : true;
      $this_ability = isset($eventinfo['event_options']['this_ability']) ? $eventinfo['event_options']['this_ability'] : false;
      $this_ability_results = isset($eventinfo['event_options']['ability_results']) ? $eventinfo['event_options']['ability_results'] : array();

//      // If this robot and the target are the same, unset the target
//      if (!empty($eventinfo['this_robot']) && !empty($eventinfo['target_robot'])
//        && $eventinfo['this_robot']->robot_id == $eventinfo['target_robot']->robot_id){
//        $eventinfo['target_robot'] = false;
//      }

      // Define the variable to collect markup
      $this_markup = array();


      // Define the necessary text markup for the current robot
      if (!empty($eventinfo['this_robot'])){

//        // Define and calculate the simpler markup and positioning variables for this robot
//        $this_robot_frame = isset($eventinfo['this_robot']->robot_frame) ? $eventinfo['this_robot']->robot_frame : 'base';
//        $this_robot_title = $eventinfo['this_robot']->robot_name
//          .' | ID '.str_pad($eventinfo['this_robot']->robot_id, 3, '0', STR_PAD_LEFT).''
//          .' | '.$eventinfo['this_robot']->robot_energy.' LE'
//          .' | '.$eventinfo['this_robot']->robot_attack.' AT'
//          .' | '.$eventinfo['this_robot']->robot_defense.' DF'
//          .' | '.$eventinfo['this_robot']->robot_speed.' SP';
//        $this_robot_energy_fraction = $eventinfo['this_robot']->robot_energy.' / '.$eventinfo['this_robot']->robot_base_energy;
//        $this_robot_energy_percent = ceil(($eventinfo['this_robot']->robot_energy / $eventinfo['this_robot']->robot_base_energy) * 100);
//        $this_robot_float = $eventinfo['this_robot']->player->player_side;
//        if (empty($this_header_float)){ $this_header_float = $this_robot_float;  }
//        if (empty($this_body_float)){ $this_body_float = $this_robot_float;  }
//        $this_robot_direction = $eventinfo['this_robot']->player->player_side == 'left' ? 'right' : 'left';
//        $this_robot_canvas_offset_x = 20;
//        $this_robot_canvas_offset_y = 40;
//        if ($this_robot_frame == 'damage'){
//          $this_robot_canvas_offset_x -= isset($this_ability_results['total_strikes']) ? 5 + (5 * $this_ability_results['total_strikes']) : 5;
//          $this_robot_canvas_offset_y += isset($this_ability_results['total_strikes']) ? (1 * $this_ability_results['total_strikes']) : 1;
//        }
//        elseif ($eventinfo['this_robot']->robot_status == 'disabled'){
//          $this_robot_canvas_offset_x -= 10;
//        }
//
//        // Calculate the energy bar parameters based on float
//        if ($this_robot_float == 'left'){
//          // Define the x position of the energy bar background
//          if ($this_robot_energy_percent == 100){ $this_robot_energy_x_position = -82; }
//          elseif ($this_robot_energy_percent > 1){ $this_robot_energy_x_position = -119 + floor(37 * ($this_robot_energy_percent / 100));  }
//          elseif ($this_robot_energy_percent == 1){ $this_robot_energy_x_position = -119; }
//          else { $this_robot_energy_x_position = -120; }
//          // Define the y position of the energy bar background
//          if ($this_robot_energy_percent > 50){ $this_robot_energy_y_position = 0; }
//          elseif ($this_robot_energy_percent > 30){ $this_robot_energy_y_position = -5;}
//          else { $this_robot_energy_y_position = -10; }
//        }
//        elseif ($this_robot_float == 'right'){
//          // Define the x position of the energy bar background
//          if ($this_robot_energy_percent == 100){ $this_robot_energy_x_position = -40; }
//          elseif ($this_robot_energy_percent > 1){ $this_robot_energy_x_position = -3 - floor(37 * ($this_robot_energy_percent / 100)); }
//          elseif ($this_robot_energy_percent == 1){ $this_robot_energy_x_position = -3; }
//          else { $this_robot_energy_x_position = -2; }
//          // Define the y position of the energy bar background
//          if ($this_robot_energy_percent > 50){ $this_robot_energy_y_position = 0; }
//          elseif ($this_robot_energy_percent > 30){ $this_robot_energy_y_position = -5; }
//          else { $this_robot_energy_y_position = -10; }
//        }

        // Collect the console data for this robot
        $this_robot_data = $this->events_markup_console_robot($eventinfo['this_robot']);

      }
      // Otherwise set this robot's show variables to false
      else {
        $option_canvas_show_this = false;
        $option_console_show_this = false;
      }

      // Define the necessary text markup for the target robot
      if (!empty($eventinfo['target_robot'])){

//        // Define and calculate the simpler markup and positioning variables for the target robot
//        $target_robot_frame = isset($eventinfo['target_robot']->robot_frame) ? $eventinfo['target_robot']->robot_frame : 'base';
//        $target_robot_title = $eventinfo['target_robot']->robot_name
//          .' | ID '.str_pad($eventinfo['target_robot']->robot_id, 3, '0', STR_PAD_LEFT).''
//          .' | '.$eventinfo['target_robot']->robot_energy.' LE'
//          .' | '.$eventinfo['target_robot']->robot_attack.' AT'
//          .' | '.$eventinfo['target_robot']->robot_defense.' DF'
//          .' | '.$eventinfo['target_robot']->robot_speed.' SP';
//        $target_robot_energy_fraction = $eventinfo['target_robot']->robot_energy.' / '.$eventinfo['target_robot']->robot_base_energy;
//        $target_robot_energy_percent = ceil(($eventinfo['target_robot']->robot_energy / $eventinfo['target_robot']->robot_base_energy) * 100);
//        $target_robot_float = $eventinfo['target_robot']->player->player_side;
//        $target_robot_direction = $eventinfo['target_robot']->player->player_side == 'left' ? 'right' : 'left';
//        $target_robot_canvas_offset_x = 20;
//        $target_robot_canvas_offset_y = 40;
//        if ($target_robot_frame == 'damage'){
//          $target_robot_canvas_offset_x -= isset($this_ability_results['total_strikes']) ? 5 + (5 * $this_ability_results['total_strikes']) : 5;
//          $target_robot_canvas_offset_y += isset($this_ability_results['total_strikes']) ? (1 * $this_ability_results['total_strikes']) : 1;
//        }
//        elseif ($eventinfo['target_robot']->robot_status == 'disabled'){
//          $target_robot_canvas_offset_x -= 10;
//        }
//
//        // Calculate the energy bar parameters based on float
//        if ($target_robot_float == 'left'){
//          // Define the x position of the energy bar background
//          if ($target_robot_energy_percent == 100){ $target_robot_energy_x_position = -82; }
//          elseif ($target_robot_energy_percent > 1){ $target_robot_energy_x_position = -119 + floor(37 * ($target_robot_energy_percent / 100));  }
//          elseif ($target_robot_energy_percent == 1){ $target_robot_energy_x_position = -119; }
//          else { $target_robot_energy_x_position = -120; }
//          // Define the y position of the energy bar background
//          if ($target_robot_energy_percent > 50){ $target_robot_energy_y_position = 0; }
//          elseif ($target_robot_energy_percent > 30){ $target_robot_energy_y_position = -5;}
//          else { $target_robot_energy_y_position = -10; }
//        }
//        elseif ($target_robot_float == 'right'){
//          // Define the x position of the energy bar background
//          if ($target_robot_energy_percent == 100){ $target_robot_energy_x_position = -40; }
//          elseif ($target_robot_energy_percent > 1){ $target_robot_energy_x_position = -3 - floor(37 * ($target_robot_energy_percent / 100)); }
//          elseif ($target_robot_energy_percent == 1){ $target_robot_energy_x_position = -3; }
//          else { $target_robot_energy_x_position = -2; }
//          // Define the y position of the energy bar background
//          if ($target_robot_energy_percent > 50){ $target_robot_energy_y_position = 0; }
//          elseif ($target_robot_energy_percent > 30){ $target_robot_energy_y_position = -5; }
//          else { $target_robot_energy_y_position = -10; }
//        }

        // Collect the console data for the target robot
        $target_robot_data = $this->events_markup_console_robot($eventinfo['target_robot']);

      }
      // Otherwise set this robot's show variables to false
      else {
        $option_canvas_show_target = false;
        $option_console_show_target = false;
      }

      // Assign player-side based floats for the header and body if not set
      if (empty($this_header_float)){ $this_header_float = $this_robot_data['robot_float'];  }
      if (empty($this_body_float)){ $this_body_float = $this_robot_data['robot_float'];  }

      // Create the event console markup
      ob_start();
      if (!empty($eventinfo['event_header']) && !empty($eventinfo['event_body'])){
        if($option_console_show_this):
          echo $this_robot_data['robot_markup'];
          /*
          ?><div class="this_sprite sprite_<?= $this_robot_float ?>"><?
          ?><img class="sprite sprite_robot_<?= $eventinfo['this_robot']->robot_status ?>" src="images/robots/<?=$eventinfo['this_robot']->robot_token?>/robot-sprite_<?= $this_robot_direction ?>_<?= $this_robot_frame ?>_40x40.gif" width="40" height="40" alt="<?= $this_robot_title ?>" title="<?= $this_robot_title ?>" /><?
          ?><div class="energy" title="<?= $this_robot_energy_fraction.' LE' ?>" style="background-position: <?=$this_robot_energy_x_position?>px <?=$this_robot_energy_y_position?>px;"><?=$this_robot_energy_fraction?></div><?
          ?></div><?
          */
        endif;
        if($option_console_show_target):
          echo $target_robot_data['robot_markup'];
          /*
          ?><div class="target_sprite sprite_<?= $target_robot_float ?>"><?
          ?><img class="sprite sprite_robot_<?= $eventinfo['target_robot']->robot_status ?>" src="images/robots/<?=$eventinfo['target_robot']->robot_token?>/robot-sprite_<?= $target_robot_direction ?>_<?= $target_robot_frame ?>_40x40.gif" width="40" height="40" alt="<?= $target_robot_title ?>" title="<?= $target_robot_title ?>" /><?
          ?><div class="energy" title="<?= $target_robot_energy_fraction.' LE' ?>" style="background-position: <?= $target_robot_energy_x_position ?>px <?=$target_robot_energy_y_position?>px;"><?=$target_robot_energy_fraction?></div><?
          ?></div><?
          */
        endif;
        ?><div class="header header_<?= $this_header_float ?>"><?= $eventinfo['event_header'] ?></div><?
        ?><div class="body body_<?= $this_body_float ?>"><?= $eventinfo['event_body'] ?></div><?
      }
      $this_markup['console'] = trim(ob_get_clean());
      $this_markup['console'] = preg_replace('#\s+#', ' ', $this_markup['console']);
































      // Define the necessary text markup for the current robot
      if (!empty($eventinfo['this_robot'])){

        // Define and calculate the simpler markup and positioning variables for this robot
        $this_robot_frame = isset($eventinfo['this_robot']->robot_frame) ? $eventinfo['this_robot']->robot_frame : 'base';
        $this_robot_title = $eventinfo['this_robot']->robot_name
          .' | ID '.str_pad($eventinfo['this_robot']->robot_id, 3, '0', STR_PAD_LEFT).''
          .' | '.$eventinfo['this_robot']->robot_energy.' LE'
          .' | '.$eventinfo['this_robot']->robot_attack.' AT'
          .' | '.$eventinfo['this_robot']->robot_defense.' DF'
          .' | '.$eventinfo['this_robot']->robot_speed.' SP';
        $this_robot_energy_fraction = $eventinfo['this_robot']->robot_energy.' / '.$eventinfo['this_robot']->robot_base_energy;
        $this_robot_energy_percent = ceil(($eventinfo['this_robot']->robot_energy / $eventinfo['this_robot']->robot_base_energy) * 100);
        $this_robot_float = $eventinfo['this_robot']->player->player_side;
        if (empty($this_header_float)){ $this_header_float = $this_robot_float;  }
        if (empty($this_body_float)){ $this_body_float = $this_robot_float;  }
        $this_robot_direction = $eventinfo['this_robot']->player->player_side == 'left' ? 'right' : 'left';
        $this_robot_canvas_offset_x = 20;
        $this_robot_canvas_offset_y = 40;
        if ($this_robot_frame == 'damage'){
          $this_robot_canvas_offset_x -= isset($this_ability_results['total_strikes']) ? 5 + (5 * $this_ability_results['total_strikes']) : 5;
          $this_robot_canvas_offset_y += isset($this_ability_results['total_strikes']) ? (1 * $this_ability_results['total_strikes']) : 1;
        }
        elseif ($eventinfo['this_robot']->robot_status == 'disabled'){
          $this_robot_canvas_offset_x -= 10;
        }

        // Calculate the energy bar parameters based on float
        if ($this_robot_float == 'left'){
          // Define the x position of the energy bar background
          if ($this_robot_energy_percent == 100){ $this_robot_energy_x_position = -82; }
          elseif ($this_robot_energy_percent > 1){ $this_robot_energy_x_position = -119 + floor(37 * ($this_robot_energy_percent / 100));  }
          elseif ($this_robot_energy_percent == 1){ $this_robot_energy_x_position = -119; }
          else { $this_robot_energy_x_position = -120; }
          // Define the y position of the energy bar background
          if ($this_robot_energy_percent > 50){ $this_robot_energy_y_position = 0; }
          elseif ($this_robot_energy_percent > 30){ $this_robot_energy_y_position = -5;}
          else { $this_robot_energy_y_position = -10; }
        }
        elseif ($this_robot_float == 'right'){
          // Define the x position of the energy bar background
          if ($this_robot_energy_percent == 100){ $this_robot_energy_x_position = -40; }
          elseif ($this_robot_energy_percent > 1){ $this_robot_energy_x_position = -3 - floor(37 * ($this_robot_energy_percent / 100)); }
          elseif ($this_robot_energy_percent == 1){ $this_robot_energy_x_position = -3; }
          else { $this_robot_energy_x_position = -2; }
          // Define the y position of the energy bar background
          if ($this_robot_energy_percent > 50){ $this_robot_energy_y_position = 0; }
          elseif ($this_robot_energy_percent > 30){ $this_robot_energy_y_position = -5; }
          else { $this_robot_energy_y_position = -10; }
        }

      }
      // Otherwise set this robot's show variables to false
      else {
        $option_canvas_show_this = false;
        $option_console_show_this = false;
      }

      // TODO

//      // Define the target robot object if it was not set
//      if (empty($eventinfo['target_robot'])){
//        $this_player_id = $eventinfo['this_robot']->player_id;
//        $target_playerinfo = array();
//        $target_robotinfo = array();
//        foreach ($this->values['players'] AS $temp_playerinfo){
//          if ($temp_playerinfo['player_id'] != $this_player_id){
//            $target_playerinfo = $temp_playerinfo;
//            $eventinfo['target_player'] = new mmrpg_player($this, $target_playerinfo);
//            foreach ($this->values['robots'] AS $temp_robotinfo){
//              if ($temp_robotinfo['player_id'] == $target_playerinfo['player_id']
//                && $temp_robotinfo['robot_position'] == 'active'){
//                $target_robotinfo = $temp_robotinfo;
//                $eventinfo['target_robot'] = new mmrpg_robot($this, $eventinfo['target_player'], $target_robotinfo);
//                break;
//              }
//            }
//            break;
//          }
//        }
//      }


      // Define the necessary text markup for the target robot
      if (!empty($eventinfo['target_robot'])){

        // Define and calculate the simpler markup and positioning variables for the target robot
        $target_robot_frame = isset($eventinfo['target_robot']->robot_frame) ? $eventinfo['target_robot']->robot_frame : 'base';
        $target_robot_title = $eventinfo['target_robot']->robot_name
          .' | ID '.str_pad($eventinfo['target_robot']->robot_id, 3, '0', STR_PAD_LEFT).''
          .' | '.$eventinfo['target_robot']->robot_energy.' LE'
          .' | '.$eventinfo['target_robot']->robot_attack.' AT'
          .' | '.$eventinfo['target_robot']->robot_defense.' DF'
          .' | '.$eventinfo['target_robot']->robot_speed.' SP';
        $target_robot_energy_fraction = $eventinfo['target_robot']->robot_energy.' / '.$eventinfo['target_robot']->robot_base_energy;
        $target_robot_energy_percent = ceil(($eventinfo['target_robot']->robot_energy / $eventinfo['target_robot']->robot_base_energy) * 100);
        $target_robot_float = $eventinfo['target_robot']->player->player_side;
        $target_robot_direction = $eventinfo['target_robot']->player->player_side == 'left' ? 'right' : 'left';
        $target_robot_canvas_offset_x = 20;
        $target_robot_canvas_offset_y = 40;
        if ($target_robot_frame == 'damage'){
          $target_robot_canvas_offset_x -= isset($this_ability_results['total_strikes']) ? 5 + (5 * $this_ability_results['total_strikes']) : 5;
          $target_robot_canvas_offset_y += isset($this_ability_results['total_strikes']) ? (1 * $this_ability_results['total_strikes']) : 1;
        }
        elseif ($eventinfo['target_robot']->robot_status == 'disabled'){
          $target_robot_canvas_offset_x -= 10;
        }

        // Calculate the energy bar parameters based on float
        if ($target_robot_float == 'left'){
          // Define the x position of the energy bar background
          if ($target_robot_energy_percent == 100){ $target_robot_energy_x_position = -82; }
          elseif ($target_robot_energy_percent > 1){ $target_robot_energy_x_position = -119 + floor(37 * ($target_robot_energy_percent / 100));  }
          elseif ($target_robot_energy_percent == 1){ $target_robot_energy_x_position = -119; }
          else { $target_robot_energy_x_position = -120; }
          // Define the y position of the energy bar background
          if ($target_robot_energy_percent > 50){ $target_robot_energy_y_position = 0; }
          elseif ($target_robot_energy_percent > 30){ $target_robot_energy_y_position = -5;}
          else { $target_robot_energy_y_position = -10; }
        }
        elseif ($target_robot_float == 'right'){
          // Define the x position of the energy bar background
          if ($target_robot_energy_percent == 100){ $target_robot_energy_x_position = -40; }
          elseif ($target_robot_energy_percent > 1){ $target_robot_energy_x_position = -3 - floor(37 * ($target_robot_energy_percent / 100)); }
          elseif ($target_robot_energy_percent == 1){ $target_robot_energy_x_position = -3; }
          else { $target_robot_energy_x_position = -2; }
          // Define the y position of the energy bar background
          if ($target_robot_energy_percent > 50){ $target_robot_energy_y_position = 0; }
          elseif ($target_robot_energy_percent > 30){ $target_robot_energy_y_position = -5; }
          else { $target_robot_energy_y_position = -10; }
        }
      }
      // Otherwise set this robot's show variables to false
      else {
        $option_canvas_show_target = false;
        $option_console_show_target = false;
      }

      // Create the event canvas markup
      ob_start();
      ?>
      <div class="background" style="background-image: url(images/fields/<?= $this->battle_field['field_background'] ?>/battle-field_background_base.png);">&nbsp;</div>
      <div class="foreground" style="background-image: url(images/fields/<?= $this->battle_field['field_foreground'] ?>/battle-field_foreground_base.png);">&nbsp;</div>
      <?if($option_canvas_show_this):?>
        <img class="sprite sprite_robot_<?= $eventinfo['this_robot']->robot_status ?>" src="images/robots/<?=$eventinfo['this_robot']->robot_token?>/robot-sprite_<?= $this_robot_direction ?>_<?= $this_robot_frame ?>_80x80.gif" width="80" height="80" alt="<?= $this_robot_title ?>" title="<?= $this_robot_title ?>" style="z-index: 100; <?= $this_robot_float ?>: <?= $this_robot_canvas_offset_x ?>px; bottom: <?= $this_robot_canvas_offset_y ?>px;" />
      <?endif;?>
      <?if($option_canvas_show_target):?>
        <img class="sprite sprite_robot_<?= $eventinfo['target_robot']->robot_status ?>" src="images/robots/<?=$eventinfo['target_robot']->robot_token?>/robot-sprite_<?= $target_robot_direction ?>_<?= $target_robot_frame ?>_80x80.gif" width="80" height="80" alt="<?= $target_robot_title ?>" title="<?= $target_robot_title ?>" style="z-index: 100; <?= $target_robot_float ?>: <?= $target_robot_canvas_offset_x ?>px; bottom: <?= $target_robot_canvas_offset_y ?>px;" />
      <?endif;?>
      <?
      $this_markup['canvas'] = trim(ob_get_clean());
      $this_markup['canvas'] = preg_replace('#\s+#', ' ', $this_markup['canvas']);


































      // Generate the jSON encoded event data markup
      $this_markup['data'] = array();
      //$this_markup['data']['this_battle'] = $eventinfo['this_battle']->export_array();
      $this_markup['data']['this_player'] = !empty($eventinfo['this_player']) ? $eventinfo['this_player']->export_array() : false;
      $this_markup['data']['this_robot'] = !empty($eventinfo['this_robot']) ? $eventinfo['this_robot']->export_array() : false;
      $this_markup['data']['target_player'] = !empty($eventinfo['target_player']) ? $eventinfo['target_player']->export_array() : false;
      $this_markup['data']['target_robot'] = !empty($eventinfo['target_robot']) ? $eventinfo['target_robot']->export_array() : false;
      $this_markup['data'] = json_encode($this_markup['data']);

      // Add the generated markup to the parent array
      $events_markup[] = $this_markup;

      }
    }

    // Return the generated event markup
    return $events_markup;

  }





  // Define a public function for generating the canvas scene
  public function events_markup_canvas($objects){

    // Extract the function arguments as local variables
    extract($objects);

    // Collect and define the battle variables
    $battle_field_background = !empty($this_battle->battle_field['field_background']) ? $this_battle->battle_field['field_background'] : 'field';
    $battle_field_background = !empty($this_battle->battle_field['field_foreground']) ? $this_battle->battle_field['field_foreground'] : 'field';


  }






  // Define a function for returning a weighted random chance
  public function weighted_chance($values, $weights = array()){

    // Count the number of values passed
    $value_amount = count($values);

    // If no weights have been defined, auto-generate
    if (empty($weights)){
      $weights = array();
      for ($i = 0; $i < $value_amount; $i++){
        $weights[] = 1;
      }
    }

    // Calculate the sum of all weights
    $weight_sum = array_sum($weights);

    // Define the two counter variables
    $value_counter = 0;
    $weight_counter = 0;

    // Randomly generate a number from zero to the sum of weights
    $random_number = mt_rand(0, array_sum($weights));
    while($value_counter < $value_amount){
      $weight_counter += $weights[$value_counter];
      if ($weight_counter >= $random_number){ break; }
      $value_counter++;
    }

    // Return the random element
    return $values[$value_counter];

  }

  // Define a function for returning a critical chance
  public function critical_chance($chance_percent = 10){

    // Invert if negative for some reason
    if ($chance_percent < 0){ $chance_percent = -1 * $chance_percent; }
    // Round up to a whole number
    $chance_percent = ceil($chance_percent);
    // If zero, automatically return false
    if ($chance_percent == 0){ return false; }
    // Return true of false at random
    $random_int = mt_rand(1, 100);
    return ($random_int <= $chance_percent) ? true : false;

  }

  // Define a public function for recalculating internal counters
  public function update_variables(){

    // Calculate this battle's count variables
    //$this->counters['thing'] = count($this->robot_stuff);

    // Return true on success
    return true;

  }

  // Define a public function for updating this player's session
  public function update_session(){

    // Update any internal counters
    $this->update_variables();

    // Update the session with the export array
    $this_data = $this->export_array();
    $_SESSION['RPG2k11']['BATTLES'][$this->battle_id] = $this_data;

    // Return true on success
    return true;

  }

  // Define a function for exporting the current data
  public function export_array(){

    // Return all internal ability fields in array format
    return array(
      'flags' => $this->flags,
      'counters' => $this->counters,
      'values' => $this->values,
      'history' => $this->history,
      'battle_id' => $this->battle_id,
      'battle_name' => $this->battle_name,
      'battle_token' => $this->battle_token,
      'battle_description' => $this->battle_description,
      'battle_field' => $this->battle_field,
      'battle_base_name' => $this->battle_base_name,
      'battle_base_token' => $this->battle_base_token,
      'battle_base_description' => $this->battle_base_description,
      'battle_base_field' => $this->battle_base_field,
      'battle_status' => $this->battle_status
      );

  }

}
?>