<?
if (!defined("ENGINE")) exit;

$method = $_REQUEST['method'];
$output = array();

//++
if ($method == "LeaveComment") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$post_id = (int)$_REQUEST['ID'];
	$text = mysql_escape_string(substr($_REQUEST['Text'], 0 , 1024));
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "INSERT INTO comments (postid, userid, text) VALUES ('$post_id', '$row->id', '$text')";
	$result = mysql_query($query);
	
	$output['result'] = "success";

	echo json_encode($output);
}

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
		$n++;
	}
	
	$output['result'] = "success";
	echo json_encode($output);
}

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
?>