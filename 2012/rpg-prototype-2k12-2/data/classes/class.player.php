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

    // Surround constructor in try...catch stack 'cause I read it on the internet
    try {

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

      //throw new Exception("testing 123 player?");

    } catch (Exception $e) {

      // Kill the script and print the exception
      die('Exception?!?! ('.$e->getMessage().')');

    }

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function player_load($this_playerinfo){

    // Collect current player data from the session if available
    $this_playerinfo_backup = $this_playerinfo;
    if (isset($_SESSION['RPG2k12-2']['PLAYERS'][$this->battle->battle_id][$this_playerinfo['player_id']])){
      $this_playerinfo = $_SESSION['RPG2k12-2']['PLAYERS'][$this->battle->battle_id][$this_playerinfo['player_id']];
    }
    // Otherwise, collect player data from the index
    else {
      // Copy over the base contents from the players index
      $this_playerinfo = $this->index['players'][$this_playerinfo['player_token']];
    }
    $this_playerinfo = array_replace($this_playerinfo, $this_playerinfo_backup);

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
    $this->player_autopilot = isset($this_playerinfo['player_autopilot']) ? $this_playerinfo['player_autopilot'] : false;
    $this->player_quotes = isset($this_playerinfo['player_quotes']) ? $this_playerinfo['player_quotes'] : array();
    $this->player_rewards = isset($this_playerinfo['player_rewards']) ? $this_playerinfo['player_rewards'] : array();
    $this->player_frame = isset($this_playerinfo['player_frame']) ? $this_playerinfo['player_frame'] : 'base';
    $this->player_frame_index = isset($this_playerinfo['player_frame_index']) ? $this_playerinfo['player_frame_index'] : array('base','taunt','victory','defeat','command','damage');
    $this->player_frame_offset = isset($this_playerinfo['player_frame_offset']) ? $this_playerinfo['player_frame_offset'] : array('x' => 0, 'y' => 0, 'z' => 0);
    $this->player_points = isset($this_playerinfo['player_points']) ? $this_playerinfo['player_points'] : 0;
//    if (empty($this->player_id)){
//      $this->player_id = md5(substr(md5($this->player_side), 0, 10));
//    }

    // Define the internal player base values using the players index array
    $this->player_base_name = isset($this_playerinfo['player_base_name']) ? $this_playerinfo['player_base_name'] : $this->player_name;
    $this->player_base_token = isset($this_playerinfo['player_base_token']) ? $this_playerinfo['player_base_token'] : $this->player_token;
    $this->player_base_description = isset($this_playerinfo['player_base_description']) ? $this_playerinfo['player_base_description'] : $this->player_description;
    $this->player_base_robots = isset($this_playerinfo['player_base_robots']) ? $this_playerinfo['player_base_robots'] : $this->player_robots;
    $this->player_base_quotes = isset($this_playerinfo['player_base_quotes']) ? $this_playerinfo['player_base_quotes'] : $this->player_quotes;
    $this->player_base_rewards = isset($this_playerinfo['player_base_rewards']) ? $this_playerinfo['player_base_rewards'] : $this->player_rewards;
    $this->player_base_points = isset($this_playerinfo['player_base_points']) ? $this_playerinfo['player_base_points'] : $this->player_points;

    // Count the number of robots this player has
    $num_robots = count($this->player_robots);
    // If this player has no robots, die
    if ($num_robots < 1){
      die('[class.player.php] player has no robots...<hr /><pre>$this_playerinfo = '.print_r($this_playerinfo, true).'</pre><hr /><pre>$_REQUEST = '.print_r($_REQUEST, true).'</pre>');
    }

    /*
    // Else if this player has more than eight robots on their team
    elseif ($num_robots > 8){
      $this->player_robots = array_slice($this->player_robots, 0, 8, false);
    }
    */

    // Now loop through each of the robots and expand their data
    foreach ($this->player_robots AS $this_key => $this_robotinfo){
      //$GLOBALS['DEBUG']['checkpoint_line'] = 'class.player.php : line 107 <pre>'.print_r($this->player_robots, true).'</pre>';
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

  // Define a function for generating player canvas variables
  public function canvas_markup($options){

    // Define the variable to hold the console player data
    $this_data = array();
    $this_results = !empty($options['this_ability']->ability_results) ? $options['this_ability']->ability_results : array();

    // Only proceed if this is a real player
    if ($this->player_token != 'player'){

      // Define and calculate the simpler markup and positioning variables for this player
      $this_data['player_id'] = $this->player_id;
      $this_data['player_frame'] = $this->player_frame !== false ? $this->player_frame : 'base-2';
      $this_data['player_frame'] = str_pad(array_search($this_data['player_frame'], $this->player_frame_index), 2, '0', STR_PAD_LEFT);
      $this_data['player_title'] = $this->player_name;
      $this_data['player_token'] = $this->player_token;
      $this_data['player_float'] = $this->player_side;
      $this_data['player_direction'] = $this->player_side == 'left' ? 'right' : 'left';
      $this_data['player_position'] = 'active';
      $this_data['player_size'] = 80;
      $this_data['image_type'] = !empty($options['this_player_image']) ? $options['this_player_image'] : 'sprite';
      $this_data['player_image'] = 'images/players/'.$this_data['player_token'].'/sprite_'.$this_data['player_direction'].'_'.$this_data['player_size'].'x'.$this_data['player_size'].'.png?'.$this->battle->config['CACHE_DATE'];
      $this_data['player_class'] = 'sprite sprite_player sprite_player_'.$this_data['image_type'].' sprite_80x80 sprite_80x80_'.$this_data['player_frame'];
      $this_data['player_styles'] = '';

      // Generate the final markup for the canvas player
      ob_start();

        // Display this robot's player sprite in the active position
        echo '<div class="'.$this_data['player_class'].'" style="z-index: 5100; '.$this_data['player_float'].': 90px; bottom: 60px; background-image: url('.$this_data['player_image'].');">'.$this_data['player_title'].'</div>';

      // Collect the generated player markup
      $this_data['player_markup'] = trim(ob_get_clean());

    } else {

      // Define empty player markup
      $this_data['player_markup'] = '';

    }

    // Return the player canvas data
    return $this_data;

  }

  // Define a function for generating player console variables
  public function console_markup($options){

    // Define the variable to hold the console robot data
    $this_data = array();

    // Define and calculate the simpler markup and positioning variables for this player
    $this_data['player_frame'] = !empty($this->player_frame) ? $this->player_frame : 'base';
    $this_data['player_frame'] = str_pad(array_search($this_data['player_frame'], $this->player_frame_index), 2, '0', STR_PAD_LEFT);
    $this_data['player_title'] = $this->player_name;
    $this_data['player_token'] = $this->player_token;
    $this_data['player_float'] = $this->player_side;
    $this_data['player_direction'] = $this->player_side == 'left' ? 'right' : 'left';
    $this_data['player_position'] = 'active';

    // Define the rest of the display variables
    $this_data['container_class'] = 'this_sprite sprite_'.$this_data['player_float'];
    $this_data['container_style'] = '';
    $this_data['player_class'] = 'sprite ';
    $this_data['player_style'] = '';
    $this_data['player_size'] = 40;
    $this_data['player_image'] = 'images/players/'.$this_data['player_token'].'/'.(!empty($options['this_player_image']) ? $options['this_player_image'] : 'sprite').'_'.$this_data['player_direction'].'_'.$this_data['player_size'].'x'.$this_data['player_size'].'.png?'.$this->battle->config['CACHE_DATE'];
    $this_data['player_class'] .= 'sprite_'.$this_data['player_size'].'x'.$this_data['player_size'].' sprite_'.$this_data['player_size'].'x'.$this_data['player_size'].'_'.$this_data['player_frame'].' ';
    $this_data['player_class'] .= 'player_position_'.$this_data['player_position'].' ';
    $this_data['player_style'] .= 'background-image: url('.$this_data['player_image'].'); ';

    // Generate the final markup for the console player
    $this_data['player_markup'] = '';
    $this_data['player_markup'] .= '<div class="'.$this_data['container_class'].'" style="'.$this_data['container_style'].'">';
    $this_data['player_markup'] .= '<div class="'.$this_data['player_class'].'" style="'.$this_data['player_style'].'" title="'.$this_data['player_title'].'">'.$this_data['player_title'].'</div>';
    $this_data['player_markup'] .= '</div>';

    // Return the player console data
    return $this_data;

  }

  // Define a public function updating internal varibales
  public function update_variables(){

    // Update parent objects first
    //$this->battle->update_variables();

    // Create the flag variables if they don't exist

    // Create the counter variables and defeault to zero
    $this->counters['robots_total'] = 0;
    $this->counters['robots_active'] = 0;
    $this->counters['robots_disabled'] = 0;
    $this->counters['robots_positions'] = array(
      'active' => 0,
      'bench' => 0
      );

    // Create the value variables and default to empty
    $this->values['robots_active'] = array();
    $this->values['robots_disabled'] = array();
    $this->values['robots_positions'] = array(
      'active' => array(),
      'bench' => array()
      );

    // Ensure this player has robots to loop over
    if (!empty($this->player_robots)){

      // Loop through each of the player's robots and check status
      foreach ($this->player_robots AS $this_key => $this_robotinfo){
        // Ensure a token an idea are provided at least
        if (empty($this_robotinfo['robot_id']) || empty($this_robotinfo['robot_token'])){ continue; }
        // Define the current temp robot object using the loaded robot data
        $temp_robot = new mmrpg_robot($this->battle, $this, $this_robotinfo);
        // Check if this robot is in active status
        if ($temp_robot->robot_status == 'active'){
          // Increment the active robot counter
          $this->counters['robots_active']++;
          // Add this robot to the active robots array
          $this->values['robots_active'][] = &$this->player_robots[$this_key]; //$this_info;
          // Check if this robot is in the active position
          if ($temp_robot->robot_position == 'active'){
            // Increment the active robot counter
            $this->counters['robots_positions']['active']++;
            // Add this robot to the active robots array
            $this->values['robots_positions']['active'][] = &$this->player_robots[$this_key]; //$this_info;
          }
          // Otherwise, if this robot is in benched position
          elseif ($temp_robot->robot_position == 'bench'){
            // Increment the bench robot counter
            $this->counters['robots_positions']['bench']++;
            // Add this robot to the bench robots array
            $this->values['robots_positions']['bench'][] = &$this->player_robots[$this_key]; //$this_info;
          }
        }
        // Otherwise, if this robot is in disabled status
        elseif ($temp_robot->robot_status == 'disabled'){
          // Increment the disabled robot counter
          $this->counters['robots_disabled']++;
          // Add this robot to the disabled robots array
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

  // Define a public, static function for resetting player values to base
  public static function reset_variables($this_data){
    $this_data['player_flags'] = array();
    $this_data['player_counters'] = array();
    $this_data['player_values'] = array();
    $this_data['player_history'] = array();
    $this_data['player_name'] = $this_data['player_base_name'];
    $this_data['player_token'] = $this_data['player_base_token'];
    $this_data['player_description'] = $this_data['player_base_description'];
    $this_data['player_robots'] = $this_data['player_base_robots'];
    $this_data['player_quotes'] = $this_data['player_base_quotes'];
    return $this_data;
  }

  // Define a public function for updating this player's session
  public function update_session(){

    // Update any internal counters
    $this->update_variables();

    // Request parent battle object to update as well
    //$this->battle->update_session();

    // Update the session with the export array
    $this_data = $this->export_array();
    $_SESSION['RPG2k12-2']['PLAYERS'][$this->battle->battle_id][$this->player_id] = $this_data;
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
      'player_quotes' => $this->player_quotes,
      'player_rewards' => $this->player_rewards,
      'player_points' => $this->player_points,
      'player_base_name' => $this->player_base_name,
      'player_base_token' => $this->player_base_token,
      'player_base_description' => $this->player_base_description,
      'player_base_robots' => $this->player_base_robots,
      'player_base_quotes' => $this->player_base_quotes,
      'player_base_rewards' => $this->player_base_rewards,
      'player_base_points' => $this->player_base_points,
      'player_side' => $this->player_side,
      'player_autopilot' => $this->player_autopilot,
      'player_frame' => $this->player_frame,
      'player_frame_index' => $this->player_frame_index,
      'player_frame_offset' => $this->player_frame_offset
      );

  }

}
?>