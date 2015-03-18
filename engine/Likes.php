<?
if (!defined("ENGINE")) exit;

$method = $_GET['method'];
$output = array();

if ($method == "Like_add") {
	$hash = mysql_escape_string(substr($_POST['Hash'], 0 , 32));
	$post_id = (int)$_POST['ID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	
	$query = "INSERT INTO likes (user_id, post_id) VALUES ($userid, $post_id)";
	$result = mysql_query($query);
	
	$output['result'] = "success";
	echo json_encode($output);
}
?>