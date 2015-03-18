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
	if (in_array('upp', $vcase))
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

//+
if ($method == "SignUp" AND $_POST['UserName'] != "" AND $_POST['Email'] != "" AND $_POST['Password'] != "") {
	$username = mysql_escape_string(substr($_POST['UserName'], 0 , 32));
	$email = mysql_escape_string(substr($_POST['Email'], 0 , 128));
	$password = mysql_escape_string(substr($_POST['Password'], 0 , 32));
	$avatar = $_FILES['Photo']['name'];
	$avatar_ext = substr($avatar, -3);
		
	if ($avatar != "") {
		$filename = rand_string(20).".$avatar_ext";
		$uploadfile = dirname(__FILE__)."/../users/avatars/$filename";
		move_uploaded_file($_FILES['Photo']['tmp_name'], $uploadfile);
		$avatar_file = "'http://".$_SERVER['SERVER_NAME']."/users/avatars/$filename'";
	} else {
		$avatar_file = "DEFAULT";
	}
	
	$query = "INSERT INTO users (username, email, password, avatar, level) VALUES ('$username', '$email', '$password', $avatar_file, 1)";
	$result = mysql_query($query);
	
	//$query = "SELECT id, username, firstname, lastname, email, avatar, fb, tw, description, phone, website FROM users WHERE id = ".mysql_insert_id()." LIMIT 0, 1";
	//$result = mysql_query($query);
	//$row = mysql_fetch_object($result);
	
	$output['result'] = "success";    //////or failed ??? 
	/*
	$output['data']['ID'] = $row->id;
	$output['data']['UserName'] = $row->username;
	$output['data']['FirstName'] = $row->firstname;
	$output['data']['LastName'] = $row->lastname;
	$output['data']['Email'] = $row->email;
	$output['data']['Photo'] = $row->avatar;
	$output['data']['Facebook_Connected'] = $row->fb;
	$output['data']['Twitter_Connected'] = $row->tw;
	$output['data']['Description'] = $row->description;
	$output['data']['PhoneNumber'] = $row->phone;
	$output['data']['WebSite'] = $row->website;
	*/

	echo json_encode($output);
}

//--
if ($method == "SignUpFB") {
	$username = mysql_escape_string($_POST['UserName']);
	$password = mysql_escape_string($_POST['Password']);
	$email = mysql_escape_string($_POST['Email']);
	$first_name = mysql_escape_string($_POST['First_name']);
	$last_name = mysql_escape_string($_POST['Last_name']);
	$gender = mysql_escape_string($_POST['Gender']);
	$photo = mysql_escape_string($_POST['Photo']);
	$status = mysql_escape_string($_POST['Verified']);
	//$avatar = $_FILES['Avatar']['name'];
	
	/*
	if ($avatar != "") {
		$filename = rand_string(20).".png";
		$uploadfile = "/www/chlln.gr/www/users/avatars/$filename";					///////path
		move_uploaded_file($_FILES['Avatar']['tmp_name'], $uploadfile);
		$avatar_file = "http://chlln.gr/users/avatars/$filename";
	} else {
		$avatar_file = "http://chlln.gr/users/avatars/no_picture.png";				/////////picture default value (in DB)
	}
	*/
	
	//$query = "INSERT INTO users (fb, email, fb_pass, avatar) VALUES ('$username', '$email', '$password', '$avatar_file')";
	$query = "INSERT INTO users (fb, fb_pass, email, firstname, lastname, gender, avatar, status, level) VALUES ('$username', '$password', '$email', '$first_name', '$last_name', '$gender', '$photo', '$status', 1)";
	$result = mysql_query($query);
	
	//$query = "SELECT id, username, firstname, lastname, email, avatar, fb, tw, description, phone, website FROM users WHERE id = ".mysql_insert_id()." LIMIT 0, 1";		///////Ciryllic
	//$result = mysql_query($query);
	//$row = mysql_fetch_object($result);
	
	$output['result'] = "success";
	/*
	$output['data']['ID'] = $row->id;
	$output['data']['UserName'] = $row->username;
	$output['data']['FirstName'] = $row->firstname;
	$output['data']['LastName'] = $row->lastname;
	$output['data']['Email'] = $row->email;
	$output['data']['Photo'] = $row->avatar;
	$output['data']['Facebook_Connected'] = $row->fb;
	$output['data']['Twitter_Connected'] = $row->tw;
	$output['data']['Description'] = $row->description;
	$output['data']['PhoneNumber'] = $row->phone;
	$output['data']['WebSite'] = $row->website;
	*/

	echo json_encode($output);
}

//--
if ($method == "SignUpTW") {
	$username = mysql_escape_string($_POST['UserName']);
	$password = mysql_escape_string($_POST['Password']);
	$name = mysql_escape_string($_POST['Name']);
	$photo = mysql_escape_string($_POST['Photo']);
	$description = mysql_escape_string($_POST['Description']);
	$status = mysql_escape_string($_POST['Verified']);
	$array = explode(" ", $name);
	$first_name = $array[0];
	$last_name = $array[1];
	
	/*
	if ($avatar != "") {
		$filename = rand_string(20).".png";
		$uploadfile = "/www/chlln.gr/www/users/avatars/$filename";					///////path
		move_uploaded_file($_FILES['Avatar']['tmp_name'], $uploadfile);
		$avatar_file = "http://chlln.gr/users/avatars/$filename";
	} else {
		$avatar_file = "http://chlln.gr/users/avatars/no_picture.png";				/////////picture default value (in DB)
	}
	*/
	
	$query = "INSERT INTO users (tw, tw_pass, firstname, lastname, avatar, description, status, level) VALUES ('$username', '$password', '$first_name', '$last_name', '$photo', '$description', '$status', 1)";
	$result = mysql_query($query);
	
	//$query = "SELECT id, username, firstname, lastname, email, avatar, fb, tw, description, phone, website FROM users WHERE id = ".mysql_insert_id()." LIMIT 0, 1";		///////Ciryllic
	//$result = mysql_query($query);
	//$row = mysql_fetch_object($result);
	
	$output['result'] = "success";
	/*
	$output['data']['ID'] = $row->id;
	$output['data']['UserName'] = $row->username;
	$output['data']['FirstName'] = $row->firstname;
	$output['data']['LastName'] = $row->lastname;
	$output['data']['Email'] = $row->email;
	$output['data']['Photo'] = $row->avatar;
	$output['data']['Facebook_Connected'] = $row->fb;
	$output['data']['Twitter_Connected'] = $row->tw;
	$output['data']['Description'] = $row->description;
	$output['data']['PhoneNumber'] = $row->phone;
	$output['data']['WebSite'] = $row->website;
	*/

	echo json_encode($output);
}

//+
if ($method == "Login") {
	$username = mysql_escape_string(substr($_POST['UserName'], 0 , 32));
	$password = mysql_escape_string(substr($_POST['Password'], 0 , 32));
	$token = mysql_escape_string(substr($_POST['Token'], 0 , 512));
	
	$query = "SELECT * FROM users WHERE (username = '$username' OR email = '$username') AND password = '$password' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if ($num_rows) {
		$row = mysql_fetch_object($result);
		
		$hash = md5(rand_string(20));
		$query1 = "UPDATE users SET hash = '$hash' WHERE id = $row->id";			///////TOKEN!!!!
		$result1 = mysql_query($query1);
		
		$output['result'] = "success";
		$output['data']['ID'] = $row->id;
		$output['data']['hash'] = $hash;
		$output['data']['UserName'] = $row->username;
		$output['data']['FirstName'] = $row->firstname;
		$output['data']['LastName'] = $row->lastname;
		$output['data']['Email'] = $row->email;
		$output['data']['Photo'] = $row->avatar;
		$output['data']['Facebook_Connected'] = $row->fb;
		$output['data']['Twitter_Connected'] = $row->tw;
		$output['data']['Gender'] = $row->gender;
		$output['data']['Family'] = $row->marital_status;
		$output['data']['Birth'] = $row->birthdate;
		$output['data']['Description'] = $row->description;
		$output['data']['PhoneNumber'] = $row->phone;
		$output['data']['WebSite'] = $row->website;
	} else {
		$output['result'] = "failed";
		$output['error'] = "1";
	}
	echo json_encode($output);
}

if ($method == "LoginFB") {
	$username = mysql_escape_string(substr($_POST['ID'], 0 , 32));
	$password = mysql_escape_string(substr($_POST['Password'], 0 , 32));
	$token = mysql_escape_string(substr($_POST['Token'], 0 , 512));
	
	$query = "SELECT * FROM users WHERE fb = '$username' AND fb_pass = '$password' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if ($num_rows) {
		$row = mysql_fetch_object($result);
		
		$hash = md5(rand_string(20));
		$query1 = "UPDATE users SET hash = '$hash' WHERE id = $row->id";			///////TOKEN!!!!
		$result1 = mysql_query($query1);
		
		$output['result'] = "success";
		$output['data']['ID'] = $row->id;
		$output['data']['hash'] = $hash;
		$output['data']['UserName'] = $row->username;
		$output['data']['FirstName'] = $row->firstname;
		$output['data']['LastName'] = $row->lastname;
		$output['data']['Email'] = $row->email;
		$output['data']['Photo'] = $row->avatar;
		$output['data']['Facebook_Connected'] = $row->fb;
		$output['data']['Twitter_Connected'] = $row->tw;
		$output['data']['Gender'] = $row->gender;
		$output['data']['Family'] = $row->marital_status;
		$output['data']['Birth'] = $row->birthdate;
		$output['data']['Description'] = $row->description;
		$output['data']['PhoneNumber'] = $row->phone;
		$output['data']['WebSite'] = $row->website;
	} else {
		$output['result'] = "failed";
		$output['error'] = "1";
	}
	echo json_encode($output);
}

if ($method == "LoginTW") {
	$username = mysql_escape_string(substr($_POST['ID'], 0 , 32));
	$password = mysql_escape_string(substr($_POST['Password'], 0 , 32));
	$token = mysql_escape_string(substr($_POST['Token'], 0 , 512));
	
	$query = "SELECT * FROM users WHERE tw = '$username' AND tw_pass = '$password' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if ($num_rows) {
		$row = mysql_fetch_object($result);
		
		$hash = md5(rand_string(20));
		$query1 = "UPDATE users SET hash = '$hash' WHERE id = $row->id";			///////TOKEN!!!!
		$result1 = mysql_query($query1);
		
		$output['result'] = "success";
		$output['data']['ID'] = $row->id;
		$output['data']['hash'] = $hash;
		$output['data']['UserName'] = $row->username;
		$output['data']['FirstName'] = $row->firstname;
		$output['data']['LastName'] = $row->lastname;
		$output['data']['Email'] = $row->email;
		$output['data']['Photo'] = $row->avatar;
		$output['data']['Facebook_Connected'] = $row->fb;
		$output['data']['Twitter_Connected'] = $row->tw;
		$output['data']['Gender'] = $row->gender;
		$output['data']['Family'] = $row->marital_status;
		$output['data']['Birth'] = $row->birthdate;
		$output['data']['Description'] = $row->description;
		$output['data']['PhoneNumber'] = $row->phone;
		$output['data']['WebSite'] = $row->website;
	} else {
		$output['result'] = "failed";
		$output['error'] = "1";
	}
	echo json_encode($output);
}

//++
if ($method == "CheckUsername") {
	$username = mysql_escape_string(substr($_POST['UserName'], 0 , 32));
	
	$query = "SELECT COUNT(*) AS total FROM users WHERE username LIKE '$username' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);

	if ($row->total)
		$output['result'] = "failed";
	else
		$output['result'] = "success";
		
	sleep(1);
	echo json_encode($output);
}

//++
if ($method == "CheckEmail") {
	$email = mysql_escape_string(substr($_POST['Email'], 0 , 128));
	
	$query = "SELECT COUNT(*) AS total FROM users WHERE email LIKE '$email' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);

	if ($row->total)
		$output['result'] = "failed";
	else
		$output['result'] = "success";

	sleep(1);		
	echo json_encode($output);
}

if ($method == "UserInfo") {
	$id = $_POST['UserID'];
	
	$query = "SELECT * FROM users WHERE id = $id LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query1 = "SELECT id FROM posts WHERE userid = $id AND subid = 0";
	$result1 = mysql_query($query1);
	$row1 = mysql_fetch_object($result1);
	$created = mysql_num_rows($result1);
	
	$query2 = "SELECT user_id FROM follow WHERE following_id = $id LIMIT 0, 1";
	$result2 = mysql_query($query2);
	$num_rows2 = mysql_num_rows($result2);
	
	$query2 = "SELECT user_id FROM follow WHERE following_id = $id";
	$result2 = mysql_query($query2);
	$num_rows3 = mysql_num_rows($result2);
	
	$query2 = "SELECT user_id FROM follow WHERE user_id = $id";
	$result2 = mysql_query($query2);
	$num_rows4 = mysql_num_rows($result2);

	$output['result'] = "success";
	$output['data']['ID'] = $row->id;
	$output['data']['UserName'] = $row->username;
	$output['data']['Status'] = $row->status;
	$output['data']['FirstName'] = $row->firstname;
	$output['data']['LastName'] = $row->lastname;
	$output['data']['Email'] = $row->email;
	$output['data']['Photo'] = $row->avatar;
	$output['data']['Facebook_Connected'] = $row->fb;
	$output['data']['Twitter_Connected'] = $row->tw;
	$output['data']['Gender'] = $row->gender;
	$output['data']['Family'] = $row->marital_status;
	$output['data']['Birth'] = $row->birthdate;
	$output['data']['Description'] = $row->description;
	$output['data']['PhoneNumber'] = $row->phone;
	$output['data']['WebSite'] = $row->website;
	$output['data']['Wins'] = $row->wins;
	$output['data']['Entries'] = $row->entries;
	$output['data']['Followers'] = "$num_rows3";
	$output['data']['Following'] = "$num_rows4";
	$output['data']['Level'] = $row->level;
	$output['data']['FollowedByMe'] = "$num_rows2";
	$output['data']['Created'] = $created;

	echo json_encode($output);
}

if ($method == "ChangePassword") {
	$hash = $_POST['Hash'];
	$pass_old = $_POST['PasswordOld'];
	$pass_new1 = $_POST['PasswordNew'];
	$pass_new2 = $_POST['PasswordRepeat'];
	
	$query = "UPDATE users SET password = '$pass_new1' WHERE hash = $hash";
	$result = mysql_query($query);

	$output['result'] = "success";
		
	echo json_encode($output);
}

if ($method == "UserInfoUpdate") {
	$hash = $_POST['Hash'];
	$avatar = $_FILES['Avatar']['name'];
	$username = mysql_escape_string($_POST['UserName']);
	$firstname = mysql_escape_string($_POST['FirstName']);
	$lastname = mysql_escape_string($_POST['LastName']);
	$gender = mysql_escape_string($_POST['Gender']);
	$marital_status = mysql_escape_string($_POST['Family']);
	$birthdate = mysql_escape_string($_POST['Birth']);
	$description = mysql_escape_string($_POST['Description']);
	$email = mysql_escape_string($_POST['Email']);
	$phone = mysql_escape_string($_POST['PhoneNumber']);
	$website = mysql_escape_string($_POST['WebSite']);
	
	if ($avatar != "") {
		$filename = rand_string(20).".png";
		$uploadfile = "/www/chlln.gr/www/users/avatars/$filename";					///////path
		move_uploaded_file($_FILES['Avatar']['tmp_name'], $uploadfile);
		$avatar_file = "http://chlln.gr/users/avatars/$filename";
	} else {
		$avatar_file = "http://chlln.gr/users/avatars/no_picture.png";				/////////picture default value (in DB)
	}
	
	$query = "UPDATE users SET avatar = '$avatar_file', username = '$username', firstname = '$firstname', lastname = '$lastname', gender = '$gender', marital_status = '$marital_status', birthdate = '$birthdate', description = '$description', email = '$email', phone = '$phone', website = '$website' WHERE hash = '$hash'";
	$result = mysql_query($query);
	$output['result'] = "success";
		
	echo json_encode($output);
}

if ($method == "MyTeam") {
	$hash = $_POST['Hash'];
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	$n = 0;
	
	$query = "SELECT user_id FROM follow WHERE following_id = $userid";
	$result = mysql_query($query);
	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$output['data'][$n]['ID'] = $row->id;
		$output['data'][$n]['UserName'] = $row->username;
		$output['data'][$n]['Status'] = $row->status;
		$output['data'][$n]['FirstName'] = $row->firstname;
		$output['data'][$n]['LastName'] = $row->lastname;
		$output['data'][$n]['Photo'] = $row->avatar;
		$output['data'][$n]['Level'] = $row->level;
		$n++;
	}
		
	echo json_encode($output);
}

if ($method == "MyNotifications") {
	$hash = $_POST['Hash'];
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	
	$query = "SELECT * FROM notifications WHERE user_id = $userid";
	$result = mysql_query($query);

	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT * FROM users WHERE id = $row->user_id";
		$result1 = mysql_query($query1);
		
		$output['data'][$n]['ID'] = $row1->id;
		$output['data'][$n]['UserName'] = $row1->username;
		$output['data'][$n]['Photo'] = $row1->avatar;
		$output['data'][$n]['Level'] = $row1->level;
		$output['data'][$n]['Action'] = "";
		$output['data'][$n]['Title'] = "";
		$n++;
	}
		
	echo json_encode($output);
}

if ($method == "MyNotificationsNum") {
	$hash = $_POST['Hash'];
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	
	$query = "SELECT * FROM notifications WHERE user_id = $userid";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result1);

	$output['result'] = "success";
	$output['total'] = $num_rows;
		
	echo json_encode($output);
}
?>