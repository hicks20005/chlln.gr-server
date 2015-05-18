<?
/*
$database_host = 'localhost';
$database_user = 'hicks';
$database_password = 'labuda73';
$database_name = 'homedb2';
*/


$database_host = 'localhost';
$database_user = 'homeuser';
$database_password = '2TT_hRNFO1yq';
$database_name = 'homedb';


$con = mysql_connect($database_host, $database_user, $database_password);
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($database_name);
?>