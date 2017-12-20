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

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function ability_load($this_abilityinfo){

    // Collect current ability data from the session if available
    $this_abilityinfo_backup = $this_abilityinfo;
    if (isset($_SESSION['RPG2k12']['ABILITIES'][$this->battle->battle_id][$this->player->player_id][$this->robot->robot_id][$this_abilityinfo['ability_id']])){
      $this_abilityinfo = $_SESSION['RPG2k12']['ABILITIES'][$this->battle->battle_id][$this->player->player_id][$this->robot->robot_id][$this_abilityinfo['ability_id']];
    }
    // Otherwise, collect robot data from the index
    else {
      $this_abilityinfo = $this->index['abilities'][$this_abilityinfo['ability_token']];
    }
    $this_abilityinfo = array_merge($this_abilityinfo, $this_abilityinfo_backup);

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
    $this->ability_damage = isset($this_abilityinfo['ability_damage']) ? $this_abilityinfo['ability_damage'] : 0;
    $this->ability_recovery = isset($this_abilityinfo['ability_recovery']) ? $this_abilityinfo['ability_recovery'] : 0;
    $this->ability_accuracy = isset($this_abilityinfo['ability_accuracy']) ? $this_abilityinfo['ability_accuracy'] : 0;
    $this->ability_function = isset($this->index['abilities'][$this->ability_token]['ability_function']) ? $this->index['abilities'][$this->ability_token]['ability_function'] : function(){};
    $this->ability_events = isset($this->index['abilities'][$this->ability_token]['ability_events']) ? $this->index['abilities'][$this->ability_token]['ability_events'] : array();
    $this->ability_frame = isset($this_robotinfo['ability_frame']) ? $this_robotinfo['ability_frame'] : 1;
    $this->ability_frame_index = isset($this_robotinfo['ability_frame_index']) ? $this_robotinfo['ability_frame_index'] : array('base');
    $this->ability_frame_offset = isset($this_robotinfo['ability_frame_offset']) ? $this_robotinfo['ability_frame_offset'] : array('x' => 0, 'y' => 0, 'z' => 1);
    $this->ability_results = array();
    $this->ability_options = array();
//    if (empty($this->ability_id)){
//      $this->ability_id = array_search($this->ability_token, $this->robot->robot_abilities);
//    }

    // Define the internal robot base values using the robots index array
    $this->ability_base_name = isset($this_abilityinfo['ability_base_name']) ? $this_abilityinfo['ability_base_name'] : $this->ability_name;
    $this->ability_base_token = isset($this_abilityinfo['ability_base_token']) ? $this_abilityinfo['ability_base_token'] : $this->ability_token;
    $this->ability_base_description = isset($this_abilityinfo['ability_base_description']) ? $this_abilityinfo['ability_base_description'] : $this->ability_description;
    $this->ability_base_type = isset($this_abilityinfo['ability_base_type']) ? $this_abilityinfo['ability_base_type'] : $this->ability_type;
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
  public function print_ability_damage(){ return '<span class="ability_damage">'.$this->ability_damage.'</span>'; }
  public function print_ability_recovery(){ return '<span class="ability_recovery">'.$this->ability_recovery.'</span>'; }
  public function print_ability_accuracy(){ return '<span class="ability_accuracy">'.$this->ability_accuracy.'%</span>'; }

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
    $_SESSION['RPG2k12']['ABILITIES'][$this->battle->battle_id][$this->player->player_id][$this->robot->robot_id][$this->ability_id] = $this_data;
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
      'ability_damage' => $this->ability_damage,
      'ability_recovery' => $this->ability_recovery,
      'ability_accuracy' => $this->ability_accuracy,
      'ability_results' => $this->ability_results,
      'ability_options' => $this->ability_options,
      'ability_base_name' => $this->ability_base_name,
      'ability_base_token' => $this->ability_base_token,
      'ability_base_description' => $this->ability_base_description,
      'ability_base_type' => $this->ability_base_type,
      'ability_base_damage' => $this->ability_base_damage,
      'ability_base_accuracy' => $this->ability_base_accuracy,
      'ability_frame' => $this->ability_frame,
      'ability_frame_index' => $this->ability_frame_index,
      'ability_frame_offset' => $this->ability_frame_offset
      );

  }

}
?>