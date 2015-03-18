<?
if (!defined("ENGINE")) exit;

$method = $_GET['method'];
$output = array();

if ($method == "Follow_add") {
	$hash = mysql_escape_string(substr($_POST['Hash'], 0 , 32));
	$user_id = (int)$_POST['UserID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	
	$query = "SELECT user_id FROM follow WHERE following_id = $user_id";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	
	if ($num_rows) {
		$query = "DELETE FROM follow WHERE following_id = $user_id";
	} else {
		$query = "INSERT INTO follow (user_id, following_id) VALUES ($userid, $user_id)";
	}
	$result = mysql_query($query);
	
	$output['result'] = "success";
	echo json_encode($output);
}

if ($method == "Follow_remove") {
	$hash = mysql_escape_string(substr($_POST['Hash'], 0 , 32));
	$user_id = (int)$_POST['UserID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	
	$query = "DELETE FROM follow WHERE user_id = $userid";
	$result = mysql_query($query);
	
	$output['result'] = "success";
	echo json_encode($output);
}

if ($method == "Follow_get") {
	$hash = mysql_escape_string(substr($_POST['Hash'], 0 , 32));
	$user_id = (int)$_POST['UserID'];
	$type = (int)$_POST['Type'];
	
	if ($type == 1) {
		$query = "SELECT following_id FROM follow WHERE user_id = $user_id";
	} elseif ($type == 2) {
		$query = "SELECT user_id FROM follow WHERE following_id = $user_id";
	}

	$result = mysql_query($query);
	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		if ($type == 1) {
			$query1 = "SELECT * FROM users WHERE id = '$row->following_id'";
		} elseif ($type == 2) {
			$query1 = "SELECT * FROM users WHERE id = '$row->user_id'";
		}

		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		$output['data'][$n]['ID'] = $row1->id;
		$output['data'][$n]['UserName'] = $row1->username;
		$output['data'][$n]['Status'] = $row1->status;
		$output['data'][$n]['FirstName'] = $row1->firstname;
		$output['data'][$n]['LastName'] = $row1->lastname;
		$output['data'][$n]['Photo'] = $row1->avatar;
		$output['data'][$n]['Level'] = $row1->level;
		$n++;
	}
		
	echo json_encode($output);
}
?>