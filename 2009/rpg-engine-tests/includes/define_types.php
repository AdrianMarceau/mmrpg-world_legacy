<?php
/*
 * Filename : define_types.php
 * Title	: Define Types
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 10, 2009
 *
 * Description:
 * This file is meant to be included before running a script.  This file is meant to be included
 * whenever robot types need to be accessed or defined.
 */

// Require the database connect function
$FUNCTIONROOT = isset($FUNCTIONROOT) ? $FUNCTIONROOT : "D:\apache2triad\htdocs\Webroots\Websites_Megaman\MMPURPG\functions\\";
$CLASSROOT = isset($CLASSROOT) ? $CLASSROOT : "D:\apache2triad\htdocs\Webroots\Websites_Megaman\MMPURPG\classes\\";
$INCLUDESROOT = isset($INCLUDESROOT) ? $INCLUDESROOT : "D:\apache2triad\htdocs\Webroots\Websites_Megaman\MMPURPG\includes\\";
require_once("{$FUNCTIONROOT}database_connect.php");

// Create the type library array
$type_library = array();
// Automatically pull info on all types from the database
$query = database_connect("SELECT * FROM robot_types ORDER BY type_id ASC");
while ($typeinfo = mysql_fetch_array($query, MYSQL_ASSOC)) {
  $type_library[$typeinfo['type_id']] = array('id' => $typeinfo['type_id'], 'code' => $typeinfo['type_code'], 'name' => $typeinfo['type_name']);
}
@mysql_free_result($query);



?>
