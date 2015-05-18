<?
$hostdb = "chlln.clmyvd87xm6p.us-west-2.rds.amazonaws.com";
$db = "chlln";
$userdb="root";
$passdb="Xfkktyl;th_";

function connect_db($hostdb, $userdb, $passdb, $db) {
	$conn = mysql_connect($hostdb, $userdb, $passdb) or die("Cannot connect to DB");
	mysql_select_db($db) or die("No such DB");
	return $conn;
}

function disconnect_db($conn) {
	mysql_close($conn) or die("Cannot disconnect from DB");
}
?>
