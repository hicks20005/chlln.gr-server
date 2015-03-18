<?
if (!defined("ENGINE")) exit;

$method = $_GET['method'];
$output = array();

if ($method == "LeaveComment") {
	$hash = $_POST['Hash'];
	$post_id = $_POST['ID'];
	$text = $_POST['Text'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$user_id = $row->id;
	
	$query = "INSERT INTO comments (postid, userid, text) VALUES ($post_id, $user_id, '$text')";
	$result = mysql_query($query);
	
	$output['result'] = "success";

	echo json_encode($output);
}

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
		$n++;
	}
	
	$output['result'] = "success";
	echo json_encode($output);
}
?>