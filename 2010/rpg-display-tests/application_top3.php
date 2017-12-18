<?php
/*
 * Filename : application_top3.php
 * Title	: 
 * Programmer/Designer : Ageman20XX / Adrian Marceau
 * Created  : Jul 5, 2009
 *
 * Description:
 * 
 */
// Define the CURRENTDOMAIN, ISLIVE and various ROOTS
$currentdomain = $_SERVER['HTTP_HOST'];
if (stristr($currentdomain, "localhost")) { define('CURRENTDOMAIN', 'localhost'); define('ISLIVE', false); }
elseif (stristr($currentdomain, "kratos")) { define('CURRENTDOMAIN', 'kratos'); define('ISLIVE', false); }
else { define('CURRENTDOMAIN', 'remote'); define('ISLIVE', true); }   
?>
