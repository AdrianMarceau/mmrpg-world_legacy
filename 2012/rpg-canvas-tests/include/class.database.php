<?php
/*
 * Project   : [PlutoCMS Version 2.2.0] <plutocms.plutolighthouse.net>
 * Name      : Database Class <class.database.php>
 * Author    : Adrian Marceau <Ageman20XX>
 * Created   : February 20th, 2010
 * Modified  : December 4th, 2010
 *
 * Description:
 * This is the Database Class for the PlutoCMS framework.
 * This class allows one to connect to, query, and pull
 * data from a MySQL database as well as a plethora of
 * other useful database-related tools and functionality.
 */

// Define the plutocms_database() class
class plutocms_database {

  // Define the private variables
  private $CMS;
  private $LINK = false;
  // Define the public variables
  public $HOST;
  public $USERNAME;
  public $PASSWORD;
  public $CHARSET;
  public $NAME;
  public $TABLES;
  public $MYSQL_RESULT;
  public $OPTION_ENCODE = true;
  public $OPTION_DECODE = true;
  public $DEBUG = false;

  /*
   * CONSTRUCTOR
   */

  // Define the constructor for the class
  public function plutocms_database(){
    // Pull in a reference to the global $CMS object
    if (defined('PLUTOCMS_CORE')){ $this->CMS = &$GLOBALS[PLUTOCMS_CORE]; }
    else { $this->CMS = false; }
    // Collect the initializer arguments
    $args = func_get_args();
    // If arguments were provided, use them
    if (!empty($args)){
      // If there is only one argument and it's an array
      if (count($args) == 1 && is_array($args[0])){
      	// Use the single config array for the private database connection variables
        $config = &$args[0];
        $this->HOST = isset($config['HOST']) ? $config['HOST'] : 'localhost';
        $this->USERNAME = isset($config['USERNAME']) ? $config['USERNAME'] : 'root';
        $this->PASSWORD = isset($config['PASSWORD']) ? $config['PASSWORD'] : 'Pass1234';
        $this->CHARSET = isset($config['CHARSET']) ? $config['CHARSET'] : 'utf8';
        $this->NAME = isset($config['NAME']) ? $config['NAME'] : 'plutocms';
        $this->TABLES = isset($config['TABLES']) ? $config['TABLES'] : array();
      }
      // Otherwise, if there are multiple arguments
      elseif (count($args) > 1){
        // Define the public database connection variables one by one
        $this->HOST = isset($args[0]) ? $args[0] : 'localhost';
        $this->USERNAME = isset($args[1]) ? $args[1] : 'root';
        $this->PASSWORD = isset($args[2]) ? $args[2] : 'Pass1234';
        $this->CHARSET = isset($args[3]) ? $args[3] : 'utf8';
        $this->NAME = isset($args[4]) ? $args[4] : 'plutocms';
        $this->TABLES = isset($args[5]) ? $args[5] : array();
      }
      // Otherwise, if invalid arguments
      else{
      	// Define system defaults
        $this->HOST = 'localhost';
        $this->USERNAME = 'root';
        $this->PASSWORD = 'Pass1234';
        $this->CHARSET = 'utf8';
        $this->NAME = 'plutocms';
        $this->TABLES = array();
      }
    }
    // Otherwise, return false
    else{
    	// Return false
      return false;
    }
    // Set the names and character set
    $this->query("SET NAMES {$this->CHARSET};");
    $this->query("SET CHARACTER SET {$this->CHARSET};");
    $this->clear();
  }

  /*
   * CONNECT / DISCONNECT FUNCTIONS
   */

  // Define the private function for initializing the database connection
  private function db_connect(){
  	// Clear any leftover data
    $this->clear();
    // Attempt to open the connection to the MySQL database
    if ($this->LINK !== false){ $connect = @mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD, $this->LINK); }
    else { $connect = @mysql_connect($this->HOST, $this->USERNAME, $this->PASSWORD); }
    // If the connection was not successful, return false
    if ($connect === false){
      $error_message = "<strong>plutocms_database::db_connect</strong> : Critical error! Unable to connect to the database &lt;".($this->DEBUG ? "{$this->USERNAME}:{$this->PASSWORD}@" : '')."{$this->HOST}&gt;!<br />[MySQL Error ".mysql_errno()."] : &quot;".mysql_error()."&quot;";
      if ($this->CMS){ $this->CMS->message($error_message, PLUTOCMS_ERROR); }
      else { echo $error_message; }
      return false;
    }
    // Set the character set, if possible
    if (function_exists('mysql_set_charset')) { @mysql_set_charset($this->CHARSET); }
    else { @mysql_query("SET NAMES 'utf8'");  }
    // Return true
    return true;
  }

  // Define the private function for closing the database connection
  private function db_close(){
  	// Close the open connection to the database
    if ($this->LINK !== false){ $close = @mysql_close($this->LINK); }
  	else { $close = true; }
    // If the closing was not successful, return false
    if ($close === false){
      $error_message = "<strong>plutocms_database::db_close</strong> : Critical error! Unable to close the database connection for host &lt;{$this->HOST}&gt;!<br />[MySQL Error ".mysql_errno()."] : &quot;".mysql_error()."&quot;";
      if ($this->CMS){ $this->CMS->message($error_message, PLUTOCMS_ERROR); }
      else { echo $error_message; }
      return false;
    }
    // Return true
    return true;
  }

  // Define the private function for selecting the database
  private function db_select(){
  	// Attempt to select the database by name
    $select = @mysql_select_db($this->NAME);
    // If the select was not successful, return false
    if ($select === false){
      $error_message = "<strong>plutocms_database::db_select</strong> : Critical error! Unable to select the database &lt;{$this->NAME}&gt;!<br />[MySQL Error ".mysql_errno()."] : &quot;".mysql_error()."&quot;";
      if ($this->CMS){ $this->CMS->message($error_message, PLUTOCMS_ERROR); }
      else { echo $error_message; }
      return false;
    }
    // Return true
    return true;
  }

  // Define the public function for parsing table quick-references
  public function parse_tables($query_string){
    // If there are any table index references, parse them
    if (preg_match_all("/\s?\['([-_a-z0-9]+)'\]\s?/i", $query_string, $matches)){
      // Loop through the matches
      if (is_array($matches)):
      foreach ($matches[1] AS $key => $index){
        // If $key is zero, skip
        if ($key = 0) { continue; }
        // If the index exists, replace it and the flag characters
        if (isset($this->TABLES[$index])) { $query_string = str_replace("['{$index}']", $this->TABLES[$index], $query_string); }
        // Otherwise, simply strip the flag characters
        else { $query_string = str_replace("['{$index}']", $index, $query_string); }
      }
      endif;
    }
    // Return the $query_string
    return $query_string;
  }

  /*
   * SYSTEM FUNCTIONS
   */

  // Define a function for encoding strings to be used in database entry
  public function string_encode($input, $recursive = true){
    // Define the search & replace text
    $find_text = array("'", '"', "\r", "\n");
    $replace_text = array('[sq]', '[dq]', '[nlr]', '[nln]');
    // If this is a string, do a simple replace
    if (is_string($input)){
      // Preform a simple string replace
      $newstring = str_replace($find_text, $replace_text, $input);
      // And return the new string
      return $newstring;
    }
    // If this is an array, recursively call the this function again
    elseif ($recursive == true && is_array($input)){
      // Create a new array to hold all the new strings
      $newstringarray = array();
      // Loop through all the array values recursively
      foreach ($input AS $key => $inputnode){
        // Call this function recursively on the element
        $newstringarray[$key] = $this->string_encode($inputnode, true);
      }
      // Return the new array
      return $newstringarray;
    }
    // Otherwise, return the original object, whatever it is
    else{
      // Return the original object
      return $input;
    }
  }

  // Define a function for decoding strings pulled from a database entry
  public function string_decode($input, $recursive = true){
    // Define the search & replace text (The [amp] is for legacy support only)
    $find_text = array('[sq]', '[dq]', '[nlr]', '[nln]', '[amp]');
    $replace_text = array("'", '"', "\r", "\n", "&");
    // If this is a string, do a simple replace
    if (is_string($input)){
      // Preform a simple string replace
      $newstring = str_replace($find_text, $replace_text, $input);
      // And return the new string
      return $newstring;
    }
    // If this is an array, recursively call the this function again
    elseif ($recursive == true && is_array($input)){
      // Create a new array to hold all the new strings
      $newstringarray = array();
      // Loop through all the array values recursively
      foreach ($input AS $key => $inputnode){
        // Call this function recursively on the element
        $newstringarray[$key] = $this->string_decode($inputnode, true);
      }
      // Return the new array
      return $newstringarray;
    }
    // Otherwise, return the original object, whatever it is
    else{
      // Return the original object
      return $input;
    }
  }

  // Define a function for serializing an array, object, or other variable
  public function dbserialize($input){
    // First serialize the data for single-cell input
    $newinput = serialize($input);
    // Then encode the data with a base of 64 to avoid character-conflicts
    $newinput = base64_encode($newinput);
    // Return the new data in a string format
    return $newinput;
  }

  // Define a function for unserializing a dbserialized array, object or other variable
  public function dbunserialize($input){
    // First decode the data with the base of 64 into a serialized string
    $newinput = base64_decode($input);
    // Then unserialize the data into the original object, array, or other value
    $newinput = unserialize($newinput);
    // Return the new data in it's origin format
    return($newinput);
  }

  /*
   * DATABASE QUERY FUNCTIONS
   */

  // Define the function for querying the database
  public function query($query_string, &$affected_rows = 0){
  	// First initialize the database connection
    $this->db_connect();
    // Now select the currently active database
    $this->db_select();
    // If there are any table index references, parse them
    $query_string = $this->parse_tables($query_string);
    // Execute the query against the database
    $this->MYSQL_RESULT = @mysql_query($query_string);
    // If a result was not found, produce an error message and return false
    if ($this->MYSQL_RESULT === false){
      $error_message = "[[plutocms_database::query]] : Unable to run the requested query. ".@mysql_error().". The query was &quot;<<".htmlentities($query_string, ENT_QUOTES, 'UTF-8').">>&quot;.";
      if ($this->CMS){ $this->CMS->message($error_message, PLUTOCMS_ERROR);  }
      else { echo $error_message; }
      return false;
    }
    // Populate the affected rows, if any
    $affected_rows = @mysql_affected_rows();
    // Close the database connection
    $this->db_close();
    // Return the results
    return $this->MYSQL_RESULT;
  }

  // Define the function for clearing the results
  public function clear(){
  	// Attempt to release the MySQL result
  	if (is_resource($this->MYSQL_RESULT)){
  	  @mysql_free_result($this->MYSQL_RESULT);
  	}
    // Return true
    return true;
  }

  // Define a function for selecting a single row as an array
  public function get_array($query_string){
  	// Ensure this is a string
    if (empty($query_string) || !is_string($query_string)) { return false; }
    // Run the query against the database
    $this->query($query_string);
    // If the result is empty NULL or empty, return false
    if (!$this->MYSQL_RESULT || @mysql_num_rows($this->MYSQL_RESULT) < 1) { return false; }
    // Otherwise, pull an array from the result
    $result_array = @mysql_fetch_array($this->MYSQL_RESULT, MYSQL_ASSOC);
    // If decoding is ON, decode the result array's contents
    if ($this->OPTION_DECODE == true) { $result_array = $this->string_decode($result_array); }
    // Free the results of the query
    $this->clear();
    // Now return the resulting array
    return $result_array;
  }
  // Define a function for selecting a single row as an object (converted array)
  public function get_object($query_string){
    // Ensure this is a string
    if (empty($query_string) || !is_string($query_string)) { return false; }
    // Now return the resulting array, casted as an object
    return (object)($this->get_array($query_string));
  }

  // Define a function for selecting a list of rows as arrays
  public function get_array_list($query_string, $index = false, &$record_count = 0){
    // Ensure this is a string
    if (empty($query_string) || !is_string($query_string)) { return false; }
    // Ensure the $index is a string, else set it to false
    if ($index) { $index = is_string($index) ? trim($index) : false; }
    // Run the query against the database
    $this->query($query_string);
    // If the result is empty NULL or empty, return false
    if (!$this->MYSQL_RESULT || @mysql_num_rows($this->MYSQL_RESULT) < 1) { return false; }
    // Create the list array to hold all the rows
    $array_list = array();
    // Now loop through the result rows, pulling associative arrays
    while ($result_array = @mysql_fetch_array($this->MYSQL_RESULT, MYSQL_ASSOC)){
      // If decoding is ON, decode the result array's contents
      if ($this->OPTION_DECODE == true) { $result_array = $this->string_decode($result_array); }
      // If there was an index defined, assign the array to a specific key in the list
      if ($index) { $array_list[$result_array[$index]] = $result_array; }
      // Otherwise, append the array to the end of the list
      else { $array_list[] = $result_array; }
    }
    // Free the results of the query
    $this->clear();
    // Update the $record_count variable
    $record_count = is_array($array_list) ? count($array_list) : 0;
    // Now return the resulting array
    return $array_list;
  }
  // Define a function for selecting a list of rows as a objects (converted arrays)
  public function get_object_list($query_string, $index = false, &$record_count = 0){
    // Ensure this is a string
    if (empty($query_string) || !is_string($query_string)) { return false; }
    // Ensure the $index is a string, else set it to false
    if ($index) { $index = is_string($index) ? trim($index) : false; }
    // Pull the object list
    $object_list = $this->get_array_list($query_string, $index);
    // Loop through and convert all arrays to objects
    if (is_array($object_list)){
    	foreach ($object_list AS $key => $array){
    		$object_list[$key] = (object)($array);
    	}
    }
    // Update the $record_count variable
    $record_count = is_array($object_list) ? count($object_list) : 0;
    // Now return the resulting object list, casted from arrays
    return $object_list;
  }
  // Define a function for pulling a single value from a database
  public function get_value($query_string, $field_name = 'value'){
    // Ensure this is a string
    if (empty($query_string) || !is_string($query_string)) { return false; }
    // Run the query against the database
    $this->query($query_string);
    // If the result is empty NULL or empty, return false
    if (!$this->MYSQL_RESULT || @mysql_num_rows($this->MYSQL_RESULT) < 1) { return false; }
    // Otherwise, pull an array from the result
    $result_array = @mysql_fetch_array($this->MYSQL_RESULT, MYSQL_ASSOC);
    // If decoding is ON, decode the result array's contents
    if ($this->OPTION_DECODE == true) { $result_array = $this->string_decode($result_array); }
    // Free the results of the query
    $this->clear();
    // Now return the resulting array
    return isset($result_array[$field_name]) ? $result_array[$field_name] : false;
  }

  // Define a function for inserting a record into the database
  public function insert($table_name, $insert_data){
    // Ensure proper data types have been received
    if (empty($table_name) || !is_string($table_name)) { return false; }
    if (empty($insert_data) || (!is_array($insert_data) && !is_string($insert_data))) { return false; }
    // Create the $insert_fields and $insert_values arrays
    $insert_fields = array();
    $insert_values = array();
    // Initialize in insert string
    $insert_string = '';
    // If the insert_data was an array
    if (is_array($insert_data)){
      // Loop through the $insert_data array and separate the keys/values
      foreach ($insert_data AS $field => $value)
      {
        // Skip fields that aren't named or have empty keys
        if (empty($field) || !is_string($field)) { continue; }
        // Otherwise, add to the insert_field and the insert_value lists
        $insert_fields[] = $field;
        $insert_values[] = "'".($this->OPTION_ENCODE == true ? $this->string_encode($value) : $value)."'";
      }
      // Implode into an the insert strings
      $insert_string = "(".implode(', ', $insert_fields).") VALUES (".implode(', ', $insert_values).")";
    }
    // Else, if the $insert_data is a string
    elseif (is_string($insert_data)){
    	// Add this preformatted value to the insert string
      $insert_string = $insert_data;
    }
    // Create the insert query to run against the database
    $insert_query = "INSERT INTO ['{$table_name}'] {$insert_string}";
    // Execute the insert query against the database
    $affected_rows = 0;
    $this->query($insert_query, $affected_rows);
    // If success, return the affected number of rows
    if ($this->MYSQL_RESULT !== false){ $this->clear(); return $affected_rows; }
    else { $this->clear(); return false; }
  }

  // Define a function for updating a record in the database
  public function update($table_name, $update_data, $condition_data){
    // Ensure proper data types have been received
    if (empty($table_name) || !is_string($table_name)) { return false; }
    if (empty($update_data) || (!is_array($update_data) && !is_string($update_data))) { return false; }
    if (empty($condition_data) || (!is_array($condition_data) && !is_string($condition_data))) { return false; }
    // Initialize the update string
    $update_string = '';
    // If the update_data is an array object
    if (is_array($update_data)){
      // Create the update blocks array
      $update_blocks = array();
      // Loop through the $update_data array and separate the keys/values
      foreach ($update_data AS $field => $value){
        // Skip fields that aren't named or have empty keys
        if (empty($field) || !is_string($field)) { continue; }
        // Otherwise, add to the update_blocks list
        $update_blocks[] = "$field = '".($this->OPTION_ENCODE ? $this->string_encode($value) : $value)."'";
      }
      // Implode into an update string
      $update_string = implode(', ', $update_blocks);
    }
    // Else, if the $update_data is a string
    elseif (is_string($update_data)){
    	// Add this preformatted value to the update string
      $update_string = $update_data;
    }
    // Initialize the condition string
    $condition_string = '';
    // If the condition_data is an array object
    if (is_array($condition_data)){
      // Create the condition blocks array
      $condition_blocks = array();
      // Loop through the $condition_data array and separate the keys/values
      foreach ($condition_data AS $field => $value){
        // Skip fields that aren't named or have empty keys
        if (empty($field) || !is_string($field)) { continue; }
        // Otherwise, add to the condition_blocks list
        $condition_blocks[] = "$field = '".($this->OPTION_ENCODE ? $this->string_encode($value) : $value)."'";
      }
      // Implode into an condition string
      $condition_string = implode(' AND ', $condition_blocks);
    }
    elseif (is_string($condition_data)){
      // Add this preformatted value to the condition string
      $condition_string = $condition_data;
    }
    // Now put together the update query to run against the database
    $update_query = "UPDATE ['{$table_name}'] SET {$update_string} WHERE {$condition_string}";
    // Execute the update query against the database
    $affected_rows = 0;
    $this->query($update_query, $affected_rows);
    // If success, return the affected number of rows
    if ($this->MYSQL_RESULT !== false){ $this->clear(); return $affected_rows; }
    else { $this->clear(); return false; }
  }

  // Define a function for deleting a record (or records) from the database
  public function delete($table_name, $condition_data){
    // Ensure proper data types have been received
    if (empty($table_name) || !is_string($table_name)) { return false; }
    if (empty($condition_data) || (!is_array($condition_data) && !is_string($condition_data))) { return false; }
    // Initialize the condition string
    $condition_string = '';
    // If the condition_data is an array object
    if (is_array($condition_data)){
      // Create the condition blocks array
      $condition_blocks = array();
      // Loop through the $condition_data array and separate the keys/values
      foreach ($condition_data AS $field => $value){
        // Skip fields that aren't named or have empty keys
        if (empty($field) || !is_string($field)) { continue; }
        // Otherwise, add to the condition_blocks list
        $condition_blocks[] = "$field = '".($this->OPTION_ENCODE ? $this->string_encode($value) : $value)."'";
      }
      // Implode into an condition string
      $condition_string = implode(' AND ', $condition_blocks);
    }
    elseif (is_string($condition_data)){
      // Add this preformatted value to the condition string
      $condition_string = $condition_data;
    }
    // Now put together the delete query to run against the database
    $delete_query = "DELETE FROM ['{$table_name}'] WHERE {$condition_string}";
    // Execute the delete query against the database
    $affected_rows = 0;
    $this->query($delete_query, $affected_rows);
    // If success, return the affected number of rows
    if ($this->MYSQL_RESULT !== false){ $this->clear(); return $affected_rows; }
    else { $this->clear(); return false; }
  }

  // Define a function for pulling the list of database tables
  public function table_list(){
    // Run the SHOW TABLES query against the database
    $this->query("SHOW TABLES");
    // If the result is empty NULL or empty, return false
    if (!$this->MYSQL_RESULT || @mysql_num_rows($this->MYSQL_RESULT) < 1) { return false; }
    // Create the array to hold all table names
    $all_tables = array();
    // Loop through the result and add the names to the array
    while ($row = @mysql_fetch_row($this->MYSQL_RESULT)){
      if (!isset($row[0]) || empty($row[0])){ continue; }
      $all_tables[] = $row[0];
    }
    // Free the results of the query
    $this->clear();
    // Now return the resulting array of table names
    return $all_tables;

  }

  // Define a function for checking if a database table exists
  public function table_exists($table_name){
    // If this table name exists in the index, pull it
    $table_name = isset($this->TABLES[$table_name]) ? $this->TABLES[$table_name] : $table_name;
    // First collect all tables from the database into an array
    $all_tables = $this->table_list();
    // Return true
    return in_array($table_name, $all_tables);
  }

  // Define a function for collection the maximum field value of a given table
  public function max_value($table_name, $field_name, $condition_data = false){
    // Ensure proper data types have been received
    if (empty($table_name) || !is_string($table_name)) { return false; }
    if (empty($field_name) || !is_string($field_name)) { return false; }
    if ($condition_data != false && (!is_array($condition_data) && !is_string($condition_data))) { return false; }
    // Initialize the condition string
    $condition_string = '';
    // If the condition_data is an array object
    if (is_array($condition_data)){
      // Create the condition blocks array
      $condition_blocks = array();
      // Loop through the $condition_data array and separate the keys/values
      foreach ($condition_data AS $field => $value){
        // Skip fields that aren't named or have empty keys
        if (empty($field) || !is_string($field)) { continue; }
        // Otherwise, add to the condition_blocks list
        $condition_blocks[] = "$field = '".($this->OPTION_ENCODE ? $this->string_encode($value) : $value)."'";
      }
      // Implode into an condition string
      $condition_string = "WHERE ".implode(' AND ', $condition_blocks);
    }
    elseif (is_string($condition_data)){
      // Add this preformatted value to the condition string
      $condition_string = "WHERE ".$condition_data;
    }
    // Pull the max valued array from the database
    $max_array = $this->get_array("SELECT MAX({$field_name}) as max_value FROM ['{$table_name}'] {$condition_string} ORDER BY {$field_name} DESC LIMIT 1");
    // Return the value for the $max_array
    return !empty($max_array['max_value']) ? $max_array['max_value'] : 0;
  }

  // Define a function for collection the minimum field value of a given table
  public function min_value($table_name, $field_name, $condition_data = false){
    // Ensure proper data types have been received
    if (empty($table_name) || !is_string($table_name)) { return false; }
    if (empty($field_name) || !is_string($field_name)) { return false; }
    if ($condition_data != false && (!is_array($condition_data) && !is_string($condition_data))) { return false; }
    // Initialize the condition string
    $condition_string = '';
    // If the condition_data is an array object
    if (is_array($condition_data)){
      // Create the condition blocks array
      $condition_blocks = array();
      // Loop through the $condition_data array and separate the keys/values
      foreach ($condition_data AS $field => $value){
        // Skip fields that aren't named or have empty keys
        if (empty($field) || !is_string($field)) { continue; }
        // Otherwise, add to the condition_blocks list
        $condition_blocks[] = "$field = '".($this->OPTION_ENCODE ? $this->string_encode($value) : $value)."'";
      }
      // Implode into an condition string
      $condition_string = "WHERE ".implode(' AND ', $condition_blocks);
    }
    elseif (is_string($condition_data)){
      // Add this preformatted value to the condition string
      $condition_string = "WHERE ".$condition_data;
    }
    // Pull the min valued array from the database
    $min_array = $this->get_array("SELECT MIN({$field_name}) as min_value FROM ['{$table_name}'] {$condition_string} ORDER BY {$field_name} ASC LIMIT 1");
    // Return the value for the $min_array
    return $min_array['min_value'];
  }

  // Define a public function for resetting the auto increment of a table
  public function reset_table($table_name, $auto_increment = false, $order_by = false){
    // Ensure proper data types have been received
    if (empty($table_name) || !is_string($table_name)) { return false; }
    if (empty($auto_increment) && empty($order_by)) { return false; }
    // Execute the alter table queries against the database and collect the successes or failures
    if (is_numeric($auto_increment)){
    	$this->query("ALTER TABLE ['{$table_name}'] AUTO_INCREMENT = {$auto_increment}");
      $success1 = $this->MYSQL_RESULT ? 1 : 0;
      $this->clear();
    }
    if (is_string($order_by)){
      $this->query("ALTER TABLE ['{$table_name}'] ORDER BY {$order_by}");
      $success2 = $this->MYSQL_RESULT ? 1 : 0;
      $this->clear();
    }
    return ($success1 + $success2);
  }

}

?>