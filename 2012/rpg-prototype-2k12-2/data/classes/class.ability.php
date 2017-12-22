<?
// Define a class for the abilities
class mmrpg_ability {

  // Define global class variables
  private $index;
  public $flags;
  public $counters;
  public $values;
  public $history;

  // Define the constructor class
  public function mmrpg_ability(){

    // Surround constructor in try...catch stack 'cause I read it on the internet
    try {

      // Define the internal index pointer
      $this->index = &$GLOBALS['mmrpg_index'];

      // Collect any provided arguments
      $args = func_get_args();

      // Define the internal battle pointer
      $this->battle = isset($args[0]) ? $args[0] : $GLOBALS['this_battle'];
      $this->battle_id = $this->battle->battle_id;
      $this->battle_token = $this->battle->battle_token;

      // Define the internal player values using the provided array
      $this->player = isset($args[1]) ? $args[1] : $GLOBALS['this_player'];
      $this->player_id = $this->player->player_id;
      $this->player_token = $this->player->player_token;

      // Define the internal player values using the provided array
      $this->robot = isset($args[2]) ? $args[2] : $GLOBALS['this_robot'];
      $this->robot_id = $this->robot->robot_id;
      $this->robot_token = $this->robot->robot_token;

      // Collect current ability data from the function if available
      $this_abilityinfo = isset($args[3]) ? $args[3] : array('ability_id' => 0, 'ability_token' => 'ability');

      if (!is_array($this_abilityinfo)){
        die('!is_array($this_abilityinfo){ '.print_r($this_abilityinfo, true)).' }';
      }

      // Now load the ability data from the session or index
      $this->ability_load($this_abilityinfo);

      //throw new Exception("testing 123 ability?");

    } catch (Exception $e) {

      // Kill the script and print the exception
      die('Exception?!?! ('.$e->getMessage().')');

    }

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function ability_load($this_abilityinfo){

    // If an ability ID has not been defined
    if (!isset($this_abilityinfo['ability_id'])){
      $this_abilityinfo['ability_id'] = 0;
    }

    // Collect current ability data from the session if available
    $this_abilityinfo_backup = $this_abilityinfo;
    $this_abilityinfo = array();
    if (isset($_SESSION['RPG2k12-2']['ABILITIES'][$this->battle->battle_id][$this->player->player_id][$this->robot->robot_id][$this_abilityinfo_backup['ability_id']])){
      $this_abilityinfo = $_SESSION['RPG2k12-2']['ABILITIES'][$this->battle->battle_id][$this->player->player_id][$this->robot->robot_id][$this_abilityinfo_backup['ability_id']];
    }
    // Collect the info from the index if still empty or the token does not match
    if (empty($this_abilityinfo) || $this_abilityinfo['ability_token'] != $this_abilityinfo_backup['ability_token']){
      $this_abilityinfo = $this->index['abilities'][$this_abilityinfo_backup['ability_token']];
    }
    $this_abilityinfo = array_replace($this_abilityinfo, $this_abilityinfo_backup);

    // Define the internal ability values using the provided array
    $this->flags = isset($this_abilityinfo['flags']) ? $this_abilityinfo['flags'] : array();
    $this->counters = isset($this_abilityinfo['counters']) ? $this_abilityinfo['counters'] : array();
    $this->values = isset($this_abilityinfo['values']) ? $this_abilityinfo['values'] : array();
    $this->history = isset($this_abilityinfo['history']) ? $this_abilityinfo['history'] : array();
    $this->ability_id = isset($this_abilityinfo['ability_id']) ? $this_abilityinfo['ability_id'] : 0;
    $this->ability_name = isset($this_abilityinfo['ability_name']) ? $this_abilityinfo['ability_name'] : 'Ability';
    $this->ability_token = isset($this_abilityinfo['ability_token']) ? $this_abilityinfo['ability_token'] : 'ability';
    $this->ability_description = isset($this_abilityinfo['ability_description']) ? $this_abilityinfo['ability_description'] : '';
    $this->ability_type = isset($this_abilityinfo['ability_type']) ? $this_abilityinfo['ability_type'] : '';
    $this->ability_speed = isset($this_abilityinfo['ability_speed']) ? $this_abilityinfo['ability_speed'] : 1;
    $this->ability_damage = isset($this_abilityinfo['ability_damage']) ? $this_abilityinfo['ability_damage'] : 0;
    $this->ability_recovery = isset($this_abilityinfo['ability_recovery']) ? $this_abilityinfo['ability_recovery'] : 0;
    $this->ability_accuracy = isset($this_abilityinfo['ability_accuracy']) ? $this_abilityinfo['ability_accuracy'] : 0;
    $this->ability_function = isset($this->index['abilities'][$this->ability_token]['ability_function']) ? $this->index['abilities'][$this->ability_token]['ability_function'] : function(){};
    $this->ability_attachment = isset($this->index['abilities'][$this->ability_token]['ability_attachment']) ? $this->index['abilities'][$this->ability_token]['ability_attachment'] : function(){};
    $this->ability_events = isset($this->index['abilities'][$this->ability_token]['ability_events']) ? $this->index['abilities'][$this->ability_token]['ability_events'] : array();
    $this->ability_frame = isset($this_abilityinfo['ability_frame']) ? $this_abilityinfo['ability_frame'] : 1;
    $this->ability_frame_index = isset($this_abilityinfo['ability_frame_index']) ? $this_abilityinfo['ability_frame_index'] : array('base');
    $this->ability_frame_offset = isset($this_abilityinfo['ability_frame_offset']) ? $this_abilityinfo['ability_frame_offset'] : array('x' => 0, 'y' => 0, 'z' => 1);
    $this->attachment_frame = isset($this_abilityinfo['attachment_frame']) ? $this_abilityinfo['attachment_frame'] : 1;
    $this->attachment_frame_offset = isset($this_abilityinfo['attachment_frame_offset']) ? $this_abilityinfo['attachment_frame_offset'] : array('x' => 0, 'y' => 0, 'z' => 1);
    $this->ability_results = array();
    $this->attachment_results = array();
    $this->ability_options = array();
    $this->target_options = array();
    $this->damage_options = array();
    $this->recovery_options = array();
    $this->attachment_options = array();
//    if (empty($this->ability_id)){
//      $this->ability_id = array_search($this->ability_token, $this->robot->robot_abilities);
//    }

    // Define the internal robot base values using the robots index array
    $this->ability_base_name = isset($this_abilityinfo['ability_base_name']) ? $this_abilityinfo['ability_base_name'] : $this->ability_name;
    $this->ability_base_token = isset($this_abilityinfo['ability_base_token']) ? $this_abilityinfo['ability_base_token'] : $this->ability_token;
    $this->ability_base_description = isset($this_abilityinfo['ability_base_description']) ? $this_abilityinfo['ability_base_description'] : $this->ability_description;
    $this->ability_base_type = isset($this_abilityinfo['ability_base_type']) ? $this_abilityinfo['ability_base_type'] : $this->ability_type;
    $this->ability_base_speed = isset($this_abilityinfo['ability_base_speed']) ? $this_abilityinfo['ability_base_speed'] : $this->ability_speed;
    $this->ability_base_damage = isset($this_abilityinfo['ability_base_damage']) ? $this_abilityinfo['ability_base_damage'] : $this->ability_damage;
    $this->ability_base_recovery = isset($this_abilityinfo['ability_base_recovery']) ? $this_abilityinfo['ability_base_recovery'] : $this->ability_recovery;
    $this->ability_base_accuracy = isset($this_abilityinfo['ability_base_accuracy']) ? $this_abilityinfo['ability_base_accuracy'] : $this->ability_accuracy;

    // Update the session variable
    $this->update_session();

    // Return true on success
    return true;

  }

  // Define public print functions for markup generation
  public function print_ability_name(){ return '<span class="ability_name">'.$this->ability_name.'</span>'; }
  public function print_ability_token(){ return '<span class="ability_token">'.$this->ability_token.'</span>'; }
  public function print_ability_description(){ return '<span class="ability_description">'.$this->ability_description.'</span>'; }
  public function print_ability_type(){ return '<span class="ability_type">'.$this->ability_type.'</span>'; }
  public function print_ability_speed(){ return '<span class="ability_speed">'.$this->ability_speed.'</span>'; }
  public function print_ability_damage(){ return '<span class="ability_damage">'.$this->ability_damage.'</span>'; }
  public function print_ability_recovery(){ return '<span class="ability_recovery">'.$this->ability_recovery.'</span>'; }
  public function print_ability_accuracy(){ return '<span class="ability_accuracy">'.$this->ability_accuracy.'%</span>'; }

  // Define a public function for easily resetting target options
  public function target_options_reset(){
    // Redfine the options variables as an empty array
    $this->target_options = array();
    // Populate the array with defaults
    $this->target_options['target_kind'] = 'energy';
    $this->target_options['target_frame'] = 'shoot';
    $this->target_options['ability_success_frame'] = 1;
    $this->target_options['ability_success_frame_offset'] = array('x' => 0, 'y' => 0, 'z' => 1);
    $this->target_options['ability_failure_frame'] = 1;
    $this->target_options['ability_failure_frame_offset'] = array('x' => 0, 'y' => 0, 'z' => 1);
    $this->target_options['target_header'] = $this->robot->robot_name.'&#39;s '.$this->ability_name;
    $this->target_options['target_text'] = "{$this->robot->print_robot_name()} uses {$this->print_ability_name()}!";
    // Update this ability's data
    $this->update_session();
    // Return the resuling array
    return $this->target_options;
  }


  // Define a public function for easily updating target options
  public function target_options_update($target_options = array()){
    // Update internal variables with basic target options, if set
    if (isset($target_options['header'])){ $this->target_options['target_header'] = $target_options['header'];  }
    if (isset($target_options['text'])){ $this->target_options['target_text'] = $target_options['text'];  }
    if (isset($target_options['frame'])){ $this->target_options['target_frame'] = $target_options['frame'];  }
    if (isset($target_options['kind'])){ $this->target_options['target_kind'] = $target_options['kind'];  }
    // Update internal variabels with success options, if set
    if (isset($target_options['success'])){
      $this->target_options['ability_success_frame'] = $target_options['success'][0];
      $this->target_options['ability_success_frame_offset']['x'] = $target_options['success'][1];
      $this->target_options['ability_success_frame_offset']['y'] = $target_options['success'][2];
      $this->target_options['ability_success_frame_offset']['z'] = $target_options['success'][3];
      $this->target_options['target_text'] = $target_options['success'][4];
    }
    // Update internal variabels with failure options, if set
    if (isset($target_options['failure'])){
      $this->target_options['ability_failure_frame'] = $target_options['failure'][0];
      $this->target_options['ability_failure_frame_offset']['x'] = $target_options['failure'][1];
      $this->target_options['ability_failure_frame_offset']['y'] = $target_options['failure'][2];
      $this->target_options['ability_failure_frame_offset']['z'] = $target_options['failure'][3];
      $this->target_options['target_text'] = $target_options['failure'][4];
    }
    // Return the new array
    return $this->target_options;
  }

  // Define a public function for easily resetting damage options
  public function damage_options_reset(){
    // Redfine the options variables as an empty array
    $this->damage_options = array();
    // Populate the array with defaults
    $this->damage_options = array();
    $this->damage_options['damage_header'] = $this->robot->robot_name.'&#39;s '.$this->ability_name;
    $this->damage_options['damage_frame'] = 'damage';
    $this->damage_options['ability_success_frame'] = 1;
    $this->damage_options['ability_success_frame_offset'] = array('x' => 0, 'y' => 0, 'z' => 1);
    $this->damage_options['ability_failure_frame'] = 1;
    $this->damage_options['ability_failure_frame_offset'] = array('x' => 0, 'y' => 0, 'z' => 1);
    $this->damage_options['damage_kind'] = 'energy';
    $this->damage_options['damage_type'] = $this->ability_type;
    $this->damage_options['damage_amount'] = $this->ability_damage;
    $this->damage_options['damage_kickback'] = array('x' => 0, 'y' => 0, 'z' => 0);
    $this->damage_options['success_rate'] = 'auto';
    $this->damage_options['failure_rate'] = 'auto';
    $this->damage_options['critical_rate'] = 10;
    $this->damage_options['critical_multiplier'] = 2;
    $this->damage_options['weakness_multiplier'] = 2;
    $this->damage_options['resistance_multiplier'] = 0.5;
    $this->damage_options['immunity_multiplier'] = 0;
    $this->damage_options['success_text'] = 'The ability hit!';
    $this->damage_options['failure_text'] = 'The ability missed&hellip;';
    $this->damage_options['immunity_text'] = 'The ability had no effect&hellip;';
    $this->damage_options['critical_text'] = 'It&#39;s a critical hit!';
    $this->damage_options['weakness_text'] = 'It&#39;s super effective!';
    $this->damage_options['resistance_text'] = 'It&#39;s not very effective&hellip;';
    $this->damage_options['weakness_resistance_text'] = ''; //"It's a super effective resisted hit!';
    $this->damage_options['weakness_critical_text'] = 'It&#39;s a super effective critical hit!';
    $this->damage_options['resistance_critical_text'] = ''; //"It's a resisted critical hit&hellip;';
    // Update this ability's data
    $this->update_session();
    // Return the resuling array
    return $this->damage_options;
  }

  // Define a public function for easily updating damage options
  public function damage_options_update($damage_options = array()){
    // Update internal variables with basic damage options, if set
    if (isset($damage_options['header'])){ $this->damage_options['damage_header'] = $damage_options['header'];  }
    if (isset($damage_options['frame'])){ $this->damage_options['damage_frame'] = $damage_options['frame'];  }
    if (isset($damage_options['kind'])){ $this->damage_options['damage_kind'] = $damage_options['kind'];  }
    if (isset($damage_options['type'])){ $this->damage_options['damage_type'] = $damage_options['type'];  }
    if (isset($damage_options['amount'])){ $this->damage_options['damage_amount'] = $damage_options['amount'];  }
    // Update internal variables with rate options, if set
    if (isset($damage_options['rates'])){
      $this->damage_options['success_rate'] = $damage_options['rates'][0];
      $this->damage_options['failure_rate'] = $damage_options['rates'][1];
      $this->damage_options['critical_rate'] = $damage_options['rates'][2];
    }
    // Update internal variables with multipier options, if set
    if (isset($damage_options['multipliers'])){
      $this->damage_options['critical_multiplier'] = $damage_options['multipliers'][0];
      $this->damage_options['weakness_multiplier'] = $damage_options['multipliers'][1];
      $this->damage_options['resistance_multiplier'] = $damage_options['multipliers'][2];
      $this->damage_options['immunity_multiplier'] = $damage_options['multipliers'][3];
    }
    // Update internal variables with kickback options, if set
    if (isset($damage_options['kickback'])){
      $this->damage_options['damage_kickback']['x'] = $damage_options['kickback'][0];
      $this->damage_options['damage_kickback']['y'] = $damage_options['kickback'][1];
      $this->damage_options['damage_kickback']['z'] = $damage_options['kickback'][2];
    }
    // Update internal variables with success options, if set
    if (isset($damage_options['success'])){
      $this->damage_options['ability_success_frame'] = $damage_options['success'][0];
      $this->damage_options['ability_success_frame_offset']['x'] = $damage_options['success'][1];
      $this->damage_options['ability_success_frame_offset']['y'] = $damage_options['success'][2];
      $this->damage_options['ability_success_frame_offset']['z'] = $damage_options['success'][3];
      $this->damage_options['success_text'] = $damage_options['success'][4];
    }
    // Update internal variables with failure options, if set
    if (isset($damage_options['failure'])){
      $this->damage_options['ability_failure_frame'] = $damage_options['failure'][0];
      $this->damage_options['ability_failure_frame_offset']['x'] = $damage_options['failure'][1];
      $this->damage_options['ability_failure_frame_offset']['y'] = $damage_options['failure'][2];
      $this->damage_options['ability_failure_frame_offset']['z'] = $damage_options['failure'][3];
      $this->damage_options['failure_text'] = $damage_options['failure'][4];
    }
    // Return the new array
    return $this->damage_options;
  }

  // Define a public function for easily resetting recovery options
  public function recovery_options_reset(){
    // Redfine the options variables as an empty array
    $this->recovery_options = array();
    // Populate the array with defaults
    $this->recovery_options = array();
    $this->recovery_options['recovery_header'] = $this->robot->robot_name.'&#39;s '.$this->ability_name;
    $this->recovery_options['recovery_frame'] = 'defend';
    $this->recovery_options['ability_success_frame'] = 1;
    $this->recovery_options['ability_success_frame_offset'] = array('x' => 0, 'y' => 0, 'z' => 1);
    $this->recovery_options['ability_failure_frame'] = 1;
    $this->recovery_options['ability_failure_frame_offset'] = array('x' => 0, 'y' => 0, 'z' => 1);
    $this->recovery_options['recovery_kind'] = 'energy';
    $this->recovery_options['recovery_type'] = $this->ability_type;
    $this->recovery_options['recovery_amount'] = $this->ability_recovery;
    $this->recovery_options['recovery_kickback'] = array('x' => 0, 'y' => 0, 'z' => 0);
    $this->recovery_options['success_rate'] = 'auto';
    $this->recovery_options['failure_rate'] = 'auto';
    $this->recovery_options['critical_rate'] = 10;
    $this->recovery_options['critical_multiplier'] = 2;
    $this->recovery_options['affinity_multiplier'] = 2;
    $this->recovery_options['resistance_multiplier'] = 0.5;
    $this->recovery_options['immunity_multiplier'] = 0;
    $this->recovery_options['recovery_type'] = $this->ability_type;
    $this->recovery_options['success_text'] = 'The ability worked!';
    $this->recovery_options['failure_text'] = 'The ability failed&hellip;';
    $this->recovery_options['immunity_text'] = 'The ability had no effect&hellip;';
    $this->recovery_options['critical_text'] = 'It&#39;s a boosted heal!';
    $this->recovery_options['affinity_text'] = 'It&#39;s super effective!';
    $this->recovery_options['resistance_text'] = 'It&#39;s not very effective&hellip;';
    $this->recovery_options['affinity_resistance_text'] = ''; //'It&#39;s a super effective resisted hit!';
    $this->recovery_options['affinity_critical_text'] = 'It&#39;s a super effective critical heal!';
    $this->recovery_options['resistance_critical_text'] = ''; //'It&#39;s a resisted critical hit&hellip;';
    // Update this ability's data
    $this->update_session();
    // Return the resuling array
    return $this->recovery_options;
  }

  // Define a public function for easily updating recovery options
  public function recovery_options_update($recovery_options = array()){
    // Update internal variables with basic recovery options, if set
    if (isset($recovery_options['header'])){ $this->recovery_options['recovery_header'] = $recovery_options['header'];  }
    if (isset($recovery_options['frame'])){ $this->recovery_options['recovery_frame'] = $recovery_options['frame'];  }
    if (isset($recovery_options['kind'])){ $this->recovery_options['recovery_kind'] = $recovery_options['kind'];  }
    if (isset($recovery_options['type'])){ $this->recovery_options['recovery_type'] = $recovery_options['type'];  }
    if (isset($recovery_options['amount'])){ $this->recovery_options['recovery_amount'] = $recovery_options['amount'];  }
    // Update internal variables with rate options, if set
    if (isset($recovery_options['rates'])){
      $this->recovery_options['success_rate'] = $recovery_options['rates'][0];
      $this->recovery_options['failure_rate'] = $recovery_options['rates'][1];
      $this->recovery_options['critical_rate'] = $recovery_options['rates'][2];
    }
    // Update internal variables with multipier options, if set
    if (isset($recovery_options['multipliers'])){
      $this->recovery_options['critical_multiplier'] = $recovery_options['multipliers'][0];
      $this->recovery_options['weakness_multiplier'] = $recovery_options['multipliers'][1];
      $this->recovery_options['resistance_multiplier'] = $recovery_options['multipliers'][2];
      $this->recovery_options['immunity_multiplier'] = $recovery_options['multipliers'][3];
    }
    // Update internal variables with kickback options, if set
    if (isset($recovery_options['kickback'])){
      $this->recovery_options['recovery_kickback']['x'] = $recovery_options['kickback'][0];
      $this->recovery_options['recovery_kickback']['y'] = $recovery_options['kickback'][1];
      $this->recovery_options['recovery_kickback']['z'] = $recovery_options['kickback'][2];
    }
    // Update internal variabels with success options, if set
    if (isset($recovery_options['success'])){
      $this->recovery_options['ability_success_frame'] = $recovery_options['success'][0];
      $this->recovery_options['ability_success_frame_offset']['x'] = $recovery_options['success'][1];
      $this->recovery_options['ability_success_frame_offset']['y'] = $recovery_options['success'][2];
      $this->recovery_options['ability_success_frame_offset']['z'] = $recovery_options['success'][3];
      $this->recovery_options['success_text'] = $recovery_options['success'][4];
    }
    // Update internal variabels with failure options, if set
    if (isset($recovery_options['failure'])){
      $this->recovery_options['ability_failure_frame'] = $recovery_options['failure'][0];
      $this->recovery_options['ability_failure_frame_offset']['x'] = $recovery_options['failure'][1];
      $this->recovery_options['ability_failure_frame_offset']['y'] = $recovery_options['failure'][2];
      $this->recovery_options['ability_failure_frame_offset']['z'] = $recovery_options['failure'][3];
      $this->recovery_options['failure_text'] = $recovery_options['failure'][4];
    }
    // Return the new array
    return $this->recovery_options;
  }

  // Define a public function for easily resetting attachment options
  public function attachment_options_reset(){
    // Redfine the options variables as an empty array
    $this->attachment_options = array();
    // Update this ability's data
    $this->update_session();
    // Return the resuling array
    return $this->attachment_options;
  }


  // Define a public function for easily updating attachment options
  public function attachment_options_update($attachment_options = array()){
    // Update this ability's data
    $this->update_session();
    // Return the new array
    return $this->attachment_options;
  }

  // Define a function for generating ability canvas variables
  public function canvas_markup($options, $player_data, $robot_data){

    // Define the variable to hold the console robot data
    $this_data = array();

    // Define the ability data array and populate basic data
    $this_data['ability_markup'] = '';
    $this_data['data_type'] = !empty($options['data_type']) ? $options['data_type'] : 'ability';
    $this_data['data_debug'] = !empty($options['data_debug']) ? $options['data_debug'] : '';
    $this_data['ability_name'] = isset($options['ability_name']) ? $options['ability_name'] : $this->ability_name;
    $this_data['ability_token'] = $this->ability_token;
    $this_data['ability_status'] = $robot_data['robot_status'];
    $this_data['ability_position'] = $robot_data['robot_position'];
    $this_data['ability_direction'] = $this->robot_id == $robot_data['robot_id'] ? $robot_data['robot_direction'] : ($robot_data['robot_direction'] == 'left' ? 'right' : 'left');
    $this_data['ability_float'] = $robot_data['robot_float'];
    $this_data['ability_size'] = $this_data['ability_position'] == 'active' ? 80 : 40;
    $this_data['ability_frame'] = isset($options['ability_frame']) ? $options['ability_frame'] : $this->ability_frame;
    if (is_numeric($this_data['ability_frame']) && $this_data['ability_frame'] >= 0){ $this_data['ability_frame'] = str_pad($this_data['ability_frame'], 2, '0', STR_PAD_LEFT); }
    elseif (is_numeric($this_data['ability_frame']) && $this_data['ability_frame'] < 0){ $this_data['ability_frame'] = ''; }
    $this_data['ability_image'] = 'images/abilities/'.$this_data['ability_token'].'/sprite_'.$this_data['ability_direction'].'_'.$this_data['ability_size'].'x'.$this_data['ability_size'].'.png?'.$this->battle->config['CACHE_DATE'];
    $this_data['ability_frame_offset'] = isset($options['ability_frame_offset']) ? $options['ability_frame_offset'] : $this->ability_frame_offset;
    $animate_frames_array = isset($options['animate_frames']) ? $options['animate_frames'] : array($this_data['ability_frame']);
    $animate_frames_string = array();
    if (!empty($animate_frames_array)){
      foreach ($animate_frames_array AS $key => $frame){
        $animate_frames_string[] = is_numeric($frame) ? str_pad($frame, 2, '0', STR_PAD_LEFT) : $frame;
      }
    }
    $this_data['animate_frames'] = implode(',', $animate_frames_string);

    // Define the ability's canvas offset variables
    if ($this_data['ability_frame_offset']['x'] > 0){ $this_data['canvas_offset_x'] = ceil($robot_data['canvas_offset_x'] + ($robot_data['robot_size'] * ($this_data['ability_frame_offset']['x']/100))); }
    elseif ($this_data['ability_frame_offset']['x'] < 0){ $this_data['canvas_offset_x'] = ceil($robot_data['canvas_offset_x'] - ($robot_data['robot_size'] * (($this_data['ability_frame_offset']['x'] * -1)/100))); }
    else { $this_data['canvas_offset_x'] = $robot_data['canvas_offset_x'];  }
    if ($this_data['ability_frame_offset']['y'] > 0){ $this_data['canvas_offset_y'] = ceil($robot_data['canvas_offset_y'] + ($robot_data['robot_size'] * ($this_data['ability_frame_offset']['y']/100))); }
    elseif ($this_data['ability_frame_offset']['y'] < 0){ $this_data['canvas_offset_y'] = ceil($robot_data['canvas_offset_y'] - ($robot_data['robot_size'] * (($this_data['ability_frame_offset']['y'] * -1)/100))); }
    else { $this_data['canvas_offset_y'] = $robot_data['canvas_offset_y'];  }
    if ($this_data['ability_frame_offset']['z'] > 0){ $this_data['canvas_offset_z'] = ceil($robot_data['canvas_offset_z'] + $this_data['ability_frame_offset']['z']); }
    elseif ($this_data['ability_frame_offset']['z'] < 0){ $this_data['canvas_offset_z'] = ceil($robot_data['canvas_offset_z'] - ($this_data['ability_frame_offset']['z'] * -1)); }
    else { $this_data['canvas_offset_z'] = $robot_data['canvas_offset_z'];  }

    // Define the ability's class and styles variables
    $this_data['ability_class'] = 'sprite ';
    $this_data['ability_class'] .= 'sprite_'.$this_data['ability_size'].'x'.$this_data['ability_size'].' sprite_'.$this_data['ability_size'].'x'.$this_data['ability_size'].'_'.$this_data['ability_frame'].' ';
    $this_data['ability_class'] .= 'ability_status_'.$this_data['ability_status'].' ability_position_'.$this_data['ability_position'].' ';
    $this_data['ability_style'] = 'z-index: '.$this_data['canvas_offset_z'].'; '.$this_data['ability_float'].': '.$this_data['canvas_offset_x'].'px; bottom: '.$this_data['canvas_offset_y'].'px; ';
    $this_data['ability_style'] .= 'background-image: url('.$this_data['ability_image'].'); ';

    // Append the final ability graphic markup to the markup array
    /* data-debug="'.$data_debug.'"
    $data_debug = 'robot_canvas_offset:'.implode('/', array($robot_data['canvas_offset_x'], $robot_data['canvas_offset_y'], $robot_data['canvas_offset_z'])).', ';
    $data_debug .= 'option_ability_frame_offset:'.implode('/', $options['ability_frame_offset']).', ';
    $data_debug .= 'data_ability_frame_offset:'.implode('/', $this_data['ability_frame_offset']).', ';
    $data_debug .= 'object_ability_frame_offset:'.implode('/', $this->ability_frame_offset).', ';
    */
    $data_debug = $this_data['data_debug']; //'event_frame_counter:'.$this->battle->counters['events'];
    $this_data['ability_markup'] .= '<div data-debug="'.$data_debug.'" data-type="'.$this_data['data_type'].'" data-position="'.$this_data['ability_position'].'" data-direction="'.$this_data['ability_direction'].'" data-size="'.$this_data['ability_size'].'" data-frame="'.$this_data['ability_frame'].'" data-animate="'.$this_data['animate_frames'].'" class="'.$this_data['ability_class'].'" style="'.$this_data['ability_style'].'">'.$this_data['ability_name'].'</div>';

    // Return the robot canvas data
    return $this_data;

  }

  // Define a function for generating ability console variables
  public function console_markup($options, $player_data, $robot_data){

    // Define the variable to hold the console ability data
    $this_data = array();

    // Define and calculate the simpler markup and positioning variables for this ability
    $this_data['ability_name'] = isset($options['ability_name']) ? $options['ability_name'] : $this->ability_name;
    $this_data['ability_token'] = $this->ability_token;
    $this_data['ability_direction'] = $this->robot_id == $robot_data['robot_id'] ? $robot_data['robot_direction'] : ($robot_data['robot_direction'] == 'left' ? 'right' : 'left');
    $this_data['ability_float'] = $robot_data['robot_float'];
    $this_data['ability_size'] = 40;
    $this_data['ability_frame'] = isset($options['ability_frame']) ? $options['ability_frame'] : $this->ability_frame;
    if (is_numeric($this_data['ability_frame']) && $this_data['ability_frame'] >= 0){ $this_data['ability_frame'] = str_pad($this_data['ability_frame'], 2, '0', STR_PAD_LEFT); }
    elseif (is_numeric($this_data['ability_frame']) && $this_data['ability_frame'] < 0){ $this_data['ability_frame'] = ''; }
    $this_data['image_type'] = !empty($options['this_ability_image']) ? $options['this_ability_image'] : 'icon';

    // Define the rest of the display variables
    $this_data['container_class'] = 'this_sprite sprite_'.$this_data['ability_float'];
    $this_data['container_style'] = '';
    $this_data['ability_class'] = 'sprite sprite_ability sprite_ability_'.$this_data['image_type'].' ';
    $this_data['ability_style'] = '';
    $this_data['ability_size'] = 40;
    $this_data['ability_image'] = 'images/abilities/'.$this_data['ability_token'].'/'.$this_data['image_type'].'_'.$this_data['ability_direction'].'_'.$this_data['ability_size'].'x'.$this_data['ability_size'].'.png?'.$this->battle->config['CACHE_DATE'];
    $this_data['ability_class'] .= 'sprite_'.$this_data['ability_size'].'x'.$this_data['ability_size'].' sprite_'.$this_data['ability_size'].'x'.$this_data['ability_size'].'_'.$this_data['ability_frame'].' ';
    $this_data['ability_style'] .= 'background-image: url('.$this_data['ability_image'].'); ';

    // Generate the final markup for the console ability
    $this_data['ability_markup'] = '';
    $this_data['ability_markup'] .= '<div class="'.$this_data['container_class'].'" style="'.$this_data['container_style'].'">';
    $this_data['ability_markup'] .= '<div class="'.$this_data['ability_class'].'" style="'.$this_data['ability_style'].'" title="'.$this_data['ability_title'].'">'.$this_data['ability_title'].'</div>';
    $this_data['ability_markup'] .= '</div>';

    // Return the ability console data
    return $this_data;

  }






  // Define a public function for recalculating internal counters
  public function update_variables(){

    // Update parent objects first
    //$this->robot->update_variables();

    // Calculate this ability's count variables
    //$this->counters['thing'] = count($this->robot_stuff);

    // Return true on success
    return true;

  }

  // Define a public function for updating this player's session
  public function update_session(){

    // Update any internal counters
    $this->update_variables();

    // Request parent robot object to update as well
    //$this->robot->update_session();

    // Update the session with the export array
    $this_data = $this->export_array();
    $_SESSION['RPG2k12-2']['ABILITIES'][$this->battle->battle_id][$this->player->player_id][$this->robot->robot_id][$this->ability_id] = $this_data;
    $this->battle->values['abilities'][$this->ability_id] = $this_data;
    $this->player->values['abilities'][$this->ability_id] = $this_data;
    $this->robot->values['abilities'][$this->ability_id] = $this_data;

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
      'battle_token' => $this->battle_token,
      'player_id' => $this->player_id,
      'player_token' => $this->player_token,
      'robot_id' => $this->robot_id,
      'robot_token' => $this->robot_token,
      'ability_id' => $this->ability_id,
      'ability_name' => $this->ability_name,
      'ability_token' => $this->ability_token,
      'ability_description' => $this->ability_description,
      'ability_type' => $this->ability_type,
      'ability_speed' => $this->ability_speed,
      'ability_damage' => $this->ability_damage,
      'ability_recovery' => $this->ability_recovery,
      'ability_accuracy' => $this->ability_accuracy,
      'ability_results' => $this->ability_results,
      'attachment_results' => $this->attachment_results,
      'ability_options' => $this->ability_options,
      'target_options' => $this->target_options,
      'damage_options' => $this->damage_options,
      'recovery_options' => $this->recovery_options,
      'attachment_options' => $this->attachment_options,
      'ability_base_name' => $this->ability_base_name,
      'ability_base_token' => $this->ability_base_token,
      'ability_base_description' => $this->ability_base_description,
      'ability_base_type' => $this->ability_base_type,
      'ability_base_damage' => $this->ability_base_damage,
      'ability_base_accuracy' => $this->ability_base_accuracy,
      'ability_frame' => $this->ability_frame,
      'ability_frame_index' => $this->ability_frame_index,
      'ability_frame_offset' => $this->ability_frame_offset,
      'attachment_frame' => $this->attachment_frame,
      'attachment_frame_offset' => $this->attachment_frame_offset
      );

  }

}
?>