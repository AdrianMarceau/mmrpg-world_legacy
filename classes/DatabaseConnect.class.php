<?php

// Define the DatabaseConnect() class
class DatabaseConnect {

    // Define the private class variables
    private $link = false;
    private $connect = true;
    private $cache = array();
    private $result;
    private $index;
    private $debug;

    // Define the private config variables
    private $db_host;
    private $db_name;
    private $db_username;
    private $db_password;
    private $db_charset;

    // Define public environment variables
    public $is_live;
    public $is_admin;
    public $is_debug;


    /*
     * CONSTRUCTOR
     */

    // Define the constructor for the class
    public function __construct($config){

        // Collect the config arguments in provided format
        if (empty($config) || !is_array($config)){
            $config = func_get_args();
            if (empty($config) || !is_array($config)){
                $config = array();
            }
        }

        // Collect any of the db config variables
        $this->db_host = isset($config['db_host']) ? $config['db_host'] : (isset($config[0]) ? $config[0] : 'localhost');
        $this->db_name = isset($config['db_name']) ? $config['db_name'] : (isset($config[1]) ? $config[1] : '');
        $this->db_username = isset($config['db_username']) ? $config['db_username'] : (isset($config[2]) ? $config[2] : 'root');
        $this->db_password = isset($config['db_password']) ? $config['db_password'] : (isset($config[3]) ? $config[3] : '');
        $this->db_charset = isset($config['db_charset']) ? $config['db_charset'] : (isset($config[4]) ? $config[4] : 'utf8');

        // Collect any of the environment config variables
        $this->is_live = isset($config['is_live']) ? $config['is_live'] : (isset($config[5]) ? $config[5] : true);
        $this->is_admin = isset($config['is_admin']) ? $config['is_admin'] : (isset($config[6]) ? $config[6] : false);
        $this->is_debug = isset($config['is_debug']) ? $config['is_debug'] : (isset($config[7]) ? $config[7] : false);

        // First initialize the database connection
        $this->connect = $this->openConnection();
        if ($this->connect === false){ $this->connect = false; return $this->connect; }

        // Set the names and character set
        $this->connect = $this->queryDatabase("SET NAMES {$this->db_charset};");
        if ($this->connect === false){ $this->connect = false; return $this->connect; }

        // Clear any links or whatever this function does not
        $this->connect = $this->clearResult();
        if ($this->connect === false){ $this->connect = false; return $this->connect; }

    }

    // Define the constructor for the class
    public function __destruct(){

        // Empty the database cache
        $this->cache = array();

        // Clear any current links
        $this->clearResult();

        // Close the database connection
        $this->closeConnection();

    }


    /**
     * Request a reference to the current database object
     * @return DatabaseConnect
     */
    public static function getDatabase(){

        // Collect DB from session if exists
        if (isset($GLOBALS['db'])){ $db = $GLOBALS['db'];  }
        elseif (isset($GLOBALS['DB'])){ $db = $GLOBALS['DB'];  }
        else { $db = false; }

        // Return the DB object with final value
        return $db;

    }


    /*
     * CONNECT / DISCONNECT FUNCTIONS
     */

    // Define the error handler for when the database goes bye bye
    private function criticalError($message){

        // Show the critical error if local, otherwise send to error log if live
        if (!$this->is_live){
            echo('<pre style="display: block; clear: both; float: none; background-color: #f2f2f2; color: #292929; text-shadow: 0 0 0 transparent; white-space: normal; padding: 10px; text-align: left;">'.$message.'</pre>');
        } else {
            error_log($message);
        }

    }

    // Define the private function for initializing the database connection
    private function openConnection(){

        // Clear any leftover data
        $this->clearResult();

        // Attempt to open the connection to the MySQL database
        if (!isset($this->link) || $this->link === false){ $this->link = new mysqli($this->db_host, $this->db_username, $this->db_password, $this->db_name);    }

        // If the connection was not successful, return false
        if ($this->link === false){
            if ($this->is_live && !$this->is_admin){ $this->criticalError("<strong>DatabaseConnect::openConnection</strong> : Critical error! Unable to connect to the database &lt;".("{$this->db_username}:******@")."{$this->db_host}&gt;!<br />[MySQL Error ".mysqli_errno($this->link)."] : &quot;".htmlentities(mysqli_error($this->link), ENT_QUOTES, 'UTF-8', true)."&quot;"); }
            else { $this->criticalError("<strong>DatabaseConnect::openConnection</strong> : Critical error! Unable to connect to the database &lt;".("{$this->db_username}:{$this->db_password}@")."{$this->db_host}&gt;!<br />[MySQL Error ".mysqli_errno()."] : &quot;".htmlentities(mysqli_errno($this->link), ENT_QUOTES, 'UTF-8', true)."&quot;"); }
            return false;
        }

        // Return true
        return true;

    }

    // Define the private function for closing the database connection
    private function closeConnection(){

        // Close the open connection to the database
        if (isset($this->link) && $this->link != false){ $close = mysqli_close($this->link); }
        else { $close = true; }

        // If the closing was not successful, return false
        if ($close === false){
            $this->criticalError("<strong>DatabaseConnect::closeConnection</strong> : ".
                "Critical error! Unable to close the database connection for host &lt;{$this->db_host}&gt;!<br /> ".
                "[MySQL Error ".mysqli_errno($this->link)."] : ".
                "&quot;".mysqli_errno($this->link)."&quot;"
                );
            return false;
        }

        // Return true
        return true;
    }

    // Define the private function for selecting the database
    private function selectDatabase(){

        // Attempt to select the database by name
        $select = mysqli_select_db($this->link, $this->db_name);

        // If the select was not successful, return false
        if ($select === false){
            $this->criticalError("<strong>DatabaseConnect::selectDatabase</strong> : ".
                "Critical error! Unable to select the database &lt;{$this->db_name}&gt;!<br /> ".
                "[MySQL Error ".mysqli_errno($this->link)."] : ".
                "&quot;".mysqli_errno($this->link)."&quot;"
                );
            return false;
        }

        // Return true
        return true;

    }

    /*
     * DATABASE QUERY FUNCTIONS
     */

    // Define the function for querying the database
    public function queryDatabase($query_string, &$affected_rows = 0){

        // Execute the query against the database
        $this->result = mysqli_query($this->link, $query_string);

        // If a result was not found, produce an error message and return false
        if ($this->result === false){

            // Find the file that called this function for debug
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            $caller2 = array_shift($bt);
            $caller['file'] = basename(dirname($caller['file'])).'/'.basename($caller['file']);
            $caller2['file'] = basename(dirname($caller2['file'])).'/'.basename($caller2['file']);
            $backtrace = "{$caller['file']}:{$caller['line']} <br /> {$caller2['file']}:{$caller2['line']}";

            // Produce a critical error with the details of this failure
            if ($this->is_debug || $this->is_admin){
                $this->criticalError("<strong>[[DatabaseConnect::queryDatabase]]</strong> : ".
                    "Unable to run the requested query. ".mysqli_errno($this->link).". ".
                    "The query was &laquo;".htmlentities(preg_replace('/\s+/', ' ', $query_string), ENT_QUOTES, 'UTF-8')."&raquo;.<br /> ".
                    "{$backtrace}"
                    );
            } else {
                $this->criticalError("<strong>[[DatabaseConnect::queryDatabase]]</strong> : ".
                    "Unable to run the requested queryDatabase. ".mysqli_errno($this->link).".<br /> ".
                    "{$backtrace}"
                    );
            }

            // Return false on failure
            return false;

        }

        // Populate the affected rows, if any
        $affected_rows = mysqli_affected_rows($this->link);

        // Return the results if there are any
        if (!empty($this->result)){

            // If this is an INSERT statement, return the new ID of the inserted row
            if (preg_match('/^INSERT INTO /i', $query_string)){
                return mysqli_insert_id($this->link);
            }
            // If this is an INSERT statement, return the number of affected row
            elseif (preg_match('/^UPDATE /i', $query_string)){
                return mysqli_affected_rows($this->link);
            }
            // If this is a SELECT statement, return the number of collected rows
            elseif (preg_match('/^SELECT /i', $query_string)){
                return mysqli_num_rows($this->result);
            }
            // Otherwise return true
            else {
                return $this->result;
            }

        } else {

            // Return false on empty return
            return false;
        }

    }

    // Define the function for clearing the results
    public function clearResult(){

        // Attempt to release the MySQL result
        if (is_resource($this->result)){
            mysqli_free_result($this->link, $this->result);
        }

        // Return true on success
        return true;

    }

    // Define a function for selecting a single row as an array
    public function getArray($query_string, $cache_results = false){

        // Ensure this is a string
        if (empty($query_string) || !is_string($query_string)) { return false; }

        // Define the md5 of this query string
        $temp_query_hash = 'getArray_'.md5(preg_replace('/\s+/', ' ', $query_string));
        $temp_query_cacheable = $cache_results ? true : false;

        // Check if there's a chached copy of this data and decode if so
        if (!empty($this->cache[$temp_query_hash])){

            // Collect and decode the results and return that
            $result_array = $this->cache[$temp_query_hash]; //json_decode($this->cache[$temp_query_hash], true);
            return $result_array;

        }

        // Run the query against the database
        $this->queryDatabase($query_string);

        // If the result is empty NULL or empty, return false
        if (!$this->result || mysqli_num_rows($this->result) < 1) { return false; }

        // Otherwise, pull an array from the result
        $result_array = mysqli_fetch_array($this->result, MYSQL_ASSOC);

        // Free the results of the query
        $this->clearResult();

        // Check to see if this is a cacheable result, and encode if so
        if ($temp_query_cacheable){

            // Serialize and cache the result before we return it
            $this->cache[$temp_query_hash] = $result_array; //json_encode($result_array);

        }

        // Now return the resulting array
        return $result_array;
    }

    // Define a function for selecting a single row as an object (converted array)
    public function getObject($query_string){

        // Ensure this is a string
        if (empty($query_string) || !is_string($query_string)) { return false; }

        // Now return the resulting array, casted as an object
        return (object)($this->getArray($query_string));

    }

    // Define a function for selecting a list of rows as arrays
    public function getArrayList($query_string, $index = false, &$record_count = 0, $cache_results = false){

        // Ensure this is a string
        if (empty($query_string) || !is_string($query_string)) { return false; }

        // Ensure the $index is a string, else set it to false
        if ($index) { $index = is_string($index) ? trim($index) : false; }

        // Define the md5 of this query string
        $temp_query_hash = 'getArrayList_'.md5(preg_replace('/\s+/', ' ', $query_string));
        $temp_query_cacheable = $cache_results ? true : false;

        // Check if there's a chached copy of this data and decode if so
        if (!empty($this->cache[$temp_query_hash])){
            // Collect and decode the results and return that
            $array_list = $this->cache[$temp_query_hash]; //json_decode($this->cache[$temp_query_hash], true);
            return $array_list;
        }

        // Run the query against the database
        $this->queryDatabase($query_string);

        // If the result is empty NULL or empty, return false
        if (!$this->result || mysqli_num_rows($this->result) < 1) { return false; }

        // Create the list array to hold all the rows
        $array_list = array();

        // Now loop through the result rows, pulling associative arrays
        while ($result_array = mysqli_fetch_array($this->result, MYSQL_ASSOC)){
            // If there was an index defined, assign the array to a specific key in the list
            if ($index) { $array_list[$result_array[$index]] = $result_array; }
            // Otherwise, append the array to the end of the list
            else { $array_list[] = $result_array; }
        }

        // Free the results of the query
        $this->clearResult();

        // Check to see if this is a cacheable result, and encode if so
        if ($temp_query_cacheable){
            // Encode and cache the result before we return it
            $this->cache[$temp_query_hash] = $array_list; //json_encode($array_list);
        }

        // Update the $record_count variable
        $record_count = is_array($array_list) ? count($array_list) : 0;

        // Now return the resulting array
        return $array_list;

    }
    // Define a function for selecting a list of rows as a objects (converted arrays)
    public function getObjectList($query_string, $index = false, &$record_count = 0){

        // Ensure this is a string
        if (empty($query_string) || !is_string($query_string)) { return false; }

        // Ensure the $index is a string, else set it to false
        if ($index) { $index = is_string($index) ? trim($index) : false; }

        // Pull the object list
        $object_list = $this->getArrayList($query_string, $index);

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
    public function getValue($query_string, $field_name = 'value', $cache_results = false){

        // Ensure this is a string
        if (empty($query_string) || !is_string($query_string)) { return false; }

        // Define the md5 of this query string
        $temp_query_hash = 'getValue_'.md5($query_string);
        $temp_query_cacheable = $cache_results ? true : false;

        // Check if there's a chached copy of this data and decode if so
        if (!empty($this->cache[$temp_query_hash])){
            // Collect and decode the results and return that
            $result_array = $this->cache[$temp_query_hash]; //json_decode($this->cache[$temp_query_hash], true);
            return $result_array;
        }

        // Run the query against the database
        $this->queryDatabase($query_string);

        // If the result is empty NULL or empty, return false
        if (!$this->result || mysqli_num_rows($this->result) < 1) { return false; }

        // Otherwise, pull an array from the result
        $result_array = mysqli_fetch_array($this->result, MYSQL_ASSOC);

        // Free the results of the query
        $this->clearResult();

        // Check to see if this is a cacheable result, and encode if so
        if ($temp_query_cacheable){
            // Encode and cache the result before we return it
            $this->cache[$temp_query_hash] = $result_array; //json_encode($result_array, true);
        }

        // Now return the resulting array
        return isset($result_array[$field_name]) ? $result_array[$field_name] : false;

    }

    // Define a function for inserting a record into the database
    public function insertRow($table_name, $insert_data){

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
            foreach ($insert_data AS $field => $value){

                // Skip fields that aren't named or have empty keys
                if (empty($field) || !is_string($field)) { continue; }

                // Otherwise, add to the insert_field and the insert_value lists
                $insert_fields[] = $field;
                $insert_values[] = "'".str_replace("'", "\'", $value)."'";

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
        $insert_query = "INSERT INTO {$table_name} {$insert_string}";

        // Execute the insert query against the database
        $affected_rows = 0;
        $this->queryDatabase($insert_query, $affected_rows);

        // If success, return the affected number of rows
        if ($this->result !== false){ $this->clearResult(); return $affected_rows; }
        else { $this->clearResult(); return false; }

    }

    // Define a function for updating a record in the database
    public function updateRows($table_name, $update_data, $condition_data){

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
            $find = "'"; $replace = "\'";
            foreach ($update_data AS $field => $value){

                // Skip fields that aren't named or have empty keys
                if (empty($field) || !is_string($field)) { continue; }

                // Otherwise, add to the update_blocks list
                $update_blocks[] = "$field = '".str_replace($find, $replace, $value)."'";

                }

            // Clear the update data to free memory
            unset($update_data, $field, $value);

            // Implode into an update string
            $update_string = implode(', ', $update_blocks);
            unset($update_blocks);

            }
        // Else, if the $update_data is a string
        elseif (is_string($update_data)){

            // Add this preformatted value to the update string
            $update_string = $update_data;

            // Clear the update data to free memory
            unset($update_data);

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
                $condition_blocks[] = "$field = '".str_replace("'", "\'", $value)."'";

                }

            // Clear the condition data to free memory
            unset($condition_data, $field, $value);

            // Implode into an condition string
            $condition_string = implode(' AND ', $condition_blocks);
            unset($condition_blocks);

            }
        elseif (is_string($condition_data)){

            // Add this preformatted value to the condition string
            $condition_string = $condition_data;

            // Clear the condition data to free memory
            unset($condition_data);

            }

        // Now put together the update query to run against the database
        $update_query = "UPDATE {$table_name} SET {$update_string} WHERE {$condition_string}";
        unset($update_string, $condition_string);

        // Execute the update query against the database
        $affected_rows = 0;
        $this->queryDatabase($update_query, $affected_rows);

        // If success, return the affected number of rows
        if ($this->result !== false){ $this->clearResult(); return $affected_rows; }
        else { $this->clearResult(); return false; }

    }

    // Define a function for deleting a record (or records) from the database
    public function deleteRows($table_name, $condition_data){

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
                $condition_blocks[] = "$field = '".str_replace("'", "\'", $value)."'";

            }

            // Implode into an condition string
            $condition_string = implode(' AND ', $condition_blocks);

        }
        elseif (is_string($condition_data)){

            // Add this preformatted value to the condition string
            $condition_string = $condition_data;

        }

        // Now put together the delete query to run against the database
        $delete_query = "DELETE FROM {$table_name} WHERE {$condition_string}";

        // Execute the delete query against the database
        $affected_rows = 0;
        $this->queryDatabase($delete_query, $affected_rows);

        // If success, return the affected number of rows
        if ($this->result !== false){ $this->clearResult(); return $affected_rows; }
        else { $this->clearResult(); return false; }

    }

    // Define a function for pulling the list of database tables
    public function getTableList(){

        // Run the SHOW TABLES query against the database
        $this->queryDatabase("SHOW TABLES");

        // If the result is empty NULL or empty, return false
        if (!$this->result || mysqli_num_rows($this->link, $this->result) < 1) { return false; }

        // Create the array to hold all table names
        $all_tables = array();

        // Loop through the result and add the names to the array
        while ($row = mysqli_fetch_row($this->link, $this->result)){
            if (!isset($row[0]) || empty($row[0])){ continue; }
            $all_tables[] = $row[0];
        }

        // Free the results of the query
        $this->clearResult();

        // Now return the resulting array of table names
        return $all_tables;


    }

    // Define a function for checking if a database table exists
    public function getTableExists($table_name){

        // First collect all tables from the database into an array
        $all_tables = $this->getTableList();

        // Return true
        return in_array($table_name, $all_tables);

    }

    // Define a function for collection the maximum field value of a given table
    public function getMaxValue($table_name, $field_name, $condition_data = false){

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
                $condition_blocks[] = "$field = '".str_replace("'", "\'", $value)."'";
            }

            // Implode into an condition string
            $condition_string = "WHERE ".implode(' AND ', $condition_blocks);

        }
        elseif (is_string($condition_data)){

            // Add this preformatted value to the condition string
            $condition_string = "WHERE ".$condition_data;

        }

        // Pull the max valued array from the database
        $max_array = $this->getArray("SELECT MAX({$field_name}) as max_value FROM {$table_name} {$condition_string} ORDER BY {$field_name} DESC LIMIT 1");

        // Return the value for the $max_array
        return !empty($max_array['max_value']) ? $max_array['max_value'] : 0;

    }

    // Define a function for collection the minimum field value of a given table
    public function getMinValue($table_name, $field_name, $condition_data = false){

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
                $condition_blocks[] = "$field = '".str_replace("'", "\'", $value)."'";
            }

            // Implode into an condition string
            $condition_string = "WHERE ".implode(' AND ', $condition_blocks);

        }
        elseif (is_string($condition_data)){

            // Add this preformatted value to the condition string
            $condition_string = "WHERE ".$condition_data;

        }

        // Pull the min valued array from the database
        $min_array = $this->getArray("SELECT MIN({$field_name}) as min_value FROM {$table_name} {$condition_string} ORDER BY {$field_name} ASC LIMIT 1");

        // Return the value for the $min_array
        return $min_array['min_value'];

    }

}

?>