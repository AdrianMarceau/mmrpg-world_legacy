<?
// Define a class for the robots
class mmrpg_robot {

  // Define global class variables
  private $index;
  public $flags;
  public $counters;
  public $values;
  public $history;

  // Define the constructor class
  public function mmrpg_robot(){

    // Surround constructor in try...catch stack 'cause I read it on the internet
    try {

      // Define the internal index pointer
      $this->index = &$GLOBALS['mmrpg_index'];

      // Collect any provided arguments
      $args = func_get_args();

      // Define the internal class identifier
      $this->class = 'robot';

      // Define the internal battle pointer
      $this->battle = isset($args[0]) ? $args[0] : $GLOBALS['this_battle'];
      $this->battle_id = $this->battle->battle_id;
      $this->battle_token = $this->battle->battle_token;

      // Define the internal battle pointer
      $this->field = isset($this->battle->field) ? $this->battle->field : $GLOBALS['this_field'];
      $this->field_id = $this->battle->battle_id;
      $this->field_token = $this->battle->battle_token;

      // Define the internal player values using the provided array
      $this->player = isset($args[1]) ? $args[1] : $GLOBALS['this_player'];
      $this->player_id = $this->player->player_id;
      $this->player_token = $this->player->player_token;

      // Collect current robot data from the function if available
      $this_robotinfo = isset($args[2]) ? $args[2] : array('robot_id' => 0, 'robot_token' => 'robot');

      // Now load the robot data from the session or index
      if (!$this->robot_load($this_robotinfo)){
        // Robot data could not be loaded
        die('Robot data could not be loaded : ('.$GLOBALS['DEBUG']['checkpoint_line'].')<br /><pre>'.print_r($args[2], true).'</pre>');
      }

      //throw new Exception("testing 123 robot?");

    } catch (Exception $e) {

      // Kill the script and print the exception
      die('Exception?!?! ('.$e->getMessage().')');

    }

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function robot_load($this_robotinfo){

    // If the robot info was not an array, return false
    if (!is_array($this_robotinfo)){ return false; }
    // If the robot ID was not provided, return false
    if (!isset($this_robotinfo['robot_id'])){ return false; }
    // If the robot token was not provided, return false
    if (!isset($this_robotinfo['robot_token'])){ return false; }

    // Collect current robot data from the session if available
    $this_robotinfo_backup = $this_robotinfo;
    if (isset($_SESSION['RPG2k12-2']['ROBOTS'][$this->battle->battle_id][$this->player->player_id][$this_robotinfo['robot_id']])){
      $this_robotinfo = $_SESSION['RPG2k12-2']['ROBOTS'][$this->battle->battle_id][$this->player->player_id][$this_robotinfo['robot_id']];
    }
    // Otherwise, collect robot data from the index
    else {
      $this_robotinfo = $this->index['robots'][$this_robotinfo['robot_token']];
      $this_robotinfo = array_replace($this_robotinfo, $this_robotinfo_backup);
    }


    // Define the internal robot values using the provided array
    $this->flags = isset($this_robotinfo['flags']) ? $this_robotinfo['flags'] : array();
    $this->counters = isset($this_robotinfo['counters']) ? $this_robotinfo['counters'] : array();
    $this->values = isset($this_robotinfo['values']) ? $this_robotinfo['values'] : array();
    $this->history = isset($this_robotinfo['history']) ? $this_robotinfo['history'] : array();
    $this->robot_key = isset($this_robotinfo['robot_key']) ? $this_robotinfo['robot_key'] : false;
    $this->robot_id = isset($this_robotinfo['robot_id']) ? $this_robotinfo['robot_id'] : false;
    $this->robot_number = isset($this_robotinfo['robot_number']) ? $this_robotinfo['robot_number'] : 'RPG000';
    $this->robot_name = isset($this_robotinfo['robot_name']) ? $this_robotinfo['robot_name'] : 'Robot';
    $this->robot_token = isset($this_robotinfo['robot_token']) ? $this_robotinfo['robot_token'] : 'robot';
    $this->robot_description = isset($this_robotinfo['robot_description']) ? $this_robotinfo['robot_description'] : '';
    $this->robot_energy = isset($this_robotinfo['robot_energy']) ? $this_robotinfo['robot_energy'] : 1;
    $this->robot_attack = isset($this_robotinfo['robot_attack']) ? $this_robotinfo['robot_attack'] : 1;
    $this->robot_defense = isset($this_robotinfo['robot_defense']) ? $this_robotinfo['robot_defense'] : 1;
    $this->robot_speed = isset($this_robotinfo['robot_speed']) ? $this_robotinfo['robot_speed'] : 1;
    $this->robot_weaknesses = isset($this_robotinfo['robot_weaknesses']) ? $this_robotinfo['robot_weaknesses'] : array();
    $this->robot_resistances = isset($this_robotinfo['robot_resistances']) ? $this_robotinfo['robot_resistances'] : array();
    $this->robot_affinities = isset($this_robotinfo['robot_affinities']) ? $this_robotinfo['robot_affinities'] : array();
    $this->robot_immunities = isset($this_robotinfo['robot_immunities']) ? $this_robotinfo['robot_immunities'] : array();
    $this->robot_abilities = isset($this_robotinfo['robot_abilities']) ? $this_robotinfo['robot_abilities'] : array();
    $this->robot_attachments = isset($this_robotinfo['robot_attachments']) ? $this_robotinfo['robot_attachments'] : array();
    $this->robot_quotes = isset($this_robotinfo['robot_quotes']) ? $this_robotinfo['robot_quotes'] : array();
    $this->robot_choices = isset($this->index['robots'][$this->robot_token]['robot_choices']) ? $this->index['robots'][$this->robot_token]['robot_choices'] : array();
    $this->robot_status = isset($this_robotinfo['robot_status']) ? $this_robotinfo['robot_status'] : 'active';
    $this->robot_position = isset($this_robotinfo['robot_position']) ? $this_robotinfo['robot_position'] : 'bench';
    $this->robot_stance = isset($this_robotinfo['robot_stance']) ? $this_robotinfo['robot_stance'] : 'base';
    $this->robot_rewards = isset($this_robotinfo['robot_rewards']) ? $this_robotinfo['robot_rewards'] : array();
    $this->robot_frame = isset($this_robotinfo['robot_frame']) ? $this_robotinfo['robot_frame'] : 'base';
    $this->robot_frame_index = isset($this_robotinfo['robot_frame_index']) ? $this_robotinfo['robot_frame_index'] : array('base','taunt','victory','defeat','shoot','throw','summon','slide','defend','damage');
    $this->robot_frame_offset = isset($this_robotinfo['robot_frame_offset']) ? $this_robotinfo['robot_frame_offset'] : array('x' => 0, 'y' => 0, 'z' => 0);
    $this->robot_points = isset($this_robotinfo['robot_points']) ? $this_robotinfo['robot_points'] : 0;
//    if (empty($this->robot_id)){
//      $this->robot_id = array_search($this->robot_token, $this->player->player_robots);
//      //$this->battle->events_create(false, false, 'DEBUG', print_r($this->player->player_robots, true));
//      //$this->robot_id = strtoupper(substr(md5($this->player->player_id.$this->robot_name), 0, 10));
//    }

    // Define the internal robot base values using the robots index array
    $this->robot_base_name = isset($this_robotinfo['robot_base_name']) ? $this_robotinfo['robot_base_name'] : $this->robot_name;
    $this->robot_base_token = isset($this_robotinfo['robot_base_token']) ? $this_robotinfo['robot_base_token'] : $this->robot_token;
    $this->robot_base_description = isset($this_robotinfo['robot_base_description']) ? $this_robotinfo['robot_base_description'] : $this->robot_description;
    $this->robot_base_energy = isset($this_robotinfo['robot_base_energy']) ? $this_robotinfo['robot_base_energy'] : $this->robot_energy;
    $this->robot_base_attack = isset($this_robotinfo['robot_base_attack']) ? $this_robotinfo['robot_base_attack'] : $this->robot_attack;
    $this->robot_base_defense = isset($this_robotinfo['robot_base_defense']) ? $this_robotinfo['robot_base_defense'] : $this->robot_defense;
    $this->robot_base_speed = isset($this_robotinfo['robot_base_speed']) ? $this_robotinfo['robot_base_speed'] : $this->robot_speed;
    $this->robot_base_weaknesses = isset($this_robotinfo['robot_base_weaknesses']) ? $this_robotinfo['robot_base_weaknesses'] : $this->robot_weaknesses;
    $this->robot_base_resistances = isset($this_robotinfo['robot_base_resistances']) ? $this_robotinfo['robot_base_resistances'] : $this->robot_resistances;
    $this->robot_base_affinities = isset($this_robotinfo['robot_base_affinities']) ? $this_robotinfo['robot_base_affinities'] : $this->robot_affinities;
    $this->robot_base_immunities = isset($this_robotinfo['robot_base_immunities']) ? $this_robotinfo['robot_base_immunities'] : $this->robot_immunities;
    $this->robot_base_abilities = isset($this_robotinfo['robot_base_abilities']) ? $this_robotinfo['robot_base_abilities'] : $this->robot_abilities;
    $this->robot_base_attachments = isset($this_robotinfo['robot_base_attachments']) ? $this_robotinfo['robot_base_attachments'] : $this->robot_attachments;
    $this->robot_base_quotes = isset($this_robotinfo['robot_base_quotes']) ? $this_robotinfo['robot_base_quotes'] : $this->robot_quotes;
    $this->robot_base_rewards = isset($this_robotinfo['robot_base_rewards']) ? $this_robotinfo['robot_base_rewards'] : $this->robot_rewards;
    $this->robot_base_points = isset($this_robotinfo['robot_base_points']) ? $this_robotinfo['robot_base_points'] : $this->robot_points;

    // Remove any abilities that do not exist in the index
    if (!empty($this->robot_abilities)){
      foreach ($this->robot_abilities AS $key => $token){
        if (!isset($this->index['abilities'][$token])){
          unset($this->robot_abilities[$key]);
        }
      }
      $this->robot_abilities = array_values($this->robot_abilities);
    }

    // Update the session variable
    $this->update_session();

    // Return true on success
    return true;

  }

  // Define public print functions for markup generation
  public function print_robot_number(){ return '<span class="robot_number">'.$this->robot_number.'</span>'; }
  public function print_robot_name(){ return '<span class="robot_name">'.$this->robot_name.'</span>'; }
  public function print_robot_token(){ return '<span class="robot_token">'.$this->robot_token.'</span>'; }
  public function print_robot_type(){ return '<span class="robot_type">'.$this->robot_type.'</span>'; }
  public function print_robot_description(){ return '<span class="robot_description">'.$this->robot_description.'</span>'; }
  public function print_robot_energy(){ return '<span class="robot_energy">'.$this->robot_energy.'</span>'; }
  public function print_robot_attack(){ return '<span class="robot_energy">x'.number_format($this->robot_attack, 2, '.', '').'</span>'; }
  public function print_robot_defense(){ return '<span class="robot_energy">x'.number_format($this->robot_defense, 2, '.', '').'</span>'; }
  public function print_robot_speed(){ return '<span class="robot_speed">'.$this->robot_speed.'</span>'; }
  public function print_robot_weaknesses(){
    $this_markup = array();
    foreach ($this->robot_weaknesses AS $this_type){
      $this_markup[] = '<span class="robot_weakness">'.$this->index['types'][$this_type]['type_name'].'</span>';
    }
    $this_markup = implode(', ', $this_markup);
    return $this_markup;
  }
  public function print_robot_resistances(){
    $this_markup = array();
    foreach ($this->robot_resistances AS $this_type){
      $this_markup[] = '<span class="robot_resistance">'.$this->index['types'][$this_type]['type_name'].'</span>';
    }
    $this_markup = implode(', ', $this_markup);
    return $this_markup;
  }
  public function print_robot_affinities(){
    $this_markup = array();
    foreach ($this->robot_affinities AS $this_type){
      $this_markup[] = '<span class="robot_affinity">'.$this->index['types'][$this_type]['type_name'].'</span>';
    }
    $this_markup = implode(', ', $this_markup);
    return $this_markup;
  }
  public function print_robot_immunities(){
    $this_markup = array();
    foreach ($this->robot_immunities AS $this_type){
      $this_markup[] = '<span class="robot_immunity">'.$this->index['types'][$this_type]['type_name'].'</span>';
    }
    $this_markup = implode(', ', $this_markup);
    return $this_markup;
  }

  // Define a function for checking if this robot has a specific ability
  public function has_ability($ability_token){
    if (empty($this->robot_abilities) || empty($ability_token)){ return false; }
    elseif (in_array($ability_token, $this->robot_abilities)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot has a specific weakness
  public function has_weakness($weakness_token){
    if (empty($this->robot_weaknesses) || empty($weakness_token)){ return false; }
    elseif (in_array($weakness_token, $this->robot_weaknesses)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot has a specific resistance
  public function has_resistance($resistance_token){
    if (empty($this->robot_resistances) || empty($resistance_token)){ return false; }
    elseif (in_array($resistance_token, $this->robot_resistances)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot has a specific affinity
  public function has_affinity($affinity_token){
    if (empty($this->robot_affinities) || empty($affinity_token)){ return false; }
    elseif (in_array($affinity_token, $this->robot_affinities)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot has a specific immunity
  public function has_immunity($immunity_token){
    if (empty($this->robot_immunities) || empty($immunity_token)){ return false; }
    elseif (in_array($immunity_token, $this->robot_immunities)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot is above a certain energy percent
  public function above_energy_percent($this_energy_percent){
    $actual_energy_percent = ceil(($this->robot_energy / $this->robot_base_energy) * 100);
    if ($actual_energy_percent > $this_energy_percent){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot is below a certain energy percent
  public function below_energy_percent($this_energy_percent){
    $actual_energy_percent = ceil(($this->robot_energy / $this->robot_base_energy) * 100);
    if ($actual_energy_percent < $this_energy_percent){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot is in attack boost status
  public function has_attack_boost(){
    if ($this->robot_attack >= ($this->robot_base_attack * 2)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot is in attack break status
  public function has_attack_break(){
    if ($this->robot_attack <= 0){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot is in defense boost status
  public function has_defense_boost(){
    if ($this->robot_defense >= ($this->robot_base_defense * 2)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot is in defense break status
  public function has_defense_break(){
    if ($this->robot_defense <= 0){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot is in speed boost status
  public function has_speed_boost(){
    if ($this->robot_speed >= ($this->robot_base_speed * 2)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot is in speed break status
  public function has_speed_break(){
    if ($this->robot_speed <= 0){ return true; }
    else { return false; }
  }

  // Define a trigger for using one of this robot's abilities
  public function trigger_ability($target_robot, $this_ability){

    // Update this robot's history with the triggered ability
    $this->history['triggered_abilities'][] = $this_ability->ability_token;

    // Define a variable to hold the ability results
    $this_ability->ability_results = array();
    $this_ability->ability_results['total_result'] = '';
    $this_ability->ability_results['total_actions'] = 0;
    $this_ability->ability_results['total_strikes'] = 0;
    $this_ability->ability_results['total_misses'] = 0;
    $this_ability->ability_results['total_amount'] = 0;
    $this_ability->ability_results['total_overkill'] = 0;
    $this_ability->ability_results['this_result'] = '';
    $this_ability->ability_results['this_amount'] = 0;
    $this_ability->ability_results['this_overkill'] = 0;
    $this_ability->ability_results['this_text'] = '';
    $this_ability->ability_results['flag_critical'] = false;
    $this_ability->ability_results['flag_affinity'] = false;
    $this_ability->ability_results['flag_weakness'] = false;
    $this_ability->ability_results['flag_resistance'] = false;
    $this_ability->ability_results['flag_immunity'] = false;

    // Reset the ability options to default
    $this_ability->target_options_reset();
    $this_ability->damage_options_reset();
    $this_ability->recovery_options_reset();

    // Default this and the target robot's frames to their base
    $this->robot_frame = 'base';
    $target_robot->robot_frame = 'base';

    // Default the robot's stances to attack/defend
    $this->robot_stance = 'attack';
    $target_robot->robot_stance = 'defend';

    // Copy the ability function to local scope and execute it
    $this_ability_function = $this_ability->ability_function;
    $this_ability_function(array(
      'this_index' => $this->index,
      'this_battle' => $this->battle,
      'this_field' => $this->field,
      'this_player' => $this->player,
      'this_robot' => $this,
      'target_player' => $target_robot->player,
      'target_robot' => $target_robot,
      'this_ability' => $this_ability
      ));

    // Update this ability's history with the triggered ability data and results
    $this_ability->history['ability_results'][] = $this_ability->ability_results;
    // Update this ability's history with the triggered ability damage options
    $this_ability->history['ability_options'][] = $this_ability->ability_options;

    // Reset the robot's stances to the base
    $this->robot_stance = 'base';
    $target_robot->robot_stance = 'base';

    // Update internal variables
    $target_robot->update_session();
    $this_ability->update_session();

    // Return the ability results
    return $this_ability->ability_results;
  }

  // Define a trigger for using one of this robot's attachments
  public function trigger_attachment($attachment_info){

    // If this is an ability attachment
    if ($attachment_info['class'] == 'ability'){

      // Create the temporary ability object
      $this_ability = new mmrpg_ability($this->battle, $this->player, $this, $attachment_info);

      // Update this robot's history with the triggered attachment
      $this->history['triggered_attachments'][] = 'ability_'.$this_ability->ability_token;

      // Define a variable to hold the ability results
      $this_ability->attachment_results = array();
      $this_ability->attachment_results['total_result'] = '';
      $this_ability->attachment_results['total_actions'] = 0;
      $this_ability->attachment_results['total_strikes'] = 0;
      $this_ability->attachment_results['total_misses'] = 0;
      $this_ability->attachment_results['total_amount'] = 0;
      $this_ability->attachment_results['total_overkill'] = 0;
      $this_ability->attachment_results['this_result'] = '';
      $this_ability->attachment_results['this_amount'] = 0;
      $this_ability->attachment_results['this_overkill'] = 0;
      $this_ability->attachment_results['this_text'] = '';
      $this_ability->attachment_results['flag_critical'] = false;
      $this_ability->attachment_results['flag_affinity'] = false;
      $this_ability->attachment_results['flag_weakness'] = false;
      $this_ability->attachment_results['flag_resistance'] = false;
      $this_ability->attachment_results['flag_immunity'] = false;

      // Reset the ability options to default
      $this_ability->attachment_options_reset();

      // Default this and the target robot's frames to their base
      $this->robot_frame = 'base';
      //$target_robot->robot_frame = 'base';

      // Collect the target robot and player objects
      //$target_robot_info = $this->battle->values['robots'][];

      // Copy the attachment function to local scope and execute it
      $this_attachment_function = $this_ability->ability_attachment;
      $this_attachment_function(array(
        'this_index' => $this->index,
        'this_battle' => $this->battle,
        'this_field' => $this->field,
        'this_player' => $this->player,
        'this_robot' => $this,
        //'target_player' => $target_robot->player,
        //'target_robot' => $target_robot,
        'this_ability' => $this_ability
        ));

      // Update this ability's attachment history with the triggered attachment data and results
      $this_ability->history['attachment_results'][] = $this_ability->attachment_results;
      // Update this ability's attachment history with the triggered attachment damage options
      $this_ability->history['attachment_options'][] = $this_ability->attachment_options;

      // Reset the robot's stances to the base
      $this->robot_stance = 'base';
      //$target_robot->robot_stance = 'base';

      // Update internal variables
      $this->update_session();
      $this_ability->update_session();

      // Return the ability results
      return $this_ability->attachment_results;

    }

  }

  // Define a trigger for using one of this robot's ability events
  public function trigger_ability_event($target_robot, $this_ability, $event_token){

    // Collect the ability event from the robot if it exists
    if (isset($this_ability->ability_events[$event_token])){ $this_function = $this_ability->ability_events[$event_token]; }
    // Otherwise create an empty event to execute
    else { $this_function = function(){}; }

    // Execute the ability event function
    $this_results = $this_function(array(
      'this_index' => $this->index,
      'this_battle' => $this->battle,
      'this_player' => $this->player,
      'this_robot' => $this,
      'target_player' => $target_robot->player,
      'target_robot' => $target_robot,
      'this_ability' => $this_ability
      ));

    // Update internal variables
    $target_robot->update_session();
    $this_ability->update_session();

    // Return the ability results
    return $this_results;

  }

//  // Define separate trigger functions for each type of damage on this robot
//  public function trigger_energy_damage($target_robot, $this_ability, &$ability_results, $damage_amount, &$damage_options){
//    $this->trigger_damage('energy', $target_robot, $this_ability, &$ability_results, $damage_amount, &$damage_options);
//  }

  // Define a trigger for using one of this robot's abilities
  public function trigger_target($target_robot, $this_ability){

    // Define the event console options
    $event_options = array();
    $event_options['console_container_height'] = 1;
    $event_options['this_ability'] = $this_ability;
    $event_options['this_ability_results'] = array();
    $event_options['console_show_target'] = false;

    // Empty any text from the previous ability result
    $this_ability->ability_results['this_text'] = '';

    // Update this robot's history with the triggered ability
    $this->history['triggered_targets'][] = $target_robot->robot_token;

    // Backup this and the target robot's frames to revert later
    $this_robot_backup_frame = $this->robot_frame;
    $this_player_backup_frame = $this->player->player_frame;
    $target_robot_backup_frame = $target_robot->robot_frame;
    $target_player_backup_frame = $target_robot->player->player_frame;
    $this_ability_backup_frame = $this_ability->ability_frame;

    // Update this robot's frames using the target options
    $this->robot_frame = $this_ability->target_options['target_frame'];
    $this->player->player_frame = 'command';
    $this->player->update_session();
    $this_ability->ability_frame = $this_ability->target_options['ability_success_frame'];
    $this_ability->ability_frame_offset = $this_ability->target_options['ability_success_frame_offset'];

    // Create a message to show the initial targeting action
    if ($this->robot_id != $target_robot->robot_id){
      $this_ability->ability_results['this_text'] .= "{$this->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    } else {
      //$this_ability->ability_results['this_text'] .= ''; //"{$this->print_robot_name()} targets itself&hellip;<br />";
    }

    // Append the targetting text to the event body
    $this_ability->ability_results['this_text'] .= $this_ability->target_options['target_text'];

    // Update the ability results with the the trigger kind
    $this_ability->ability_results['trigger_kind'] = 'target';
    $this_ability->ability_results['this_result'] = 'success';

    // Update the event options with the ability results
    $event_options['this_ability_results'] = $this_ability->ability_results;

    // Create a new entry in the event log for the targeting event
    $this->battle->events_create($this, $target_robot, $this_ability->target_options['target_header'], $this_ability->ability_results['this_text'], $event_options);

    // Update this ability's history with the triggered ability data and results
    $this_ability->history['ability_results'][] = $this_ability->ability_results;

    // restore this and the target robot's frames to their backed up state
    $this->robot_frame = $this_robot_backup_frame;
    $this->player->player_frame = $this_player_backup_frame;
    $target_robot->robot_frame = $target_robot_backup_frame;
    $target_player->player_frame = $target_player_backup_frame;
    $this_ability->ability_frame = $this_ability_backup_frame;

    // Update internal variables
    $this->update_session();
    $this->player->update_session();
    $target_robot->update_session();
    $this_ability->update_session();

    // Return the ability results
    return $this_ability->ability_results;

  }

  // Define a trigger for inflicting all types of damage on this robot
  public function trigger_damage($target_robot, $this_ability, $damage_amount){

    // Backup this and the target robot's frames to revert later
    $this_robot_backup_frame = $this->robot_frame;
    $this_player_backup_frame = $this->player->player_frame;
    $target_robot_backup_frame = $target_robot->robot_frame;
    $target_player_backup_frame = $target_robot->player->player_frame;
    $this_ability_backup_frame = $this_ability->ability_frame;

    // Define the event console options
    $event_options = array();
    $event_options['console_container_height'] = 1;
    $event_options['this_ability'] = $this_ability;
    $event_options['this_ability_results'] = array();

    // Empty any text from the previous ability result
    $this_ability->ability_results['this_text'] = '';

    // If this robot has weakness to the ability (based on type)
    if ($this->has_weakness($this_ability->damage_options['damage_type'])){
      $this_ability->ability_results['flag_weakness'] = true;
    } else {
      $this_ability->ability_results['flag_weakness'] = false;
    }

    // If target robot has affinity to the ability (based on type)
    if ($this->has_affinity($this_ability->damage_options['damage_type'])){
      $this_ability->ability_results['flag_affinity'] = true;
      return $this->trigger_recovery($target_robot, $this_ability, $damage_amount);
    } else {
      $this_ability->ability_results['flag_affinity'] = false;
    }

    // If target robot has resistance tp the ability (based on type)
    if ($this->has_resistance($this_ability->damage_options['damage_type'])){
      $this_ability->ability_results['flag_resistance'] = true;
    } else {
      $this_ability->ability_results['flag_resistance'] = false;
    }

    // If target robot has immunity to the ability (based on type)
    if ($this->has_immunity($this_ability->damage_options['damage_type'])){
      $this_ability->ability_results['flag_immunity'] = true;
    } else {
      $this_ability->ability_results['flag_immunity'] = false;
    }

    // Update the ability results with the the trigger kind and damage details
    $this_ability->ability_results['trigger_kind'] = 'damage';
    $this_ability->ability_results['damage_kind'] = $this_ability->damage_options['damage_kind'];
    $this_ability->ability_results['damage_type'] = $this_ability->damage_options['damage_type'];

    // If the success rate was not provided, auto-calculate
    if ($this_ability->damage_options['success_rate'] == 'auto'){
      // If this robot is targetting itself, default to ability accuracy
      if ($this->robot_id == $target_robot->robot_id){
        // Update the success rate to the ability accuracy value
        $this_ability->damage_options['success_rate'] = $this_ability->ability_accuracy;
      }
      // Otherwise, if this robot is in speed break, default to 100% accuracy
      elseif ($this->robot_speed <= 0){
        // Hard-code the success rate at 100% accuracy
          $this_ability->damage_options['success_rate'] = 100;
      }
      // Otherwise, calculate the success rate based on relative speeds
      else {
        // Collect this ability's accuracy stat for modification
        $this_ability_accuracy = $this_ability->ability_accuracy;
        // If the target was faster/slower, boost/lower the ability accuracy
        if ($target_robot->robot_speed > $this->robot_speed
          || $target_robot->robot_speed < $this->robot_speed){
          $this_modifier = $target_robot->robot_speed / $this->robot_speed;
          //$this_ability_accuracy = ceil($this_ability_accuracy * $this_modifier);
          $this_ability_accuracy = ceil($this_ability_accuracy * 0.90) + ceil(($this_ability_accuracy * 0.10) * $this_modifier);
          if ($this_ability_accuracy > 100){ $this_ability_accuracy = 100; }
          elseif ($this_ability_accuracy < 0){ $this_ability_accuracy = 0; }
        }
        // Update the success rate to the ability accuracy value
        $this_ability->damage_options['success_rate'] = $this_ability_accuracy;
        //$this_ability->ability_results['this_text'] .= '$this_ability_accuracy : '.$this_ability_accuracy.'<br />';
        //$this_ability->ability_results['this_text'] .= '';
      }
    }

    // If the failure rate was not provided, auto-calculate
    if ($this_ability->damage_options['failure_rate'] == 'auto'){
      // Set the failure rate to the difference of success vs failure (100% base)
      $this_ability->damage_options['failure_rate'] = 100 - $this_ability->damage_options['success_rate'];
      if ($this_ability->damage_options['failure_rate'] < 0){
        $this_ability->damage_options['failure_rate'] = 0;
      }
    }

    // If this robot is in speed break, increase success rate, reduce failure
    if ($this->robot_speed == 0 && $this_ability->damage_options['success_rate'] > 0){
      $this_ability->damage_options['success_rate'] = ceil($this_ability->damage_options['success_rate'] * 2);
      $this_ability->damage_options['failure_rate'] = ceil($this_ability->damage_options['failure_rate'] / 2);
    }
    // If the target robot is in speed break, decease the success rate, increase failure
    elseif ($target_robot->robot_speed == 0 && $this_ability->damage_options['success_rate'] > 0){
      $this_ability->damage_options['success_rate'] = ceil($this_ability->damage_options['success_rate'] / 2);
      $this_ability->damage_options['failure_rate'] = ceil($this_ability->damage_options['failure_rate'] * 2);
    }

    // If success rate is at 100%, auto-set the result to success
    if ($this_ability->damage_options['success_rate'] == 100){
      // Set this ability result as a success
      $this_ability->ability_results['this_result'] = 'success';
    }
    // Else if the success rate is at 0%, auto-set the result to failure
    elseif ($this_ability->damage_options['success_rate'] == 0){
      // Set this ability result as a failure
      $this_ability->ability_results['this_result'] = 'failure';
    }
    // Otherwise, use a weighted random generation to get the result
    else {
      // Calculate whether this attack was a success, based on the success vs. failure rate
      $this_ability->ability_results['this_result'] = $this->battle->weighted_chance(
        array('success','failure'),
        array($this_ability->damage_options['success_rate'], $this_ability->damage_options['failure_rate'])
        );
    }

    // If this is ENERGY damage and this robot is already disabled
    if ($this_ability->damage_options['damage_kind'] == 'energy' && $this->robot_status == 'disabled'){
      // Hard code the result to failure
      $this_ability->ability_results['this_result'] = 'failure';
      // Return an empty ability result
      //return $this_ability->ability_results;
    }
    // Otherwise if ATTACK damage but attack is already zero
    elseif ($this_ability->damage_options['damage_kind'] == 'attack' && $this->robot_attack <= 0){
      // Hard code the result to failure
      $this_ability->ability_results['this_result'] = 'failure';
    }
    // Otherwise if DEFENSE damage but defense is already zero
    elseif ($this_ability->damage_options['damage_kind'] == 'defense' && $this->robot_defense <= 0){
      // Hard code the result to failure
      $this_ability->ability_results['this_result'] = 'failure';
    }
    // Otherwise if SPEED damage but speed is already zero
    elseif ($this_ability->damage_options['damage_kind'] == 'speed' && $this->robot_speed <= 0){
      // Hard code the result to failure
      $this_ability->ability_results['this_result'] = 'failure';
    }

    // If this robot has immunity to the ability, hard-code a failure result
    if ($this_ability->ability_results['flag_immunity']){
      $this_ability->ability_results['this_result'] = 'failure';
    }

    // If the attack was a success, proceed normally
    if ($this_ability->ability_results['this_result'] == 'success'){

      // Update this robot's frame based on damage type
      $this->robot_frame = $this_ability->damage_options['damage_frame'];
      $this->player->player_frame = $this->robot_id != $target_robot->robot_id ? 'damage' : 'base';
      $this_ability->ability_frame = $this_ability->damage_options['ability_success_frame'];
      $this_ability->ability_frame_offset = $this_ability->damage_options['ability_success_frame_offset'];

      // Display the success text, if text has been provided
      if (!empty($this_ability->damage_options['success_text'])){
        $this_ability->ability_results['this_text'] .= $this_ability->damage_options['success_text'];
      }

      // Collect the damage amount argument from the function
      $this_ability->ability_results['this_amount'] = $damage_amount;

      // If this is ENERGY type damage we're dealing with, apply stat mods
      if (true || $this_ability->damage_options['damage_kind'] == 'energy'){

        // If this robot's defense stat is not at 100% power
        if ($this->robot_id != $target_robot->robot_id && ($this->robot_defense > 100 || $this->robot_defense < 100)){
          // If this robot is NOT in defense break, calculate damage normally
          if ($this->robot_defense >= 1){ $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] / ($this->robot_defense / 100)); }
          // Otherwise, if this robot is in defense break, this is a OHKO
          elseif ($this->robot_defense <= 0){ $this_ability->ability_results['this_amount'] = ceil($this->robot_energy * 10); }
        }

        // If the target robot's attack stat is not at 100% power
        if ($this->robot_id != $target_robot->robot_id && ($target_robot->robot_attack > 100 || $target_robot->robot_attack < 100)){
          // If the target robot is NOT in attack break, calculate damage normally
          if ($target_robot->robot_attack >= 1){ $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * ($target_robot->robot_attack / 100)); }
          // Otherwise, if the target robot is in attack break, this does zero damage
          elseif ($target_robot->robot_attack <= 0){ $this_ability->ability_results['this_amount'] = 0; }
        }

        // If this is a critical hit (random chance)
        if ($this->battle->critical_chance($this_ability->damage_options['critical_rate'])){
          $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] * $this_ability->damage_options['critical_multiplier'];
          $this_ability->ability_results['flag_critical'] = true;
        } else {
          $this_ability->ability_results['flag_critical'] = false;
        }

      }

      // If this robot is weak to the ability (based on type)
      if ($this_ability->ability_results['flag_weakness']){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->damage_options['weakness_multiplier']);
      }

      // If target robot resists the ability (based on type)
      if ($this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->damage_options['resistance_multiplier']);
      }

      // If target robot is immune to the ability (based on type)
      if ($this_ability->ability_results['flag_immunity']){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->damage_options['immunity_multiplier']);
      }

      // Generate the flag string for easier parsing
      $this_flag_string = array();
      if ($this_ability->ability_results['flag_weakness']){ $this_flag_string[] = 'weakness'; }
      if ($this_ability->ability_results['flag_affinity']){ $this_flag_string[] = 'affinity'; }
      if ($this_ability->ability_results['flag_resistance']){ $this_flag_string[] = 'resistance'; }
      if ($this_ability->ability_results['flag_immunity']){ $this_flag_string[] = 'immunity'; }
      if ($this_ability->ability_results['flag_critical']){ $this_flag_string[] = 'critical'; }
      $this_flag_name = (!empty($this_flag_string) ? implode('_', $this_flag_string).'_' : '').'text';

      // Generate the status text based on flags
      if (isset($this_ability->damage_options[$this_flag_name])){
        //$event_options['console_container_height'] = 2;
        //$this_ability->ability_results['this_text'] .= '<br />';
        $this_ability->ability_results['this_text'] .= ' '.$this_ability->damage_options[$this_flag_name];
      }

      // Display a break before the damage amount if other text was generated
      if (!empty($this_ability->ability_results['this_text'])){
        $this_ability->ability_results['this_text'] .= '<br />';
      }

      // Ensure the damage amount is always at least one, unless absolute zero
      if ($this_ability->ability_results['this_amount'] < 1 && $this_ability->ability_results['this_amount'] > 0){ $this_ability->ability_results['this_amount'] = 1; }

      // Reference the requested damage kind with a shorter variable
      $this_ability->damage_options['damage_kind'] = strtolower($this_ability->damage_options['damage_kind']);
      $damage_stat_name = 'robot_'.$this_ability->damage_options['damage_kind'];

      // Inflict the approiate damage type based on the damage options
      switch ($damage_stat_name){

        // If this is an ATTACK type damage trigger
        case 'robot_attack': {
          // Inflict attack damage on the target's internal stat
          $this->robot_attack = $this->robot_attack - $this_ability->ability_results['this_amount'];
          // If the damage put the robot's attack below zero
          if ($this->robot_attack < 0){
            // Calculate the overkill amount
            $this_ability->ability_results['this_overkill'] = $this->robot_attack * -1;
            // Calculate the actual damage amount
            $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] + $this->robot_attack;
            // Zero out the robots attack
            $this->robot_attack = 0;
          }
          // Break from the ATTACK case
          break;
        }
        // If this is an DEFENSE type damage trigger
        case 'robot_defense': {
          // Inflict defense damage on the target's internal stat
          $this->robot_defense = $this->robot_defense - $this_ability->ability_results['this_amount'];
          // If the damage put the robot's defense below zero
          if ($this->robot_defense < 0){
            // Calculate the overkill amount
            $this_ability->ability_results['this_overkill'] = $this->robot_defense * -1;
            // Calculate the actual damage amount
            $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] + $this->robot_defense;
            // Zero out the robots defense
            $this->robot_defense = 0;
          }
          // Break from the DEFENSE case
          break;
        }
        // If this is an SPEED type damage trigger
        case 'robot_speed': {
          // Inflict attack damage on the target's internal stat
          $this->robot_speed = $this->robot_speed - $this_ability->ability_results['this_amount'];
          // If the damage put the robot's speed below zero
          if ($this->robot_speed < 0){
            // Calculate the overkill amount
            $this_ability->ability_results['this_overkill'] = $this->robot_speed * -1;
            // Calculate the actual damage amount
            $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] + $this->robot_speed;
            // Zero out the robots speed
            $this->robot_speed = 0;
          }
          // Break from the SPEED case
          break;
        }
        // If this is an ENERGY type damage trigger
        case 'robot_energy': default: {
          // Inflict the actual damage on the robot
          $this->robot_energy = $this->robot_energy - $this_ability->ability_results['this_amount'];
          // If the damage put the robot into overkill, recalculate the damage
          if ($this->robot_energy < 0){
            // Calculate the overkill amount
            $this_ability->ability_results['this_overkill'] = $this->robot_energy * -1;
            // Calculate the actual damage amount
            $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] + $this->robot_energy;
            // Zero out the robots energy
            $this->robot_energy = 0;
          }
          // If the robot's energy has dropped to zero, disable them
          if ($this->robot_energy == 0){
            $this->robot_status = 'disabled';
          }
          // Break from the ENERGY case
          break;
        }

      }

      // Define the print variables to return
      $this_ability->ability_results['print_strikes'] = '<span class="damage_strikes">'.$this_ability->ability_results['total_strikes'].'</span>';
      $this_ability->ability_results['print_misses'] = '<span class="damage_misses">'.$this_ability->ability_results['total_misses'].'</span>';
      $this_ability->ability_results['print_result'] = '<span class="damage_result">'.$this_ability->ability_results['total_result'].'</span>';
      $this_ability->ability_results['print_amount'] = '<span class="damage_amount">'.$this_ability->ability_results['this_amount'].'</span>';
      $this_ability->ability_results['print_overkill'] = '<span class="damage_overkill">'.$this_ability->ability_results['this_overkill'].'</span>';

      // Add the final damage text showing the amount based on damage type
      if ($this_ability->damage_options['damage_kind'] == 'energy'){
        $this_ability->ability_results['this_text'] .= "{$this->print_robot_name()} takes {$this_ability->ability_results['print_amount']} damage";
        //$this_ability->ability_results['this_text'] .= ($this_ability->ability_results['this_overkill'] > 0 ? " and {$this_ability->ability_results['print_overkill']} overkill" : '');
        $this_ability->ability_results['this_text'] .= '!<br />';
      }
      // Otherwise, if this is one of the robot's other internal stats
      elseif ($this_ability->damage_options['damage_kind'] == 'attack'
        || $this_ability->damage_options['damage_kind'] == 'defense'
        || $this_ability->damage_options['damage_kind'] == 'speed'){
        // Print the result based on if the stat will go any lower
        if ($this_ability->ability_results['this_amount'] > 0){

          $this_ability->ability_results['this_text'] .= "{$this->print_robot_name()}&#39;s {$this_ability->damage_options['damage_kind']} fell by {$this_ability->ability_results['print_amount']}";
          $this_ability->ability_results['this_text'] .= '!<br />';
        }
        // Otherwise if the stat wouldn't go any lower
        else {

          // Update this robot's frame based on damage type
          //$this->robot_frame = $this_ability->damage_options['damage_frame'];
          $this_ability->ability_frame = $this_ability->damage_options['ability_failure_frame'];
          $this_ability->ability_frame_offset = $this_ability->damage_options['ability_failure_frame_offset'];

          // Display the failure text, if text has been provided
          if (!empty($this_ability->damage_options['failure_text'])){
            $this_ability->ability_results['this_text'] .= $this_ability->damage_options['failure_text'].' ';
          }
        }
      }

    }
    // Otherwise, if the attack was a failure
    else {

      // Update this robot's frame based on damage type
      //$this->robot_frame = $this_ability->damage_options['damage_frame'];
      //$this->player->player_frame = 'base';
      $this_ability->ability_frame = $this_ability->damage_options['ability_failure_frame'];
      $this_ability->ability_frame_offset = $this_ability->damage_options['ability_failure_frame_offset'];

      // Update the damage and overkilll amounts to reflect zero damage
      $this_ability->ability_results['this_amount'] = 0;
      $this_ability->ability_results['this_overkill'] = 0;

      // Display the failure text, if text has been provided
      if (!empty($this_ability->damage_options['failure_text'])){
        $this_ability->ability_results['this_text'] .= $this_ability->damage_options['failure_text'].' ';
      }

    }

    // Update the damage result total variables
    $this_ability->ability_results['total_amount'] += $this_ability->ability_results['this_amount'];
    $this_ability->ability_results['total_overkill'] += $this_ability->ability_results['this_overkill'];
    if ($this_ability->ability_results['this_result'] == 'success'){ $this_ability->ability_results['total_strikes']++; }
    else { $this_ability->ability_results['total_misses']++; }
    $this_ability->ability_results['total_actions'] = $this_ability->ability_results['total_strikes'] + $this_ability->ability_results['total_misses'];
    if ($this_ability->ability_results['total_result'] != 'success'){ $this_ability->ability_results['total_result'] = $this_ability->ability_results['this_result']; }
    $event_options['this_ability_results'] = $this_ability->ability_results;

    // Update internal variables
    $target_robot->update_session();
    $target_robot->player->update_session();
    $this->update_session();
    $this->player->update_session();

    // Generate an event with the collected damage results based on damage type
    if ($this->robot_id == $target_robot->robot_id){  // || $this_ability->damage_options['damage_kind'] == 'energy'
      $event_options['console_show_target'] = false;
      $this->battle->events_create($target_robot, $this, $this_ability->damage_options['damage_header'], $this_ability->ability_results['this_text'], $event_options);
    } else {
      $event_options['console_show_target'] = false;
      $this->battle->events_create($this, $target_robot, $this_ability->damage_options['damage_header'], $this_ability->ability_results['this_text'], $event_options);
    }

    // restore this and the target robot's frames to their backed up state
    $this->robot_frame = $this_robot_backup_frame;
    $this->player->player_frame = $this_player_backup_frame;
    $target_robot->robot_frame = $target_robot_backup_frame;
    $target_robot->player->player_frame = $target_player_backup_frame;
    $this_ability_robot->ability_frame = $this_ability_backup_frame;

    // Update internal variables
    $target_robot->update_session();
    $target_robot->player->update_session();
    $this->update_session();
    $this->player->update_session();
    $this_ability->update_session();

    // Return the final damage results
    return $this_ability->ability_results;

  }

  // Define a trigger for inflicting all types of recovery on this robot
  public function trigger_recovery($target_robot, $this_ability, $recovery_amount){

    // Backup this and the target robot's frames to revert later
    $this_robot_backup_frame = $this->robot_frame;
    $this_player_backup_frame = $this->robot_frame;
    $target_robot_backup_frame = $target_robot->robot_frame;
    $target_player_backup_frame = $target_robot->robot_frame;

    // Define the event console options
    $event_options = array();
    $event_options['console_container_height'] = 1;
    $event_options['this_ability'] = $this_ability;
    $event_options['this_ability_results'] = array();

    // Empty any text from the previous ability result
    $this_ability->ability_results['this_text'] = '';

    // If this robot has weakness to the ability (based on type)
    if ($this->has_weakness($this_ability->recovery_options['recovery_type'])){
      $this_ability->ability_results['flag_weakness'] = true;
      return $this->trigger_damage($target_robot, $this_ability, $damage_amount);
    } else {
      $this_ability->ability_results['flag_weakness'] = false;
    }

    // If target robot has affinity to the ability (based on type)
    if ($this->has_affinity($this_ability->recovery_options['recovery_type'])){
      $this_ability->ability_results['flag_affinity'] = true;
    } else {
      $this_ability->ability_results['flag_affinity'] = false;
    }

    // If target robot has resistance tp the ability (based on type)
    if ($this->has_resistance($this_ability->recovery_options['recovery_type'])){
      $this_ability->ability_results['flag_resistance'] = true;
    } else {
      $this_ability->ability_results['flag_resistance'] = false;
    }

    // If target robot has immunity to the ability (based on type)
    if ($this->has_immunity($this_ability->recovery_options['recovery_type'])){
      $this_ability->ability_results['flag_immunity'] = true;
    } else {
      $this_ability->ability_results['flag_immunity'] = false;
    }

    // Update the ability results with the the trigger kind and recovery details
    $this_ability->ability_results['trigger_kind'] = 'recovery';
    $this_ability->ability_results['recovery_kind'] = $this_ability->recovery_options['recovery_kind'];
    $this_ability->ability_results['recovery_type'] = $this_ability->recovery_options['recovery_type'];

    // If the success rate was not provided, auto-calculate
    if ($this_ability->recovery_options['success_rate'] == 'auto'){
      // If this robot is targetting itself, default to ability accuracy
      if ($this->robot_id == $target_robot->robot_id){
        // Update the success rate to the ability accuracy value
        $this_ability->recovery_options['success_rate'] = $this_ability->ability_accuracy;
      }
      // Otherwise, if this robot is in speed break, default to 100% accuracy
      elseif ($this->robot_speed <= 0){
        // Hard-code the success rate at 100% accuracy
          $this_ability->recovery_options['success_rate'] = 100;
      }
      // Otherwise, calculate the success rate based on relative speeds
      else {
        // Collect this ability's accuracy stat for modification
        $this_ability_accuracy = $this_ability->ability_accuracy;
        // If the target was faster/slower, boost/lower the ability accuracy
        if ($target_robot->robot_speed > $this->robot_speed
          || $target_robot->robot_speed < $this->robot_speed){
          $this_modifier = $target_robot->robot_speed / $this->robot_speed;
          //$this_ability_accuracy = ceil($this_ability_accuracy * $this_modifier);
          $this_ability_accuracy = ceil($this_ability_accuracy * 0.90) + ceil(($this_ability_accuracy * 0.10) * $this_modifier);
          if ($this_ability_accuracy > 100){ $this_ability_accuracy = 100; }
          elseif ($this_ability_accuracy < 0){ $this_ability_accuracy = 0; }
        }
        // Update the success rate to the ability accuracy value
        $this_ability->recovery_options['success_rate'] = $this_ability_accuracy;
        //$this_ability->ability_results['this_text'] .= '';
      }
    }

    // If the failure rate was not provided, auto-calculate
    if ($this_ability->recovery_options['failure_rate'] == 'auto'){
      // Set the failure rate to the difference of success vs failure (100% base)
      $this_ability->recovery_options['failure_rate'] = 100 - $this_ability->recovery_options['success_rate'];
      if ($this_ability->recovery_options['failure_rate'] < 0){
        $this_ability->recovery_options['failure_rate'] = 0;
      }
    }

    // If this robot is in speed break, increase success rate, reduce failure
    if ($this->robot_speed == 0 && $this_ability->recovery_options['success_rate'] > 0){
      $this_ability->recovery_options['success_rate'] = ceil($this_ability->recovery_options['success_rate'] * 2);
      $this_ability->recovery_options['failure_rate'] = ceil($this_ability->recovery_options['failure_rate'] / 2);
    }
    // If the target robot is in speed break, decease the success rate, increase failure
    elseif ($target_robot->robot_speed == 0 && $this_ability->recovery_options['success_rate'] > 0){
      $this_ability->recovery_options['success_rate'] = ceil($this_ability->recovery_options['success_rate'] / 2);
      $this_ability->recovery_options['failure_rate'] = ceil($this_ability->recovery_options['failure_rate'] * 2);
    }

    // If success rate is at 100%, auto-set the result to success
    if ($this_ability->recovery_options['success_rate'] == 100){
      // Set this ability result as a success
      $this_ability->ability_results['this_result'] = 'success';
    }
    // Else if the success rate is at 0%, auto-set the result to failure
    elseif ($this_ability->recovery_options['success_rate'] == 0){
      // Set this ability result as a failure
      $this_ability->ability_results['this_result'] = 'failure';
    }
    // Otherwise, use a weighted random generation to get the result
    else {
      // Calculate whether this attack was a success, based on the success vs. failure rate
      $this_ability->ability_results['this_result'] = $this->battle->weighted_chance(
        array('success','failure'),
        array($this_ability->recovery_options['success_rate'], $this_ability->recovery_options['failure_rate'])
        );
    }

    // If this is ENERGY recovery and this robot is already at full health
    if ($this_ability->recovery_options['recovery_kind'] == 'energy' && $this->robot_energy >= $this->robot_base_energy){
      // Hard code the result to failure
      $this_ability->ability_results['this_result'] = 'failure';
    }
    // Otherwise if ATTACK recovery but attack is already at double the base
    elseif ($this_ability->recovery_options['recovery_kind'] == 'attack' && $this->robot_attack >= ($this->robot_base_attack * 2)){
      // Hard code the result to failure
      $this_ability->ability_results['this_result'] = 'failure';
    }
    // Otherwise if DEFENSE recovery but defense is already at double the base
    elseif ($this_ability->recovery_options['recovery_kind'] == 'defense' && $this->robot_defense >= ($this->robot_base_defense * 2)){
      // Hard code the result to failure
      $this_ability->ability_results['this_result'] = 'failure';
    }
    // Otherwise if SPEED recovery but speed is already at double the base
    elseif ($this_ability->recovery_options['recovery_kind'] == 'speed' && $this->robot_speed >= ($this->robot_base_speed * 2)){
      // Hard code the result to failure
      $this_ability->ability_results['this_result'] = 'failure';
    }

    // If this robot has immunity to the ability, hard-code a failure result
    if ($this_ability->ability_results['flag_immunity']){
      $this_ability->ability_results['this_result'] = 'failure';
    }

    // If the attack was a success, proceed normally
    if ($this_ability->ability_results['this_result'] == 'success'){

      // Update this robot's frame based on recovery type
      $this->robot_frame = $this_ability->recovery_options['recovery_frame'];
      $this->robot_frame = 'taunt'; //$this_ability->recovery_options['recovery_frame'];
      $this_ability->ability_frame = $this_ability->recovery_options['ability_success_frame'];
      $this_ability->ability_frame_offset = $this_ability->recovery_options['ability_success_frame_offset'];

      // Display the success text, if text has been provided
      if (!empty($this_ability->recovery_options['success_text'])){
        $this_ability->ability_results['this_text'] .= $this_ability->recovery_options['success_text'];
      }

      // Collect the recovery amount argument from the function
      $this_ability->ability_results['this_amount'] = $recovery_amount;

      // If this is ENERGY type recovery we're dealing with, apply stat mods
      if (true || $this_ability->recovery_options['recovery_kind'] == 'energy'){

        // If this robot's defense stat is not at 100% power
        if ($this->robot_id != $target_robot->robot_id && ($this->robot_defense > 100 || $this->robot_defense < 100)){
          // If this robot is NOT in defense break, calculate damage normally
          if ($this->robot_defense >= 1){ $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] / ($this->robot_defense / 100)); }
          // Otherwise, if this robot is in defense break, this is a OHKO
          elseif ($this->robot_defense <= 0){ $this_ability->ability_results['this_amount'] = ceil($this->robot_energy * 2); }
        }

        // If the target robot's attack stat is not at 100% power
        if ($this->robot_id != $target_robot->robot_id && ($target_robot->robot_attack > 100 || $target_robot->robot_attack < 100)){
          // If the target robot is NOT in attack break, calculate damage normally
          if ($target_robot->robot_attack >= 1){ $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * ($target_robot->robot_attack / 100)); }
          // Otherwise, if the target robot is in attack break, this does zero damage
          elseif ($target_robot->robot_attack <= 0){ $this_ability->ability_results['this_amount'] = 0; }
        }

        // If this is a critical hit (random chance)
        if ($this->battle->critical_chance($this_ability->recovery_options['critical_rate'])){
          $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] * $this_ability->recovery_options['critical_multiplier'];
          $this_ability->ability_results['flag_critical'] = true;
        } else {
          $this_ability->ability_results['flag_critical'] = false;
        }

      }

      // If this robot has affinity to the ability (based on type)
      if ($this->has_affinity($this_ability->recovery_options['recovery_type'])){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->recovery_options['affinity_multiplier']);
      }

      // If target robot has resistance to the ability (based on type)
      if ($this->has_resistance($this_ability->recovery_options['recovery_type'])){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->recovery_options['resistance_multiplier']);
      }

      // If target robot has immunity to the ability (based on type)
      if ($this->has_immunity($this_ability->recovery_options['recovery_type'])){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->recovery_options['immunity_multiplier']);
      }

      // Generate the flag string for easier parsing
      $this_flag_string = array();
      if ($this_ability->ability_results['flag_weakness']){ $this_flag_string[] = 'weakness'; }
      if ($this_ability->ability_results['flag_affinity']){ $this_flag_string[] = 'affinity'; }
      if ($this_ability->ability_results['flag_resistance']){ $this_flag_string[] = 'resistance'; }
      if ($this_ability->ability_results['flag_immunity']){ $this_flag_string[] = 'immunity'; }
      if ($this_ability->ability_results['flag_critical']){ $this_flag_string[] = 'critical'; }
      $this_flag_name = (!empty($this_flag_string) ? implode('_', $this_flag_string).'_' : '').'text';

      // Generate the status text based on flags
      if (isset($this_ability->receovery_options[$this_flag_name])){
        //$event_options['console_container_height'] = 2;
        //$this_ability->ability_results['this_text'] .= '<br />';
        $this_ability->ability_results['this_text'] .= ' '.$this_ability->recovery_options[$this_flag_name];
      }

      // Display a break before the recovery amount if other text was generated
      if (!empty($this_ability->ability_results['this_text'])){
        $this_ability->ability_results['this_text'] .= '<br />';
      }

      // Ensure the damage amount is always at least one, unless absolute zero
      if ($this_ability->ability_results['this_amount'] < 1 && $this_ability->ability_results['this_amount'] > 0){ $this_ability->ability_results['this_amount'] = 1; }

      // Reference the requested recovery kind with a shorter variable
      $this_ability->recovery_options['recovery_kind'] = strtolower($this_ability->recovery_options['recovery_kind']);
      $recovery_stat_name = 'robot_'.$this_ability->recovery_options['recovery_kind'];

      // Inflict the approiate recovery type based on the recovery options
      switch ($recovery_stat_name){

        // If this is an ATTACK type recovery trigger
        case 'robot_attack': {
          // Inflict attack recovery on the target's internal stat
          $this->robot_attack = $this->robot_attack + $this_ability->ability_results['this_amount'];
          // If the recovery put the robot's attack above double the base
          if ($this->robot_attack > ($this->robot_base_attack * 2)){
            // Calculate the overkill amount
            $this_ability->ability_results['this_overkill'] = (($this->robot_base_attack * 2) - $this->robot_attack) * -1;
            // Calculate the actual recovery amount
            $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] - $this_ability->ability_results['this_overkill'];
            // Max out the robots attack
            $this->robot_attack = $this->robot_base_attack * 2;
          }
          // Break from the ATTACK case
          break;
        }
        // If this is an DEFENSE type recovery trigger
        case 'robot_defense': {
          // Inflict defense recovery on the target's internal stat
          $this->robot_defense = $this->robot_defense + $this_ability->ability_results['this_amount'];
          // If the recovery put the robot's defense above double the base
          if ($this->robot_defense > ($this->robot_base_defense * 2)){
            // Calculate the overkill amount
            $this_ability->ability_results['this_overkill'] = (($this->robot_base_defense * 2) - $this->robot_defense) * -1;
            // Calculate the actual recovery amount
            $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] - $this_ability->ability_results['this_overkill'];
            // Max out the robots defense
            $this->robot_defense = $this->robot_base_defense * 2;
          }
          // Break from the DEFENSE case
          break;
        }
        // If this is an SPEED type recovery trigger
        case 'robot_speed': {
          // Inflict speed recovery on the target's internal stat
          $this->robot_speed = $this->robot_speed + $this_ability->ability_results['this_amount'];
          // If the recovery put the robot's speed above double the base
          if ($this->robot_speed > ($this->robot_base_speed * 2)){
            // Calculate the overkill amount
            $this_ability->ability_results['this_overkill'] = (($this->robot_base_speed * 2) - $this->robot_speed) * -1;
            // Calculate the actual recovery amount
            $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] - $this_ability->ability_results['this_overkill'];
            // Max out the robots speed
            $this->robot_speed = $this->robot_base_speed * 2;
          }
          // Break from the SPEED case
          break;
        }
        // If this is an ENERGY type recovery trigger
        case 'robot_energy': default: {
          // Inflict the actual recovery on the robot
          $this->robot_energy = $this->robot_energy + $this_ability->ability_results['this_amount'];
          // If the recovery put the robot's energy above the base
          if ($this->robot_energy > $this->robot_base_energy){
            // Calculate the overcure amount
            $this_ability->ability_results['this_overkill'] = ($this->robot_base_energy - $this->robot_energy) * -1;
            // Calculate the actual recovery amount
            $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] - $this_ability->ability_results['this_overkill'];
            // Max out the robots energy
            $this->robot_energy = $this->robot_base_energy;
          }
          // Break from the ENERGY case
          break;
        }

      }

      // Define the print variables to return
      $this_ability->ability_results['print_strikes'] = '<span class="recovery_strikes">'.$this_ability->ability_results['total_strikes'].'</span>';
      $this_ability->ability_results['print_misses'] = '<span class="recovery_misses">'.$this_ability->ability_results['total_misses'].'</span>';
      $this_ability->ability_results['print_result'] = '<span class="recovery_result">'.$this_ability->ability_results['total_result'].'</span>';
      $this_ability->ability_results['print_amount'] = '<span class="recovery_amount">'.$this_ability->ability_results['this_amount'].'</span>';
      $this_ability->ability_results['print_overkill'] = '<span class="recovery_overkill">'.$this_ability->ability_results['this_overkill'].'</span>';

      // Add the final recovery text showing the amount based on recovery type
      if ($this_ability->recovery_options['recovery_kind'] == 'energy'){
        $this_ability->ability_results['this_text'] .= "{$this->print_robot_name()} recovers {$this_ability->ability_results['print_amount']} energy";
        //$this_ability->ability_results['this_text'] .= ($this_ability->ability_results['this_overkill'] > 0 ? " and {$this_ability->ability_results['print_overkill']} overkill" : '');
        $this_ability->ability_results['this_text'] .= '!<br />';
      }
      // Otherwise, if this is one of the robot's other internal stats
      elseif ($this_ability->recovery_options['recovery_kind'] == 'attack'
        || $this_ability->recovery_options['recovery_kind'] == 'defense'
        || $this_ability->recovery_options['recovery_kind'] == 'speed'){
        // Print the result based on if the stat will go any lower
        if ($this_ability->ability_results['this_amount'] > 0){
          $this_ability->ability_results['this_text'] .= "{$this->print_robot_name()}&#39;s {$this_ability->recovery_options['recovery_kind']} rose by {$this_ability->ability_results['print_amount']}";
          $this_ability->ability_results['this_text'] .= '!<br />';
        }
        // Otherwise if the stat wouldn't go any lower
        else {

          // Update this robot's frame based on recovery type
          //$this->robot_frame = 'defend'; //$this_ability->recovery_options['recovery_frame'];
          $this_ability->ability_frame = $this_ability->recovery_options['ability_failure_frame'];
          $this_ability->ability_frame_offset = $this_ability->recovery_options['ability_failure_frame_offset'];

          // Display the failure text, if text has been provided
          if (!empty($this_ability->recovery_options['failure_text'])){
            $this_ability->ability_results['this_text'] .= $this_ability->recovery_options['failure_text'].' ';
          }
        }
      }

    }
    // Otherwise, if the attack was a failure
    else {


      // Update this robot's frame based on recovery type
      //$this->robot_frame = 'defend'; //$this_ability->recovery_options['recovery_frame'];
      $this_ability->ability_frame = $this_ability->recovery_options['ability_failure_frame'];
      $this_ability->ability_frame_offset = $this_ability->recovery_options['ability_failure_frame_offset'];

      // Update the damage and overkilll amounts to reflect zero damage
      $this_ability->ability_results['this_amount'] = 0;
      $this_ability->ability_results['this_overkill'] = 0;

      // Display the failure text, if text has been provided
      if (!empty($this_ability->recovery_options['failure_text'])){
        $this_ability->ability_results['this_text'] .= $this_ability->recovery_options['failure_text'].' ';
      }

    }

    // Update the recovery result total variables
    $this_ability->ability_results['total_amount'] += $this_ability->ability_results['this_amount'];
    $this_ability->ability_results['total_overkill'] += $this_ability->ability_results['this_overkill'];
    if ($this_ability->ability_results['this_result'] == 'success'){ $this_ability->ability_results['total_strikes']++; }
    else { $this_ability->ability_results['total_misses']++; }
    $this_ability->ability_results['total_actions'] = $this_ability->ability_results['total_strikes'] + $this_ability->ability_results['total_misses'];
    if ($this_ability->ability_results['total_result'] != 'success'){ $this_ability->ability_results['total_result'] = $this_ability->ability_results['this_result']; }
    $event_options['this_ability_results'] = $this_ability->ability_results;

    // Update internal variables
    $target_robot->update_session();
    $this->update_session();

    // Generate an event with the collected recovery results based on recovery type
    if ($this->robot_id == $target_robot->robot_id){ //$this_ability->recovery_options['recovery_kind'] == 'energy' ||
      $event_options['console_show_target'] = false;
      $this->battle->events_create($target_robot, $this, $this_ability->recovery_options['recovery_header'], $this_ability->ability_results['this_text'], $event_options);
    } else {
      $event_options['console_show_target'] = false;
      $this->battle->events_create($this, $target_robot, $this_ability->recovery_options['recovery_header'], $this_ability->ability_results['this_text'], $event_options);
    }

    // restore this and the target robot's frames to their backed up state
    $this->robot_frame = $this_robot_backup_frame;
    $this->player->player_frame = $this_player_backup_frame;
    $target_robot->robot_frame = $target_robot_backup_frame;
    $target_robot->player->player_frame = $target_player_backup_frame;

    // Update internal variables
    $target_robot->update_session();
    $target_robot->player->update_session();
    $this->update_session();
    $this->player->update_session();

    // Return the final recovery results
    return $this_ability->ability_results;

  }



  // Define a function for generating robot canvas variables
  public function canvas_markup($options, $player_data){

    // Define the variable to hold the console robot data
    $this_data = array();
    $this_target_options = !empty($options['this_ability']->target_options) ? $options['this_ability']->target_options : array();
    $this_damage_options = !empty($options['this_ability']->damage_options) ? $options['this_ability']->damage_options : array();
    $this_recovery_options = !empty($options['this_ability']->recovery_options) ? $options['this_ability']->recovery_options : array();
    $this_results = !empty($options['this_ability']->ability_results) ? $options['this_ability']->ability_results : array();

    // Define and calculate the simpler markup and positioning variables for this robot
    $this_data['robot_id'] = $this->robot_id;
    $this_data['robot_key'] = $this->robot_key !== false ? $this->robot_key : 0;
    $this_data['robot_stance'] = !empty($this->robot_stance) ? $this->robot_stance : 'base';
    $this_data['robot_frame'] = !empty($this->robot_frame) ? $this->robot_frame : 'base';
    $this_data['robot_title'] = $this->robot_name;
    $this_data['robot_token'] = $this->robot_token;
    $this_data['robot_float'] = $this->player->player_side;
    $this_data['robot_direction'] = $this->player->player_side == 'left' ? 'right' : 'left';
    $this_data['robot_status'] = $this->robot_status;
    $this_data['robot_position'] = $this->robot_position;
    $this_data['robot_action'] = 'scan_'.$this->robot_id.'_'.$this->robot_token;

    /* DEBUG
    $this_data['robot_title'] = $this->robot_name
      .' | ID '.str_pad($this->robot_id, 3, '0', STR_PAD_LEFT).''
      //.' | '.strtoupper($this->robot_position)
      .' | '.$this->robot_energy.' LE'
      .' | '.$this->robot_attack.' AT'
      .' | '.$this->robot_defense.' DF'
      .' | '.$this->robot_speed.' SP';
      */


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
    $this_data['canvas_offset_z'] = 5000;
    $this_data['canvas_offset_x'] = 185;  //!$this->flags['wap'] ? 82 : 35;
    $this_data['canvas_offset_y'] = 65;
    $total_attempts = 0;
    if (!empty($this_results['total_strikes'])){ $total_attempts += $this_results['total_strikes']; }
    if (!empty($this_results['total_misses'])){ $total_attempts += $this_results['total_misses']; }
    if ($this_data['robot_frame'] == 'damage' || $this_data['robot_stance'] == 'defend'){
      if (!empty($this_results['total_strikes']) || $this_results['this_result'] == 'success'){ //checkpoint
        if ($this_results['trigger_kind'] == 'damage' && !empty($this_damage_options['damage_kickback']['x'])){
          $this_data['canvas_offset_x'] -= $this_damage_options['damage_kickback']['x']; //isset($this_results['total_strikes']) ? $this_damage_options['damage_kickback']['x'] + ($this_damage_options['damage_kickback']['x'] * $this_results['total_strikes']) : $this_damage_options['damage_kickback']['x'];
        }
        elseif ($this_results['trigger_kind'] == 'recovery' && !empty($this_recovery_options['recovery_kickback']['x'])){
          $this_data['canvas_offset_x'] -= $this_recovery_options['recovery_kickback']['x']; //isset($this_results['total_strikes']) ? $this_recovery_options['recovery_kickback']['x'] + ($this_recovery_options['recovery_kickback']['x'] * $this_results['total_strikes']) : $this_recovery_options['recovery_kickback']['x'];
        }
      }
      if ($this_results['this_result'] == 'success'){
        if ($this_results['trigger_kind'] == 'damage' && !empty($this_damage_options['damage_kickback']['y'])){
          $this_data['canvas_offset_y'] += $this_damage_options['damage_kickback']['y']; //isset($this_results['total_strikes']) ? ($this_damage_options['damage_kickback']['y'] * $this_results['total_strikes']) : $this_damage_options['damage_kickback']['y'];
        }
        elseif ($this_results['trigger_kind'] == 'recovery' && !empty($this_recovery_options['recovery_kickback']['y'])){
          $this_data['canvas_offset_y'] += $this_recovery_options['recovery_kickback']['y']; //isset($this_results['total_strikes']) ? ($this_recovery_options['recovery_kickback']['y'] * $this_results['total_strikes']) : $this_recovery_options['recovery_kickback']['y'];
        }
      }
    }
    elseif ($this_data['robot_status'] == 'disabled'){
      $this_data['canvas_offset_x'] -= 10;
    }
    if ($this_data['robot_position'] == 'bench'){
      $this_data['canvas_offset_z'] -= 100 * $this_data['robot_key'];
      $position_modifier = ($this_data['robot_key'] + 1) / 8;
      $position_modifier_2 = 1 - $position_modifier;
      $this_data['canvas_offset_x'] = 10 + ceil(($this_data['robot_key'] * 25) * $position_modifier); //10 + ceil(($this_data['robot_key'] * 18) * $position_modifier);
      $this_data['canvas_offset_y'] = 45 + ceil((130 - ($this_data['robot_key'] * 9)) * $position_modifier);
    }

    // Calculate the energy bar amount and display properties
    $this_data['energy_fraction'] = $this->robot_energy.' / '.$this->robot_base_energy;
    $this_data['energy_percent'] = ceil(($this->robot_energy / $this->robot_base_energy) * 100);
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
      $this_data['robot_image'] = 'images/robots/'.$this_data['robot_token'].'/sprite_'.$this_data['robot_direction'].'_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'.png?'.$this->battle->config['CACHE_DATE'];
      $this_data['robot_class'] = 'sprite ';
      $this_data['robot_class'] .= 'sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].' sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'_'.$this_data['robot_frame'].' ';
      $this_data['robot_class'] .= 'robot_status_'.$this_data['robot_status'].' robot_position_'.$this_data['robot_position'].' ';
      $this_data['robot_style'] = 'z-index: '.$this_data['canvas_offset_z'].'; '.$this_data['robot_float'].': '.$this_data['canvas_offset_x'].'px; bottom: '.$this_data['canvas_offset_y'].'px; ';
      $this_data['robot_style'] .= 'background-image: url('.$this_data['robot_image'].'); ';
      $this_data['energy_title'] = $this_data['energy_fraction'].' LE';
      $this_data['energy_class'] = 'energy';
      $this_data['energy_style'] = 'background-position: '.$this_data['energy_x_position'].'px '.$this_data['energy_y_position'].'px;';

      // Display the robot's battle sprite
      echo '<a class="'.$this_data['robot_class'].'" style="'.$this_data['robot_style'].'" title="'.$this_data['robot_title'].'" data-type="robot" data-size="'.$this_data['robot_size'].'" data-direction="'.$this_data['robot_direction'].'" data-frame="'.$this_data['robot_frame'].'" data-position="'.$this_data['robot_position'].'" data-action="'.$this_data['robot_action'].'" data-status="'.$this_data['robot_status'].'">'.$this_data['robot_title'].'</a>';

      // Check if this is an active position robot
      if ($this_data['robot_position'] == 'active'){

        // Define the mugshot and detail variables for the GUI
        $details_data = $this_data;
        $details_data['robot_size'] = 40;
        $details_data['robot_image'] = 'images/robots/'.$details_data['robot_token'].'/sprite_'.$details_data['robot_direction'].'_'.$details_data['robot_size'].'x'.$details_data['robot_size'].'.png?'.$this->battle->config['CACHE_DATE'];
        $details_data['robot_details'] = '<div class="robot_name">'.$this->robot_name.'</div>';
        $details_data['robot_details'] .= '<div class="'.$details_data['energy_class'].'" style="'.$details_data['energy_style'].'" title="'.$details_data['energy_title'].'">'.$details_data['energy_title'].'</div>';
        $robot_attack_markup = '<div class="robot_attack'.($this->robot_attack < 1 ? ' robot_attack_break' : ($this->robot_attack < ($this->robot_base_attack / 2) ? ' robot_attack_break_chance' : '')).'">'.str_pad($this->robot_attack, 3, '0', STR_PAD_LEFT).'</div>';
        $robot_defense_markup = '<div class="robot_defense'.($this->robot_defense < 1 ? ' robot_defense_break' : ($this->robot_defense < ($this->robot_base_defense / 2) ? ' robot_defense_break_chance' : '')).'">'.str_pad($this->robot_defense, 3, '0', STR_PAD_LEFT).'</div>';
        $robot_speed_markup = '<div class="robot_speed'.($this->robot_speed < 1 ? ' robot_speed_break' : ($this->robot_speed < ($this->robot_base_speed / 2) ? ' robot_speed_break_chance' : '')).'">'.str_pad($this->robot_speed, 3, '0', STR_PAD_LEFT).'</div>';
        if ($details_data['robot_float'] == 'left'){
          $details_data['robot_details'] .= $robot_attack_markup;
          $details_data['robot_details'] .= $robot_defense_markup;
          $details_data['robot_details'] .= $robot_speed_markup;
        } else {
          $details_data['robot_details'] .= $robot_speed_markup;
          $details_data['robot_details'] .= $robot_defense_markup;
          $details_data['robot_details'] .= $robot_attack_markup;
        }
        $details_data['mugshot_image'] = 'images/robots/'.$details_data['robot_token'].'/mug_'.$details_data['robot_direction'].'_'.$details_data['robot_size'].'x'.$details_data['robot_size'].'.png?'.$this->battle->config['CACHE_DATE'];
        $details_data['mugshot_class'] = 'sprite ';
        $details_data['mugshot_class'] .= 'sprite_'.$details_data['robot_size'].'x'.$details_data['robot_size'].' sprite_'.$details_data['robot_size'].'x'.$details_data['robot_size'].'_mugshot sprite_mugshot_'.$details_data['robot_float'].' ';
        $details_data['mugshot_class'] .= 'robot_status_'.$details_data['robot_status'].' robot_position_'.$details_data['robot_position'].' ';
        $details_data['mugshot_style'] = 'z-index: 9100; ';
        $details_data['mugshot_style'] .= 'background-image: url('.$details_data['mugshot_image'].'); ';

        // Display the robot's mugshot sprite and detail fields
        echo '<div class="sprite robot_details robot_details_'.$details_data['robot_float'].'"><div class="container">'.$details_data['robot_details'].'</div></div>';
        echo '<div class="'.$details_data['mugshot_class'].'" style="'.$details_data['mugshot_style'].'" title="'.$details_data['robot_title'].'">'.$details_data['robot_title'].'</div>';

        // Update the main data array with this markup
        $this_data['details'] = $details_data;
      }

    // Collect the generated robot markup
    $this_data['robot_markup'] = trim(ob_get_clean());

    // Return the robot canvas data
    return $this_data;

  }

  // Define a function for generating robot console variables
  public function console_markup($options, $player_data){

    // Define the variable to hold the console robot data
    $this_data = array();

    // Define and calculate the simpler markup and positioning variables for this robot
    $this_data['robot_frame'] = !empty($this->robot_frame) ? $this->robot_frame : 'base';
    $this_data['robot_title'] = $this->robot_name;
    $this_data['robot_token'] = $this->robot_token;
    $this_data['robot_float'] = $this->player->player_side;
    $this_data['robot_direction'] = $this->player->player_side == 'left' ? 'right' : 'left';
    $this_data['robot_status'] = $this->robot_status;
    $this_data['robot_position'] = $this->robot_position;
    $this_data['image_type'] = !empty($options['this_robot_image']) ? $options['this_robot_image'] : 'sprite';

    // Calculate the energy bar amount and display properties
    $this_data['energy_fraction'] = $this->robot_energy.' / '.$this->robot_base_energy;
    $this_data['energy_percent'] = ceil(($this->robot_energy / $this->robot_base_energy) * 100);
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
    $this_data['robot_class'] = 'sprite sprite_robot sprite_robot_'.$this_data['image_type'].' ';
    $this_data['robot_style'] = '';
    $this_data['robot_size'] = 40;
    $this_data['robot_image'] = 'images/robots/'.$this_data['robot_token'].'/'.$this_data['image_type'].'_'.$this_data['robot_direction'].'_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'.png?'.$this->battle->config['CACHE_DATE'];
    $this_data['robot_class'] .= 'sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].' sprite_'.$this_data['robot_size'].'x'.$this_data['robot_size'].'_'.$this_data['robot_frame'].' ';
    $this_data['robot_class'] .= 'robot_status_'.$this_data['robot_status'].' robot_position_'.$this_data['robot_position'].' ';
    $this_data['robot_style'] .= 'background-image: url('.$this_data['robot_image'].'); ';
    $this_data['energy_title'] = $this_data['energy_fraction'].' Energy';
    $this_data['energy_class'] = 'energy';
    $this_data['energy_style'] = 'background-position: '.$this_data['energy_x_position'].'px '.$this_data['energy_y_position'].'px;';

    // Generate the final markup for the console robot
    $this_data['robot_markup'] = '';
    $this_data['robot_markup'] .= '<div class="'.$this_data['container_class'].'" style="'.$this_data['container_style'].'">';
    $this_data['robot_markup'] .= '<div class="'.$this_data['robot_class'].'" style="'.$this_data['robot_style'].'" title="'.$this_data['robot_title'].'">'.$this_data['robot_title'].'</div>';
    if ($this_data['image_type'] != 'mug'){ $this_data['robot_markup'] .= '<div class="'.$this_data['energy_class'].'" style="'.$this_data['energy_style'].'" title="'.$this_data['energy_title'].'">'.$this_data['energy_title'].'</div>'; }
    $this_data['robot_markup'] .= '</div>';

    // Return the robot console data
    return $this_data;

  }

  // Define a public function for recalculating internal counters
  public function update_variables(){

    // Update parent objects first
    //$this->player->update_variables();

    // Calculate this robot's count variables
    $this->counters['abilities_total'] = count($this->robot_abilities);

    // Now collect an export array for this object
    $this_data = $this->export_array();

    // Update the parent battle variable
    $this->battle->values['robots'][$this->robot_id] = $this_data;

    // Find and update the parent's robot variable
    foreach ($this->player->player_robots AS $this_key => $this_robotinfo){
      if ($this_robotinfo['robot_id'] == $this->robot_id){
        $this->player->player_robots[$this_key] = $this_data;
        break;
      }
    }

    // Return true on success
    return true;

  }

  // Define a public, static function for resetting robot values to base
  public static function reset_variables($this_data){
    $this_data['robot_flags'] = array();
    $this_data['robot_counters'] = array();
    $this_data['robot_values'] = array();
    $this_data['robot_history'] = array();
    $this_data['robot_name'] = $this_data['robot_base_name'];
    $this_data['robot_token'] = $this_data['robot_base_token'];
    $this_data['robot_description'] = $this_data['robot_base_description'];
    $this_data['robot_energy'] = $this_data['robot_base_energy'];
    $this_data['robot_attack'] = $this_data['robot_base_attack'];
    $this_data['robot_defense'] = $this_data['robot_base_defense'];
    $this_data['robot_speed'] = $this_data['robot_base_speed'];
    $this_data['robot_weaknesses'] = $this_data['robot_base_weaknesses'];
    $this_data['robot_resistances'] = $this_data['robot_base_resistances'];
    $this_data['robot_affinities'] = $this_data['robot_base_affinities'];
    $this_data['robot_immunities'] = $this_data['robot_base_immunities'];
    $this_data['robot_abilities'] = $this_data['robot_base_abilities'];
    $this_data['robot_attachments'] = $this_data['robot_base_attachments'];
    $this_data['robot_quotes'] = $this_data['robot_base_quotes'];
    return $this_data;

  }

  // Define a public function for updating this player's session
  public function update_session(){

    // Update any internal counters
    $this->update_variables();

    // Request parent player object to update as well
    //$this->player->update_session();

    // Update the session with the export array
    $this_data = $this->export_array();
    $_SESSION['RPG2k12-2']['ROBOTS'][$this->battle->battle_id][$this->player->player_id][$this->robot_id] = $this_data;
    $this->battle->values['robots'][$this->robot_id] = $this_data;
    $this->player->values['robots'][$this->robot_id] = $this_data;

    // Return true on success
    return true;

  }


  // Define a function for exporting the current data
  public function export_array(){

    // Return all internal robot fields in array format
    return array(
      'flags' => $this->flags,
      'counters' => $this->counters,
      'values' => $this->values,
      'history' => $this->history,
      'battle_id' => $this->battle_id,
      'battle_token' => $this->battle_token,
      'player_id' => $this->player_id,
      'player_token' => $this->player_token,
      'robot_key' => $this->robot_key,
      'robot_id' => $this->robot_id,
      'robot_number' => $this->robot_number,
      'robot_name' => $this->robot_name,
      'robot_token' => $this->robot_token,
      'robot_description' => $this->robot_description,
      'robot_energy' => $this->robot_energy,
      'robot_attack' => $this->robot_attack,
      'robot_defense' => $this->robot_defense,
      'robot_speed' => $this->robot_speed,
      'robot_weaknesses' => $this->robot_weaknesses,
      'robot_resistances' => $this->robot_resistances,
      'robot_affinities' => $this->robot_affinities,
      'robot_immunities' => $this->robot_immunities,
      'robot_abilities' => $this->robot_abilities,
      'robot_attachments' => $this->robot_attachments,
      'robot_quotes' => $this->robot_quotes,
      'robot_rewards' => $this->robot_rewards,
      'robot_points' => $this->robot_points,
      'robot_base_name' => $this->robot_base_name,
      'robot_base_token' => $this->robot_base_token,
      'robot_base_description' => $this->robot_base_description,
      'robot_base_energy' => $this->robot_base_energy,
      'robot_base_attack' => $this->robot_base_attack,
      'robot_base_defense' => $this->robot_base_defense,
      'robot_base_speed' => $this->robot_base_speed,
      'robot_base_weaknesses' => $this->robot_base_weaknesses,
      'robot_base_resistances' => $this->robot_base_resistances,
      'robot_base_affinities' => $this->robot_base_affinities,
      'robot_base_immunities' => $this->robot_base_immunities,
      'robot_base_abilities' => $this->robot_base_abilities,
      'robot_base_attachments' => $this->robot_base_attachments,
      'robot_base_quotes' => $this->robot_base_quotes,
      'robot_base_rewards' => $this->robot_base_rewards,
      'robot_base_points' => $this->robot_base_points,
      'robot_status' => $this->robot_status,
      'robot_position' => $this->robot_position,
      'robot_stance' => $this->robot_stance,
      'robot_frame' => $this->robot_frame,
      'robot_frame_index' => $this->robot_frame_index,
      'robot_frame_offset' => $this->robot_frame_offset
      );

  }

}
?>