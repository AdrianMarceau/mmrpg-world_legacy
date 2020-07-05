<?

// -- MYSQL FALLBACKS -- //
// Define a fallback for deprecated MYSQL functions
if (!function_exists('mysql_connect')){
    $MYSQL_LINK = false;
    if (!defined('MYSQL_ASSOC')){
        define('MYSQL_ASSOC', MYSQLI_ASSOC);
    }
    function mysql_connect($DBHOST, $DBUSERNAME, $DBPASSWORD){
        global $MYSQL_LINK;
        $MYSQL_LINK = mysqli_connect($DBHOST, $DBUSERNAME, $DBPASSWORD);
        return $MYSQL_LINK;
    }
    if (!function_exists('mysql_select_db')){
        function mysql_select_db($DBNAME){
            global $MYSQL_LINK;
            return mysqli_select_db($MYSQL_LINK, $DBNAME);
        }
    }
    if (!function_exists('mysql_query')){
        function mysql_query($QUERY){
            global $MYSQL_LINK;
            return mysqli_query($MYSQL_LINK, $QUERY);
        }
    }
    if (!function_exists('mysql_close')){
        function mysql_close(){
            global $MYSQL_LINK;
            return mysqli_close($MYSQL_LINK);
        }
    }
    if (!function_exists('mysql_free_result')){
        function mysql_free_result($RESULT){
            return mysqli_free_result($RESULT);
        }
    }
    if (!function_exists('mysql_fetch_array')){
        function mysql_fetch_array($RESULT_OR_QUERY, $TYPE = MYSQLI_ASSOC){
            if (is_string($RESULT_OR_QUERY)){
                $QUERY = $RESULT_OR_QUERY;
                $RESULT = mysql_query($RESULT_OR_QUERY);
                return mysqli_fetch_array($RESULT, $TYPE);
            } else {
                $RESULT = $RESULT_OR_QUERY;
                return mysqli_fetch_array($RESULT, $TYPE);
            }
        }
    }
    if (!function_exists('mysql_affected_rows')){
        function mysql_affected_rows(){
            global $MYSQL_LINK;
            return mysqli_affected_rows($MYSQL_LINK);
        }
    }
    if (!function_exists('mysql_num_rows')){
        function mysql_num_rows($RESULT){
            return mysqli_num_rows($RESULT);
        }
    }
}

?>