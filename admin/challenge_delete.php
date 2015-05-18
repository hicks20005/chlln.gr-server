<?
include ("config.php");
$challenge_id = $_POST['challenge_id'];

$query = "SELECT group_members FROM fgp_group WHERE ID = $challenge_id LIMIT 0, 1";
$result = mysql_query($query);
$row = mysql_fetch_object($result);

$temp = explode(",", $row->group_members);
$callenge_answers_array = array();
for ($n = 0; $n < sizeof($temp); $n++) {
	$callenge_answers_array[$n] = $temp[$n];	
}
	
for ($n = 0; $n < sizeof($callenge_answers_array); $n++) {	
	$query = "DELETE FROM fgp_posts WHERE ID = $callenge_answers_array[$n]";
	$result = mysql_query($query);	
}
	
$query = "DELETE FROM fgp_group WHERE ID = $challenge_id";
$result = mysql_query($query);

header( "Refresh: 0; url=/admin/index.php" )
?>