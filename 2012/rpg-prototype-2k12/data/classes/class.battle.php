<?
// Define a class for the battles
class mmrpg_battle {

  // Define global class variables
  private $config;
  private $index;
  public $flags;
  public $counters;
  public $values;
  public $events;
  public $actions;
  public $history;

  // Define the constructor class
  public function mmrpg_battle(){

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

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function battle_load($this_battleinfo){

    // Collect current battle data from the session if available
    $this_battleinfo_backup = $this_battleinfo;
    if (isset($_SESSION['RPG2k12']['BATTLES'][$this_battleinfo['battle_id']])){
      $this_battleinfo = $_SESSION['RPG2k12']['BATTLES'][$this_battleinfo['battle_id']];
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
    $this->battle_field = isset($this_battleinfo['battle_field']) ? $this_battleinfo['battle_field'] : false;
    $this->battle_status = isset($this_battleinfo['battle_status']) ? $this_battleinfo['battle_status'] : 'active';
//    if (empty($this->battle_id)){
//      $this->battle_id = md5(time());
//    }

    // Define the internal robot base values using the robots index array
    $this->battle_base_name = isset($this_battleinfo['battle_base_name']) ? $this_battleinfo['battle_base_name'] : $this->battle_name;
    $this->battle_base_token = isset($this_battleinfo['battle_base_token']) ? $this_battleinfo['battle_base_token'] : $this->battle_token;
    $this->battle_base_description = isset($this_battleinfo['battle_base_description']) ? $this_battleinfo['battle_base_description'] : $this->battle_description;

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
          $this_robot = $current_action['this_robot'];
        }
        if (!empty($current_action['target_robot'])){
          $current_action['target_robot']->robot_frame = $current_action['target_robot']->robot_status != 'disabled' ? 'base' : 'defeat';
          $current_action['target_robot']->update_session();
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

        // Create the enter event for this robot
        $event_header = "{$this_player->player_name}&#39;s {$this_robot->robot_name}";
        $event_body = "{$this_robot->print_robot_name()} enters the battle!<br />";
        $this_robot->robot_frame = 'base';
        $this_robot->robot_position = 'active';
        if (isset($this_robot->robot_quotes['battle_start'])){
          $this_robot->robot_frame = 'taunt';
          $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_start'].'</em>&quot;';
        }
        $this_robot->update_session();
        $this->events_create($this_robot, false, $event_header, $event_body, array('canvas_show_target' => false));

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
          $event_header = $target_player->player_name.'&#39;s '.$target_robot->robot_name;
          $event_body = "{$target_player->print_player_name()}&#39;s {$target_robot->print_robot_name()} was disabled!<br />";
          if (isset($target_robot->robot_quotes['battle_defeat'])){ $event_body .= '&quot;<em>'.$target_robot->robot_quotes['battle_defeat'].'</em>&quot;'; }
          $this_robot->robot_frame = 'base';
          $target_robot->robot_frame = 'defeat';
          $this_robot->update_session();
          $target_robot->update_session();
          $this->events_create($target_robot, $this_robot, $event_header, $event_body, array('console_show_target' => false));

          // Create the robot stat boost event
          $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
          $event_body = "{$this_robot->print_robot_name()} absorbs power from the fallen robot!<br />";
          $this_robot->robot_frame = 'victory';
          $this_robot->update_session();
          if (isset($this_robot->robot_quotes['battle_victory'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_victory'].'</em>&quot;'; }
          $this->events_create($this_robot, $target_robot, $event_header, $event_body, array('console_show_target' => false, 'canvas_show_target' => false));

          // Define the event options array
          $event_options = array();
          $event_options['this_ability_results']['total_actions'] = 0;

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
              $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
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
              $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
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
              $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
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

          // Ensure player and robot variables are updated
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

        // If a robot token was not collected
        if (empty($this_token)){
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
        $this_robot->robot_position = 'bench';
        $this_robot->update_session();
        $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
        $event_body = $this_robot->print_robot_name().' is '.($this_robot->robot_status != 'disabled' ? 'withdrawn' : 'removed').' from battle!';
        if ($this_robot->robot_status != 'disabled' && isset($this_robot->robot_quotes['battle_retreat'])){ $event_body .= '&quot;<em>'.$this_robot->robot_quotes['battle_retreat'].'</em>&quot;'; }
        $this->events_create($this_robot, false, $event_header, $event_body);

        // Switch in the player's new robot and display an event for it
        $this_robot->robot_load($this_robotinfo);
        $this_robot->robot_position = 'active';
        $this_robot->update_session();
        $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
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
          // Create the temporary robot object
          $temp_target_robot = new mmrpg_robot($this, $target_player, $this_token);
          // Ensure this robot is still active
          if ($temp_target_robot->robot_position != 'active'){
            $this_token = '';
          }
        }

        // If an ability token was not collected
        if (empty($this_token)){
          // Decide which robot should be scanned
          foreach ($target_player->player_robots AS $this_key => $this_robotinfo){
            if ($this_robotinfo['robot_position'] == 'active'){ $this_token = $this_robotinfo;  }
          }
          // Create the temporary robot object
          $temp_target_robot = new mmrpg_robot($this, $target_player, $this_token);
        }

        // Ensure the target robot's frame is set to its base
        $temp_target_robot->robot_frame = 'base';
        $temp_target_robot->update_session();

        // Collect the weakness, resistsance, affinity, and immunity text
        $temp_robot_weaknesses = $temp_target_robot->print_robot_weaknesses();
        $temp_robot_resistances = $temp_target_robot->print_robot_resistances();
        $temp_robot_affinities = $temp_target_robot->print_robot_affinities();
        $temp_robot_immunities = $temp_target_robot->print_robot_immunities();

        // If the scan is being iniated on a target
        if ($this_robot->robot_id != $target_robot->robot_id){
          // Create an event to show this robot targetting the other
          $backup_frame = $this_robot->robot_frame;
          $this_robot->robot_frame = 'summon';
          $event_header = $this_player->player_name.'&#39;s '.$this_robot->robot_name;
          $event_body = $this_robot->print_robot_name().' begins scanning the target&hellip;<br />';
          $event_body .= $this_robot->print_robot_name().' downloaded battle data!';
          $this->events_create($this_robot, $temp_target_robot, $event_header, $event_body);
          $this_robot->robot_frame = $backup_frame;
          $this_robot->update_session();
        }

        // Now change the target robot's frame is set to its mugshot
        $temp_target_robot->robot_frame = 'mugshot'; //taunt';

        // Create an event showing the scanned robot's data
        $event_header = $target_player->player_name.'&#39;s '.$temp_target_robot->robot_name;
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
              <td  class="right"><?= !empty($temp_robot_weaknesses) ? $temp_robot_weaknesses : '<span class="robot_weakness">None</span>' ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Energy : </td>
              <td  class="right"><span class="robot_stat"><?= $temp_target_robot->robot_energy.' / '.$temp_target_robot->robot_base_energy ?></span></td>
            </tr>
            <tr>
              <td class="left">Resistances : </td>
              <td  class="right"><?= !empty($temp_robot_resistances) ? $temp_robot_resistances : '<span class="robot_resistance">None</span>' ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Attack : </td>
              <td  class="right"><span class="robot_stat"><?= $temp_target_robot->robot_attack.' / '.$temp_target_robot->robot_base_attack ?></span></td>
            </tr>
            <tr>
              <td class="left">Affinities : </td>
              <td  class="right"><?= !empty($temp_robot_affinities) ? $temp_robot_affinities : '<span class="robot_affinity">None</span>' ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Defense : </td>
              <td  class="right"><span class="robot_stat"><?= $temp_target_robot->robot_defense.' / '.$temp_target_robot->robot_base_defense ?></span></td>
            </tr>
            <tr>
              <td class="left">Immunities : </td>
              <td  class="right"><?= !empty($temp_robot_immunities) ? $temp_robot_immunities : '<span class="robot_immunity">None</span>' ?></td>
              <td class="center">&nbsp;</td>
              <td class="left">Speed : </td>
              <td  class="right"><span class="robot_stat"><?= $temp_target_robot->robot_speed.' / '.$temp_target_robot->robot_base_speed ?></span></td>
            </tr>
          </tbody>
        </table>
        <?
        $event_body .= preg_replace('#\s+#', ' ', trim(ob_get_clean()));
        $this->events_create($temp_target_robot, false, $event_header, $event_body, array('console_container_height' => 2, 'canvas_show_this' => false, 'event_flag_autoplay' => false));

        // Ensure the target robot's frame is set to its base
        $temp_target_robot->robot_frame = 'base';
        $temp_target_robot->update_session();

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
  public function events_markup_console_message($eventinfo, $options){

    // Define the console markup string
    $this_markup = '';

    // Define the necessary text markup for the current robot if allowed and exists
    if (!empty($eventinfo['this_robot']) && $options['console_show_this'] != false){
      // Collect the console data for this robot
      $this_robot_data = $this->events_markup_console_robot($eventinfo['this_robot'], $options);
    }
    // Otherwise if this robot was empty or was turned off
    else {
      // Automatically set the console option to false
      $options['console_show_this'] = false;
      // And set the robot data to false as well
      $this_robot_data = false;
    }

    // Define the necessary text markup for the current robot if allowed and exists
    if (!empty($eventinfo['target_robot']) && $options['console_show_target'] != false){
      // Collect the console data for the target robot
      $target_robot_data = $this->events_markup_console_robot($eventinfo['target_robot'], $options);
    }
    // Otherwise if the target robot was empty or was turned off
    else {
      // Automatically set the console option to false
      $options['console_show_target'] = false;
      // And set the robot data to false as well
      $target_robot_data = false;
    }

    // Assign player-side based floats for the header and body if not set
    if (empty($options['console_header_float'])){
      $options['console_header_float'] = $this_robot_data['robot_float'];
    }
    if (empty($options['console_body_float'])){
      $options['console_body_float'] = $this_robot_data['robot_float'];
    }

    // Append the generated console markup if not empty
    if (!empty($eventinfo['event_header']) && !empty($eventinfo['event_body'])){
      // Define the container class based on height
      $event_class = 'event ';
      if ($options['console_container_height'] == 1){ $event_class .= 'event_single '; }
      if ($options['console_container_height'] == 2){ $event_class .= 'event_double '; }
      if ($options['console_container_height'] == 3){ $event_class .= 'event_triple '; }
      // Display the opening event tag
      $this_markup .= '<div class="'.$event_class.'">';
      // Display this robot's markup if allowed
      if ($options['console_show_this']){ $this_markup .= $this_robot_data['robot_markup']; }
      // Display the target robot's markup if allowed
      if ($options['console_show_target']){ $this_markup .= $target_robot_data['robot_markup']; }
      // Display the event header and event body
      $this_markup .= '<div class="header header_'.$options['console_header_float'].'">'.$eventinfo['event_header'].'</div>';
      $this_markup .= '<div class="body body_'.$options['console_body_float'].'">'.$eventinfo['event_body'].'</div>';
      // Displat the closing event tag
      $this_markup .= '</div>';
    }

    // Return the generated markup and robot data
    return $this_markup;

  }


  // Define a function for generating robot console variables
  public function events_markup_console_robot($this_robot, $options){

    // Define the variable to hold the console robot data
    $this_data = array();

    // Define and calculate the simpler markup and positioning variables for this robot
    $this_data['robot_frame'] = !empty($this_robot->robot_frame) ? $this_robot->robot_frame : 'base';
    $this_data['robot_title'] = $this_robot->robot_name
      .' | ID '.str_pad($this_robot->robot_id, 3, '0', STR_PAD_LEFT).''
      //.' | '.strtoupper($this_robot->robot_position)
      .' | '.$this_robot->robot_energy.' LE'
      .' | '.$this_robot->robot_attack.' AT'
      .' | '.$this_robot->robot_defense.' DF'
      .' | '.$this_robot->robot_speed.' SP';
    $this_data['robot_token'] = $this_robot->robot_token;
    $this_data['robot_float'] = $this_robot->player->player_side;
    $this_data['robot_direction'] = $this_robot->player->player_side == 'left' ? 'right' : 'left';
    $this_data['robot_status'] = $this_robot->robot_status;
    $this_data['robot_position'] = $this_robot->robot_position;

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
    //$this_data['robot_class'] = 'sprite sprite_robot_'.$this_data['robot_status'];
    $this_data['robot_class'] = 'sprite ';
    $this_data['robot_style'] = '';
    $this_data['robot_size'] = 40;
    $this_data['robot_image'] = 'images/robots/robot_'.$this_data['robot_token'].'_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'.png';
    $this_data['robot_class'] .= 'sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].' sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'_'.$this_data['robot_direction'].'_'.$this_data['robot_frame'].' ';
    $this_data['robot_class'] .= 'robot_status_'.$this_data['robot_status'].' robot_position_'.$this_data['robot_position'].' ';
    $this_data['robot_style'] .= 'background-image: url('.$this_data['robot_image'].'); ';
    $this_data['energy_title'] = $this_data['energy_fraction'].' LE';
    $this_data['energy_class'] = 'energy';
    $this_data['energy_style'] = 'background-position: '.$this_data['energy_x_position'].'px '.$this_data['energy_y_position'].'px;';
    // Generate the final markup for the canvas robot
    ob_start();
    echo '<div class="'.$this_data['robot_class'].'" style="'.$this_data['robot_style'].'" title="'.$this_data['robot_title'].'">'.$this_data['robot_title'].'</div>';
    $this_data['robot_markup'] = trim(ob_get_clean());

    // Generate the final markup for the console robot
    ob_start();
    echo '<div class="'.$this_data['container_class'].'" style="'.$this_data['container_style'].'">';
    echo '<div class="'.$this_data['robot_class'].'" style="'.$this_data['robot_style'].'" title="'.$this_data['robot_title'].'">'.$this_data['robot_title'].'</div>';
    echo '<div class="'.$this_data['energy_class'].'" style="'.$this_data['energy_style'].'" title="'.$this_data['energy_title'].'">'.$this_data['energy_title'].'</div>';
    echo '</div>';
    $this_data['robot_markup'] = trim(ob_get_clean());

    // Return the robot console data
    return $this_data;

  }

  // Define a function for generating canvas scene markup
  public function events_markup_canvas_scene($eventinfo, $options){

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

    // Display the foreground and background images
    $this_markup .= '<div class="background" style="background-image: url(images/fields/'.$this->battle_field->field_background.'/battle-field_background_base.png?'.$this->config['CACHE_DATE'].');">&nbsp;</div>';
    $this_markup .= '<div class="foreground" style="background-image: url(images/fields/'.$this->battle_field->field_foreground.'/battle-field_foreground_base.png?'.$this->config['CACHE_DATE'].');">&nbsp;</div>';

    // Loop through and display this player's robots
    if (!empty($eventinfo['this_player']->player_robots)){
      $num_player_robots = count($eventinfo['this_player']->player_robots);
      foreach ($eventinfo['this_player']->player_robots AS $this_key => $this_robotinfo){
        $this_robot = new mmrpg_robot($this, $eventinfo['this_player'], $this_robotinfo);
        $this_options = $options;
        if ($this_robot->robot_status == 'disabled' && $this_robot->robot_position == 'bench'){ continue; }
        elseif (!empty($eventinfo['this_robot']->robot_id) && $eventinfo['this_robot']->robot_id != $this_robot->robot_id){ $this_options['this_ability'] = false;  }
        elseif (!empty($eventinfo['this_robot']->robot_id) && $eventinfo['this_robot']->robot_id == $this_robot->robot_id && $options['canvas_show_this'] != false){ $this_robot->robot_frame =  $eventinfo['this_robot']->robot_frame; }
        $this_robot->robot_key = $this_key > 0 ? $this_key : $num_player_robots;
        $this_robot_data = $this->events_markup_canvas_robot($this_robot, $this_options);

          /*

          $pre_markup = '';
          //$pre_markup .= print_r($this_options['this_ability']->robot_id, true);
          //$pre_markup .= print_r($this_options['this_ability']->ability_frame_offset, true);
          $pre_markup .= $this_options['this_ability_results']['trigger_kind'].'/'.$this_options['this_ability_results']['this_result'].'/';
          if ($this_options['this_ability_results']['trigger_kind'] == 'damage'){ $pre_markup .= $this_options['this_ability_results']['damage_kind'].'/'; }
          elseif ($this_options['this_ability_results']['trigger_kind'] == 'recovery'){ $pre_markup .= $this_options['this_ability_results']['recovery_kind'].'/'; }
          if (!empty($this_options['this_ability_results']['damage_type'])){ $pre_markup .= $this_options['this_ability_results']['damage_type'].'/'; }
          else { $pre_markup .= 'none/'; }
          $pre_markup .= $this_options['this_ability_results']['this_amount'];
          $this_markup .= '<pre>this_ability_results : '.preg_replace('#\s+#i', ' ', htmlentities($pre_markup)).'</pre>';

          */

        // ABILITY/RESULT ANIMATION STUFF
        if ($this_robot_data['robot_position'] != 'bench'
            && (!empty($this_options['this_ability']) || !empty($this_options['this_ability_results']))){

            $this_markup .= '<div class="ability_overlay">&nbsp;</div>';

        }

        // ABILITY ANIMATION STUFF
        if ($this_robot_data['robot_position'] != 'bench' && !empty($this_options['this_ability'])){

          // Define the ability data array and populate basic data
          $this_ability_data = array();
          $this_ability_data['ability_markup'] = '';
          $this_ability_data['ability_name'] = $this_options['this_ability']->ability_name;
          $this_ability_data['ability_token'] = $this_options['this_ability']->ability_token;
          $this_ability_data['ability_status'] = $this_robot_data['robot_status'];
          $this_ability_data['ability_position'] = $this_robot_data['robot_position'];
          $this_ability_data['ability_direction'] = $this_options['this_ability']->robot_id == $this_robot->robot_id ? $this_robot_data['robot_direction'] : ($this_robot_data['robot_direction'] == 'left' ? 'right' : 'left');
          $this_ability_data['ability_float'] = $this_robot_data['robot_float'];
          $this_ability_data['ability_size'] = $this_ability_data['ability_position'] == 'active' ? 80 : 40;
          $this_ability_data['ability_frame'] = $this_options['this_ability']->ability_frame;
          if (is_numeric($this_ability_data['ability_frame']) && $this_ability_data['ability_frame'] > 0){ $this_ability_data['ability_frame'] = str_pad($this_options['this_ability']->ability_frame, 2, '0', STR_PAD_LEFT); }
          elseif (is_numeric($this_ability_data['ability_frame']) && $this_ability_data['ability_frame'] < 0){ $this_ability_data['ability_frame'] = ''; }
          $this_ability_data['ability_image'] = 'images/abilities/ability_'.$this_ability_data['ability_token'].'_'.$this_ability_data['ability_size'].'x'.$this_ability_data['ability_size'].'.png?'.$this->config['CACHE_DATE'];

          // Define the ability's canvas offset variables
          $this_ability_data['canvas_offset_x'] = ceil($this_robot_data['canvas_offset_x'] + ($this_robot_data['robot_size'] * ($this_options['this_ability']->ability_frame_offset['x']/100)));
          $this_ability_data['canvas_offset_y'] = ceil($this_robot_data['canvas_offset_y'] + ($this_robot_data['robot_size'] * ($this_options['this_ability']->ability_frame_offset['y']/100)));
          $this_ability_data['canvas_offset_z'] = ceil($this_robot_data['canvas_offset_z'] + ($this_robot_data['robot_size'] * ($this_options['this_ability']->ability_frame_offset['z']/100)));

          // Define the ability's class and styles variables
          $this_ability_data['ability_class'] = 'sprite ';
          $this_ability_data['ability_class'] .= 'sprite_'.$this_ability_data['ability_size'].'x'.$this_ability_data['ability_size'].' sprite_'.$this_ability_data['ability_size'].'x'.$this_ability_data['ability_size'].'_'.$this_ability_data['ability_direction'].'_'.$this_ability_data['ability_frame'].' ';
          $this_ability_data['ability_class'] .= 'ability_status_'.$this_ability_data['ability_status'].' ability_position_'.$this_ability_data['ability_position'].' ';
          $this_ability_data['ability_style'] = 'z-index: '.$this_ability_data['canvas_offset_z'].'; '.$this_ability_data['ability_float'].': '.$this_ability_data['canvas_offset_x'].'px; bottom: '.$this_ability_data['canvas_offset_y'].'px; ';
          $this_ability_data['ability_style'] .= 'background-image: url('.$this_ability_data['ability_image'].'); ';

          // Append the final ability graphic markup to the markup array
          $this_ability_data['ability_markup'] .= '<div class="'.$this_ability_data['ability_class'].'" style="'.$this_ability_data['ability_style'].'">'.$this_ability_data['ability_name'].'</div>';

          // Append this ability's markup to the main markup array
          $this_markup .= $this_ability_data['ability_markup'];

        }


        // ABILITY RESULTS STUFF
        if ($this_robot_data['robot_position'] != 'bench' && !empty($this_options['this_ability_results'])){

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
          $this_results_data['canvas_offset_z'] = ceil($this_robot_data['canvas_offset_z'] - 15);

          // Define the style and class variables for these results
          $this_results_data['results_amount_class'] = 'sprite ';
          $this_results_data['results_amount_style'] = 'bottom: '.($this_robot_data['canvas_offset_y'] + 65).'px; '.$this_robot_data['robot_float'].': '.($this_robot_data['canvas_offset_x'] - 40).'px; ';
          $this_results_data['results_effect_class'] = 'sprite sprite_'.$this_robot_data['robot_size'].'x'.$this_robot_data['robot_size'].' ability_status_active ability_position_active ';
          $this_results_data['results_effect_style'] = 'z-index: '.$this_results_data['canvas_offset_z'].'; '.$this_robot_data['robot_float'].': '.$this_results_data['canvas_offset_x'].'px; bottom: '.$this_results_data['canvas_offset_y'].'px; background-image: url(images/abilities/ability_ability-results_'.$this_robot_data['robot_size'].'x'.$this_robot_data['robot_size'].'.png?'.$this->config['CACHE_DATE'].'); ';

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
              $this_results_data['results_effect_index']['recovery']['energy'] = '01';
              $this_results_data['results_effect_index']['damage']['energy'] = '02';
              $this_results_data['results_effect_index']['recovery']['attack'] = '03';
              $this_results_data['results_effect_index']['damage']['attack'] = '04';
              $this_results_data['results_effect_index']['recovery']['defense'] = '05';
              $this_results_data['results_effect_index']['damage']['defense'] = '06';
              $this_results_data['results_effect_index']['recovery']['speed'] = '07';
              $this_results_data['results_effect_index']['damage']['speed'] = '08';
              $this->index['results_effects'] = $this_results_data['results_effect_index'];
            }


            // Check if a damage trigger was sent with the ability results
            if ($this_options['this_ability_results']['trigger_kind'] == 'damage'){

              // Append the ability damage kind to the class
              $this_results_data['results_amount_class'] .= 'ability_damage ability_damage_'.$this_options['this_ability_results']['damage_kind'].' ';
              $this_results_data['results_effect_class'] .= 'sprite_80x80_'.$this_robot_data['robot_direction'].'_'.$this_results_data['results_effect_index']['damage'][$this_options['this_ability_results']['damage_kind']].' ';
              // Append the final damage results markup to the markup array
              $this_results_data['results_amount_markup'] .= '<div class="'.$this_results_data['results_amount_class'].'" style="'.$this_results_data['results_amount_style'].'">-'.$this_options['this_ability_results']['this_amount'].'</div>';
              $this_results_data['results_effect_markup'] .= '<div class="'.$this_results_data['results_effect_class'].'" style="'.$this_results_data['results_effect_style'].'">-'.$this_options['this_ability_results']['damage_kind'].'</div>';

            }
            // Check if a recovery trigger was sent with the ability results
            elseif ($this_options['this_ability_results']['trigger_kind'] == 'recovery'){

              // Append the ability recovery kind to the class
              $this_results_data['results_amount_class'] .= 'ability_recovery ability_recovery_'.$this_options['this_ability_results']['recovery_kind'].' ';
              $this_results_data['results_effect_class'] .= 'sprite_80x80_'.$this_robot_data['robot_direction'].'_'.$this_results_data['results_effect_index']['recovery'][$this_options['this_ability_results']['recovery_kind']].' ';
              // Append the final recovery results markup to the markup array
              $this_results_data['results_amount_markup'] .= '<div class="'.$this_results_data['results_amount_class'].'" style="'.$this_results_data['results_amount_style'].'">+'.$this_options['this_ability_results']['this_amount'].'</div>';
              $this_results_data['results_effect_markup'] .= '<div class="'.$this_results_data['results_effect_class'].'" style="'.$this_results_data['results_effect_style'].'">+'.$this_options['this_ability_results']['recovery_kind'].'</div>';

            }

          }

          // Append this result's markup to the main markup array
          $this_markup .= $this_results_data['results_amount_markup'];
          $this_markup .= $this_results_data['results_effect_markup'];

        }


        // Append this robot's markup to the main markup array
        $this_markup .= $this_robot_data['robot_markup'];

      }
    }

    // Loop through and display the target player's robots
    if (!empty($eventinfo['target_player']->player_robots)){
      $num_player_robots = count($eventinfo['target_player']->player_robots);
      foreach ($eventinfo['target_player']->player_robots AS $target_key => $target_robotinfo){
        $target_robot = new mmrpg_robot($this, $eventinfo['target_player'], $target_robotinfo);
        $target_options = $options;
        if ($target_robot->robot_status == 'disabled' && $target_robot->robot_position == 'bench'){ continue; }
        elseif (!empty($eventinfo['target_robot']->robot_id) && $eventinfo['target_robot']->robot_id != $target_robot->robot_id){ $target_options['this_ability'] = false;  }
        elseif (!empty($eventinfo['target_robot']->robot_id) && $eventinfo['target_robot']->robot_id == $target_robot->robot_id && $options['canvas_show_target'] != false){ $target_robot->robot_frame =  $eventinfo['target_robot']->robot_frame; }
        $target_robot->robot_key = $target_key > 0 ? $target_key : $num_player_robots;
        $target_robot_data = $this->events_markup_canvas_robot($target_robot, $target_options);
        $this_markup .= $target_robot_data['robot_markup'];
      }
    }

    // Return the generated markup and robot data
    return $this_markup;

  }

  // Define a function for generating robot canvas variables
  public function events_markup_canvas_robot($this_robot, $options){

    // Define the variable to hold the console robot data
    $this_data = array();
    $this_results = !empty($options['this_ability']->ability_results) ? $options['this_ability']->ability_results : array();

    // Define and calculate the simpler markup and positioning variables for this robot
    $this_data['robot_key'] = !empty($this_robot->robot_key) ? $this_robot->robot_key : 0;
    $this_data['robot_stance'] = !empty($this_robot->robot_stance) ? $this_robot->robot_stance : 'base';
    $this_data['robot_frame'] = !empty($this_robot->robot_frame) ? $this_robot->robot_frame : 'base';
    $this_data['robot_title'] = $this_robot->robot_name
      .' | ID '.str_pad($this_robot->robot_id, 3, '0', STR_PAD_LEFT).''
      //.' | '.strtoupper($this_robot->robot_position)
      .' | '.$this_robot->robot_energy.' LE'
      .' | '.$this_robot->robot_attack.' AT'
      .' | '.$this_robot->robot_defense.' DF'
      .' | '.$this_robot->robot_speed.' SP';
    $this_data['robot_token'] = $this_robot->robot_token;
    $this_data['robot_float'] = $this_robot->player->player_side;
    $this_data['robot_direction'] = $this_robot->player->player_side == 'left' ? 'right' : 'left';
    $this_data['robot_status'] = $this_robot->robot_status;
    $this_data['robot_position'] = $this_robot->robot_position;

    // If this robot is on the bench and inactive, override default sprite frames
    if ($this_data['robot_position'] == 'bench' && $this_data['robot_frame'] == 'base'){
      // Define a randomly generated integer value
      $random_int = mt_rand(1, 10);
      // If the random number was one, show an attack frame
      if ($random_int == 1){ $this_data['robot_frame'] = 'taunt'; }
      // Else if the random number was two, show a defense frame
      elseif ($random_int == 2){ $this_data['robot_frame'] = 'defend'; }
      // Else if the random number was anything else, show the base frame
      else { $this_data['robot_frame'] = 'base'; }
    }

    // Calculate the canvas offset variables
    $this_data['canvas_offset_z'] = 100;
    $this_data['canvas_offset_x'] = 185;  //!$this->flags['wap'] ? 82 : 35;
    $this_data['canvas_offset_y'] = 65;
    $total_attempts = 0;
    if (!empty($this_results['total_strikes'])){ $total_attempts += $this_results['total_strikes']; }
    if (!empty($this_results['total_misses'])){ $total_attempts += $this_results['total_misses']; }
    if ($this_data['robot_frame'] == 'damage' || $this_data['robot_stance'] == 'defend'){
      if (!empty($this_results['total_strikes']) || $this_results['this_result'] == 'success'){
        $this_data['canvas_offset_x'] -= isset($this_results['total_strikes']) ? 5 + (5 * $this_results['total_strikes']) : 5;
      }
      if ($this_results['this_result'] == 'success'){
        $this_data['canvas_offset_y'] += isset($this_results['total_strikes']) ? (1 * $this_results['total_strikes']) : 1;
      }
    }
    elseif ($this_data['robot_status'] == 'disabled'){
      $this_data['canvas_offset_x'] -= 10;
    }
    if ($this_data['robot_position'] == 'bench'){
      $this_data['canvas_offset_z'] = 70 - (1 * $this_data['robot_key']);
      $position_modifier = ($this_data['robot_key'] + 1) / 8;
      $position_modifier_2 = 1 - $position_modifier;
      $this_data['canvas_offset_x'] = 10 + ceil(($this_data['robot_key'] * 18) * $position_modifier);
      $this_data['canvas_offset_y'] = 42 + ceil((130 - ($this_data['robot_key'] * 9)) * $position_modifier);
    }

    // Calculate the energy bar amount and display properties
    $this_data['energy_fraction'] = $this_robot->robot_energy.' / '.$this_robot->robot_base_energy;
    $this_data['energy_percent'] = ceil(($this_robot->robot_energy / $this_robot->robot_base_energy) * 100);
    // Calculate the energy bar positioning variables based on float
    if ($this_data['robot_float'] == 'left'){
      // Define the x position of the energy bar background
      if ($this_data['energy_percent'] == 100){ $this_data['energy_x_position'] = -2; }
      elseif ($this_data['energy_percent'] > 1){ $this_data['energy_x_position'] = -111 + floor(111 * ($this_data['energy_percent'] / 100));  }
      elseif ($this_data['energy_percent'] == 1){ $this_data['energy_x_position'] = -111; }
      else { $this_data['energy_x_position'] = -112; }
      // Define the y position of the energy bar background
      if ($this_data['energy_percent'] > 50){ $this_data['energy_y_position'] = 0; }
      elseif ($this_data['energy_percent'] > 30){ $this_data['energy_y_position'] = -12;}
      else { $this_data['energy_y_position'] = -24; }
    }
    elseif ($this_data['robot_float'] == 'right'){
      // Define the x position of the energy bar background
      if ($this_data['energy_percent'] == 100){ $this_data['energy_x_position'] = -112; }
      elseif ($this_data['energy_percent'] > 1){ $this_data['energy_x_position'] = -3 - floor(111 * ($this_data['energy_percent'] / 100)); }
      elseif ($this_data['energy_percent'] == 1){ $this_data['energy_x_position'] = -3; }
      else { $this_data['energy_x_position'] = -2; }
      // Define the y position of the energy bar background
      if ($this_data['energy_percent'] > 50){ $this_data['energy_y_position'] = -36; }
      elseif ($this_data['energy_percent'] > 30){ $this_data['energy_y_position'] = -48; }
      else { $this_data['energy_y_position'] = -60; }
    }


    // Generate the final markup for the canvas robot
    ob_start();

      // Define the rest of the display variables
      $this_data['robot_size'] = $this_data['robot_position'] == 'active' ? 80 : 40;
      $this_data['robot_image'] = 'images/robots/robot_'.$this_data['robot_token'].'_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'.png';
      $this_data['robot_class'] = 'sprite ';
      $this_data['robot_class'] .= 'sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].' sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'_'.$this_data['robot_direction'].'_'.$this_data['robot_frame'].' ';
      $this_data['robot_class'] .= 'robot_status_'.$this_data['robot_status'].' robot_position_'.$this_data['robot_position'].' ';
      $this_data['robot_style'] = 'z-index: '.$this_data['canvas_offset_z'].'; '.$this_data['robot_float'].': '.$this_data['canvas_offset_x'].'px; bottom: '.$this_data['canvas_offset_y'].'px; ';
      $this_data['robot_style'] .= 'background-image: url('.$this_data['robot_image'].'); ';
      $this_data['energy_title'] = $this_data['energy_fraction'].' LE';
      $this_data['energy_class'] = 'energy';
      $this_data['energy_style'] = 'background-position: '.$this_data['energy_x_position'].'px '.$this_data['energy_y_position'].'px;';

      // Display the robot's battle sprite
      echo '<div class="'.$this_data['robot_class'].'" style="'.$this_data['robot_style'].'" title="'.$this_data['robot_title'].'">'.$this_data['robot_title'].'</div>';

      // Check if this is an active position robot
      if ($this_data['robot_position'] == 'active'){

        // Define the mugshot and detail variables for the GUI
        $this_data['robot_size'] = 40; //$this_data['robot_position'] == 'active' ? 80 : 40;
        $this_data['robot_image'] = 'images/robots/robot_'.$this_data['robot_token'].'_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'.png';
        $this_data['robot_details'] = '<div class="robot_name">'.$this_robot->robot_name.'</div>';
        $this_data['robot_details'] .= '<div class="'.$this_data['energy_class'].'" style="'.$this_data['energy_style'].'" title="'.$this_data['energy_title'].'">'.$this_data['energy_title'].'</div>';
        $robot_attack_markup = '<div class="robot_attack'.($this_robot->robot_attack < 1 ? ' robot_attack_break' : ($this_robot->robot_attack < ($this_robot->robot_base_attack / 2) ? ' robot_attack_break_chance' : '')).'">'.str_pad($this_robot->robot_attack, 3, '0', STR_PAD_LEFT).'</div>';
        $robot_defense_markup = '<div class="robot_defense'.($this_robot->robot_defense < 1 ? ' robot_defense_break' : ($this_robot->robot_defense < ($this_robot->robot_base_defense / 2) ? ' robot_defense_break_chance' : '')).'">'.str_pad($this_robot->robot_defense, 3, '0', STR_PAD_LEFT).'</div>';
        $robot_speed_markup = '<div class="robot_speed'.($this_robot->robot_speed < 1 ? ' robot_speed_break' : ($this_robot->robot_speed < ($this_robot->robot_base_speed / 2) ? ' robot_speed_break_chance' : '')).'">'.str_pad($this_robot->robot_speed, 3, '0', STR_PAD_LEFT).'</div>';
        if ($this_data['robot_float'] == 'left'){
          $this_data['robot_details'] .= $robot_attack_markup;
          $this_data['robot_details'] .= $robot_defense_markup;
          $this_data['robot_details'] .= $robot_speed_markup;
        } else {
          $this_data['robot_details'] .= $robot_speed_markup;
          $this_data['robot_details'] .= $robot_defense_markup;
          $this_data['robot_details'] .= $robot_attack_markup;
        }
        $this_data['mugshot_class'] = 'sprite ';
        $this_data['mugshot_class'] .= 'sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].' sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'_'.$this_data['robot_direction'].'_mugshot ';
        $this_data['mugshot_class'] .= 'robot_status_'.$this_data['robot_status'].' robot_position_'.$this_data['robot_position'].' ';
        $this_data['mugshot_style'] = 'z-index: 100; '.$this_data['robot_float'].': 5px; top: 5px; ';
        $this_data['mugshot_style'] .= 'background-image: url('.$this_data['robot_image'].'); ';

        // Display the robot's mugshot sprite and detail fields
        echo '<div class="sprite robot_details robot_details_'.$this_data['robot_float'].'" style="'.$this_data['robot_float'].': 4px; top: 4px;"><div class="container">'.$this_data['robot_details'].'</div></div>';
        //echo '<div class="sprite" style="z-index: 98; '.$this_data['robot_float'].': 2px; top: 2px; background-image: url(images/assets/mugshot-container.gif); width: 40px; height: 40px; " title="'.$this_data['robot_title'].'">&nbsp;</div>';
        echo '<div class="'.$this_data['mugshot_class'].'" style="'.$this_data['mugshot_style'].'" title="'.$this_data['robot_title'].'">'.$this_data['robot_title'].'</div>';

        // Reset any important variables
        $this_data['robot_size'] = 80;
      }

    // Collect the generated robot markup
    $this_data['robot_markup'] = trim(ob_get_clean());

    // Return the robot canvas data
    return $this_data;

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
    $options['console_show_target'] = isset($eventinfo['event_options']['console_show_target']) ? $eventinfo['event_options']['console_show_target'] : true;
    $options['canvas_show_this'] = isset($eventinfo['event_options']['canvas_show_this']) ? $eventinfo['event_options']['canvas_show_this'] : true;
    $options['canvas_show_this_team'] = isset($eventinfo['event_options']['canvas_show_this_team']) ? $eventinfo['event_options']['canvas_show_this_team'] : true;
    $options['canvas_show_target'] = isset($eventinfo['event_options']['canvas_show_target']) ? $eventinfo['event_options']['canvas_show_target'] : true;
    $options['canvas_show_target_team'] = isset($eventinfo['event_options']['canvas_show_target_team']) ? $eventinfo['event_options']['canvas_show_target_team'] : true;
    $options['this_ability'] = isset($eventinfo['event_options']['this_ability']) ? $eventinfo['event_options']['this_ability'] : false;
    $options['this_ability_results'] = isset($eventinfo['event_options']['this_ability_results']) ? $eventinfo['event_options']['this_ability_results'] : false;

    // Define the variable to collect markup
    $this_markup = array();

    // Generate the event flags markup
    $event_flags = array();
    $event_flags['testing'] = true;
    $event_flags['autoplay'] = $options['event_flag_autoplay'];
    $this_markup['flags'] = json_encode($event_flags);

    // Generate the console message markup
    $this_markup['console'] = $this->events_markup_console_message($eventinfo, $options);

    // Generate the canvas scene markup
    $this_markup['canvas'] = $this->events_markup_canvas_scene($eventinfo, $options);

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
    $_SESSION['RPG2k12']['BATTLES'][$this->battle_id] = $this_data;

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
      'battle_base_name' => $this->battle_base_name,
      'battle_base_token' => $this->battle_base_token,
      'battle_base_description' => $this->battle_base_description,
      'battle_status' => $this->battle_status
      );

  }

}
?>