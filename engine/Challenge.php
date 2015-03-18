<?
if (!defined("ENGINE")) exit;

$method = $_GET['method'];
$output = array();

function rand_string($nChars, array $case = array()) {
	define ("LOW", 'abcdefghijklmnopqrstuvwxyz');
	define ("UPP", 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
	define ("NUM", '1234567890');

	$nChars–;
	$symbols = array();
	if (in_array('low', $case))
	$symbols[] = LOW;
	if (in_array('upp', $case))
	$symbols[] = UPP;
	if (in_array('num', $case))
	$symbols[] = NUM;
	if (count($symbols) == 0)
	$symbols = array(LOW, UPP, NUM);

	$rand_str = "";
	for ($i = 0; $i <= $nChars; $i++) {
		$id = mt_rand(0, count($symbols) - 1);
		$source_str = $symbols[$id];
		$rand_str .= $source_str{ mt_rand(0, strlen($source_str) - 1) };
	}
	return $rand_str;
}

if ($method == "CreateChallenge") {
	$hash = $_POST['Hash'];
	$x = $_POST['X'];
	$y = $_POST['Y'];
	$size = $_POST['Size'];
	$type = $_POST['Type'];
	$title= $_POST['Title'];
	$description = $_POST['Description'];
	$latitude = $_POST['Latitude'];
	$longitude = $_POST['Longitude'];
	$category = $_POST['Category'];
	$count_videos = $_POST['Count_Videos'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	
	$query = "INSERT INTO posts (subid, userid, type, title, description, latitude, longitude, category, date, end_date) VALUES (0, $userid, $type, '$title', '$description', '$latitude', '$longitude', '$category', NOW(), NOW()+INTERVAL 14 DAY)";
	$result = mysql_query($query);
	
	$next_id = mysql_insert_id();
	
	$query = "INSERT INTO posts (subid, userid, type, title, description, latitude, longitude, category, date, end_date) VALUES ($next_id, $userid, $type, '$title', '$description', '$latitude', '$longitude', '$category', NOW(), NOW()+INTERVAL 14 DAY)";
	$result = mysql_query($query);
	
	if ($type == 1) {
		$n = 0;
		$photo = $_FILES["Photo$n"]["name"];
		$photo_ext = substr($photo, -3);
		$filename = rand_string(20).".$photo_ext";
		$uploadfile = dirname(__FILE__)."/../users/files/$filename";
		move_uploaded_file($_FILES["Photo$n"]["tmp_name"], $uploadfile);
		$challenge_file_photo = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename";

		$query = "INSERT INTO posts_files (`postid`, `order`, `filename`) VALUES ($next_id, $n, '$challenge_file_photo')";
		$result = mysql_query($query);
	} elseif ($type == 2) {
		for ($n = 0; $n < $count_videos; $n++) {
			$video = $_FILES["Video$n"]["name"];
			$video_ext = substr($video, -3);
			$filename = rand_string(20).".$video_ext";
			$uploadfile = dirname(__FILE__)."/../users/files/$filename";
			move_uploaded_file($_FILES["video$n"]["tmp_name"], $uploadfile);
			$challenge_file_video = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename";

			$query = "INSERT INTO posts_files (`postid`, `order`, `filename`) VALUES ($next_id, $n, '$challenge_file_video')";
			$result = mysql_query($query);
		}
	}
	
	$output['result'] = "success";
	$output['data']['ID'] = $next_id;

	echo json_encode($output);
}

if ($method == "CreateChallengeAnswer") {
	$hash = $_POST['Hash'];
	$challenge_id = $_POST['ID'];
	$x = $_POST['X'];
	$y = $_POST['Y'];
	$size = $_POST['Size'];
	$type = $_POST['Type'];
	$title= $_POST['Title'];
	$description = $_POST['Description'];
	$latitude = $_POST['Latitude'];
	$longitude = $_POST['Longitude'];
	$category = $_POST['Category'];
	$count_videos = $_POST['Count_Videos'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	
	$query = "INSERT INTO posts (subid, userid, type, title, description, latitude, longitude, category, date, end_date) VALUES ($challenge_id, $userid, $type, '$title', '$description', '$latitude', '$longitude', '$category', NOW(), NOW()+INTERVAL 14 DAY)";
	$result = mysql_query($query);
	$next_id = mysql_insert_id();
	
	if ($type == 1) {
		$n = 0;
		$photo = $_FILES["Photo$n"]["name"];
		$photo_ext = substr($photo, -3);
		$filename = rand_string(20).".$photo_ext";
		$uploadfile = dirname(__FILE__)."/../users/files/$filename";
		move_uploaded_file($_FILES["Photo$n"]["tmp_name"], $uploadfile);
		$challenge_file_photo = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename";

		$query = "INSERT INTO posts_files (`postid`, `order`, `filename`) VALUES ($next_id, $n, '$challenge_file_photo')";
		$result = mysql_query($query);
	} elseif ($type == 2) {
		for ($n = 0; $n < $count_videos; $n++) {
			$video = $_FILES["Video$n"]["name"];
			$video_ext = substr($video, -3);
			$filename = rand_string(20).".$video_ext";
			$uploadfile = dirname(__FILE__)."/../users/files/$filename";
			move_uploaded_file($_FILES["video$n"]["tmp_name"], $uploadfile);
			$challenge_file_video = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename";

			$query = "INSERT INTO posts_files (`postid`, `order`, `filename`) VALUES ($next_id, $n, '$challenge_file_video')";
			$result = mysql_query($query);
		}
	}
	
	$output['result'] = "success";
	$output['data']['ID'] = $next_id;

	echo json_encode($output);
}


if ($method == "ViewChallenge") {
	$hash = $_POST['Hash'];
	$latitude = $_POST['Latitude'];
	$longitude = $_POST['Longitude'];
	$offset = $_POST['OffsetID'];
	$category = $_POST['Category'];
	$search_category = $_POST['Search_Category'];
	$user_id = $_POST['UserID'];
	$id = $_POST['ID'];
	$n = 0;
	$wtf = 0;
	$latitude_min = $latitude - 1;
	$latitude_max = $latitude + 1;
	$longitude_min = $longitude - 1;
	$longitude_max = $longitude + 1;
	
	if ($user_id == "" AND $id == "") {
		$query = "SELECT * FROM posts ORDER BY date DESC";
		$wtf = 1;
	} else {
		$query = "SELECT * FROM posts WHERE id = '$id' OR userid = '$user_id' ORDER BY date DESC";
	}
	
	if ($category == "Own") {
		$query = "SELECT * FROM posts WHERE id = '$id'";
	}
	if ($category == "List") {
		$query = "SELECT * FROM posts WHERE subid = '$id'";
	}
	if ($search_category != "") {
		$query = "SELECT * FROM posts WHERE category LIKE '$search_category%' OR description LIKE '$search_category%' OR title LIKE '$search_category%'";
	}

	////////////////////////////
	if ($category == "Activity") { //prosto vse
		$query = "SELECT * FROM posts";
		$wtf = 1;
	}
	
	if ($category == "New") { //poslednie 24 chasa. posledniy v tope; tolko challenge
		$query = "SELECT * FROM posts WHERE subid != 0 ORDER BY date DESC";
	}
	
	if ($category == "Trending") { // likes. ot bolshego; tolko challenge
		$query = "SELECT * FROM posts WHERE subid != 0";
	}
	
	if ($category == "Nearby") { // 10km x-y; challenge and reply
		$query = "SELECT * FROM posts WHERE (latitude < $latitude_max OR latitude > $latitude_min) AND (longitude < $longitude_max OR longitude > $longitude_min)";
		$wtf = 1;
	}
	
	if ($category == "Favorite") {	//dobavlenniy v izbrannoe; challenge and reply
		$query33 = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
		$result33 = mysql_query($query33);
		$row33 = mysql_fetch_object($result33);
		$userid = $row33->id;
		
		$query = "SELECT * FROM posts";
		$wtf = 1;
	}
	////////////////////
	
	$result = mysql_query($query);
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT * FROM users WHERE id = '$row->userid' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		if ($wtf) {
			$query2 = "SELECT filename FROM posts_files WHERE postid = '$row->id' LIMIT 0, 1";
		} else {
			$query2 = "SELECT * FROM posts_files WHERE postid = '$id' LIMIT 0, 1";
		}
		$result2 = mysql_query($query2);
		$row2 = mysql_fetch_object($result2);
		
		$query3 = "SELECT * FROM likes WHERE user_id = '$row1->id' AND post_id = '$row->id' LIMIT 0, 1";
		$result3 = mysql_query($query3);
		$like_my = mysql_num_rows($result3);
		
		$output['data'][$n]['ID'] = $row->id;
		///////
		if (!$row->subid)
			$output['data'][$n]['Base_ID'] = $row->id;
		else 
			$output['data'][$n]['Base_ID'] = $row->subid;
		///////
		$output['data'][$n]['UserName'] = $row1->username;
		$output['data'][$n]['UserID'] = $row1->id;
		$output['data'][$n]['Photo'] = $row1->avatar;
		$output['data'][$n]['Date'] = strtotime($row->date);
		$output['data'][$n]['End_Date'] = strtotime($row->end_date);
		$output['data'][$n]['Title'] = $row->title;
		$output['data'][$n]['Tag'] = $row->category;
		$output['data'][$n]['Description'] = $row->description;
		$output['data'][$n]['Like_Count'] = "0";
		$output['data'][$n]['Like_My'] = $like_my;
		$output['data'][$n]['Comments_Count'] = "0";
		$output['data'][$n]['Latitude'] = $row->latitude;
		$output['data'][$n]['Longitude'] = $row->longitude;
		$output['data'][$n]['Type'] = $row->type;
		$output['data'][$n]['URL'] = $row2->filename;
		$output['data'][$n]['Leader_Username'] = $row1->username; ////////////
		$output['data'][$n]['Leader_Photo'] = $row1->avatar; /////////////
		$n++;
	}

	$output['result'] = "success";
	echo json_encode($output);
}

if ($method == "Search_User") {
	$username = $_POST['UserName'];
	$query = "SELECT * FROM users WHERE (username LIKE '$username%') OR (firstname LIKE '$username%') OR (lastname LIKE '$username%') OR (email LIKE '$username%')";
	$result = mysql_query($query);
	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT user_id FROM follow WHERE following_id = $row->id";
		$result1 = mysql_query($query1);
		$num_rows = mysql_num_rows($result1);
		
		$output['data'][$n]['UserName'] = $row->username;
		$output['data'][$n]['Status'] = $row->status;
		$output['data'][$n]['Photo'] = $row->avatar;
		$output['data'][$n]['Level'] = $row->level;
		$output['data'][$n]['FollowedByMe'] = "$num_rows";
		$n++;
	}
	echo json_encode($output);
}

if ($method == "Search_User_FB") {
	$username = $_POST['UserName'];
	for ($n = 0; $n < sizeof($username); $n++) {
		$query_add .= " OR (fb LIKE '$username[$n]%') ";
	}
	$query = "SELECT * FROM users WHERE (1 $query_add) OR (firstname LIKE '$username%') OR (lastname LIKE '$username%') OR (email LIKE '$username%')";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$output['result'] = "success";
	$n = 0;

	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT user_id FROM follow WHERE following_id = $row->id";
		$result1 = mysql_query($query1);
		$num_rows = mysql_num_rows($result1);
		
		$output['data'][$n]['UserName'] = $row->username;
		$output['data'][$n]['Status'] = $row->status;
		$output['data'][$n]['Photo'] = $row->avatar;
		$output['data'][$n]['Level'] = $row->level;
		$output['data'][$n]['FollowedByMe'] = "$num_rows";
		$n++;
	}
	echo json_encode($output);
}

if ($method == "Search_User_TW") {
	$username = $_POST['UserName'];
	for ($n = 0; $n < sizeof($username); $n++) {
		$query_add .= " OR (tw LIKE '$username[$n]%') ";
	}
	$query = "SELECT * FROM users WHERE (1 $query_add) OR (firstname LIKE '$username%') OR (lastname LIKE '$username%') OR (email LIKE '$username%')";

	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$output['result'] = "success";
	$n = 0;
	
	while ($row = mysql_fetch_object($result)) {
			$query1 = "SELECT user_id FROM follow WHERE following_id = $row->id";
		$result1 = mysql_query($query1);
		$num_rows = mysql_num_rows($result1);
		
		$output['data'][$n]['UserName'] = $row->username;
		$output['data'][$n]['Status'] = $row->status;
		$output['data'][$n]['Photo'] = $row->avatar;
		$output['data'][$n]['Level'] = $row->level;
		$output['data'][$n]['FollowedByMe'] = "$num_rows";
		$n++;
	}
	echo json_encode($output);
}

if ($method == "Search_User_Email") {
	$username = $_POST['UserName'];
	for ($n = 0; $n < sizeof($username); $n++) {
		$query_add .= " OR (email LIKE '$username[$n]%') ";
	}
	$query = "SELECT * FROM users WHERE (1 $query_add) OR (firstname LIKE '$username%') OR (lastname LIKE '$username%')";

	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT user_id FROM follow WHERE following_id = $row->id";
		$result1 = mysql_query($query1);
		$num_rows = mysql_num_rows($result1);
		
		$output['data'][$n]['UserName'] = $row->username;
		$output['data'][$n]['Status'] = $row->status;
		$output['data'][$n]['Photo'] = $row->avatar;
		$output['data'][$n]['Level'] = $row->level;
		$output['data'][$n]['FollowedByMe'] = "$num_rows";
		$n++;
	}
	echo json_encode($output);
}

if ($method == "Leader_Board") {
	$query = "SELECT user_id FROM likes LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;

	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT user_id FROM likes WHERE user_id = $userid";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		$output['data'][$n]['UserName'] = $row1->username;
		$output['data'][$n]['Status'] = $row1->status;
		$output['data'][$n]['Photo'] = $row1->avatar;
		$output['data'][$n]['Level'] = $row1->level;
		$n++;
	}
	echo json_encode($output);
}

?>