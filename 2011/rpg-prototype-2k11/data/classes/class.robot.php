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

    // Define the internal index pointer
    $this->index = &$GLOBALS['mmrpg_index'];

    // Collect any provided arguments
    $args = func_get_args();

    // Define the internal battle pointer
    $this->battle = isset($args[0]) ? $args[0] : array();
    $this->battle_id = $this->battle->battle_id;
    $this->battle_token = $this->battle->battle_token;

    // Define the internal player values using the provided array
    $this->player = isset($args[1]) ? $args[1] : array();
    $this->player_id = $this->player->player_id;
    $this->player_token = $this->player->player_token;

    // Collect current robot data from the function if available
    $this_robotinfo = isset($args[2]) ? $args[2] : array('robot_id' => 0, 'robot_token' => 'robot');

    // Now load the robot data from the session or index
    $this->robot_load($this_robotinfo);

    // Create a player entry in parent variables
    if (!isset($this->battle->values['robots'][$this->robot_id])){
      $this->battle->values['robots'][$this->robot_id] = $this->export_array();
    }

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function robot_load($this_robotinfo){

    // If the robot ID was not provided, return false
    if (!isset($this_robotinfo['robot_id'])){ return false; }
    // If the robot token was not provided, return false
    if (!isset($this_robotinfo['robot_token'])){ return false; }

    // Collect current robot data from the session if available
    $this_robotinfo_backup = $this_robotinfo;
    if (isset($_SESSION['RPG2k11']['ROBOTS'][$this->battle->battle_id][$this->player->player_id][$this_robotinfo['robot_id']])){
      $this_robotinfo = $_SESSION['RPG2k11']['ROBOTS'][$this->battle->battle_id][$this->player->player_id][$this_robotinfo['robot_id']];
    }
    // Otherwise, collect robot data from the index
    else {
      $this_robotinfo = $this->index['robots'][$this_robotinfo['robot_token']];
    }
    $this_robotinfo = array_merge($this_robotinfo, $this_robotinfo_backup);

    // Define the internal robot values using the provided array
    $this->flags = isset($this_robotinfo['flags']) ? $this_robotinfo['flags'] : array();
    $this->counters = isset($this_robotinfo['counters']) ? $this_robotinfo['counters'] : array();
    $this->values = isset($this_robotinfo['values']) ? $this_robotinfo['values'] : array();
    $this->history = isset($this_robotinfo['history']) ? $this_robotinfo['history'] : array();
    $this->robot_id = isset($this_robotinfo['robot_id']) ? $this_robotinfo['robot_id'] : false;
    $this->robot_number = isset($this_robotinfo['robot_number']) ? $this_robotinfo['robot_number'] : 'RPG000';
    $this->robot_name = isset($this_robotinfo['robot_name']) ? $this_robotinfo['robot_name'] : 'Robot';
    $this->robot_token = isset($this_robotinfo['robot_token']) ? $this_robotinfo['robot_token'] : 'robot';
    $this->robot_type = isset($this_robotinfo['robot_type']) ? $this_robotinfo['robot_type'] : '';
    $this->robot_description = isset($this_robotinfo['robot_description']) ? $this_robotinfo['robot_description'] : '';
    $this->robot_energy = isset($this_robotinfo['robot_energy']) ? $this_robotinfo['robot_energy'] : 1;
    $this->robot_attack = isset($this_robotinfo['robot_attack']) ? $this_robotinfo['robot_attack'] : 1;
    $this->robot_defense = isset($this_robotinfo['robot_defense']) ? $this_robotinfo['robot_defense'] : 1;
    $this->robot_speed = isset($this_robotinfo['robot_speed']) ? $this_robotinfo['robot_speed'] : 1;
    $this->robot_weaknesses = isset($this_robotinfo['robot_weaknesses']) ? $this_robotinfo['robot_weaknesses'] : '';
    $this->robot_resistances = isset($this_robotinfo['robot_resistances']) ? $this_robotinfo['robot_resistances'] : '';
    $this->robot_abilities = isset($this_robotinfo['robot_abilities']) ? $this_robotinfo['robot_abilities'] : array();
    $this->robot_quotes = isset($this_robotinfo['robot_quotes']) ? $this_robotinfo['robot_quotes'] : array();
    $this->robot_status = isset($this_robotinfo['robot_status']) ? $this_robotinfo['robot_status'] : 'active';
    $this->robot_position = isset($this_robotinfo['robot_position']) ? $this_robotinfo['robot_position'] : 'bench';
//    if (empty($this->robot_id)){
//      $this->robot_id = array_search($this->robot_token, $this->player->player_robots);
//      //$this->battle->events_create(false, false, 'DEBUG', print_r($this->player->player_robots, true));
//      //$this->robot_id = strtoupper(substr(md5($this->player->player_id.$this->robot_name), 0, 10));
//    }

    // Define the internal robot base values using the robots index array
    $this->robot_base_name = isset($this_robotinfo['robot_base_name']) ? $this_robotinfo['robot_base_name'] : $this->robot_name;
    $this->robot_base_token = isset($this_robotinfo['robot_base_token']) ? $this_robotinfo['robot_base_token'] : $this->robot_token;
    $this->robot_base_type = isset($this_robotinfo['robot_base_type']) ? $this_robotinfo['robot_base_type'] : $this->robot_type;
    $this->robot_base_description = isset($this_robotinfo['robot_base_description']) ? $this_robotinfo['robot_base_description'] : $this->robot_description;
    $this->robot_base_energy = isset($this_robotinfo['robot_base_energy']) ? $this_robotinfo['robot_base_energy'] : $this->robot_energy;
    $this->robot_base_attack = isset($this_robotinfo['robot_base_attack']) ? $this_robotinfo['robot_base_attack'] : $this->robot_attack;
    $this->robot_base_defense = isset($this_robotinfo['robot_base_defense']) ? $this_robotinfo['robot_base_defense'] : $this->robot_defense;
    $this->robot_base_speed = isset($this_robotinfo['robot_base_speed']) ? $this_robotinfo['robot_base_speed'] : $this->robot_speed;
    $this->robot_base_weakness = isset($this_robotinfo['robot_base_weakness']) ? $this_robotinfo['robot_base_weakness'] : $this->robot_weaknesses;
    $this->robot_base_resistance = isset($this_robotinfo['robot_base_resistance']) ? $this_robotinfo['robot_base_resistance'] : $this->robot_resistances;
    $this->robot_base_abilities = isset($this_robotinfo['robot_base_abilities']) ? $this_robotinfo['robot_base_abilities'] : $this->robot_abilities;
    $this->robot_base_quotes = isset($this_robotinfo['robot_base_quotes']) ? $this_robotinfo['robot_base_quotes'] : array();

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
  public function print_robot_name(){ return '<span class="robot_name">'.$this->robot_name.'</span>'; }
  public function print_robot_token(){ return '<span class="robot_token">'.$this->robot_token.'</span>'; }
  public function print_robot_type(){ return '<span class="robot_type">'.$this->robot_type.'</span>'; }
  public function print_robot_description(){ return '<span class="robot_description">'.$this->robot_description.'</span>'; }
  public function print_robot_energy(){ return '<span class="robot_energy">'.$this->robot_energy.'</span>'; }
  public function print_robot_attack(){ return '<span class="robot_energy">x'.number_format($this->robot_attack, 2, '.', '').'</span>'; }
  public function print_robot_defense(){ return '<span class="robot_energy">x'.number_format($this->robot_defense, 2, '.', '').'</span>'; }
  public function print_robot_speed(){ return '<span class="robot_speed">'.$this->robot_speed.'</span>'; }
  public function print_robot_weaknesses(){ return '<span class="robot_weaknesses">'.$this->robot_weaknesses.'</span>'; }
  public function print_robot_resistances(){ return '<span class="robot_resistances">'.$this->robot_resistances.'</span>'; }

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
    if (empty($this->robot_affinity) || empty($affinity_token)){ return false; }
    elseif (in_array($affinity_token, $this->robot_affinity)){ return true; }
    else { return false; }
  }

  // Define a function for checking if this robot has a specific immunity
  public function has_immunity($immunity_token){
    if (empty($this->robot_immunity) || empty($immunity_token)){ return false; }
    elseif (in_array($immunity_token, $this->robot_immunity)){ return true; }
    else { return false; }
  }

  // Define a trigger for using one of this robot's abilities
  public function trigger_ability($target_robot, $this_ability){

    // Update this robot's history with the triggered ability
    $this->history['triggered_abilities'][] = $this_ability->ability_token;

    // Define a variable to hold the ability results
    $this_ability->ability_results = array();
    $this_ability->ability_results['total_result'] = '';
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
    $this_ability->ability_results['flag_immune'] = false;

    // Define the damage options and populate with default text
    $this_ability->target_options = array();
    $this_ability->target_options['target_kind'] = 'energy';
    $this_ability->target_options['target_header'] = $this->robot_name.'&#39;s '.$this_ability->ability_name;
    $this_ability->target_options['target_text'] = "{$this->print_robot_name()} uses {$this_ability->print_ability_name()}!";

    // Define the damage options and populate with default text
    $this_ability->damage_options = array();
    $this_ability->damage_options['damage_header'] = $this->robot_name.'&#39;s '.$this_ability->ability_name;
    $this_ability->damage_options['damage_kind'] = 'energy';
    $this_ability->damage_options['damage_type'] = $this_ability->ability_type;
    $this_ability->damage_options['damage_amount'] = $this_ability->ability_damage;
    $this_ability->damage_options['success_rate'] = false;
    $this_ability->damage_options['failure_rate'] = false;
    $this_ability->damage_options['critical_rate'] = 10;
    $this_ability->damage_options['critical_multiplier'] = 2;
    $this_ability->damage_options['weakness_multiplier'] = 2;
    $this_ability->damage_options['resistance_multiplier'] = 0.5;
    $this_ability->damage_options['immune_multiplier'] = 0;
    $this_ability->damage_options['success_text'] = 'The ability hit!';
    $this_ability->damage_options['failure_text'] = 'The ability missed&hellip;';
    $this_ability->damage_options['immunity_text'] = 'The ability had no effect&hellip;';
    $this_ability->damage_options['critical_text'] = 'It&#39;s a critical hit!';
    $this_ability->damage_options['weakness_text'] = 'It&#39;s super effective!';
    $this_ability->damage_options['resistance_text'] = 'It&#39;s not very effective&hellip;';
    $this_ability->damage_options['weakness_resistance_text'] = ''; //"It's a super effective resisted hit!';
    $this_ability->damage_options['weakness_critical_text'] = 'It&#39;s a super effective critical hit!';
    $this_ability->damage_options['resistance_critical_text'] = ''; //"It's a resisted critical hit&hellip;';

    // Define the damage options and populate with default text
    $this_ability->recovery_options = array();
    $this_ability->recovery_options['recovery_header'] = $this->robot_name.'&#39;s '.$this_ability->ability_name;
    $this_ability->recovery_options['recovery_kind'] = 'energy';
    $this_ability->recovery_options['recovery_type'] = $this_ability->ability_type;
    $this_ability->recovery_options['recovery_amount'] = $this_ability->ability_recovery;
    $this_ability->recovery_options['success_rate'] = false;
    $this_ability->recovery_options['failure_rate'] = false;
    $this_ability->recovery_options['critical_rate'] = 10;
    $this_ability->recovery_options['critical_multiplier'] = 2;
    $this_ability->recovery_options['affinity_multiplier'] = 2;
    $this_ability->recovery_options['resistance_multiplier'] = 0.5;
    $this_ability->recovery_options['immune_multiplier'] = 0;
    $this_ability->recovery_options['recovery_type'] = $this_ability->ability_type;
    $this_ability->recovery_options['success_text'] = 'The ability worked!';
    $this_ability->recovery_options['failure_text'] = 'The ability failed&hellip;';
    $this_ability->recovery_options['immunity_text'] = 'The ability had no effect&hellip;';
    $this_ability->recovery_options['critical_text'] = 'It&#39;s a critical heal!';
    $this_ability->recovery_options['affinity_text'] = 'It&#39;s super effective!';
    $this_ability->recovery_options['resistance_text'] = 'It&#39;s not very effective&hellip;';
    $this_ability->recovery_options['affinity_resistance_text'] = ''; //'It&#39;s a super effective resisted hit!';
    $this_ability->recovery_options['affinity_critical_text'] = 'It&#39;s a super effective critical heal!';
    $this_ability->recovery_options['resistance_critical_text'] = ''; //'It&#39;s a resisted critical hit&hellip;';

    // Default this and the target robot's frames to their base
    $this->robot_frame = 'base';
    $target_robot->robot_frame = 'base';

    // Copy the ability function to local scope and execute it
    $this_ability_function = $this_ability->ability_function;
    $this_ability_function(array(
      'this_index' => $this->index,
      'this_battle' => $this->battle,
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

    // Update internal variables
    $target_robot->update_variables();
    $this_ability->update_variables();

    // Return the ability results
    return $this_ability->ability_results;
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
    $target_robot->update_variables();
    $this_ability->update_variables();

    // Return the ability results
    return $this_results;

  }

//  // Define separate trigger functions for each type of damage on this robot
//  public function trigger_energy_damage($target_robot, $this_ability, &$ability_results, $damage_amount, &$damage_options){
//    $this->trigger_damage('energy', $target_robot, $this_ability, &$ability_results, $damage_amount, &$damage_options);
//  }

  // Define a trigger for using one of this robot's abilities
  public function trigger_target($target_robot, $this_ability){

    // Update this robot's history with the triggered ability
    $this->history['triggered_targets'][] = $target_robot->robot_token;

    // Default this and the target robot's frames to their base
    $this->robot_frame = 'attack'; //$this_ability->target_options['target_kind'];

    // Create a message to show the initial targeting action
    if ($this->robot_id != $target_robot->robot_id){
      $event_body = "{$this->print_robot_name()} targets {$target_robot->print_robot_name()}!<br />";
    } else {
      $event_body = ''; //"{$this->print_robot_name()} targets itself&hellip;<br />";
    }

    $event_body .= $this_ability->target_options['target_text'];
    $this->battle->events_create($this, $target_robot, $this_ability->target_options['target_header'], $event_body, array('this_ability' => $this_ability));

    // Update this ability's history with the triggered ability data and results
    $this_ability->history['ability_results'][] = $this_ability->ability_results;

    // Update internal variables
    $target_robot->update_variables();
    $this_ability->update_variables();

    // Return the ability results
    return $this_ability->ability_results;

  }

  // Define a trigger for inflicting all types of damage on this robot
  public function trigger_damage($target_robot, $this_ability, $damage_amount){

    // Backup this and the target robot's frames to revert later
    $this_robot_backup_frame = $this->robot_frame;
    $target_robot_backup_frame = $target_robot->robot_frame;

    // Empty any text from the previous ability result
    $this_ability->ability_results['this_text'] = '';

    // If the success rate was not provided, auto-calculate
    if ($this_ability->damage_options['success_rate'] === false){
      // Set the success rate to the ability's accuracy stat
      $this_ability->damage_options['success_rate'] = $this_ability->ability_accuracy;
      if ($this_ability->damage_options['success_rate'] > 100){
        $this_ability->damage_options['success_rate'] = 100;
      }
    }

    // If the failure rate was not provided, auto-calculate
    if ($this_ability->damage_options['failure_rate'] === false){
      // Set the failure rate to the difference of success vs failure (100% base)
      $this_ability->damage_options['failure_rate'] = 100 - $this_ability->damage_options['success_rate'];
      if ($this_ability->damage_options['failure_rate'] < 0){
        $this_ability->damage_options['failure_rate'] = 0;
      }
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

    // If the attack was a success, proceed normally
    if ($this_ability->ability_results['this_result'] == 'success'){

      // Update this robot's frame based on damage type
      if ($this_ability->damage_options['damage_kind'] == 'energy'){ $this->robot_frame = 'damage'; }
      else { $this->robot_frame = 'defend'; }

      // Display the success text, if text has been provided
      if (!empty($this_ability->damage_options['success_text'])){
        $this_ability->ability_results['this_text'] .= $this_ability->damage_options['success_text'];
      }

      // Collect the damage amount argument from the function
      $this_ability->ability_results['this_amount'] = is_numeric($damage_amount) ? $damage_amount : 0;

      // If this is ENERGY type damage we're dealing with, apply stat mods
      if ($this_ability->damage_options['damage_kind'] == 'energy'){

        // If this robot's defense stat is modified
        if ($this->robot_defense > 100 || $this->robot_defense < 100){
          $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] / ($this->robot_defense / 100));
        }

        // If the target robot's attack stat is modified
        if ($target_robot->robot_attack > 100 || $target_robot->robot_attack < 100){
          $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * ($target_robot->robot_attack / 100));
        }

        // If this is a critical hit (random chance)
        if ($this->battle->critical_chance($this_ability->damage_options['critical_rate'])){
          $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] * $this_ability->damage_options['critical_multiplier'];
          $this_ability->ability_results['flag_critical'] = true;
        }

      }

      // If this robot is weak to the ability (based on type)
      if ($this->has_weakness($this_ability->damage_options['damage_type'])){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->damage_options['weakness_multiplier']);
        $this_ability->ability_results['flag_weakness'] = true;
      }

      // If target robot resists the ability (based on type)
      if ($this->has_resistance($this_ability->damage_options['damage_type'])){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->damage_options['resistance_multiplier']);
        $this_ability->ability_results['flag_resistance'] = true;
      }

      // Generate the status text based on flags
      if (!$this_ability->ability_results['flag_critical'] && $this_ability->ability_results['flag_weakness'] && !$this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['weakness_text'];
      }
      elseif (!$this_ability->ability_results['flag_critical'] && !$this_ability->ability_results['flag_weakness'] && $this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['resistance_text'];
      }
      elseif (!$this_ability->ability_results['flag_critical'] && !$this_ability->ability_results['flag_weakness'] && !$this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= '';
      }
      elseif (!$this_ability->ability_results['flag_critical'] && $this_ability->ability_results['flag_weakness'] && $this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['weakness_resistance_text'];
      }
      elseif ($this_ability->ability_results['flag_critical'] && $this_ability->ability_results['flag_weakness'] && !$this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['weakness_critical_text'];
      }
      elseif ($this_ability->ability_results['flag_critical'] && !$this_ability->ability_results['flag_weakness'] && $this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['resistance_critical_text'];
      }
      elseif ($this_ability->ability_results['flag_critical'] && !$this_ability->ability_results['flag_weakness'] && !$this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['critical_text'];
      }

      // Display a break before the damage amount if other text was generated
      if (!empty($this_ability->ability_results['this_text'])){
        $this_ability->ability_results['this_text'] .= '<br />';
      }

      // Ensure the damage amount is always at least 1
      if ($this_ability->ability_results['this_amount'] < 1){ $this_ability->ability_results['this_amount'] = 1; }

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
        $this_ability->ability_results['this_text'] .= ($this_ability->ability_results['this_overkill'] > 0 ? " and {$this_ability->ability_results['print_overkill']} overkill" : '');
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
          // Update this robot's frame
          $this->robot_frame = 'defend';
          // Display the failure text, if text has been provided
          if (!empty($this_ability->damage_options['failure_text'])){
            $this_ability->ability_results['this_text'] .= $this_ability->damage_options['failure_text'].' ';
          }
        }
      }

    }
    // Otherwise, if the attack was a failure
    else {

      // Update this robot's frame
      $this->robot_frame = 'defend';
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
    if ($this_ability->ability_results['total_result'] != 'success'){ $this_ability->ability_results['total_result'] = $this_ability->ability_results['this_result']; }

    // Generate an event with the collected damage results based on damage type
    if ($this_ability->damage_options['damage_kind'] == 'energy' || $this->robot_id == $target_robot->robot_id){
      $this->battle->events_create($target_robot, $this, $this_ability->damage_options['damage_header'], $this_ability->ability_results['this_text'], array('this_ability' => $this_ability));
    } else {
      $this->battle->events_create($this, $target_robot, $this_ability->damage_options['damage_header'], $this_ability->ability_results['this_text'], array('console_show_target' => false, 'ability_results' => $this_ability->ability_results));
    }

    // restore this and the target robot's frames to their backed up state
    $this->robot_frame = $this_robot_backup_frame;
    $target_robot->robot_frame = $target_robot_backup_frame;

    // Update internal variables
    $target_robot->update_session();
    $this->update_session();

    // Return the final damage results
    return $this_ability->ability_results;

  }

  // Define a trigger for inflicting all types of recovery on this robot
  public function trigger_recovery($target_robot, $this_ability, $recovery_amount){

    // Backup this and the target robot's frames to revert later
    $this_robot_backup_frame = $this->robot_frame;
    $target_robot_backup_frame = $target_robot->robot_frame;

    // Empty any text from the previous ability result
    $this_ability->ability_results['this_text'] = '';

    // If the success rate was not provided, auto-calculate
    if ($this_ability->recovery_options['success_rate'] === false){
      // Set the success rate to the ability's accuracy stat
      $this_ability->recovery_options['success_rate'] = $this_ability->ability_accuracy;
      if ($this_ability->recovery_options['success_rate'] > 100){
        $this_ability->recovery_options['success_rate'] = 100;
      }
    }

    // If the failure rate was not provided, auto-calculate
    if ($this_ability->recovery_options['failure_rate'] === false){
      // Set the failure rate to the difference of success vs failure (100% base)
      $this_ability->recovery_options['failure_rate'] = 100 - $this_ability->recovery_options['success_rate'];
      if ($this_ability->recovery_options['failure_rate'] < 0){
        $this_ability->recovery_options['failure_rate'] = 0;
      }
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

    // If the attack was a success, proceed normally
    if ($this_ability->ability_results['this_result'] == 'success'){

      // Update this robot's frame based on recovery type
      if ($this_ability->recovery_options['recovery_kind'] == 'energy'){ $this->robot_frame = 'defend'; }
      else { $this->robot_frame = 'defend'; }

      // Display the success text, if text has been provided
      if (!empty($this_ability->recovery_options['success_text'])){
        $this_ability->ability_results['this_text'] .= $this_ability->recovery_options['success_text'];
      }

      // Collect the recovery amount argument from the function
      $this_ability->ability_results['this_amount'] = $recovery_amount;

      // If this is ENERGY type recovery we're dealing with, apply stat mods
      if ($this_ability->recovery_options['recovery_kind'] == 'energy'){

//        // If this robot's defense stat is modified
//        if ($this->robot_defense > 100 || $this->robot_defense < 100){
//          $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] / ($this->robot_defense / 100));
//        }
//
//        // If the target robot's attack stat is modified
//        if ($target_robot->robot_attack > 100 || $target_robot->robot_attack < 100){
//          $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * ($target_robot->robot_attack / 100));
//        }

        // If this is a critical hit (random chance)
        if ($this->battle->critical_chance($this_ability->recovery_options['critical_rate'])){
          $this_ability->ability_results['this_amount'] = $this_ability->ability_results['this_amount'] * $this_ability->recovery_options['critical_multiplier'];
          $this_ability->ability_results['flag_critical'] = true;
        }

      }

      // If this robot is affinite to the ability (based on type)
      if ($this->has_affinity($this_ability->recovery_options['recovery_type'])){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->recovery_options['affinity_multiplier']);
        $this_ability->ability_results['flag_affinity'] = true;
      }

      // If target robot resists the ability (based on type)
      if ($this->has_resistance($this_ability->recovery_options['recovery_type'])){
        $this_ability->ability_results['this_amount'] = ceil($this_ability->ability_results['this_amount'] * $this_ability->recovery_options['resistance_multiplier']);
        $this_ability->ability_results['flag_resistance'] = true;
      }

      // Generate the status text based on flags
      if (!$this_ability->ability_results['flag_critical'] && $this_ability->ability_results['flag_affinity'] && !$this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['affinity_text'];
      }
      elseif (!$this_ability->ability_results['flag_critical'] && !$this_ability->ability_results['flag_affinity'] && $this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['resistance_text'];
      }
      elseif (!$this_ability->ability_results['flag_critical'] && !$this_ability->ability_results['flag_affinity'] && !$this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= '';
      }
      elseif (!$this_ability->ability_results['flag_critical'] && $this_ability->ability_results['flag_affinity'] && $this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['affinity_resistance_text'];
      }
      elseif ($this_ability->ability_results['flag_critical'] && $this_ability->ability_results['flag_affinity'] && !$this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['affinity_critical_text'];
      }
      elseif ($this_ability->ability_results['flag_critical'] && !$this_ability->ability_results['flag_affinity'] && $this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['resistance_critical_text'];
      }
      elseif ($this_ability->ability_results['flag_critical'] && !$this_ability->ability_results['flag_affinity'] && !$this_ability->ability_results['flag_resistance']){
        $this_ability->ability_results['this_text'] .= $recovery_options['critical_text'];
      }

      // Display a break before the recovery amount if other text was generated
      if (!empty($this_ability->ability_results['this_text'])){
        $this_ability->ability_results['this_text'] .= '<br />';
      }

      // Ensure the recovery amount is always at least 1
      if ($this_ability->ability_results['this_amount'] < 1){ $this_ability->ability_results['this_amount'] = 1; }

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
          // Update this robot's frame
          $this->robot_frame = 'defend';
          // Display the failure text, if text has been provided
          if (!empty($this_ability->recovery_options['failure_text'])){
            $this_ability->ability_results['this_text'] .= $this_ability->recovery_options['failure_text'].' ';
          }
        }
      }

    }
    // Otherwise, if the attack was a failure
    else {

      // Update this robot's frame
      $this->robot_frame = 'defend';
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
    if ($this_ability->ability_results['total_result'] != 'success'){ $this_ability->ability_results['total_result'] = $this_ability->ability_results['this_result']; }

    // Generate an event with the collected recovery results based on recovery type
    if ($this_ability->recovery_options['recovery_kind'] == 'energy' || $this->robot_id == $target_robot->robot_id){
      $this->battle->events_create($target_robot, $this, $this_ability->recovery_options['recovery_header'], $this_ability->ability_results['this_text'], array('this_ability' => $this_ability));
    } else {
      $this->battle->events_create($this, $target_robot, $this_ability->recovery_options['recovery_header'], $this_ability->ability_results['this_text'], array('console_show_target' => false, 'ability_results' => $this_ability->ability_results));
    }

    // restore this and the target robot's frames to their backed up state
    $this->robot_frame = $this_robot_backup_frame;
    $target_robot->robot_frame = $target_robot_backup_frame;

    // Update internal variables
    $target_robot->update_session();
    $this->update_session();

    // Return the final recovery results
    return $this_ability->ability_results;

  }

  /*

  // Define a trigger for recovering damage of this robot
  public function trigger_recovery($target_robot, $recovery_type, $recovery_amount){

    if ($recovery_amount < 1){ return 0; }
    $this->robot_energy = $this->robot_energy + $recovery_amount;
    if ($this->robot_energy > $this->robot_base_energy){
      $recovery_amount = $recovery_amount - ($this->robot_energy - $this->robot_base_energy);
      $this->robot_energy = $this->robot_base_energy;
    }

    // Update internal variables
    $target_robot->update_variables();
    $this->update_variables();

    return $recovery_amount;
  }

  */

  // Define a public function for recalculating internal counters
  public function update_variables(){

    // Update parent objects first
    //$this->player->update_variables();

    // Calculate this robot's count variables
    $this->counters['abilities_total'] = count($this->robot_abilities);

    // Update the parent battle variable

    // Return true on success
    return true;

  }

  // Define a public function for updating this player's session
  public function update_session(){

    // Update any internal counters
    $this->update_variables();

    // Request parent player object to update as well
    //$this->player->update_session();

    // Update the session with the export array
    $this_data = $this->export_array();
    $_SESSION['RPG2k11']['ROBOTS'][$this->battle->battle_id][$this->player->player_id][$this->robot_id] = $this_data;
    $this->battle->values['robots'][$this->robot_id] = $this_data;

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
      'robot_id' => $this->robot_id,
      'robot_number' => $this->robot_number,
      'robot_name' => $this->robot_name,
      'robot_token' => $this->robot_token,
      'robot_type' => $this->robot_type,
      'robot_description' => $this->robot_description,
      'robot_energy' => $this->robot_energy,
      'robot_attack' => $this->robot_attack,
      'robot_defense' => $this->robot_defense,
      'robot_speed' => $this->robot_speed,
      'robot_weaknesses' => $this->robot_weaknesses,
      'robot_resistances' => $this->robot_resistances,
      'robot_quotes' => $this->robot_quotes,
      'robot_base_name' => $this->robot_base_name,
      'robot_base_token' => $this->robot_base_token,
      'robot_base_type' => $this->robot_base_type,
      'robot_base_description' => $this->robot_base_description,
      'robot_base_energy' => $this->robot_base_energy,
      'robot_base_speed' => $this->robot_base_speed,
      'robot_base_attack' => $this->robot_base_attack,
      'robot_base_defense' => $this->robot_base_defense,
      'robot_base_weakness' => $this->robot_base_weakness,
      'robot_base_resistance' => $this->robot_base_resistance,
      'robot_abilities' => $this->robot_abilities,
      'robot_status' => $this->robot_status,
      'robot_position' => $this->robot_position
      );

  }

}
?>