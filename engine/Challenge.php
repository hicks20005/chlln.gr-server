<?
if (!defined("ENGINE")) exit;

<<<<<<< HEAD
$method = $_REQUEST['method'];
=======
$method = $_GET['method'];
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
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

<<<<<<< HEAD
//++
if ($method == "CreateChallenge") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$x = (int)$_REQUEST['X'];
	$y = (int)$_REQUEST['Y'];
	$size = (int)$_REQUEST['Size'];
	$type = (int)$_REQUEST['Type'];
	$title = mysql_escape_string(substr($_REQUEST['Title'], 0 , 256));
	$description = mysql_escape_string(substr($_REQUEST['Description'], 0 , 1024));
	$latitude = (float)$_REQUEST['Latitude'];
	$longitude = (float)$_REQUEST['Longitude'];
	$category = mysql_escape_string(substr($_REQUEST['Category'], 0 , 128));
	$count_videos = (int)$_REQUEST['Count_Videos'];
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
<<<<<<< HEAD
	
	$query = "INSERT INTO posts (subid, userid, type, title, description, latitude, longitude, category, date, end_date) VALUES (0, '$row->id', '$type', '$title', '$description', '$latitude', '$longitude', '$category', NOW(), NOW()+INTERVAL 1 DAY)";
	$result = mysql_query($query);
	$next_id = mysql_insert_id();
	
	$query = "INSERT INTO posts (subid, userid, type, title, description, latitude, longitude, category, date, end_date) VALUES ('$next_id', '$row->id', '$type', '$title', '', '$latitude', '$longitude', '$category', NOW(), NOW()+INTERVAL 1 DAY)";
	$result = mysql_query($query);
	$next_id2 = mysql_insert_id();
	
	if ($type == 1) {
		$photo = $_FILES["Photo0"]["name"];
		$photo_ext = explode(".", $photo);
		$photo_ext = $photo_ext[sizeof($photo_ext) - 1];
		
		$filename = rand_string(20).".$photo_ext";
		$uploadfile = dirname(__FILE__)."/../users/files/$filename";
		move_uploaded_file($_FILES["Photo0"]["tmp_name"], $uploadfile);
		$challenge_file_photo = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename";
		
		$filename2 = rand_string(20).".$photo_ext";
		$uploadfile2 = dirname(__FILE__)."/../users/files/$filename2";
		copy($uploadfile, $uploadfile2);
		$challenge_file_photo2 = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename2";
		
		$query = "UPDATE posts SET file = '$challenge_file_photo' WHERE id = '$next_id'";
		$result = mysql_query($query);
		
		$query = "UPDATE posts SET file = '$challenge_file_photo2' WHERE id = '$next_id2'";
		$result = mysql_query($query);
	} elseif ($type == 2) {
		$video = $_FILES["Video0"]["name"];
		$video_ext = explode(".", $video);
		$video_ext = $video_ext[sizeof($video_ext) - 1];
		
		$filename = rand_string(20).".$video_ext";
		$uploadfile = dirname(__FILE__)."/../users/files/$filename";
		move_uploaded_file($_FILES["Video0"]["tmp_name"], $uploadfile);
		$challenge_file_video = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename";
		
		$filename2 = rand_string(20).".$video_ext";
		$uploadfile2 = dirname(__FILE__)."/../users/files/$filename2";
		copy($uploadfile, $uploadfile2);
		$challenge_file_video2 = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename2";
		
		$query = "UPDATE posts SET file = '$challenge_file_video' WHERE id = '$next_id'";
		$result = mysql_query($query);
		
		$query = "UPDATE posts SET file = '$challenge_file_video2' WHERE id = '$next_id2'";
		$result = mysql_query($query);
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	}
	
	$output['result'] = "success";
	$output['data']['ID'] = $next_id;

	echo json_encode($output);
}

<<<<<<< HEAD
//++
if ($method == "CreateChallengeAnswer") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$challenge_id = (int)$_REQUEST['ID'];
	$x = (int)$_REQUEST['X'];
	$y = (int)$_REQUEST['Y'];
	$size = (int)$_REQUEST['Size'];
	$type = (int)$_REQUEST['Type'];
	$title = mysql_escape_string(substr($_REQUEST['Title'], 0 , 256));
	$description = mysql_escape_string(substr($_REQUEST['Description'], 0 , 1024));
	$latitude = (float)$_REQUEST['Latitude'];
	$longitude = (float)$_REQUEST['Longitude'];
	$category = mysql_escape_string(substr($_REQUEST['Category'], 0 , 128));
	$count_videos = (int)$_REQUEST['Count_Videos'];
	
	$query = "SELECT id, end_date FROM posts WHERE id = '$challenge_id' AND subid = 0 LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if ($num_rows) {
		$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
		$result = mysql_query($query);
		$row = mysql_fetch_object($result);

		$query = "INSERT INTO posts (subid, userid, type, title, description, latitude, longitude, category, date, end_date) VALUES ('$challenge_id', '$row->id', '$type', '$title', '$description', '$latitude', '$longitude', '$category', NOW(), NOW()+INTERVAL 1 DAY)";
		$result = mysql_query($query);
		$next_id = mysql_insert_id();
		
		$query = "UPDATE posts SET end_date = ADDTIME(end_date, '02:00:00') WHERE id = '$challenge_id'";
		$result = mysql_query($query);
		
		if ($type == 1) {
			$photo = $_FILES["Photo0"]["name"];
			$photo_ext = explode(".", $photo);
			$photo_ext = $photo_ext[sizeof($photo_ext) - 1];
			
			$filename = rand_string(20).".$photo_ext";
			$uploadfile = dirname(__FILE__)."/../users/files/$filename";
			move_uploaded_file($_FILES["Photo0"]["tmp_name"], $uploadfile);
			$challenge_file_photo = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename";
			
			$query = "UPDATE posts SET file = '$challenge_file_photo' WHERE id = '$next_id'";
			$result = mysql_query($query);
		} elseif ($type == 2) {
			$video = $_FILES["Video0"]["name"];
			$video_ext = explode(".", $video);
			$video_ext = $video_ext[sizeof($video_ext) - 1];
			
			$filename = rand_string(20).".$video_ext";
			$uploadfile = dirname(__FILE__)."/../users/files/$filename";
			move_uploaded_file($_FILES["Video0"]["tmp_name"], $uploadfile);
			$challenge_file_video = "http://".$_SERVER['SERVER_NAME']."/users/files/$filename";
			
			$query = "UPDATE posts SET file = '$challenge_file_video' WHERE id = '$next_id'";
			$result = mysql_query($query);
		}

		$output['result'] = "success";
		$output['data']['ID'] = $next_id;
	} else {
		$output['result'] = "failed";
	}
	
=======
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

>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	echo json_encode($output);
}


if ($method == "ViewChallenge") {
<<<<<<< HEAD
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$latitude = (float)$_REQUEST['Latitude'];
	$longitude = (float)$_REQUEST['Longitude'];
	$offset = (int)$_REQUEST['OffsetID'];
	$category = mysql_escape_string(substr($_REQUEST['Category'], 0 , 128));
	$search_category = mysql_escape_string(substr($_REQUEST['Search_Category'], 0 , 128));
	$user_id = (int)$_REQUEST['UserID'];
	$id = (int)$_REQUEST['ID'];
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	$latitude_min = $latitude - 1;
	$latitude_max = $latitude + 1;
	$longitude_min = $longitude - 1;
	$longitude_max = $longitude + 1;
	
<<<<<<< HEAD
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$my_id = $row->id;

	
	
	
	if ($user_id == "" AND $id == "") {
		$query = "SELECT * FROM posts ORDER BY date DESC LIMIT $offset, 10";
	} else {
		$query = "SELECT * FROM posts WHERE id = '$id' OR userid = '$user_id' ORDER BY date DESC LIMIT $offset, 10";
	}
	
	if ($category == "Own") {
		$query = "SELECT * FROM posts WHERE id = '$id' LIMIT $offset, 10";
	}
	if ($category == "List") {
		$query = "SELECT * FROM posts WHERE subid = '$id' LIMIT $offset, 10";
	}
	if ($search_category != "") {
		$query = "SELECT * FROM posts WHERE category LIKE '$search_category%' OR description LIKE '$search_category%' OR title LIKE '$search_category%' LIMIT $offset, 10";
	}






	////////////////////////////
	if ($category == "Activity") { //prosto vse
		$query = "SELECT * FROM posts LIMIT $offset, 10";
	}
	
	if ($category == "New") { //poslednie 24 chasa. posledniy v tope; tolko challenge
		$query = "SELECT * FROM posts WHERE subid != 0 ORDER BY date DESC LIMIT $offset, 10";
	}
	
	if ($category == "Trending") { // likes. ot bolshego; tolko challenge
		$query = "SELECT * FROM posts WHERE subid != 0 LIMIT $offset, 10";
	}
	
	if ($category == "Nearby") { // 10km x-y; challenge and reply
		$query = "SELECT * FROM posts WHERE (latitude < $latitude_max OR latitude > $latitude_min) AND (longitude < $longitude_max OR longitude > $longitude_min) LIMIT $offset, 10";
	}
	
	//++
	if ($category == "Favorite") {	//dobavlenniy v izbrannoe; challenge and reply
		$posts_array = array();
		$query = "SELECT postid FROM favorites WHERE userid = '$my_id'";
		$result = mysql_query($query);
		$n = 0;
		while ($row = mysql_fetch_object($result)) {
			$posts_array[$n] = $row->postid;
			$n++;
		}
		
		$query = "(SELECT * FROM posts WHERE id = '$posts_array[0]' OR subid = '$posts_array[0]') ";
		for ($n = 1; $n < sizeof($posts_array); $n++) {
			$query .= " UNION (SELECT * FROM posts WHERE id = '$posts_array[$n]' OR subid = '$posts_array[$n]') ";
		}
		$query .= " LIMIT $offset, 10";
		$result = mysql_query($query);
	}
	////////////////////
	
	
	
	$n = 0;
=======
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
	
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	$result = mysql_query($query);
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT * FROM users WHERE id = '$row->userid' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
<<<<<<< HEAD
		if ($row->subid) {
			$query1 = "SELECT id FROM likes WHERE post_id = '$row->id'";
			$result1 = mysql_query($query1);
			$like_count = mysql_num_rows($result1);
		} else {
			$posts_array = array();
			$query2 = "SELECT id FROM posts WHERE subid = '$row->id'";
			$result2 = mysql_query($query2);
			$like_count = 0;
			while ($row2 = mysql_fetch_object($result2)) {
				$query3 = "SELECT id FROM likes WHERE post_id = '$row2->id'";
				$result3 = mysql_query($query3);
				$like_count += mysql_num_rows($result3);
			}
		}
		
		$query1 = "SELECT id FROM posts WHERE subid = '$row->id'";
		$result1 = mysql_query($query1);
		$entries = mysql_num_rows($result1);
		
		$query1 = "SELECT id FROM likes WHERE user_id = '$my_id' AND post_id = '$row->id' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$like_my = mysql_num_rows($result1);
		
		$query1 = "SELECT userid FROM favorites WHERE userid = '$my_id' AND postid = '$row->id' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$favorite_my = mysql_num_rows($result1);
		
		$query1 = "SELECT id FROM comments WHERE postid = '$row->id'";
		$result1 = mysql_query($query1);
		$comments_count = mysql_num_rows($result1);
		
		$date = strtotime($row->date);
		$end_date = strtotime($row->end_date);
		$post_my = 0;
		if ($row->userid == $my_id) $post_my = 1;

		$output['data'][$n]['ID'] = "$row->id";
		if (!$row->subid)
			$output['data'][$n]['Base_ID'] = "$row->id";
		else 
			$output['data'][$n]['Base_ID'] = "$row->subid";
		$output['data'][$n]['UserName'] = "$row1->username";
		$output['data'][$n]['UserID'] = "$row1->id";
		$output['data'][$n]['Photo'] = "$row1->avatar";
		$output['data'][$n]['Date'] = "$date";
		$output['data'][$n]['End_Date'] = "$end_date";
		$output['data'][$n]['Title'] = "$row->title";
		$output['data'][$n]['Tag'] = "$row->category";
		$output['data'][$n]['Description'] = "$row->description";
		$query1 = "SELECT userid, text, date FROM comments WHERE postid = '$row->id' ORDER BY date DESC LIMIT 0, 4";
		$result1 = mysql_query($query1);
		$nn = 0;
		while ($row1 = mysql_fetch_object($result1)) {
			$comment_date = strtotime($row1->date);
			$query2 = "SELECT username FROM users WHERE id = '$row1->userid' LIMIT 0, 1";
			$result2 = mysql_query($query2);
			$row2 = mysql_fetch_object($result2);

			$output['data'][$n]['Comments'][$nn]['UserID'] = "$row1->userid";
			$output['data'][$n]['Comments'][$nn]['UserName'] = "$row2->username";
			$output['data'][$n]['Comments'][$nn]['Text'] = "$row1->text";
			$output['data'][$n]['Comments'][$nn]['Date'] = "$comment_date";

			$nn++;
		}
		$output['data'][$n]['Like_Count'] = "$like_count";
		$output['data'][$n]['Like_My'] = "$like_my";
		$output['data'][$n]['Favorite_My'] = "$favorite_my";
		$output['data'][$n]['Post_My'] = "$post_my";
		$output['data'][$n]['Entries'] = "$entries";
		$output['data'][$n]['Comments_Count'] = "$comments_count";
		$output['data'][$n]['Latitude'] = "$row->latitude";
		$output['data'][$n]['Longitude'] = "$row->longitude";
		$output['data'][$n]['Type'] = "$row->type";
		$output['data'][$n]['URL'] = "$row->file";
		if (!$row->subid) {
			$leader_id = 0;
			$leader_count = 0;
			$query1 = "SELECT id, userid FROM posts WHERE subid = '$row->id'";
			$result1 = mysql_query($query1);
			while ($row1 = mysql_fetch_object($result1)) {
				$query2 = "SELECT id FROM likes WHERE post_id = '$row1->id'";
				$result2 = mysql_query($query2);
				$num_rows = mysql_num_rows($result2);
				
				if ($num_rows > $leader_count) {
					$leader_count = $num_rows;
					$leader_id = $row1->userid;
				}
			}
			$query1 = "SELECT username, avatar FROM users WHERE id = '$leader_id' LIMIT 0, 1";
			$result1 = mysql_query($query1);
			$row1 = mysql_fetch_object($result1);

			$output['data'][$n]['Leader_Username'] = "$row1->username";
			$output['data'][$n]['Leader_Photo'] = "$row1->avatar";
		}
		if ($row->subid) {
			$rank = 1;
			$likes_num = 0;
			
			$query2 = "SELECT id FROM likes WHERE post_id = '$row->id'";
			$result2 = mysql_query($query2);
			$likes_num = mysql_num_rows($result2);
			
			$query1 = "SELECT id FROM posts WHERE subid = '$row->subid' AND id != '$row->id'";
			$result1 = mysql_query($query1);
			while ($row1 = mysql_fetch_object($result1)) {
				$query2 = "SELECT id FROM likes WHERE post_id = '$row1->id'";
				$result2 = mysql_query($query2);
				$num_rows = mysql_num_rows($result2);
				
				if ($num_rows > $likes_num) $rank++;
			}
			$output['data'][$n]['Rank'] = "$rank";
		}
		$n++;
	}

	$output['result'] = "success";
	echo json_encode($output);
}

//++
if ($method == "SearchChallenge") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$search_category = mysql_escape_string(substr($_REQUEST['Search_Category'], 0 , 128));
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$my_id = $row->id;
	
	$query = "SELECT * FROM posts WHERE category LIKE '$search_category%'";
	$result = mysql_query($query);
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT * FROM users WHERE id = '$row->userid' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		$query1 = "SELECT id FROM likes WHERE post_id = '$row->id'";
		$result1 = mysql_query($query1);
		$like_count = mysql_num_rows($result1);
		
		$query1 = "SELECT id FROM likes WHERE user_id = '$my_id' AND post_id = '$row->id' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$like_my = mysql_num_rows($result1);
		
		$query1 = "SELECT userid FROM favorites WHERE userid = '$my_id' AND postid = '$row->id' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$favorite_my = mysql_num_rows($result1);
		
		$query1 = "SELECT id FROM comments WHERE postid = '$row->id'";
		$result1 = mysql_query($query1);
		$comments_count = mysql_num_rows($result1);
		
		$date = strtotime($row->date);
		$end_date = strtotime($row->end_date);
		$post_my = 0;
		if ($row->userid == $my_id) $post_my = 1;

		$output['data'][$n]['ID'] = "$row->id";
		if (!$row->subid)
			$output['data'][$n]['Base_ID'] = "$row->id";
		else 
			$output['data'][$n]['Base_ID'] = "$row->subid";
		$output['data'][$n]['UserName'] = "$row1->username";
		$output['data'][$n]['UserID'] = "$row1->id";
		$output['data'][$n]['Photo'] = "$row1->avatar";
		$output['data'][$n]['Date'] = "$date";
		$output['data'][$n]['End_Date'] = "$end_date";
		$output['data'][$n]['Title'] = "$row->title";
		$output['data'][$n]['Tag'] = "$row->category";
		$output['data'][$n]['Description'] = "$row->description";
		$query1 = "SELECT userid, text, date FROM comments WHERE postid = '$row->id' ORDER BY date DESC LIMIT 0, 4";
		$result1 = mysql_query($query1);
		$nn = 0;
		while ($row1 = mysql_fetch_object($result1)) {
			$comment_date = strtotime($row1->date);
			$query2 = "SELECT username FROM users WHERE id = '$row1->userid' LIMIT 0, 1";
			$result2 = mysql_query($query2);
			$row2 = mysql_fetch_object($result2);

			$output['data'][$n]['Comments'][$nn]['UserID'] = "$row1->userid";
			$output['data'][$n]['Comments'][$nn]['UserName'] = "$row2->username";
			$output['data'][$n]['Comments'][$nn]['Text'] = "$row1->text";
			$output['data'][$n]['Comments'][$nn]['Date'] = "$comment_date";

			$nn++;
		}
		$output['data'][$n]['Like_Count'] = "$like_count";
		$output['data'][$n]['Like_My'] = "$favorite_my";
		$output['data'][$n]['Favorite_My'] = "$favorite_my";
		$output['data'][$n]['Post_My'] = "$post_my";
		$output['data'][$n]['Comments_Count'] = "$comments_count";
		$output['data'][$n]['Latitude'] = "$row->latitude";
		$output['data'][$n]['Longitude'] = "$row->longitude";
		$output['data'][$n]['Type'] = "$row->type";
		$output['data'][$n]['URL'] = "$row->file";
		if (!$row->subid) {
			$leader_id = 0;
			$leader_count = 0;
			$query1 = "SELECT id, userid FROM posts WHERE subid = '$row->id'";
			$result1 = mysql_query($query1);
			while ($row1 = mysql_fetch_object($result1)) {
				$query2 = "SELECT id FROM likes WHERE post_id = '$row1->id'";
				$result2 = mysql_query($query2);
				$num_rows = mysql_num_rows($result2);
				
				if ($num_rows > $leader_count) {
					$leader_count = $num_rows;
					$leader_id = $row1->userid;
				}
			}
			$query1 = "SELECT username, avatar FROM users WHERE id = '$leader_id' LIMIT 0, 1";
			$result1 = mysql_query($query1);
			$row1 = mysql_fetch_object($result1);

			$output['data'][$n]['Leader_Username'] = "$row1->username";
			$output['data'][$n]['Leader_Photo'] = "$row1->avatar";
		}
		if ($row->subid) {
			$rank = 1;
			$likes_num = 0;
			
			$query2 = "SELECT id FROM likes WHERE post_id = '$row->id'";
			$result2 = mysql_query($query2);
			$likes_num = mysql_num_rows($result2);
			
			$query1 = "SELECT id FROM posts WHERE subid = '$row->subid' AND id != '$row->id'";
			$result1 = mysql_query($query1);
			while ($row1 = mysql_fetch_object($result1)) {
				$query2 = "SELECT id FROM likes WHERE post_id = '$row1->id'";
				$result2 = mysql_query($query2);
				$num_rows = mysql_num_rows($result2);
				
				if ($num_rows > $likes_num) $rank++;
			}
			$output['data'][$n]['Rank'] = "$rank";
		}
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
		$n++;
	}

	$output['result'] = "success";
	echo json_encode($output);
}

if ($method == "Search_User") {
<<<<<<< HEAD
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$user_name = mysql_escape_string(substr($_REQUEST['Search_User'], 0 , 32));
	$user_id = (int)$_REQUEST['ID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$my_id = $row->id;
	
	$username = $_POST['UserName'];
	$query = "SELECT * FROM users WHERE ((username LIKE '$username%') OR (firstname LIKE '$username%') OR (lastname LIKE '$username%') OR (email LIKE '$username%')) AND id != $my_id";
=======
	$username = $_POST['UserName'];
	$query = "SELECT * FROM users WHERE (username LIKE '$username%') OR (firstname LIKE '$username%') OR (lastname LIKE '$username%') OR (email LIKE '$username%')";
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	$result = mysql_query($query);
	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT user_id FROM follow WHERE following_id = $row->id";
		$result1 = mysql_query($query1);
		$num_rows = mysql_num_rows($result1);
		
<<<<<<< HEAD
		$output['data'][$n]['UserID'] = $row->id;
=======
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
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
<<<<<<< HEAD
	$query = "SELECT DISTINCT user_id FROM likes";
	$result = mysql_query($query);
	//$row = mysql_fetch_object($result);
	//$userid = $row->user_id;

	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT * FROM users WHERE id = $row->user_id";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		$output['data'][$n]['UserID'] = $row1->id;
		$output['data'][$n]['UserName'] = $row1->username;
		$output['data'][$n]['Status'] = $row1->status;
		$output['data'][$n]['Photo'] = $row1->avatar;
		$output['data'][$n]['Level'] = $row1->level;
		$n++;
	}
	
	$output['result'] = "success";
	echo json_encode($output);
}

if ($method == "Challenge_Request") {
	$id = $_POST['ID'];
	$peoples = $_POST['Peoples'];
	
	$filename = 'test_peoples.txt';
	$handle = fopen($filename, 'a');
	$results = print_r($_POST['Peoples'], true);
	fwrite($handle, $results);
    fclose($handle);

	$output['result'] = "success";
	/*
=======
	$query = "SELECT user_id FROM likes LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;

	$output['result'] = "success";
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
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
<<<<<<< HEAD
	*/
	echo json_encode($output);
}

//++
if ($method == "Add_Favorite") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$id = (int)$_REQUEST['ID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT userid FROM favorites WHERE userid = '$row->id' AND postid = '$id' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	
	if ($num_rows) {
		$query = "DELETE FROM favorites WHERE userid = '$row->id' AND postid = '$id'";
	} else {
		$query = "INSERT INTO favorites (userid, postid) VALUES ('$row->id', '$id')";
	}
	$result = mysql_query($query);
	
	$output['result'] = "success";
	echo json_encode($output);
}

if ($method == "My_Favorite") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT postid FROM favorites WHERE userid = '$row->id'";
	$result = mysql_query($query);
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$output['data'][$n]['ID'] = $row->postid;
		$n++;
	}
	
	$output['result'] = "success";
	echo json_encode($output);
}

//++
if ($method == "Delete_Challenge") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$id = (int)$_REQUEST['ID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$user_id = $row->id;
	
	$query = "SELECT id, subid FROM posts WHERE id = '$id' AND userid = '$user_id' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	
	if ($num_rows) {
		$row = mysql_fetch_object($result);
		
		if ($row->subid) {
			$query = "DELETE FROM comments WHERE postid = '$id'";
			$result = mysql_query($query);
					
			$query = "DELETE FROM favorites WHERE postid = '$id'";
			$result = mysql_query($query);
			
			$query = "DELETE FROM likes WHERE post_id = '$id'";
			$result = mysql_query($query);
			
			$query = "DELETE FROM notifications WHERE challenge_id = '$id'";
			$result = mysql_query($query);
			
			$query = "DELETE FROM posts WHERE id = '$id' AND userid = '$user_id'";
			$result = mysql_query($query);
		} else {
			$posts_array = array();
			$n = 0;

			$query = "(SELECT id FROM posts WHERE subid = '$id') UNION (SELECT $id)";
			$result = mysql_query($query);
			while ($row = mysql_fetch_object($result)) {
				$posts_array[$n] = $row->id;
				$n++;
			}
			
			for ($n = 0; $n < sizeof($posts_array); $n++) {
				$query = "DELETE FROM comments WHERE postid = '$posts_array[$n]'";
				$result = mysql_query($query);
						
				$query = "DELETE FROM favorites WHERE postid = '$posts_array[$n]'";
				$result = mysql_query($query);
				
				$query = "DELETE FROM likes WHERE post_id = '$posts_array[$n]'";
				$result = mysql_query($query);
				
				$query = "DELETE FROM notifications WHERE challenge_id = '$posts_array[$n]'";
				$result = mysql_query($query);
			}

			$query = "DELETE FROM posts WHERE subid = '$id'";
			$result = mysql_query($query);
			
			$query = "DELETE FROM posts WHERE id = '$id' AND userid = '$user_id'";
			$result = mysql_query($query);
		}

		$output['result'] = "success";
	} else {
		$query = "SELECT id FROM posts WHERE id = '$id' LIMIT 0, 1";
		$result = mysql_query($query);
		$num_rows = mysql_num_rows($result);
	
		if ($num_rows) {
			$query = "SELECT user_id FROM posts_ban WHERE user_id = '$user_id' AND post_id = '$id' LIMIT 0, 1";
			$result = mysql_query($query);
			$num_rows = mysql_num_rows($result);
			
			if (!$num_rows) {
				$query = "INSERT INTO posts_ban (user_id, post_id) VALUES ('$user_id', '$id')";
				$result = mysql_query($query);				
			}			
			
			$output['result'] = "success";
		} else {
			$output['result'] = "failed";
		}
	}
	
=======
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	echo json_encode($output);
}

?>