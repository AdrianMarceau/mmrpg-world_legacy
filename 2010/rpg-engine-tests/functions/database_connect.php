<?php
/*
 * Filename : database_connect.php
 * Title	: Function - database_connect()
 * Programmer/Designer : Ageman20XX / Adrian Marceau Created  : Nov 1, 2008
 *
 * Description:
 * This is the database_connect function.  Include and use this to make
 * queries against a mysql database.
 */

// The database_connect function
// This function is used to either execute database
// queries and get a return object, or to just execute
// and free whatever result is returned
// The database credentials of username, password, database, and host
function database_connect($querystring, $return = true)
{
  // Open the connection to the database
  @mysql_connect(DBHOST, DBUSERNAME, DBPASSWORD) or die ("Unable to connect to database!\n" . mysql_errno() . ": " . mysql_error() . "\n\n");
  // Select the appropriate database
  @mysql_select_db(DBNAME) or die ("Unable to select the damn database!\n" . mysql_errno() . ": " . mysql_error() . "\n\n");
  // Execute the desired query against the database
  $queryresult = @mysql_query($querystring) or die ("Unable to execute query!\r\n<br \>" . mysql_errno() . ": " . mysql_error() . "\r\n<br \>" . "Attempted query was : &quot;" . htmlentities($querystring) . "&quot;\r\n<br \>");
    // Close the database connection to prevent any broken databases ;)
    mysql_close() or die ("Unable to close database!\n" . mysql_errno() . ": " . mysql_error() . "\n\n");
    // Return the output, if necessary
    if ($return)
      return $queryresult;
    // Free the results of the query if not needed
    @mysql_free_result($queryresult);
}

?>
