<?
if (!defined("ENGINE")) exit;

<<<<<<< HEAD
$method = $_REQUEST['method'];
$output = array();

//++
if ($method == "LeaveComment") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$post_id = (int)$_REQUEST['ID'];
	$text = mysql_escape_string(substr($_REQUEST['Text'], 0 , 1024));
=======
$method = $_GET['method'];
$output = array();

if ($method == "LeaveComment") {
	$hash = $_POST['Hash'];
	$post_id = $_POST['ID'];
	$text = $_POST['Text'];
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
<<<<<<< HEAD
	
	$query = "INSERT INTO comments (postid, userid, text) VALUES ('$post_id', '$row->id', '$text')";
=======
	$user_id = $row->id;
	
	$query = "INSERT INTO comments (postid, userid, text) VALUES ($post_id, $user_id, '$text')";
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	$result = mysql_query($query);
	
	$output['result'] = "success";

	echo json_encode($output);
}

<<<<<<< HEAD
//++
if ($method == "GetComments") {
	$post_id = (int)$_REQUEST['ID'];
	$offset = (int)$_REQUEST['OffsetID'];
	
	$query = "SELECT id, userid, text, UNIX_TIMESTAMP(date) AS date FROM comments WHERE postid = '$post_id' ORDER BY date LIMIT $offset, 10";
	$result = mysql_query($query);
	
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT username, avatar FROM users WHERE id = '$row->userid' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		$output['data'][$n]['ID'] = "$row->id";
		$output['data'][$n]['UserID'] = "$row->userid";
		$output['data'][$n]['UserName'] = "$row1->username";
		$output['data'][$n]['Photo'] = "$row1->avatar";
		$output['data'][$n]['Text'] = "$row->text";
		$output['data'][$n]['Date'] = "$row->date";
=======
if ($method == "GetComments") {
	$n = 0;
	$post_id = $_POST['ID'];
	$offset = $_POST['OffsetID'];
	
	$query = "SELECT userid, text, UNIX_TIMESTAMP(date) AS date FROM comments WHERE postid = $post_id ORDER BY date";   /////Offset
	$result = mysql_query($query);
	while ($row = mysql_fetch_object($result)) {
		$user_id = $row->userid;
		$query1 = "SELECT username, avatar FROM users WHERE id = $user_id LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		$username = $row1->username;
		$avatar = $row1->avatar;
		$text = $row->text;
		$date = $row->date;
		
		$output['data'][$n]['UserName'] = $row1->username;
		$output['data'][$n]['Photo'] = $row1->avatar;
		$output['data'][$n]['Text'] = $text;
		$output['data'][$n]['Date'] = $date;
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
		$n++;
	}
	
	$output['result'] = "success";
	echo json_encode($output);
}
<<<<<<< HEAD

//++
if ($method == "DeleteComment") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$comment_id = (int)$_REQUEST['ID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT id FROM comments WHERE id = '$comment_id' AND userid = '$row->id' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);;
	
	if ($num_rows) {
		$query = "DELETE FROM comments WHERE id = '$comment_id' AND userid = '$row->id'";
		$result = mysql_query($query);
		$output['result'] = "success";
	} else {
		$output['result'] = "failed";
	}

	echo json_encode($output);
}
=======
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
?>