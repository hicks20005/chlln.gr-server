<?
include ("config.php");
$challenge_id = $_POST['challenge_id'];
$challenge_answer_id = $_POST['challenge_answer_id'];

$query = "DELETE FROM fgp_posts WHERE ID = $challenge_answer_id";
$result = mysql_query($query);

header( "Refresh: 0; url=/admin/challenge_answers.php?challenge_id=$challenge_id" )
?>