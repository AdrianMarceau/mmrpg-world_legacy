<?

// Include the application top
require_once('_top.php');

// Collect the request type and index from the header
$this_request_type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : false;
$this_request_index = !empty($_REQUEST['index']) ? $_REQUEST['index'] : false;

// Define the necessary markup, index, and type variables
$data_markup = '';
$data_index_types = array('players', 'robots', 'abilities', 'types');
$data_index_lists = array('weaknesses', 'resistances', 'affinities', 'immunities', 'rewards');
$data_index_functions = array('actions', 'quotes');

// If this is a script type request
if ($this_request_type == 'script'){
  
  // Ensure the requested index type is in the type index
  if (in_array($this_request_index, $data_index_types)){
    
    // Define the object variable based on request
    $data_markup .= '$'.$this_request_index.' = new mmrpgIndex(false, \''.$this_request_index.'\');'."\n";
    
    //Collect all the objects from the database and generate javascript insert markup
    $this_index = $DB->get_array_list('SELECT * FROM index_'.$this_request_index.' ORDER BY id ASC');
    if (!empty($this_index)){
      foreach ($this_index AS $info){
        $insert_string = array();
        foreach ($info AS $field => $value){
          if (in_array($field, $data_index_types) || in_array($field, $data_index_lists)){ $value = '['.$value.']'; }
          elseif (in_array($field, $data_index_functions)){ $value = 'function(data){'.$value.'}'; }
          elseif (is_numeric($value)){ $value = $value; }
          else { $value = "'".str_replace("'", "\'", $value)."'"; }
          $insert_string[] = $field.':'.$value;
        }
        $insert_string = '{'.implode(',', $insert_string).'}';
        $data_markup .= '$'.$this_request_index.'.insert('.$insert_string.');'."\n";
      }
    } else {
      die(print_r($this_index, true));
    }
    
  }
  
  // Now convert the headers to that of an JS document
  $CMS->header_js();
  
}
// Else if this is a style type request
elseif ($this_request_type == 'script'){
  
  // Now convert the headers to that of an CSS document
  $CMS->header_css();
  
}

// Output the data markup to the JS document
echo $data_markup;

?>