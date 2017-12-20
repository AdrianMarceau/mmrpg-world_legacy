<?
// Define a class for the players
class mmrpg_player {

  // Define global class variables
  private $index;
  public $flags;
  public $counters;
  public $values;
  public $history;

  // Define the constructor class
  public function mmrpg_player(){

    // Define the internal index pointer
    $this->index = &$GLOBALS['mmrpg_index'];

    // Collect any provided arguments
    $args = func_get_args();

    // Define the internal battle pointer
    $this->battle = isset($args[0]) ? $args[0] : array();
    $this->battle_id = $this->battle->battle_id;
    $this->battle_token = $this->battle->battle_token;

    // Collect current player data from the function if available
    $this_playerinfo = isset($args[1]) ? $args[1] : array('player_id' => 0, 'player_token' => 'player');

    // Now load the player data from the session or index
    $this->player_load($this_playerinfo);

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function player_load($this_playerinfo){

    // Collect current player data from the session if available
    $this_playerinfo_backup = $this_playerinfo;
    if (isset($_SESSION['RPG2k12']['PLAYERS'][$this->battle->battle_id][$this_playerinfo['player_id']])){
      $this_playerinfo = $_SESSION['RPG2k12']['PLAYERS'][$this->battle->battle_id][$this_playerinfo['player_id']];
    }
    // Otherwise, collect player data from the index
    else {
      $this_playerinfo = $this->index['players'][$this_playerinfo['player_token']];
    }
    $this_playerinfo = array_merge($this_playerinfo, $this_playerinfo_backup);

    // Define the internal player values using the collected array
    $this->flags = isset($this_playerinfo['flags']) ? $this_playerinfo['flags'] : array();
    $this->counters = isset($this_playerinfo['counters']) ? $this_playerinfo['counters'] : array();
    $this->values = isset($this_playerinfo['values']) ? $this_playerinfo['values'] : array();
    $this->history = isset($this_playerinfo['history']) ? $this_playerinfo['history'] : array();
    $this->player_id = isset($this_playerinfo['player_id']) ? $this_playerinfo['player_id'] : 0;
    $this->player_name = isset($this_playerinfo['player_name']) ? $this_playerinfo['player_name'] : 'Robot';
    $this->player_token = isset($this_playerinfo['player_token']) ? $this_playerinfo['player_token'] : 'player';
    $this->player_description = isset($this_playerinfo['player_description']) ? $this_playerinfo['player_description'] : '';
    $this->player_robots = isset($this_playerinfo['player_robots']) ? $this_playerinfo['player_robots'] : array();
    $this->player_side = isset($this_playerinfo['player_side']) ? $this_playerinfo['player_side'] : 'left';
//    if (empty($this->player_id)){
//      $this->player_id = md5(substr(md5($this->player_side), 0, 10));
//    }

    // Define the internal player base values using the players index array
    $this->player_base_name = isset($this_playerinfo['player_base_name']) ? $this_playerinfo['player_base_name'] : $this->player_name;
    $this->player_base_token = isset($this_playerinfo['player_base_token']) ? $this_playerinfo['player_base_token'] : $this->player_token;
    $this->player_base_description = isset($this_playerinfo['player_base_description']) ? $this_playerinfo['player_base_description'] : $this->player_description;
    $this->player_base_robots = isset($this_playerinfo['player_base_robots']) ? $this_playerinfo['player_base_robots'] : $this->player_robots;

    // Count the number of robots this player has
    $num_robots = count($this->player_robots);
    // If this player has no robots, die
    if ($num_robots < 1){
      die('player has no robots...'.print_r($this_playerinfo, true));
    }
    // Else if this player has more than eight robots on their team
    elseif ($num_robots > 8){
      $this->player_robots = array_slice($this->player_robots, 0, 8, false);
    }

    // Now loop through each of the robots and expand their data
    foreach ($this->player_robots AS $this_key => $this_robotinfo){
      $this_robot = new mmrpg_robot($this->battle, $this, $this_robotinfo);
      $this_export_array = $this_robot->export_array();
      $this->player_robots[$this_key] = $this_export_array;
      unset($this_robot);
    }

    // Update the session variable
    $this->update_session();

    // Return true on success
    return true;

  }

  // Define public print functions for markup generation
  public function print_player_name(){ return '<span class="player_name">'.$this->player_name.'</span>'; }
  public function print_player_token(){ return '<span class="player_token">'.$this->player_token.'</span>'; }
  public function print_player_description(){ return '<span class="player_description">'.$this->player_description.'</span>'; }

  // Define a public function updating internal varibales
  public function update_variables(){

    // Update parent objects first
    //$this->battle->update_variables();

    // Create the flag variables if they don't exist

    // Create the counter variables and defeault to zero
    $this->counters['robots_total'] = 0;
    $this->counters['robots_active'] = 0;
    $this->counters['robots_disabled'] = 0;

    // Create the value variables and default to empty
    $this->values['robots_active'] = array();
    $this->values['robots_disabled'] = array();

    // Ensure this player has robots to loop over
    if (!empty($this->player_robots)){

      // Loop through each of the player's robots and check status
      foreach ($this->player_robots AS $this_key => $this_robotinfo){
        // Ensure a token an idea are provided at least
        if (empty($this_robotinfo['robot_id']) || empty($this_robotinfo['robot_token'])){ continue; }
        // Define the current temp robot object using the loaded robot data
        $temp_robot = new mmrpg_robot($this->battle, $this, $this_robotinfo);
        // Increment the active or inactive counter based on status
        if ($temp_robot->robot_status == 'active'){
          $this->counters['robots_active']++;
          $this->values['robots_active'][] = &$this->player_robots[$this_key]; //$this_info;
        }
        elseif ($temp_robot->robot_status == 'disabled'){
          $this->counters['robots_disabled']++;
          $this->values['robots_disabled'][] = &$this->player_robots[$this_key]; //$this_info;
        }
        // Increment the robot total by default
        $this->counters['robots_total']++;
        // Update or create this robot's session object
        //$temp_robot->update_session();
      }



    }

    // Return true on success
    return true;

  }

  // Define a public function for updating this player's session
  public function update_session(){

    // Update any internal counters
    $this->update_variables();

    // Request parent battle object to update as well
    //$this->battle->update_session();

    // Update the session with the export array
    $this_data = $this->export_array();
    $_SESSION['RPG2k12']['PLAYERS'][$this->battle->battle_id][$this->player_id] = $this_data;
    $this->battle->values['players'][$this->player_id] = $this_data;

    // Return true on success
    return true;

  }

  // Define a function for exporting the current data
  public function export_array(){

    // Return all internal player fields in array format
    return array(
      'flags' => $this->flags,
      'counters' => $this->counters,
      'values' => $this->values,
      'history' => $this->history,
      'battle_id' => $this->battle_id,
      'battle_token' => $this->battle_token,
      'player_id' => $this->player_id,
      'player_name' => $this->player_name,
      'player_token' => $this->player_token,
      'player_description' => $this->player_description,
      'player_robots' => $this->player_robots,
      'player_base_name' => $this->player_base_name,
      'player_base_token' => $this->player_base_token,
      'player_base_description' => $this->player_base_description,
      'player_base_robots' => $this->player_base_robots,
      'player_side' => $this->player_side
      );

  }

}
?>