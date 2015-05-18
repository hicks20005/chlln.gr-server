<?
if (!defined("ENGINE")) exit;

<<<<<<< HEAD
$method = $_REQUEST['method'];
$output = array();

//++
if ($method == "Like_add") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$post_id = (int)$_REQUEST['ID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	
	if ($num_rows AND $post_id > 0) {
		$row = mysql_fetch_object($result);
		
		$query = "SELECT id FROM posts WHERE id = '$post_id' LIMIT 0, 1";
		$result = mysql_query($query);
		$num_rows = mysql_num_rows($result);
		
		if ($num_rows) {
			$query = "SELECT id FROM likes WHERE user_id = '$row->id' AND post_id = '$post_id' LIMIT 0, 1";
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			if ($num_rows) {
				$query = "DELETE FROM likes WHERE user_id = '$row->id' AND post_id = '$post_id'";
			} else {
				$query = "INSERT INTO likes (user_id, post_id) VALUES ('$row->id', '$post_id')";
			}
			$result = mysql_query($query);
			
			$output['result'] = "success";
		} else {
			$output['result'] = "failed";
		}
	} else {
		$output['result'] = "failed";
	}
	
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	echo json_encode($output);
}
?>