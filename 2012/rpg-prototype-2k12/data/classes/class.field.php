<?
// Define a class for the fields
class mmrpg_field {

  // Define global class variables
  private $index;
  public $flags;
  public $counters;
  public $values;
  public $history;

  // Define the constructor class
  public function mmrpg_field(){

    // Define the internal index pointer
    $this->index = &$GLOBALS['mmrpg_index'];

    // Collect any provided arguments
    $args = func_get_args();

    // Define the internal battle pointer
    $this->battle = isset($args[0]) ? $args[0] : array();
    $this->battle_id = $this->battle->battle_id;
    $this->battle_token = $this->battle->battle_token;

    // Collect current field data from the function if available
    $this_fieldinfo = isset($args[1]) ? $args[1] : array('field_id' => 0, 'field_token' => 'field');

    // Now load the field data from the session or index
    $this->field_load($this_fieldinfo);

    // Return true on success
    return true;

  }

  // Define a public function for manually loading data
  public function field_load($this_fieldinfo){

    // Collect current field data from the session if available
    $this_fieldinfo_backup = $this_fieldinfo;
    if (isset($_SESSION['RPG2k12']['FIELDS'][$this->battle->battle_id][$this_fieldinfo['field_id']])){
      $this_fieldinfo = $_SESSION['RPG2k12']['FIELDS'][$this->battle->battle_id][$this_fieldinfo['field_id']];
    }
    // Otherwise, collect field data from the index
    else {
      $this_fieldinfo = $this->index['fields'][$this_fieldinfo['field_token']];
    }
    $this_fieldinfo = array_merge($this_fieldinfo, $this_fieldinfo_backup);

    // Define the internal field values using the collected array
    $this->flags = isset($this_fieldinfo['flags']) ? $this_fieldinfo['flags'] : array();
    $this->counters = isset($this_fieldinfo['counters']) ? $this_fieldinfo['counters'] : array();
    $this->values = isset($this_fieldinfo['values']) ? $this_fieldinfo['values'] : array();
    $this->history = isset($this_fieldinfo['history']) ? $this_fieldinfo['history'] : array();
    $this->field_id = isset($this_fieldinfo['field_id']) ? $this_fieldinfo['field_id'] : 0;
    $this->field_name = isset($this_fieldinfo['field_name']) ? $this_fieldinfo['field_name'] : 'Field';
    $this->field_token = isset($this_fieldinfo['field_token']) ? $this_fieldinfo['field_token'] : 'field';
    $this->field_type = isset($this_fieldinfo['field_type']) ? $this_fieldinfo['field_type'] : '';
    $this->field_description = isset($this_fieldinfo['field_description']) ? $this_fieldinfo['field_description'] : '';
    $this->field_background = isset($this_fieldinfo['field_background']) ? $this_fieldinfo['field_background'] : 'field';
    $this->field_foreground = isset($this_fieldinfo['field_foreground']) ? $this_fieldinfo['field_foreground'] : 'field';

    // Define the internal field base values using the fields index array
    $this->field_base_name = isset($this_fieldinfo['field_base_name']) ? $this_fieldinfo['field_base_name'] : $this->field_name;
    $this->field_base_token = isset($this_fieldinfo['field_base_token']) ? $this_fieldinfo['field_base_token'] : $this->field_token;
    $this->field_base_type = isset($this_fieldinfo['field_base_type']) ? $this_fieldinfo['field_base_type'] : $this->field_type;
    $this->field_base_description = isset($this_fieldinfo['field_base_description']) ? $this_fieldinfo['field_base_description'] : $this->field_description;
    $this->field_base_background = isset($this_fieldinfo['field_base_background']) ? $this_fieldinfo['field_base_background'] : $this->field_background;
    $this->field_base_foreground = isset($this_fieldinfo['field_base_foreground']) ? $this_fieldinfo['field_base_foreground'] : $this->field_foreground;

    // Update the session variable
    $this->update_session();

    // Return true on success
    return true;

  }

  // Define public print functions for markup generation
  public function print_field_name(){ return '<span class="field_name">'.$this->field_name.'</span>'; }
  public function print_field_token(){ return '<span class="field_token">'.$this->field_token.'</span>'; }
  public function print_field_type(){ return '<span class="field_token">'.$this->field_type.'</span>'; }
  public function print_field_description(){ return '<span class="field_description">'.$this->field_description.'</span>'; }
  public function print_field_background(){ return '<span class="field_background">'.$this->field_background.'</span>'; }
  public function print_field_foreground(){ return '<span class="field_foreground">'.$this->field_foreground.'</span>'; }

  // Define a public function updating internal variables
  public function update_variables(){

    // Update parent objects first
    //$this->battle->update_variables();

    // Return true on success
    return true;

  }

  // Define a public function for updating this field's session
  public function update_session(){

    // Update any internal counters
    $this->update_variables();

    // Request parent battle object to update as well
    //$this->battle->update_session();

    // Update the session with the export array
    $this_data = $this->export_array();
    $_SESSION['RPG2k12']['FIELDS'][$this->battle->battle_id][$this->field_id] = $this_data;
    $this->battle->battle_field = &$this;  //new mmrpg_field($this->battle, $this->export_array());

    // Return true on success
    return true;

  }

  // Define a function for exporting the current data
  public function export_array(){

    // Return all internal field fields in array format
    return array(
      'flags' => $this->flags,
      'counters' => $this->counters,
      'values' => $this->values,
      'history' => $this->history,
      'battle_id' => $this->battle_id,
      'battle_token' => $this->battle_token,
      'field_id' => $this->field_id,
      'field_name' => $this->field_name,
      'field_token' => $this->field_token,
      'field_type' => $this->field_type,
      'field_description' => $this->field_description,
      'field_background' => $this->field_background,
      'field_foreground' => $this->field_foreground,
      'field_base_name' => $this->field_base_name,
      'field_base_token' => $this->field_base_token,
      'field_base_type' => $this->field_base_type,
      'field_base_description' => $this->field_base_description,
      'field_base_background' => $this->field_base_background,
      'field_base_foreground' => $this->field_base_foreground
      );

  }

}
?>