<?php
/*
 * Filename : define_abilities.php
 * Title	: Define Abilities
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : May 10, 2009
 *
 * Description:
 * This file is meant to be included before running a script.  This file is meant to be included
 * whenever robot abilities need to be accessed or defined.
 */

// Require the database connect function
$FUNCTIONROOT = isset($FUNCTIONROOT) ? $FUNCTIONROOT : "D:\apache2triad\htdocs\Webroots\Websites_Megaman\MMPURPG\functions\\";
$CLASSROOT = isset($CLASSROOT) ? $CLASSROOT : "D:\apache2triad\htdocs\Webroots\Websites_Megaman\MMPURPG\classes\\";
$INCLUDESROOT = isset($INCLUDESROOT) ? $INCLUDESROOT : "D:\apache2triad\htdocs\Webroots\Websites_Megaman\MMPURPG\includes\\";
require_once("{$FUNCTIONROOT}database_connect.php");
require_once("{$CLASSROOT}ability.class.php");

// Create the type library array
$ability_library = array();
// Automatically pull info on all types from the database
$query = database_connect("SELECT * FROM robot_abilities ORDER BY ability_id ASC");
while ($ability_array = mysql_fetch_array($query, MYSQL_ASSOC)) {
  $ability_library[$ability_array['ability_id']] = new ability($type_library, $ability_array);
}
@mysql_free_result($query);



?>
