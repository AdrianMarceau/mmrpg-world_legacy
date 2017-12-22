<?
// Define a class for the battles
class mmrpg_battle {

  // Define global class variables
  public $config;
  public $index;
  public $flags;
  public $counters;
  public $values;
  public $events;
  public $actions;
  public $history;

  // Define the constructor class
  public function mmrpg_battle(){

    // Surround constructor in try...catch stack 'cause I read it on the internet
    try {

      // Define the internal config pointer
      $this->config = &$GLOBALS['MMRPG_CONFIG'];

      // Define the internal index pointer
      $this->index = &$GLOBALS['mmrpg_index'];

      // Collect any provided arguments
      $args = func_get_args();

      // Collect current battle data from the function if available
      $this_battleinfo = isset($args[0]) ? $args[0] : array('battle_id' => 0, 'battle_token' => 'battle');

      // Now load the battle data from the session or index
      $this->battle_load($this_battleinfo);

      //throw new Exception("testing 123 battle?");

    } catch (Exception $e) {

      // Kill the script and print the exception
      die('Exception?!?! ('.$e->getMessage().')');

    }

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function battle_load($this_battleinfo){

    // Collect current battle data from the session if available
    $this_battleinfo_backup = $this_battleinfo;
    if (isset($_SESSION['RPG2k12-2']['BATTLES'][$this_battleinfo['battle_id']])){
      $this_battleinfo = $_SESSION['RPG2k12-2']['BATTLES'][$this_battleinfo['battle_id']];
    }
    // Otherwise, collect battle data from the index
    else {
      //die(print_r($this_battleinfo, true));
      $this_battleinfo = $this->index['battles'][$this_battleinfo['battle_token']];
    }
    $this_battleinfo = array_replace($this_battleinfo, $this_battleinfo_backup);

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
    $this->battle_turns = isset($this_battleinfo['battle_turns']) ? $this_battleinfo['battle_turns'] : 1;
    $this->battle_status = isset($this_battleinfo['battle_status']) ? $this_battleinfo['battle_status'] : 'active';
    $this->battle_robot_limit = isset($this_battleinfo['battle_robot_limit']) ? $this_battleinfo['battle_robot_limit'] : 1;
    $this->battle_field_base = isset($this_battleinfo['battle_field_base']) ? $this_battleinfo['battle_field_base'] : array();
    $this->battle_target_player = isset($this_battleinfo['battle_target_player']) ? $this_battleinfo['battle_target_player'] : array();
    $this->battle_rewards = isset($this_battleinfo['battle_rewards']) ? $this_battleinfo['battle_rewards'] : array();
    $this->battle_points = isset($this_battleinfo['battle_points']) ? $this_battleinfo['battle_points'] : 0;

    // Define the internal robot base values using the robots index array
    $this->battle_base_name = isset($this_battleinfo['battle_base_name']) ? $this_battleinfo['battle_base_name'] : $this->battle_name;
    $this->battle_base_token = isset($this_battleinfo['battle_base_token']) ? $this_battleinfo['battle_base_token'] : $this->battle_token;
    $this->battle_base_description = isset($this_battleinfo['battle_base_description']) ? $this_battleinfo['battle_base_description'] : $this->battle_description;
    $this->battle_base_turns = isset($this_battleinfo['battle_base_turns']) ? $this_battleinfo['battle_base_turns'] : $this->battle_turns;
    $this->battle_base_rewards = isset($this_battleinfo['battle_base_rewards']) ? $this_battleinfo['battle_base_rewards'] : $this->battle_rewards;
    $this->battle_base_points = isset($this_battleinfo['battle_base_points']) ? $this_battleinfo['battle_base_points'] : $this->battle_points;

    // Update the session variable
    $this->update_session();

    // Return true on success
    return true;

  }

  // Define public print functions for markup generation
  public function print_battle_name(){ return '<span class="battle_name">'.$this->battle_name.'</span>'; }
  public function print_battle_token(){ return '<span class="battle_token">'.$this->battle_token.'</span>'; }
  public function print_battle_description(){ return '<span class="battle_description">'.$this->battle_description.'</span>'; }
  public function print_battle_points(){ return '<span class="battle_points">'.$this->battle_points.'</span>'; }

  // Define a public function for prepending to the action array
  public function actions_prepend(&$this_player, &$this_robot, &$target_player, &$target_robot, $this_action, $this_action_token){

    // Prepend the new action to the array
    array_unshift($this->actions, array(
      'this_field' => &$this->battle_field,
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
      'this_field' => &$this->battle_field,
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
        $damage_percent = 100 - $energy_percent;

        // Collect this player's last action if it exists
        if (!empty($current_action['this_player']->history['actions'])){
          end($current_action['this_player']->history['actions']);
          $this_last_action = current($current_action['this_player']->history['actions']);
          $this_recent_actions = array_slice($current_action['this_player']->history['actions'], -5, 5, false);
          foreach ($this_recent_actions AS $key => $info){
            $this_recent_actions[$key] = $info['this_action'];
          }
        }
        // Otherwise define an empty action
        else {
          $this_last_action = array('this_action' => '', 'this_action_token' => '');
          $this_recent_actions = array();
        }

        // One in ten chance of switching
        if ($current_action['this_player']->counters['robots_active'] > 1
          && $damage_percent > 0
          && !in_array('start', $this_recent_actions)
          && !in_array('switch', $this_recent_actions)
          && $this->critical_chance($damage_percent)){
          $current_action['this_action'] = 'switch';
          //$this->events_create(false, false, 'DEBUG', 'switch event automatically chosen on line 150! <pre>'.preg_replace('#\s+#', ' ', print_r($this_recent_actions, true)).'</pre>');
        }
        /*
        // Otherwise, one in ten chance of scanning
        elseif ($damage_percent < 50 && $this->critical_chance(5)){
          $current_action['this_action'] = 'scan';
        }
        */
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
          // Initiate the switch event for this player's robot
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
        // If the robot scan action was called
        case 'scan': {
          // Initiate the scan event for this player's robot
          $battle_action = $this->actions_trigger(
            $current_action['this_player'],
            $current_action['this_robot'],
            $current_action['target_player'],
            $current_action['target_robot'],
            'scan',
            $current_action['this_action_token']
            );
          break;
        }
      }

      // Create a closing event with robots in base frames, if the battle is not over
      if ($this->battle_status != 'complete'){
        $this_robot = false;
        $target_robot = false;
        if (!empty($current_action['this_robot'])){
          $current_action['this_robot']->robot_frame = $current_action['this_robot']->robot_status != 'disabled' ? 'base' : 'defeat';
          $current_action['this_robot']->update_session();
          $current_action['this_player']->player_frame = $current_action['this_robot']->robot_status != 'disabled' ? 'base' : 'defeat';
          $current_action['this_player']->update_session();
          $this_robot = $current_action['this_robot'];
        }
        if (!empty($current_action['target_robot'])){
          $current_action['target_robot']->robot_frame = $current_action['target_robot']->robot_status != 'disabled' ? 'base' : 'defeat';
          $current_action['target_robot']->update_session();
          $current_action['target_player']->player_frame = $current_action['target_robot']->robot_status != 'disabled' ? 'base' : 'defeat';
          $current_action['target_player']->update_session();
          $target_robot = $current_action['target_robot'];
        }
        $this->events_create($this_robot, $target_robot, '', '');
      }

    }

    /*

    // Create a closing event with robots in base frames, if the battle is not over
    if ($this->battle_status != 'complete'){
      $this_robot = false;
      $target_robot = false;
      if (!empty($current_action['this_robot'])){
        $current_action['this_robot']->robot_frame = $current_action['this_robot']->robot_status != 'disabled' ? 'base' : 'defeat';
        $current_action['this_robot']->update_session();
        $this_robot = $current_action['this_robot'];
      }
      if (!empty($current_action['target_robot'])){
        $current_action['target_robot']->robot_frame = $current_action['target_robot']->robot_status != 'disabled' ? 'base' : 'defeat';
        $current_action['target_robot']->update_session();
        $target_robot = $current_action['target_robot'];
      }
      $this->events_create($this_robot, $target_robot, '', '');
    }

    */

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

        // Ensure this is an actual player
        if ($this_player->player_token != 'player'){

          // Create the enter event for this robot
          $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
          if ($target_player->player_token != 'player'){ $event_body = "{$this_robot->print_robot_name()} enters the battle!<br />"; }
          else { $event_body = "{$this_robot->print_robot_name()} prepares for battle!<br />"; }
          $this_robot->robot_frame = 'base';
          $this_player->player_frame = 'command';
          $this_robot->robot_position = 'active';
          if (isset($this_robot->robot_quotes['battle_start'])){
            $this_robot->robot_frame = 'taunt';
            $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_start'].'</em>&quot;';
          }
          $this_robot->update_session();
          $this_player->update_session();
          $this->events_create($this_robot, false, $event_header, $event_body, array('canvas_show_target' => false, 'console_show_target' => false));

        }
        // Otherwise, if the player is empty
        else {

          // Create the enter event for this robot
          $event_header = $this_robot->robot_name;
          $event_body = "{$this_robot->print_robot_name()} wants to battle!<br />";
          $this_robot->robot_frame = 'defend';
          $this_robot->robot_position = 'active';
          if (isset($this_robot->robot_quotes['battle_start'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_start'].'</em>&quot;'; }
          $this_robot->update_session();
          $this_player->update_session();
          $this->events_create($this_robot, false, $event_header, $event_body, array('canvas_show_target' => false, 'console_show_target' => false));

          // Create an event for this robot teleporting in
          /*
          $this_robot->robot_frame = 'base';
          $this_robot->update_session();
          $this->events_create($this_robot, false, '', '');
          */
          $this_robot->robot_frame = 'taunt';
          $this_robot->update_session();
          $this->events_create($this_robot, false, '', '');
          $this_robot->robot_frame = 'base';
          $this_robot->update_session();

        }

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

        // Set this token to the ID and token of the starting robot
        $this_token = $this_robot->robot_id.'_'.$this_robot->robot_token;

        // Return from the battle function with the start results
        $this_return = true;
        break;

      }
      // Else if the player has chosen to use an ability
      elseif ($this_action == 'ability'){

        // If an ability token was not collected
        if (empty($this_token)){

          // Check if this robot has choice data defined
          if (isset($this_robot->robot_choices['abilities'])){

            // Collect the ability choice from the robot
            $temp_function = $this_robot->robot_choices['abilities'];
            $temp_token = $temp_function(array(
              'this_battle' => &$this,
              'this_field' => &$this->battle_field,
              'this_player' => &$this_player,
              'this_robot' => &$this_robot,
              'target_player' => &$target_player,
              'target_robot' => &$target_robot
              ));
            $temp_id = array_search($temp_token, $this_robot->robot_abilities);
            $this_token = array('ability_id' => $temp_id, 'ability_token' => $temp_token);
          }
          // Otherwise, if not choice data was defined
          else {
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

          // Update the target player's session
          $target_player->update_session();

          /*
          // If the target player noes NOT have any other remaining robots to switch to
          if ($target_player->counters['robots_active'] == 0){
            $target_player->player_frame = 'defeat';
            $target_player->update_session();
          }
          */

          // Create the robot disabled event
          $event_header = ($target_player->player_token != 'player' ? $target_player->player_name.'&#39;s ' : '').$target_robot->robot_name;
          $event_body = ($target_player->player_token != 'player' ? $target_player->print_player_name().'&#39;s ' : 'The target ').' '.$target_robot->print_robot_name().' was disabled!<br />';
          if (isset($target_robot->robot_quotes['battle_defeat'])){ $event_body .= '&quot;<em>'.$target_robot->robot_quotes['battle_defeat'].'</em>&quot;'; }
          $this_robot->robot_frame = 'base';
          $target_robot->robot_frame = 'defeat';
          $this_robot->update_session();
          $target_robot->update_session();
          $this->events_create($target_robot, $this_robot, $event_header, $event_body, array('console_show_target' => false));


          // Create the robot victory message if there is more battle to come
          if ($target_player->counters['robots_active'] > 0){
          $event_header = ($this_player->player_token != 'player' ? $this_player->player_name.'&#39;s ' : '').$this_robot->robot_name;
          if ($target_player->counters['robots_active'] > 0){ $event_body = "{$this_robot->print_robot_name()} absorbs power from the fallen robot!<br />"; }
          else { $event_body = "{$this_robot->print_robot_name()} defeated the target robot!<br />"; }
            $this_robot->robot_frame = 'victory';
            $target_player->player_frame = 'defeat';
            $this_robot->update_session();
            $target_player->update_session();
            if (isset($this_robot->robot_quotes['battle_victory'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_victory'].'</em>&quot;'; }
            $this->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false, 'canvas_show_target' => false));
          }

          // Define the event options array
          $event_options = array();
          $event_options['this_ability_results']['total_actions'] = 0;

          // If there are more robots to fight on the target's side
          if ($target_player->counters['robots_active'] > 0){

            // Boost this robot's attack if a boost is in order
            $this_attack_boost = floor($target_robot->robot_attack / 10);
            if ($this_attack_boost > 0){
              // Increase this robot's attack by the boost amount
              $this_robot->robot_attack = $this_robot->robot_attack + $this_attack_boost;
              // If the boost put the robot's attack above double the base
              if ($this_robot->robot_attack > ($this_robot->robot_base_attack * 2)){
                // Calculate the overboost amount
                $this_attack_overboost = (($this_robot->robot_base_attack * 2) - $this_robot->robot_attack) * -1;
                // Calculate the actual boost amount
                $this_attack_boost = $this_attack_boost - $this_attack_overboost;
                // Max out this robot's attack
                $this_robot->robot_attack = $this_robot->robot_base_attack * 2;
              }
              // Create the robot boost bonus event, if applicable
              if ($this_attack_boost > 0){
                $event_header = ($this_player->player_token != 'player' ? $this_player->player_name.'&#39;s ' : '').$this_robot->robot_name;
                $event_body = $this_robot->print_robot_name().'&#39;s weapons improved!<br />';
                $event_body .= $this_robot->print_robot_name().'&#39;s attack rose by <span class="recovery_amount">'.$this_attack_boost.'</span>!<br />';
                //$event_options = array();
                $event_options['console_show_target'] = false;
                $event_options['canvas_show_target'] = false;
                $event_options['this_ability_results']['trigger_kind'] = 'recovery';
                $event_options['this_ability_results']['recovery_kind'] = 'attack';
                $event_options['this_ability_results']['recovery_type'] = '';
                $event_options['this_ability_results']['this_amount'] = $this_attack_boost;
                $event_options['this_ability_results']['this_result'] = 'success';
                $event_options['this_ability_results']['total_actions']++;
                $this_robot->robot_frame = 'taunt';
                $this_robot->update_session();
                $this->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
              }
            }

            // Boost this robot's defense if a boost is in order
            $this_defense_boost = floor($target_robot->robot_defense / 10);
            if ($this_defense_boost > 0){
              // Increase this robot's defense by the boost amount
              $this_robot->robot_defense = $this_robot->robot_defense + $this_defense_boost;
              // If the boost put the robot's defense above double the base
              if ($this_robot->robot_defense > ($this_robot->robot_base_defense * 2)){
                // Calculate the overboost amount
                $this_defense_overboost = (($this_robot->robot_base_defense * 2) - $this_robot->robot_defense) * -1;
                // Calculate the actual boost amount
                $this_defense_boost = $this_defense_boost - $this_defense_overboost;
                // Max out this robot's defense
                $this_robot->robot_defense = $this_robot->robot_base_defense * 2;
              }
              // Create the robot boost bonus event, if applicable
              if ($this_defense_boost > 0){
                $event_header = ($this_player->player_token != 'player' ? $this_player->player_name.'&#39;s ' : '').$this_robot->robot_name;
                $event_body = $this_robot->print_robot_name().'&#39;s shields improved!<br />';
                $event_body .= $this_robot->print_robot_name().'&#39;s defense rose by <span class="recovery_amount">'.$this_defense_boost.'</span>!<br />';
                //$event_options = array();
                $event_options['console_show_target'] = false;
                $event_options['canvas_show_target'] = false;
                $event_options['this_ability_results']['trigger_kind'] = 'recovery';
                $event_options['this_ability_results']['recovery_kind'] = 'defense';
                $event_options['this_ability_results']['recovery_type'] = '';
                $event_options['this_ability_results']['this_amount'] = $this_defense_boost;
                $event_options['this_ability_results']['this_result'] = 'success';
                $event_options['this_ability_results']['total_actions']++;
                $this_robot->robot_frame = 'taunt';
                $this_robot->update_session();
                $this->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
              }
            }

            // Boost this robot's speed if a boost is in order
            $this_speed_boost = floor($target_robot->robot_speed / 10);
            if ($this_speed_boost > 0){
              // Increase this robot's speed by the boost amount
              $this_robot->robot_speed = $this_robot->robot_speed + $this_speed_boost;
              // If the boost put the robot's speed above double the base
              if ($this_robot->robot_speed > ($this_robot->robot_base_speed * 2)){
                // Calculate the overboost amount
                $this_speed_overboost = (($this_robot->robot_base_speed * 2) - $this_robot->robot_speed) * -1;
                // Calculate the actual boost amount
                $this_speed_boost = $this_speed_boost - $this_speed_overboost;
                // Max out this robot's speed
                $this_robot->robot_speed = $this_robot->robot_base_speed * 2;
              }
              // Create the robot boost bonus event, if applicable
              if ($this_speed_boost > 0){
                $event_header = ($this_player->player_token != 'player' ? $this_player->player_name.'&#39;s ' : '').$this_robot->robot_name;
                $event_body = $this_robot->print_robot_name().'&#39;s mobility improved!<br />';
                $event_body .= $this_robot->print_robot_name().'&#39;s speed rose by <span class="recovery_amount">'.$this_speed_boost.'</span>!<br />';
                //$event_options = array();
                $event_options['console_show_target'] = false;
                $event_options['canvas_show_target'] = false;
                $event_options['this_ability_results']['trigger_kind'] = 'recovery';
                $event_options['this_ability_results']['recovery_kind'] = 'speed';
                $event_options['this_ability_results']['recovery_type'] = '';
                $event_options['this_ability_results']['this_amount'] = $this_speed_boost;
                $event_options['this_ability_results']['this_result'] = 'success';
                $event_options['this_ability_results']['total_actions']++;
                $this_robot->robot_frame = 'taunt';
                $this_robot->update_session();
                $this->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);
              }
            }

          }

          // Ensure player and robot variables are updated
          $this_robot->update_session();
          $this_player->update_session();
          $target_robot->update_session();
          $target_player->update_session();

          // If the target player noes NOT have remaining robots to switch to
          if ($target_player->counters['robots_active'] == 0){

            // Update the battle status to complete
            $this->battle_status = 'complete';

             // Check if the target was the human character
            if ($target_player->player_side == 'left'){

              // Calculate the number of battle points for the target player
              $this_base_points = 0; //$this->battle_points;
              $this_turn_points = 10 * $this->counters['battle_turn'];
              $this_stat_points = 0;
              $target_battle_points = $this_base_points + $this_turn_points + $this_stat_points;

              // Increment the main game's points total with the battle points
              $_SESSION['RPG2k12-2']['GAME']['counters']['battle_points'] += $target_battle_points;

              // Increment this player's points total with the battle points
              $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$target_player->player_token]['player_points'] += $target_battle_points;

            }

            // Display the defeat message for thr target character
            //$target_robot->robot_position = 'bench';
            if ($target_player->player_token != 'player'){
              $target_player->player_frame = 'defeat';
              $target_robot->update_session();
              $target_player->update_session();
              $event_header = ($target_player->player_token != 'player' ? $target_player->player_name : 'Target').' Defeated';
              $event_body = ($target_player->player_token != 'player' ? $target_player->print_player_name() : 'The target').' was defeated! ';
              if ($target_player->player_side == 'left'){ $event_body .= $target_player->print_player_name().' collects <span class="recovery_amount">'.$target_battle_points.'</span> battle points&hellip;'; }
              $event_body .= '<br />';
              $event_options = array();
              $event_options['console_show_this_player'] = true;
              $event_options['console_show_target'] = false;
              $event_options['this_header_float'] = $event_options['this_body_float'] = $target_player->player_side;
              if ($target_player->player_token != 'player'
                && isset($target_player->player_quotes['battle_defeat'])){
                $this_find = array('{target_player}');
                $this_replace = array($this_player->print_player_name());
                $this_quote_text = str_replace($this_find, $this_replace, $target_player->player_quotes['battle_defeat']);
                $event_body .= '&quot;<em>'.$this_quote_text.'</em>&quot;';
              }
              $this->events_create($target_robot, $this_robot, $event_header, $event_body, $event_options);
            }

            // Check if this player was the human player
            if ($this_player->player_side == 'left'){

              // Calculate the number of battle points for this player
              $this_base_points = $this->battle_points;
              if ($this->counters['battle_turn'] < $this->battle_turns
                || $this->counters['battle_turn'] > $this->battle_turns){
                $this_turn_diff = $this->battle_turns - $this->counters['battle_turn'];
                $this_turn_points = ceil(($this_turn_diff / $this->battle_turns) * ($this->battle_points / 2));
              }
              else {
                $this_turn_points = 0;
              }
              //$this_turn_points = ceil($this->battle_points * ($this->battle_turns / $this->counters['battle_turn'])) - $this->battle_points;
              //$this_turn_points = $this_turn_points > ($this->battle_points * 2) ? $this->battle_points : ($this_turn_points < ($this->battle_points / 2) ? ceil($this->battle_points / 2) : $this_turn_points);
              $this_stat_points = 0;
              if (!empty($this_player->values['robots_active'])){
                foreach ($this_player->values['robots_active'] AS $this_key => $this_robotinfo){
                  // Define the temp robot object using the loaded robot data
                  $temp_robot = new mmrpg_robot($this, $this_player, $this_robotinfo);
                  // Add all it's stats into one value
                  $this_stat_points += ceil($temp_robot->robot_energy * 0.10);
                  $this_stat_points += ceil($temp_robot->robot_attack * 0.10);
                  $this_stat_points += ceil($temp_robot->robot_defense * 0.10);
                  $this_stat_points += ceil($temp_robot->robot_speed * 0.10);
                }
              }
              $this_battle_points = $this_base_points + $this_turn_points + $this_stat_points;

              // Increment the main game's points total with the battle points
              $_SESSION['RPG2k12-2']['GAME']['counters']['battle_points'] += $this_battle_points;

              // Define the number of points this player gets
              $this_player_points = $this_battle_points;

              // Increment this player's points total with the battle points
              $player_token = $this_player->player_token;
              $player_info = $this_player->export_array();
              $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$player_token]['player_points'] += $this_player_points;

              // Display the win message for this player with battle points
              $this_robot->robot_frame = 'victory';
              $this_player->player_frame = 'victory';
              $this_robot->update_session();
              $this_player->update_session();
              $event_header = $this_player->player_name.' Victorious';
              $event_body = $this_player->print_player_name().' was victorious! ';
              $event_body .= $this_player->print_player_name().' collects <span class="recovery_amount">'.$this_player_points.'</span> battle points!';
              $event_body .= '<br />';
              $event_options = array();
              $event_options['console_show_this_player'] = true;
              $event_options['console_show_target'] = false;
              $event_options['this_header_float'] = $event_options['this_body_float'] = $this_player->player_side;
              if ($this_player->player_token != 'player'
                && isset($this_player->player_quotes['battle_start'])){
                $this_find = array('{target_player}');
                $this_replace = array($target_player->print_player_name());
                $this_quote_text = str_replace($this_find, $this_replace, $this_player->player_quotes['battle_victory']);
                $event_body .= '&quot;<em>'.$this_quote_text.'</em>&quot;';
              }
              $this->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);

              // Define the number of points each robot who participated gets
              $this_robot_points = ceil($this_battle_points / $this_player->counters['robots_active']);

              // Increment each of this player's robots
              foreach ($this_player->values['robots_active'] AS $temp_id => $temp_info){

                // Collect or define the robot points and robot rewards variables
                $temp_robot = new mmrpg_robot($this, $this_player, $temp_info);
                $temp_robot_token = $temp_info['robot_token'];
                $temp_robot_points = mmrpg_prototype_robot_points($this_player->player_token, $temp_info['robot_token']);
                $temp_robot_rewards = !empty($temp_info['robot_rewards']) ? $temp_info['robot_rewards'] : array();

                // Collect the robot's current points and level for reference later
                $temp_start_points = mmrpg_prototype_robot_points($this_player->player_token, $temp_robot_token);
                $temp_start_level = floor($temp_start_points / 1000) + 1;

                // Increment this robots's points total with the battle points
                $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$this_player->player_token]['player_robots'][$temp_robot_token]['robot_points'] += $this_robot_points;

                // Define the new points and level for this robot
                $temp_new_points = mmrpg_prototype_robot_points($this_player->player_token, $temp_info['robot_token']);
                $temp_new_level = floor($temp_new_points / 1000) + 1;

                // Display the win message for this robot with battle points
                $temp_robot->robot_frame = 'victory';
                $this_player->player_frame = 'victory';
                $event_header = $temp_robot->robot_name.'&#39;s Rewards';
                $event_body = $temp_robot->print_robot_name().' collects <span class="recovery_amount">'.$this_robot_points.'</span> battle points! ';
                if ($temp_start_level != $temp_new_level){
                  $event_body .= $temp_robot->print_robot_name().' grew to <span class="recovery_amount">Level '.$temp_new_level.'</span>! ';
                  $temp_new_modifier = $temp_new_level / 100;
                  $temp_robot->robot_base_energy = $temp_robot->robot_energy += floor($temp_robot->robot_base_energy * $temp_new_modifier);
                  $temp_robot->robot_base_attack = $temp_robot->robot_attack += floor($temp_robot->robot_base_attack * $temp_new_modifier);
                  $temp_robot->robot_base_defense = $temp_robot->robot_defense += floor($temp_robot->robot_base_defense * $temp_new_modifier);
                  $temp_robot->robot_base_speed = $temp_robot->robot_speed += floor($temp_robot->robot_base_speed * $temp_new_modifier);
                }
                $event_body .= '<br />';
                if (isset($temp_robot->robot_quotes['battle_victory'])){ $event_body .= '&quot;<em>'.$temp_robot->robot_quotes['battle_victory'].'</em>&quot;'; }
                $event_options = array();
                $event_options['console_show_target'] = false;
                $event_options['this_header_float'] = $event_options['this_body_float'] = $this_player->player_side;
                $temp_robot->update_session();
                $this_player->update_session();
                $this->events_create($temp_robot, $target_robot, $event_header, $event_body, $event_options);

                // Collect the robot info array
                $temp_robot_info = $temp_robot->export_array();

                // Loop through the ability rewards for this robot if set
                if (!empty($temp_robot_rewards['abilities'])){
                  foreach ($temp_robot_rewards['abilities'] AS $ability_reward_key => $ability_reward_info){

                    if (mmrpg_prototype_ability_unlocked($this_player->player_token, $temp_robot_token, $ability_reward_info['token'])){ continue; }

                    // Check if the required amount of points have been met by this robot
                    if ($temp_new_points >= $ability_reward_info['points']){

                      // Collect the ability info from the index
                      $ability_info = $this->index['abilities'][$ability_reward_info['token']];
                      // Create the temporary ability object for event creation
                      $temp_ability = new mmrpg_ability($this, $this_player, $temp_robot, $ability_info);

                      // Collect or define the ability variables
                      $temp_ability_token = $ability_info['ability_token'];

                      // Display the robot reward message markup
                      $event_header = $ability_info['ability_name'].' Unlocked';
                      $event_body = '<span class="robot_name">'.$temp_info['robot_name'].'</span> unlocked a new ability!<br />';
                      $event_body .= '<span class="ability_name">'.$ability_info['ability_name'].'</span> can now be used in battle!';
                      $event_options = array();
                      $event_options['console_show_target'] = false;
                      $event_options['this_header_float'] = $this_player->player_side;
                      $event_options['this_body_float'] = $this_player->player_side;
                      $event_options['this_ability'] = $temp_ability;
                      $event_options['this_ability_image'] = 'icon';
                      $event_options['console_show_this_player'] = false;
                      $event_options['console_show_this_robot'] = false;
                      $event_options['console_show_this_ability'] = true;
                      $event_options['canvas_show_this_ability'] = false;
                      $temp_ability->ability_frame = 'base';
                      $temp_ability->update_session();
                      $this->events_create($temp_robot, false, $event_header, $event_body, $event_options);

                      // Automatically unlock this ability for use in battle
                      $this_reward = array('ability_token' => $temp_ability_token);
                      mmrpg_game_unlock_ability($player_info, $temp_robot_info, $this_reward);
                      //$_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$this_player_token]['player_robots'][$temp_robot_token]['robot_abilities'][$temp_ability_token] = $this_reward;

                    }

                  }
                }



              }

            }






            // Check if this player was the human player
            if ($this_player->player_side == 'left'){

              // Update the GAME session variable with the completed battle token
              $_SESSION['RPG2k12-2']['GAME']['values']['battle_complete'][$this_player->player_token][$this->battle_token] = array('battle_token' => $this->battle_token);

              // Collect or define the player variables
              $this_player_token = $this_player->player_token;
              $this_player_info = $this_player->export_array();

              // Loop through any robot rewards for this battle
              $this_robot_rewards = !empty($this->battle_rewards['robots']) ? $this->battle_rewards['robots'] : array();
              if (!empty($this_robot_rewards)){
                foreach ($this_robot_rewards AS $robot_reward_key => $robot_reward_info){

                  // If this robot has already been unlocked, continue
                  if (mmrpg_prototype_robot_unlocked($this_player_token, $robot_reward_info['token'])){ continue; }

                  // Collect the robot info from the index
                  $robot_info = $this->index['robots'][$robot_reward_info['token']];
                  // Search this player's base robots for the robot ID
                  $robot_info['robot_id'] = 0;
                  foreach ($this_player->player_base_robots AS $base_robot){
                    if ($robot_info['robot_token'] == $base_robot['robot_token']){
                      $robot_info['robot_id'] = $base_robot['robot_id'];
                      break;
                    }
                  }
                  // Create the temporary robot object for event creation
                  $temp_robot = new mmrpg_robot($this, $this_player, $robot_info);

                  // Collect or define the robot points and robot rewards variables
                  $this_robot_token = $robot_info['robot_token'];
                  $this_robot_points = !empty($robot_info['robot_points']) ? $robot_info['robot_points'] : 0;
                  $this_robot_rewards = !empty($robot_info['robot_rewards']) ? $robot_info['robot_rewards'] : array();

                  // Automatically unlock this robot for use in battle
                  $this_reward = array('robot_token' => $this_robot_token, 'robot_points' => $this_robot_points);
                  mmrpg_game_unlock_robot($this_player_info, $this_reward);
                  //$_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$this_player_token]['player_robots'][$this_robot_token] = $this_reward;

                  // Display the robot reward message markup
                  $event_header = $robot_info['robot_name'].' Unlocked';
                  $event_body = 'A new robot has been unlocked!<br />';
                  $event_body .= '<span class="robot_name">'.$robot_info['robot_name'].'</span> can now be used in battle!';
                  $event_options = array();
                  $event_options['console_show_target'] = false;
                  $event_options['this_header_float'] = $this_player->player_side;
                  $event_options['this_body_float'] = $this_player->player_side;
                  $event_options['this_robot_image'] = 'mug';
                  $temp_robot->robot_frame = 'base';
                  $temp_robot->update_session();
                  $this->events_create($temp_robot, false, $event_header, $event_body, $event_options);

                  /*
                  // Loop through the ability rewards for this robot if set
                  if (!empty($this_robot_rewards['abilities'])){
                    foreach ($this_robot_rewards['abilities'] AS $ability_reward_key => $ability_reward_info){

                      // Check if the required amount of points have been met by this robot
                      if ($this_robot_points >= $ability_reward_info['points']){

                        // Collect the ability info from the index
                        $ability_info = $this->index['abilities'][$ability_reward_info['token']];

                        // Collect or define the ability variables
                        $this_ability_token = $ability_info['ability_token'];

                        // Automatically unlock this ability for use in battle
                        $this_reward = array('ability_token' => $this_ability_token);
                        $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$this_player_token]['player_robots'][$this_robot_token]['robot_abilities'][$this_ability_token] = $this_reward;

                      }

                    }
                  }
                  */

                }
              }

              /*
              // Loop through any battle rewards and add them to the GAME session variable
              if (!empty($this->battle_rewards)){

                // Define the reward type index
                $reward_types_index = array();
                $reward_types_index['battles'] = array('type_name' => 'battle', 'unlock_text' => 'can now be battled!');
                $reward_types_index['fields'] = array('type_name' => 'field', 'unlock_text' => 'can now be battled on!');
                $reward_types_index['players'] = array('type_name' => 'player', 'unlock_text' => 'can now be used in battle!');
                $reward_types_index['robots'] = array('type_name' => 'robot', 'unlock_text' => 'can now be used in battle!');
                $reward_types_index['abilities'] = array('type_name' => 'ability', 'unlock_text' => 'can now be used in battle!');

                // Loop through each one of this battle's robot rewards
                foreach ($this->battle_rewards AS $this_key => $this_rewardinfo){



                  // Collect the rewardinfo's index data and merge with the passed data
                  $this_rewardinfo = array_merge($this_rewardinfo, $reward_types_index[$this_rewardinfo['reward_type']]);
                  $this_rewardinfo = array_merge($this_rewardinfo, $this->index[$this_rewardinfo['reward_type']][$this_rewardinfo['reward_token']]);

                  // Ensure this reward has not already been unlocked
                  if (!isset($_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$this_player->player_token]['player_'.$this_rewardinfo['reward_type']][$this_rewardinfo['reward_token']])){

                    // Display the reward message markup
                    $event_header = $this_rewardinfo[$this_rewardinfo['type_name'].'_name'].' Unlocked';
                    $event_body = 'A new '.$this_rewardinfo['type_name'].' has been unlocked!<br />';
                    $event_body .= '<span class="'.$this_rewardinfo['type_name'].'_name">'.$this_rewardinfo[$this_rewardinfo['type_name'].'_name'].'</span> '.$this_rewardinfo['unlock_text'];
                    $this_robot->robot_frame = 'taunt';
                    $this_player->player_frame = 'victory';
                    $this_robot->update_session();
                    $this_player->update_session();
                    $this->events_create($this_robot, $target_robot, $event_header, $event_body, $event_options);

                    // Create the session variable unlocking this reward
                    $_SESSION['RPG2k12-2']['GAME']['values']['battle_rewards'][$this_player->player_token][$this_rewardinfo['reward_type']][$this_rewardinfo['reward_token']] = $this_rewardinfo['reward_token'];
                  }

                }

              }
              */

            }

            /*
            // Display the battle completed message
            $event_header = $this->battle_name.' Battle '.($this_player->player_side == 'left' ? 'Complete' : 'Failed');
            if ($target_player->player_token != 'player'){
              $event_body = $this_player->player_side == 'left' ? 'The target has run out of robots!<br />' : 'You have run out of robots!<br />';//checkpoint
              $event_body .= $this_player->player_side == 'left' ? 'The target was defeated!' : 'You were defeated!';
            } else {
              $event_body = $this_player->player_side == 'left' ? 'The target '.($target_player->counters['robots_disabled'] > 1 ? 'robots were' : 'robot was').' defeated!<br />' : 'Your '.($this_player->counters['robots_disabled'] > 1 ? 'robots were' : 'robot was').' were defeated!<br />';//checkpoint
            }
            $this_robot->robot_frame = 'base';
            $this_player->player_frame = 'base';
            $this_robot->update_session();
            $this_player->update_session();
            $this->events_create(false, false, $event_header, $event_body);
            */

            // Create one final frame for the blank frame
            $this->events_create(false, false, '', '');



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
            $this_robot->robot_frame = 'taunt';
            $target_robot->robot_frame = 'base';
            $this->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false));
            $this_robot->robot_frame = 'base';
            // Create the quote flag to ensure robots don't repeat themselves
            $this_robot->flags['robot_quotes']['battle_taunt'] = true;
          }

        }

        // Set this token to the ID and token of the triggered ability
        $this_token = $this_token['ability_id'].'_'.$this_token['ability_token'];

        // Return from the battle function with the used ability
        $this_return = &$this_ability;
        break;

      }
      // Else if the player has chosen to switch
      elseif ($this_action == 'switch'){

        // Collect this player's last action if it exists
        if (!empty($this_player->history['actions'])){
          $this_recent_switches = array_slice($this_player->history['actions'], -5, 5, false);
          foreach ($this_recent_switches AS $key => $info){
            if ($info['this_action'] == 'switch' || $info['this_action'] == 'start'){ $this_recent_switches[$key] = $info['this_action_token']; } //$info['this_action_token'];
            else { unset($this_recent_switches[$key]); }
          }
          $this_recent_switches = array_values($this_recent_switches);
          $this_recent_switches_count = count($this_recent_switches);
        }
        // Otherwise define an empty action
        else {
          $this_recent_switches = array();
          $this_recent_switches_count = 0;
        }

        // If the robot token was not collected and this player is NOT on autopilot
        if (empty($this_token) && $this_player->player_side == 'left'){

          // Clear any pending actions
          $this->actions_empty();
          // Return from the battle function
          $this_return = true;
          break;
        }
        // Else If a robot token was not collected and this player IS on autopilot
        elseif (empty($this_token) && $this_player->player_side == 'right'){

          // Decide which robot the target should use (random)
          $active_robot_count = count($this_player->values['robots_active']);
          if ($active_robot_count == 1){
            $this_robotinfo = $this_player->values['robots_active'][0];
          }
          elseif ($active_robot_count > 1) {
            $this_last_switch = !empty($this_recent_switches) ? array_slice($this_recent_switches, -1, 1, false) : array('');
            $this_last_switch = $this_last_switch[0];
            $this_current_token = $this_robot->robot_id.'_'.$this_robot->robot_token;
            do {
              $this_robotinfo = $this_player->values['robots_active'][mt_rand(0, ($active_robot_count - 1))];
              if ($this_robotinfo['robot_id'] == $this_robot->robot_id ){ continue; }
              $this_temp_token = $this_robotinfo['robot_id'].'_'.$this_robotinfo['robot_token'];
              //$this->events_create(false, false, 'DEBUG', '!empty('.$this_last_switch.') && '.$this_temp_token.' == '.$this_last_switch);
            } while(empty($this_temp_token));
          }
          else {
            $this_robotinfo = array('robot_id' => 0, 'robot_token' => 'robot');
          }
          //$this->events_create(false, false, 'DEBUG', 'auto switch picked ['.print_r($this_robotinfo['robot_name'], true).'] | recent : ['.preg_replace('#\s+#', ' ', print_r($this_recent_switches, true)).']');
        }
        // Otherwise, parse the token for data
        else {
          list($temp_id, $temp_token) = explode('_', $this_token);
          $this_robotinfo = array('robot_id' => $temp_id, 'robot_token' => $temp_token);
        }

        // Update this player and robot's session data before switching
        $this_player->update_session();
        $this_robot->update_session();

        // Withdraw the player's robot and display an event for it
        $this_robot->robot_frame = $this_robot->robot_status != 'disabled' ? 'base' : 'defeat';
        if ($this_robot->robot_position != 'bench'){
          $this_robot->robot_position = 'bench';
          $this_player->player_frame = 'base';
          $this_robot->update_session();
          $this_player->update_session();
          $event_header = ($this_player->player_token != 'player' ? $this_player->player_name.'&#39;s ' : '').$this_robot->robot_name;
          $event_body = $this_robot->print_robot_name().' is '.($this_robot->robot_status != 'disabled' ? 'withdrawn' : 'removed').' from battle!';
          if ($this_robot->robot_status != 'disabled' && isset($this_robot->robot_quotes['battle_retreat'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_retreat'].'</em>&quot;'; }
          $this->events_create($this_robot, false, $event_header, $event_body);
        }
        else {
          $this_robot->robot_frame = 'base';
          $this_robot->update_session();
        }

        // Switch in the player's new robot and display an event for it
        $this_robot->robot_load($this_robotinfo);
        $this_robot->robot_position = 'active';
        $this_player->player_frame = 'command';
        $this_robot->update_session();
        $this_player->update_session();
        $event_header = ($this_player->player_token != 'player' ? $this_player->player_name.'&#39;s ' : '').$this_robot->robot_name;
        $event_body = "{$this_robot->print_robot_name()} enters the battle!<br />";
        if (isset($this_robot->robot_quotes['battle_start'])){
          $this_robot->robot_frame = 'taunt';
          $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_start'].'</em>&quot;';
        }
        $this->events_create($this_robot, false, $event_header, $event_body);

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

        // Set this token to the ID and token of the switched robot
        $this_token = $this_robotinfo['robot_id'].'_'.$this_robotinfo['robot_token'];

        // Return from the battle function
        $this_return = true;
        break;
      }
      // Else if the player has chosen to scan the target
      elseif ($this_action == 'scan'){

        // Otherwise, parse the token for data
        if (!empty($this_token)){
          list($temp_id, $temp_token) = explode('_', $this_token);
          $this_token = array('robot_id' => $temp_id, 'robot_token' => $temp_token);
        }

        // If an ability token was not collected
        if (empty($this_token)){
          // Decide which robot should be scanned
          foreach ($target_player->player_robots AS $this_key => $this_robotinfo){
            if ($this_robotinfo['robot_position'] == 'active'){ $this_token = $this_robotinfo;  }
          }
        }

        //die('<pre>'.print_r($temp_target_robot_info, true).'</pre>');

        // Create the temporary target player and robot objects
        $temp_target_robot_info = !empty($this->values['robots'][$this_token['robot_id']]) ? $this->values['robots'][$this_token['robot_id']] : array();
        $temp_target_player_info = !empty($this->values['players'][$temp_target_robot_info['player_id']]) ? $this->values['players'][$temp_target_robot_info['player_id']] : array();
        $temp_target_player = new mmrpg_player($this, $temp_target_player_info);
        $temp_target_robot = new mmrpg_robot($this, $temp_target_player, $temp_target_robot_info);
        //die('<pre>'.print_r($temp_target_robot, true).'</pre>');

        // Ensure the target robot's frame is set to its base
        $temp_target_robot->robot_frame = 'base';
        $temp_target_robot->update_session();

        // Collect the weakness, resistsance, affinity, and immunity text
        $temp_target_robot_weaknesses = $temp_target_robot->print_robot_weaknesses();
        $temp_target_robot_resistances = $temp_target_robot->print_robot_resistances();
        $temp_target_robot_affinities = $temp_target_robot->print_robot_affinities();
        $temp_target_robot_immunities = $temp_target_robot->print_robot_immunities();

        // Change the target robot's frame to defend base and save
        $temp_target_robot->robot_frame = 'taunt';
        $temp_target_robot->update_session();

        // Now change the target robot's frame is set to its mugshot
        $temp_target_robot->robot_frame = 'mugshot'; //taunt';

        // Create an event showing the scanned robot's data
        $event_header = $temp_target_player->player_name.'&#39;s '.$temp_target_robot->robot_name;
        $event_body = '';
        ob_start();
        ?>
        <table class="full">
          <colgroup>
            <col width="24%" />
            <col width="24%" />
            <col width="4%" />
            <col width="24%" />
            <col width="24%" />
          </colgroup>
          <tbody>
            <tr>
              <td class="left">Name  : </td>
              <td  class="right"><?= $temp_target_robot->print_robot_name() ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Number : </td>
              <td  class="right"><?= $temp_target_robot->print_robot_number() ?></td>
            </tr>
            <tr>
              <td class="left">Weaknesses : </td>
              <td  class="right"><?= !empty($temp_target_robot_weaknesses) ? $temp_target_robot_weaknesses : '<span class="robot_weakness">None</span>' ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Energy : </td>
              <td  class="right"><span class="robot_stat"><?= $temp_target_robot->robot_energy.' / '.$temp_target_robot->robot_base_energy ?></span></td>
            </tr>
            <tr>
              <td class="left">Resistances : </td>
              <td  class="right"><?= !empty($temp_target_robot_resistances) ? $temp_target_robot_resistances : '<span class="robot_resistance">None</span>' ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Attack : </td>
              <td  class="right"><span class="robot_stat"><?= $temp_target_robot->robot_attack.' / '.$temp_target_robot->robot_base_attack ?></span></td>
            </tr>
            <tr>
              <td class="left">Affinities : </td>
              <td  class="right"><?= !empty($temp_target_robot_affinities) ? $temp_target_robot_affinities : '<span class="robot_affinity">None</span>' ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Defense : </td>
              <td  class="right"><span class="robot_stat"><?= $temp_target_robot->robot_defense.' / '.$temp_target_robot->robot_base_defense ?></span></td>
            </tr>
            <tr>
              <td class="left">Immunities : </td>
              <td  class="right"><?= !empty($temp_target_robot_immunities) ? $temp_target_robot_immunities : '<span class="robot_immunity">None</span>' ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Speed : </td>
              <td  class="right"><span class="robot_stat"><?= $temp_target_robot->robot_speed.' / '.$temp_target_robot->robot_base_speed ?></span></td>
            </tr>
          </tbody>
        </table>
        <?
        $event_body .= preg_replace('#\s+#', ' ', trim(ob_get_clean()));
        $this->events_create($temp_target_robot, false, $event_header, $event_body, array('console_container_height' => 2, 'canvas_show_this' => false)); //, 'event_flag_autoplay' => false

        // Ensure the target robot's frame is set to its base
        $temp_target_robot->robot_frame = 'base';
        $temp_target_robot->update_session();

        // Add this robot to the global robot database array
        $_SESSION['RPG2k12-2']['GAME']['values']['robot_database'][$temp_target_robot->robot_token] = array('robot_token' => $temp_target_robot->robot_token);

        // Set this token to the ID and token of the triggered ability
        $this_token = $this_token['robot_id'].'_'.$this_token['robot_token'];

        // Return from the battle function with the scanned robot
        $this_return = &$this_ability;
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

    // Clone or define the event objects
    $this_battle = $this;
    $this_field = $this->battle_field; //array_slice($this->values['fields'];
    $this_player = false;
    $this_robot = !empty($this_robot) ? $this_robot : false;
    if (!empty($this_robot)){ $this_player = new mmrpg_player($this, $this->values['players'][$this_robot->player_id]); }
    $target_player = false;
    $target_robot = !empty($target_robot) ? $target_robot : false;
    if (!empty($target_robot)){ $target_player = new mmrpg_player($this, $this->values['players'][$target_robot->player_id]); }

    // Increment the internal events counter
    if (!isset($this->counters['events'])){ $this->counters['events'] = 1; }
    else { $this->counters['events']++; }

    // Generate the event markup and add it to the array
    $this->events[] = $this->events_markup_generate(array(
      'this_battle' => $this_battle,
      'this_field' => $this_field,
      'this_player' => $this_player,
      'this_robot' => $this_robot,
      'target_player' => $target_player,
      'target_robot' => $target_robot,
      'event_header' => $event_header,
      'event_body' => $event_body,
      'event_options' => $event_options
      ));

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

  // Define a function for generating console message markup
  public function console_markup($eventinfo, $options){

    // Define the console markup string
    $this_markup = '';

    // Ensure this side is allowed to be shown before generating any markup
    if ($options['console_show_this'] != false){

        // Define the necessary text markup for the current player if allowed and exists
      if (!empty($eventinfo['this_player'])){
        // Collect the console data for this player
        $this_player_data = $eventinfo['this_player']->console_markup($options);
      } else {
        // Define empty console data for this player
        $this_player_data = array();
        $options['console_show_this_player'] = false;
      }
      // Define the necessary text markup for the current robot if allowed and exists
      if (!empty($eventinfo['this_robot'])){
        // Collect the console data for this robot
        $this_robot_data = $eventinfo['this_robot']->console_markup($options, $this_player_data);
      } else {
        // Define empty console data for this robot
        $this_robot_data = array();
        $options['console_show_this_robot'] = false;
      }
      // Define the necessary text markup for the current ability if allowed and exists
      if (!empty($options['this_ability'])){
        // Collect the console data for this ability
        $this_ability_data = $options['this_ability']->console_markup($options, $this_player_data, $this_robot_data);
      } else {
        // Define empty console data for this ability
        $this_ability_data = array();
        $options['console_show_this_ability'] = false;
      }

      // If no objects would found to display, turn the left side off
      if (empty($options['console_show_this_player'])
        && empty($options['console_show_this_robot'])
        && empty($options['console_show_this_ability'])){
        // Automatically set the console option to false
        $options['console_show_this'] = false;
      }

    }
    // Otherwise, if this side is not allowed to be shown at all
    else {

      // Default all of this side's objects to empty arrays
      $this_player_data = array();
      $this_robot_data = array();
      $this_ability_data = array();

    }


    // Ensure the target side is allowed to be shown before generating any markup
    if ($options['console_show_target'] != false){

      // Define the necessary text markup for the target player if allowed and exists
      if (!empty($eventinfo['target_player'])){
        // Collect the console data for this player
        $target_player_data = $eventinfo['target_player']->console_markup($options);
      } else {
        // Define empty console data for this player
        $target_player_data = array();
        $options['console_show_target_player'] = false;
      }
      // Define the necessary text markup for the target robot if allowed and exists
      if (!empty($eventinfo['target_robot'])){
        // Collect the console data for this robot
        $target_robot_data = $eventinfo['target_robot']->console_markup($options, $target_player_data);
      } else {
        // Define empty console data for this robot
        $target_robot_data = array();
        $options['console_show_target_robot'] = false;
      }
      // Define the necessary text markup for the target ability if allowed and exists
      if (!empty($options['target_ability'])){
        // Collect the console data for this ability
        $target_ability_data = $options['target_ability']->console_markup($options, $target_player_data, $target_robot_data);
      } else {
        // Define empty console data for this ability
        $target_ability_data = array();
        $options['console_show_target_ability'] = false;
      }

      // If no objects would found to display, turn the right side off
      if (empty($options['console_show_target_player'])
        && empty($options['console_show_target_robot'])
        && empty($options['console_show_target_ability'])){
        // Automatically set the console option to false
        $options['console_show_target'] = false;
      }

    }
    // Otherwise, if the target side is not allowed to be shown at all
    else {

      // Default all of the target side's objects to empty arrays
      $target_player_data = array();
      $target_robot_data = array();
      $target_ability_data = array();

    }

    // Assign player-side based floats for the header and body if not set
    if (empty($options['console_header_float']) && !empty($this_robot_data)){
      $options['console_header_float'] = $this_robot_data['robot_float'];
    }
    if (empty($options['console_body_float']) && !empty($this_robot_data)){
      $options['console_body_float'] = $this_robot_data['robot_float'];
    }

    // Append the generated console markup if not empty
    if (!empty($eventinfo['event_header']) && !empty($eventinfo['event_body'])){

      // Define the container class based on height
      $event_class = 'event ';
      if ($options['console_container_height'] == 1){ $event_class .= 'event_single '; }
      if ($options['console_container_height'] == 2){ $event_class .= 'event_double '; }
      if ($options['console_container_height'] == 3){ $event_class .= 'event_triple '; }

      // Generate the opening event tag
      $this_markup .= '<div class="'.$event_class.'">';

      // Generate this side's markup if allowed
      if ($options['console_show_this'] != false){
        // Append this player's markup if allowed
        if ($options['console_show_this_player'] != false){ $this_markup .= $this_player_data['player_markup']; }
        // Otherwise, append this robot's markup if allowed
        elseif ($options['console_show_this_robot'] != false){ $this_markup .= $this_robot_data['robot_markup']; }
        // Otherwise, append this ability's markup if allowed
        elseif ($options['console_show_this_ability'] != false){ $this_markup .= $this_ability_data['ability_markup']; }
      }

      // Generate the target side's markup if allowed
      if ($options['console_show_target'] != false){
        // Append the target player's markup if allowed
        if ($options['console_show_target_player'] != false){ $this_markup .= $target_player_data['player_markup']; }
        // Otherwise, append the target robot's markup if allowed
        elseif ($options['console_show_target_robot'] != false){ $this_markup .= $target_robot_data['robot_markup']; }
        // Otherwise, append the target ability's markup if allowed
        elseif ($options['console_show_target_ability'] != false){ $this_markup .= $target_ability_data['ability_markup']; }
      }

      /*
      $eventinfo['event_body'] .= '<div>';
      $eventinfo['event_body'] .= 'console_show_this_player : '.($options['console_show_this_player'] != false ? 'true : '.$this_player_data['player_markup'] : 'false : -').'<br />';
      $eventinfo['event_body'] .= 'console_show_this_robot : '.($options['console_show_this_robot'] != false ? 'true : '.$this_robot_data['robot_markup'] : 'false : -').'<br />';
      $eventinfo['event_body'] .= 'console_show_this_ability : '.($options['console_show_this_ability'] != false ? 'true : '.$this_ability_data['ability_markup'] : 'false : -').'<br />';
      $eventinfo['event_body'] .= '</div>';
      */

      // Prepend the turn counter to the header if necessary
      if (!empty($this->counters['battle_turn']) && $this->battle_status != 'complete'){ $eventinfo['event_header'] = 'Turn #'.$this->counters['battle_turn'].' : '.$eventinfo['event_header']; }

      // Display the event header and event body
      $this_markup .= '<div class="header header_'.$options['console_header_float'].'">'.$eventinfo['event_header'].'</div>';
      $this_markup .= '<div class="body body_'.$options['console_body_float'].'">'.$eventinfo['event_body'].'</div>';

      // Displat the closing event tag
      $this_markup .= '</div>';

    }

    // Return the generated markup and robot data
    return $this_markup;

  }

  // Define a function for generating canvas scene markup
  public function canvas_markup($eventinfo, $options = array()){

    // Define the console markup string
    $this_markup = '';

    // If this robot was not provided or allowed by the function
    if (empty($eventinfo['this_player']) || empty($eventinfo['this_robot']) || $options['canvas_show_this'] == false){
      // Set both this player and robot to false
      $eventinfo['this_player'] = false;
      $eventinfo['this_robot'] = false;
      // Collect the target player ID if set
      $target_player_id = !empty($eventinfo['target_player']) ? $eventinfo['target_player']->player_id : false;
      // Loop through the players index looking for this player
      foreach ($this->values['players'] AS $this_player_id => $this_playerinfo){
        if (empty($target_player_id) || $target_player_id != $this_player_id){
          $eventinfo['this_player'] = new mmrpg_player($this, $this_playerinfo);
          break;
        }
      }
      // Now loop through this player's robots looking for an active one
      foreach ($eventinfo['this_player']->player_robots AS $this_key => $this_robotinfo){
        if ($this_robotinfo['robot_position'] == 'active' && $this_robotinfo['robot_status'] != 'disabled'){
          $eventinfo['this_robot'] = new mmrpg_robot($this, $eventinfo['this_player'], $this_robotinfo);
          break;
        }
      }
    }

    // If this robot was targetting itself, set the target to false
    if (!empty($eventinfo['this_robot']) && !empty($eventinfo['target_robot'])){
      if ($eventinfo['this_robot']->robot_id == $eventinfo['target_robot']->robot_id){
        $eventinfo['target_robot'] = array();
      }
    }

    // If the target robot was not provided or allowed by the function
    if (empty($eventinfo['target_player']) || empty($eventinfo['target_robot']) || $options['canvas_show_target'] == false){
      // Set both this player and robot to false
      $eventinfo['target_player'] = false;
      $eventinfo['target_robot'] = false;
      // Collect this player ID if set
      $this_player_id = !empty($eventinfo['this_player']) ? $eventinfo['this_player']->player_id : false;
      // Loop through the players index looking for this player
      foreach ($this->values['players'] AS $target_player_id => $target_playerinfo){
        if (empty($this_player_id) || $this_player_id != $target_player_id){
          $eventinfo['target_player'] = new mmrpg_player($this, $target_playerinfo);
          break;
        }
      }
      // Now loop through the target player's robots looking for an active one
      foreach ($eventinfo['target_player']->player_robots AS $target_key => $target_robotinfo){
        if ($target_robotinfo['robot_position'] == 'active' && $target_robotinfo['robot_status'] != 'disabled'){
          $eventinfo['target_robot'] = new mmrpg_robot($this, $eventinfo['target_player'], $target_robotinfo);
          break;
        }
      }
    }

    // Collect this player's markup data
    $this_player_data = $eventinfo['this_player']->canvas_markup($options);
    // Append this player's markup to the main markup array
    $this_markup .= $this_player_data['player_markup'];

    // Loop through and display this player's robots
    if ($options['canvas_show_this_robots'] && !empty($eventinfo['this_player']->player_robots)){
      $num_player_robots = count($eventinfo['this_player']->player_robots);
      foreach ($eventinfo['this_player']->player_robots AS $this_key => $this_robotinfo){
        $this_robot = new mmrpg_robot($this, $eventinfo['this_player'], $this_robotinfo);
        $this_options = $options;
        if ($this_robot->robot_status == 'disabled' && $this_robot->robot_position == 'bench'){ continue; }
        elseif (!empty($eventinfo['this_robot']->robot_id) && $eventinfo['this_robot']->robot_id != $this_robot->robot_id){ $this_options['this_ability'] = false;  }
        elseif (!empty($eventinfo['this_robot']->robot_id) && $eventinfo['this_robot']->robot_id == $this_robot->robot_id && $options['canvas_show_this'] != false){ $this_robot->robot_frame =  $eventinfo['this_robot']->robot_frame; }
        $this_robot->robot_key = $this_robot->robot_key !== false ? $this_robot->robot_key : ($this_key > 0 ? $this_key : $num_player_robots);
        $this_robot_data = $this_robot->canvas_markup($this_options, $this_player_data);

        // ABILITY/RESULT ANIMATION STUFF
        if ($this_robot_data['robot_position'] != 'bench'
            && (!empty($this_options['this_ability']) || !empty($this_options['this_ability_results']))){
            $this_markup .= '<div class="ability_overlay">&nbsp;</div>';
        }


        // RESULTS ANIMATION STUFF
        if ($this_robot_data['robot_position'] != 'bench'
          && !empty($this_options['this_ability_results'])){

          /*
           * ABILITY EFFECT OFFSETS
           * Frame 01 : Energy +
           * Frame 02 : Energy -
           * Frame 03 : Attack +
           * Frame 04 : Attack -
           * Frame 05 : Defense +
           * Frame 06 : Defense -
           * Frame 07 : Speed +
           * Frame 08 : Speed -
           */

          // Define the results data array and populate with basic fields
          $this_results_data = array();
          $this_results_data['results_amount_markup'] = '';
          $this_results_data['results_effect_markup'] = '';

          /*
          sprite sprite_80x80 sprite_80x80_right_02 ability_status_active ability_position_active
          z-index: 92; left: 181px; bottom: 65px; background-image: url("images/abilities/ability_attack-boost_80x80.png?20120107-05");
          */

          // Calculate the results effect canvas offsets
          $this_results_data['canvas_offset_x'] = ceil($this_robot_data['canvas_offset_x'] - (4 * $this_options['this_ability_results']['total_actions']));
          $this_results_data['canvas_offset_y'] = ceil($this_robot_data['canvas_offset_y'] + 0);
          $this_results_data['canvas_offset_z'] = ceil($this_robot_data['canvas_offset_z'] - 20);

          // Define the style and class variables for these results
          $this_results_data['results_amount_class'] = 'sprite ';
          $this_results_data['results_amount_style'] = 'bottom: '.($this_robot_data['canvas_offset_y'] + 65).'px; '.$this_robot_data['robot_float'].': '.($this_robot_data['canvas_offset_x'] - 40).'px; ';
          $this_results_data['results_effect_class'] = 'sprite sprite_'.$this_robot_data['robot_size'].'x'.$this_robot_data['robot_size'].' ability_status_active ability_position_active ';
          $this_results_data['results_effect_style'] = 'z-index: '.$this_results_data['canvas_offset_z'].'; '.$this_robot_data['robot_float'].': '.$this_results_data['canvas_offset_x'].'px; bottom: '.$this_results_data['canvas_offset_y'].'px; background-image: url(images/abilities/ability-results/sprite_'.$this_robot_data['robot_direction'].'_'.$this_robot_data['robot_size'].'x'.$this_robot_data['robot_size'].'.png?'.$this->config['CACHE_DATE'].'); ';

          // Ensure a damage/recovery trigger has been sent and actual damage/recovery was done
          if (!empty($this_options['this_ability_results']['this_amount'])
            && in_array($this_options['this_ability_results']['trigger_kind'], array('damage', 'recovery'))){

            // Define the results effect index
            $this_results_data['results_effect_index'] = array();
            // Check if the results effect index was already generated
            if (!empty($this->index['results_effects'])){
              // Collect the results effect index from the battle index
              $this_results_data['results_effect_index'] = $this->index['results_effects'];
            }
            // Otherwise, generate the results effect index
            else {
              // Define the results effect index for quick programatic lookups
              $this_results_data['results_effect_index']['recovery']['energy'] = '00';
              $this_results_data['results_effect_index']['damage']['energy'] = '01';
              $this_results_data['results_effect_index']['recovery']['attack'] = '02';
              $this_results_data['results_effect_index']['damage']['attack'] = '03';
              $this_results_data['results_effect_index']['recovery']['defense'] = '04';
              $this_results_data['results_effect_index']['damage']['defense'] = '05';
              $this_results_data['results_effect_index']['recovery']['speed'] = '06';
              $this_results_data['results_effect_index']['damage']['speed'] = '07';
              $this->index['results_effects'] = $this_results_data['results_effect_index'];
            }


            // Check if a damage trigger was sent with the ability results
            if ($this_options['this_ability_results']['trigger_kind'] == 'damage'){

              // Append the ability damage kind to the class
              $this_results_data['results_amount_class'] .= 'ability_damage ability_damage_'.$this_options['this_ability_results']['damage_kind'].' ';
              $this_results_data['results_effect_class'] .= 'sprite_80x80_'.$this_results_data['results_effect_index']['damage'][$this_options['this_ability_results']['damage_kind']].' ';
              // Append the final damage results markup to the markup array
              $this_results_data['results_amount_markup'] .= '<div class="'.$this_results_data['results_amount_class'].'" style="'.$this_results_data['results_amount_style'].'">-'.$this_options['this_ability_results']['this_amount'].'</div>';
              $this_results_data['results_effect_markup'] .= '<div class="'.$this_results_data['results_effect_class'].'" style="'.$this_results_data['results_effect_style'].'">-'.$this_options['this_ability_results']['damage_kind'].'</div>';

            }
            // Check if a recovery trigger was sent with the ability results
            elseif ($this_options['this_ability_results']['trigger_kind'] == 'recovery'){

              // Append the ability recovery kind to the class
              $this_results_data['results_amount_class'] .= 'ability_recovery ability_recovery_'.$this_options['this_ability_results']['recovery_kind'].' ';
              $this_results_data['results_effect_class'] .= 'sprite_80x80_'.$this_results_data['results_effect_index']['recovery'][$this_options['this_ability_results']['recovery_kind']].' ';
              // Append the final recovery results markup to the markup array
              $this_results_data['results_amount_markup'] .= '<div class="'.$this_results_data['results_amount_class'].'" style="'.$this_results_data['results_amount_style'].'">+'.$this_options['this_ability_results']['this_amount'].'</div>';
              $this_results_data['results_effect_markup'] .= '<div class="'.$this_results_data['results_effect_class'].'" style="'.$this_results_data['results_effect_style'].'">+'.$this_options['this_ability_results']['recovery_kind'].'</div>';

            }

          }

          // Append this result's markup to the main markup array
          $this_markup .= $this_results_data['results_amount_markup'];
          $this_markup .= $this_results_data['results_effect_markup'];

        }

        // ATTACHMENT ANIMATION STUFF
        if (!empty($this_robot->robot_attachments)){

          // Loop through each attachment and process it
          foreach ($this_robot->robot_attachments AS $attachment_token => $attachment_info){

            // If this is an ability attachment
            if ($attachment_info['class'] == 'ability'){
              // Create the temporary ability object using the provided data and generate its markup data
              $this_ability = new mmrpg_ability($this, $eventinfo['this_player'], $this_robot, $attachment_info);
              // Define this ability data array and generate the markup data
              $attachment_frame_count = sizeof($this_ability->attachment_frame); //checkpoint
              if ($this->counters['events'] == 1 || $attachment_frame_count == 1){ $attachment_frame_key = 0;  }
              elseif ($this->counters['events'] <= $attachment_frame_count){ $attachment_frame_key = $this->counters['events'] - 1; }
              elseif ($this->counters['events'] > $attachment_frame_count){ $attachment_frame_key = (($this->counters['events'] - 1) % $attachment_frame_count); }
              $this_attachment_options = $this_options;
              $this_attachment_options['data_type'] = 'attachment';
              $this_attachment_options['data_debug'] = $attachment_token;
              $this_attachment_options['ability_frame'] = isset($attachment_info['ability_frame']) ? $attachment_info['ability_frame'] : $this_ability->attachment_frame[$attachment_frame_key];
              $this_attachment_options['animate_frames'] = isset($attachment_info['animate_frames']) ? $attachment_info['animate_frames'] : $this_ability->attachment_frame;
              $this_attachment_options['ability_frame_offset'] = isset($attachment_info['ability_frame_offset']) ? $attachment_info['ability_frame_offset'] : $this_ability->attachment_frame_offset;
              $this_ability_data = $this_ability->canvas_markup($this_attachment_options, $this_player_data, $this_robot_data);
              // Append this ability's markup to the main markup array
              $this_markup .= $this_ability_data['ability_markup'];
            }

          }

        }

        // ABILITY ANIMATION STUFF
        if ($this_robot_data['robot_position'] != 'bench'
          && !empty($this_options['this_ability'])
          && $options['canvas_show_this_ability']){

          // Define the ability data array and generate markup data
          $attachment_options['data_type'] = 'ability';
          $this_ability_data = $this_options['this_ability']->canvas_markup($this_options, $this_player_data, $this_robot_data);
          // Append this ability's markup to the main markup array
          $this_markup .= $this_ability_data['ability_markup'];

        }

        // Append this robot's markup to the main markup array
        $this_markup .= $this_robot_data['robot_markup'];

      }
    }

    // Collect the target player's markup data
    $target_player_data = $eventinfo['target_player']->canvas_markup($options);
    // Append the target player's markup to the main markup array
    $this_markup .= $target_player_data['player_markup'];

    // Loop through and display the target player's robots
    if ($options['canvas_show_target_robots'] && !empty($eventinfo['target_player']->player_robots)){

      // Count the number of robots on the target's side of the field
      $num_player_robots = count($eventinfo['target_player']->player_robots);

      // Loop through each target robot and generate it's markup
      foreach ($eventinfo['target_player']->player_robots AS $target_key => $target_robotinfo){

        // Create the temporary target robot ovject
        $target_robot = new mmrpg_robot($this, $eventinfo['target_player'], $target_robotinfo);
        $target_options = $options;
        if ($target_robot->robot_status == 'disabled' && $target_robot->robot_position == 'bench'){ continue; }
        elseif (!empty($eventinfo['target_robot']->robot_id) && $eventinfo['target_robot']->robot_id != $target_robot->robot_id){ $target_options['this_ability'] = false;  }
        elseif (!empty($eventinfo['target_robot']->robot_id) && $eventinfo['target_robot']->robot_id == $target_robot->robot_id && $options['canvas_show_target'] != false){ $target_robot->robot_frame =  $eventinfo['target_robot']->robot_frame; }
        $target_robot->robot_key = $target_robot->robot_key !== false ? $target_robot->robot_key : ($target_key > 0 ? $target_key : $num_player_robots);
        $target_robot_data = $target_robot->canvas_markup($target_options, $target_player_data);

        // ATTACHMENT ANIMATION STUFF
        if (!empty($target_robot->robot_attachments)){

          // Loop through each attachment and process it
          foreach ($target_robot->robot_attachments AS $attachment_token => $attachment_info){

            // If this is an ability attachment
            if ($attachment_info['class'] == 'ability'){
              // Create the target's temporary ability object using the provided data
              $target_ability = new mmrpg_ability($this, $eventinfo['target_player'], $target_robot, $attachment_info);
              // Define the target's ability data array and generate the markup data
              $attachment_frame_count = sizeof($target_ability->attachment_frame); //checkpoint
              if ($this->counters['events'] == 1 || $attachment_frame_count == 1){ $attachment_frame_key = 0;  }
              elseif ($this->counters['events'] <= $attachment_frame_count){ $attachment_frame_key = $this->counters['events'] - 1; }
              elseif ($this->counters['events'] > $attachment_frame_count){ $attachment_frame_key = (($this->counters['events'] - 1) % $attachment_frame_count); }
              $target_attachment_options = $target_options;
              $target_attachment_options['data_type'] = 'attachment';
              $target_attachment_options['data_debug'] = $attachment_token;
              $target_attachment_options['ability_frame'] = isset($attachment_info['ability_frame']) ? $attachment_info['ability_frame'] : $target_ability->attachment_frame[$attachment_frame_key];
              $target_attachment_options['animate_frames'] = isset($attachment_info['animate_frames']) ? $attachment_info['animate_frames'] : $target_ability->attachment_frame;
              $target_attachment_options['ability_frame_offset'] = isset($attachment_info['ability_frame_offset']) ? $attachment_info['ability_frame_offset'] : $target_ability->attachment_frame_offset;
              $target_ability_data = $target_ability->canvas_markup($target_attachment_options, $target_player_data, $target_robot_data);
              // Append this target's ability's markup to the main markup array
              $this_markup .= $target_ability_data['ability_markup'];
            }

          }

        }

        $this_markup .= $target_robot_data['robot_markup'];

      }

    }

    // Return the generated markup and robot data
    return $this_markup;

  }


  // Define a public function for generating event markup
  public function events_markup_generate($eventinfo){

    // Define defaults for event options
    $options = array();
    $options['event_flag_autoplay'] = isset($eventinfo['event_options']['event_flag_autoplay']) ? $eventinfo['event_options']['event_flag_autoplay'] : true;
    $options['console_container_height'] = isset($eventinfo['event_options']['console_container_height']) ? $eventinfo['event_options']['console_container_height'] : 1;
    $options['console_header_float'] = isset($eventinfo['event_options']['this_header_float']) ? $eventinfo['event_options']['this_header_float'] : '';
    $options['console_body_float'] = isset($eventinfo['event_options']['this_body_float']) ? $eventinfo['event_options']['this_body_float'] : '';
    $options['console_show_this'] = isset($eventinfo['event_options']['console_show_this']) ? $eventinfo['event_options']['console_show_this'] : true;
    $options['console_show_this_player'] = isset($eventinfo['event_options']['console_show_this_player']) ? $eventinfo['event_options']['console_show_this_player'] : false;
    $options['console_show_this_robot'] = isset($eventinfo['event_options']['console_show_this_robot']) ? $eventinfo['event_options']['console_show_this_robot'] : true;
    $options['console_show_this_ability'] = isset($eventinfo['event_options']['console_show_this_ability']) ? $eventinfo['event_options']['console_show_this_ability'] : false;
    $options['console_show_target'] = isset($eventinfo['event_options']['console_show_target']) ? $eventinfo['event_options']['console_show_target'] : true;
    $options['console_show_target_player'] = isset($eventinfo['event_options']['console_show_target_player']) ? $eventinfo['event_options']['console_show_target_player'] : true;
    $options['console_show_target_robot'] = isset($eventinfo['event_options']['console_show_target_robot']) ? $eventinfo['event_options']['console_show_target_robot'] : true;
    $options['console_show_target_ability'] = isset($eventinfo['event_options']['console_show_target_ability']) ? $eventinfo['event_options']['console_show_target_ability'] : true;
    $options['canvas_show_this'] = isset($eventinfo['event_options']['canvas_show_this']) ? $eventinfo['event_options']['canvas_show_this'] : true;
    $options['canvas_show_this_robots'] = isset($eventinfo['event_options']['canvas_show_this_robots']) ? $eventinfo['event_options']['canvas_show_this_robots'] : true;
    $options['canvas_show_this_ability'] = isset($eventinfo['event_options']['canvas_show_this_ability']) ? $eventinfo['event_options']['canvas_show_this_ability'] : true;
    $options['canvas_show_target'] = isset($eventinfo['event_options']['canvas_show_target']) ? $eventinfo['event_options']['canvas_show_target'] : true;
    $options['canvas_show_target_robots'] = isset($eventinfo['event_options']['canvas_show_target_robots']) ? $eventinfo['event_options']['canvas_show_target_robots'] : true;
    $options['canvas_show_target_ability'] = isset($eventinfo['event_options']['canvas_show_target_ability']) ? $eventinfo['event_options']['canvas_show_target_ability'] : true;
    $options['this_ability'] = isset($eventinfo['event_options']['this_ability']) ? $eventinfo['event_options']['this_ability'] : false;
    $options['this_ability_results'] = isset($eventinfo['event_options']['this_ability_results']) ? $eventinfo['event_options']['this_ability_results'] : false;
    $options['this_player_image'] = isset($eventinfo['event_options']['this_player_image']) ? $eventinfo['event_options']['this_player_image'] : 'sprite';
    $options['this_robot_image'] = isset($eventinfo['event_options']['this_robot_image']) ? $eventinfo['event_options']['this_robot_image'] : 'sprite';
    $options['this_ability_image'] = isset($eventinfo['event_options']['this_ability_image']) ? $eventinfo['event_options']['this_ability_image'] : 'sprite';

    // Define the variable to collect markup
    $this_markup = array();

    // Generate the event flags markup
    $event_flags = array();
    //$event_flags['testing'] = true;
    $event_flags['autoplay'] = $options['event_flag_autoplay'];
    $this_markup['flags'] = json_encode($event_flags);

    // Generate the console message markup
    $this_markup['console'] = $this->console_markup($eventinfo, $options);

    // Generate the canvas scene markup
    $this_markup['canvas'] = $this->canvas_markup($eventinfo, $options);

    // Generate the jSON encoded event data markup
    $this_markup['data'] = array();
    //$this_markup['data']['this_battle'] = $eventinfo['this_battle']->export_array();
    $this_markup['data']['this_battle'] = '';
    $this_markup['data']['this_field'] = '';
    $this_markup['data']['this_player'] = ''; //!empty($eventinfo['this_player']) ? $eventinfo['this_player']->export_array() : false;
    $this_markup['data']['this_robot'] = ''; //!empty($eventinfo['this_robot']) ? $eventinfo['this_robot']->export_array() : false;
    $this_markup['data']['target_player'] = ''; //!empty($eventinfo['target_player']) ? $eventinfo['target_player']->export_array() : false;
    $this_markup['data']['target_robot'] = ''; //!empty($eventinfo['target_robot']) ? $eventinfo['target_robot']->export_array() : false;
    $this_markup['data'] = json_encode($this_markup['data']);

    // Return the generated event markup
    return $this_markup;

  }

  // Define a public function for collecting event markup
  public function events_markup_collect(){

    // Return the events markup array
    return $this->events;

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

    //$debug = array('$values' => $values, '$weights' => $weights);
    //$this->events_create(false, false, 'DEBUG', '<pre>'.preg_replace('#\s+#', ' ', print_r($debug, true)).'</pre>');

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
    $_SESSION['RPG2k12-2']['BATTLES'][$this->battle_id] = $this_data;

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
      'battle_turns' => $this->battle_turns,
      'battle_rewards' => $this->battle_rewards,
      'battle_points' => $this->battle_points,
      'battle_base_name' => $this->battle_base_name,
      'battle_base_token' => $this->battle_base_token,
      'battle_base_description' => $this->battle_base_description,
      'battle_base_turns' => $this->battle_base_turns,
      'battle_base_rewards' => $this->battle_base_rewards,
      'battle_base_points' => $this->battle_base_points,
      'battle_status' => $this->battle_status,
      'battle_robot_limit' => $this->battle_robot_limit,
      'battle_field_base' => $this->battle_field_base,
      'battle_target_player' => $this->battle_target_player
      );

  }

}
?>