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

<<<<<<< HEAD
//++
if ($method == "SignUp") {
	if ($_REQUEST['UserName'] != "" AND $_REQUEST['Email'] != "" AND $_REQUEST['Password'] != "") {
		$username = mysql_escape_string(substr($_REQUEST['UserName'], 0 , 32));
		$email = mysql_escape_string(substr($_REQUEST['Email'], 0 , 128));
		$password = mysql_escape_string(substr($_REQUEST['Password'], 0 , 32));
		$avatar = $_FILES['Photo']['name'];
		$avatar_ext = explode(".", $avatar);
		$avatar_ext = $avatar_ext[sizeof($avatar_ext) - 1];
		
		$query = "SELECT COUNT(*) AS total FROM users WHERE username = '$username' LIMIT 0, 1";
		$result = mysql_query($query);
		$row = mysql_fetch_object($result);
		if ($row->total) {
			$output['result'] = "failed";
		} else {
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
			
			if ($email != "") {
				include("templates/email/signup.php");
			}
			
			$output['result'] = "success";
		}
	} else
		$output['result'] = "failed";
	
	echo json_encode($output);
}

//++
if ($method == "SignUpFB") {
	$username = mysql_escape_string(substr($_REQUEST['UserName'], 0 , 32));
	$password = mysql_escape_string(substr($_REQUEST['Password'], 0 , 32));
	$email = mysql_escape_string(substr($_REQUEST['Email'], 0 , 128));
	$first_name = mysql_escape_string(substr($_REQUEST['First_name'], 0 , 32));
	$last_name = mysql_escape_string(substr($_REQUEST['Last_name'], 0 , 32));
	$gender = (int)$_REQUEST['Gender'];
	$avatar = mysql_escape_string(substr($_REQUEST['Photo'], 0 , 128));
	$status = (int)$_REQUEST['Verified'];
	
	$query = "SELECT COUNT(*) AS total FROM users WHERE fb = '$username' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if ($row->total) {
		$output['result'] = "failed";
	} else {
		$query = "INSERT INTO users (fb, fb_pass, email, firstname, lastname, gender, avatar, status, level) VALUES ('$username', '$password', '$email', '$first_name', '$last_name', '$gender', '$avatar', '$status', 1)";
		$result = mysql_query($query);
	
		if ($email != "") {
			include("templates/email/signup.php");
		}
		
		$output['result'] = "success";
	}
	echo json_encode($output);
}

//++
if ($method == "SignUpTW") {
	$username = mysql_escape_string(substr($_REQUEST['UserName'], 0 , 32));
	$password = mysql_escape_string(substr($_REQUEST['Password'], 0 , 32));
	$name = mysql_escape_string(substr($_REQUEST['Name'], 0 , 64));
	$avatar = mysql_escape_string(substr($_REQUEST['Photo'], 0 , 128));
	$description = mysql_escape_string(substr($_REQUEST['Description'], 0 , 1024));
	$status = (int)$_REQUEST['Verified'];
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	$array = explode(" ", $name);
	$first_name = $array[0];
	$last_name = $array[1];
	
<<<<<<< HEAD
	$query = "SELECT COUNT(*) AS total FROM users WHERE tw = '$username' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if ($row->total) {
		$output['result'] = "failed";
	} else {
		$query = "INSERT INTO users (tw, tw_pass, firstname, lastname, avatar, description, status, level) VALUES ('$username', '$password', '$first_name', '$last_name', '$avatar', '$description', '$status', 1)";
		$result = mysql_query($query);
		
		$output['result'] = "success";
	}
	echo json_encode($output);
}

//++
if ($method == "Login") {
	$username = mysql_escape_string(substr($_REQUEST['UserName'], 0 , 32));
	$password = mysql_escape_string(substr($_REQUEST['Password'], 0 , 32));
	$token = mysql_escape_string(substr($_REQUEST['Token'], 0 , 512));
	
	$query = "SELECT * FROM users WHERE (username = '$username' OR email = '$username') AND password_restore != '' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if ($num_rows) {
		$row = mysql_fetch_object($result);
		if ($password == $row->password_restore) {
			$query = "UPDATE users SET password = '$row->password_restore' WHERE id = '$row->id'";
			$result = mysql_query($query);
			
			$query = "UPDATE users SET password_restore = '' WHERE id = '$row->id'";
			$result = mysql_query($query);			
		}
	}
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	
	$query = "SELECT * FROM users WHERE (username = '$username' OR email = '$username') AND password = '$password' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if ($num_rows) {
		$row = mysql_fetch_object($result);
		
		$hash = md5(rand_string(20));
<<<<<<< HEAD
		$query1 = "UPDATE users SET hash = '$hash', token = '$token', password_restore= '' WHERE id = '$row->id'";
		$result1 = mysql_query($query1);
		
		$output['result'] = "success";
		$output['data']['ID'] = "$row->id";
		$output['data']['hash'] = "$hash";
		$output['data']['UserName'] = "$row->username";
		$output['data']['FirstName'] = "$row->firstname";
		$output['data']['LastName'] = "$row->lastname";
		$output['data']['Email'] = "$row->email";
		$output['data']['Photo'] = "$row->avatar";
		$output['data']['Facebook_Connected'] = "$row->fb";
		$output['data']['Twitter_Connected'] = "$row->tw";
		$output['data']['Gender'] = "$row->gender";
		$output['data']['Family'] = "$row->marital_status";
		$output['data']['Birth'] = "$row->birthdate";
		$output['data']['Description'] = "$row->description";
		$output['data']['PhoneNumber'] = "$row->phone";
		$output['data']['WebSite'] = "$row->website";
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	} else {
		$output['result'] = "failed";
		$output['error'] = "1";
	}
	echo json_encode($output);
}

<<<<<<< HEAD
//++
if ($method == "LoginFB") {
	$username = mysql_escape_string(substr($_REQUEST['ID'], 0 , 32));
	$password = mysql_escape_string(substr($_REQUEST['Password'], 0 , 32));
	$token = mysql_escape_string(substr($_REQUEST['Token'], 0 , 512));
=======
if ($method == "LoginFB") {
	$username = mysql_escape_string(substr($_POST['ID'], 0 , 32));
	$password = mysql_escape_string(substr($_POST['Password'], 0 , 32));
	$token = mysql_escape_string(substr($_POST['Token'], 0 , 512));
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	
	$query = "SELECT * FROM users WHERE fb = '$username' AND fb_pass = '$password' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if ($num_rows) {
		$row = mysql_fetch_object($result);
		
		$hash = md5(rand_string(20));
<<<<<<< HEAD
		$query1 = "UPDATE users SET hash = '$hash', token = '$token' WHERE id = '$row->id'";
		$result1 = mysql_query($query1);
		
		$output['result'] = "success";
		$output['data']['ID'] = "$row->id";
		$output['data']['hash'] = "$hash";
		$output['data']['UserName'] = "$row->username";
		$output['data']['FirstName'] = "$row->firstname";
		$output['data']['LastName'] = "$row->lastname";
		$output['data']['Email'] = "$row->email";
		$output['data']['Photo'] = "$row->avatar";
		$output['data']['Facebook_Connected'] = "$row->fb";
		$output['data']['Twitter_Connected'] = "$row->tw";
		$output['data']['Gender'] = "$row->gender";
		$output['data']['Family'] = "$row->marital_status";
		$output['data']['Birth'] = "$row->birthdate";
		$output['data']['Description'] = "$row->description";
		$output['data']['PhoneNumber'] = "$row->phone";
		$output['data']['WebSite'] = "$row->website";
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	} else {
		$output['result'] = "failed";
		$output['error'] = "1";
	}
	echo json_encode($output);
}

<<<<<<< HEAD
//++
if ($method == "LoginTW") {
	$username = mysql_escape_string(substr($_REQUEST['ID'], 0 , 32));
	$password = mysql_escape_string(substr($_REQUEST['Password'], 0 , 32));
	$token = mysql_escape_string(substr($_REQUEST['Token'], 0 , 512));
=======
if ($method == "LoginTW") {
	$username = mysql_escape_string(substr($_POST['ID'], 0 , 32));
	$password = mysql_escape_string(substr($_POST['Password'], 0 , 32));
	$token = mysql_escape_string(substr($_POST['Token'], 0 , 512));
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	
	$query = "SELECT * FROM users WHERE tw = '$username' AND tw_pass = '$password' LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if ($num_rows) {
		$row = mysql_fetch_object($result);
		
		$hash = md5(rand_string(20));
<<<<<<< HEAD
		$query1 = "UPDATE users SET hash = '$hash', token = '$token' WHERE id = $row->id";
		$result1 = mysql_query($query1);
		
		$output['result'] = "success";
		$output['data']['ID'] = "$row->id";
		$output['data']['hash'] = "$hash";
		$output['data']['UserName'] = "$row->username";
		$output['data']['FirstName'] = "$row->firstname";
		$output['data']['LastName'] = "$row->lastname";
		$output['data']['Email'] = "$row->email";
		$output['data']['Photo'] = "$row->avatar";
		$output['data']['Facebook_Connected'] = "$row->fb";
		$output['data']['Twitter_Connected'] = "$row->tw";
		$output['data']['Gender'] = "$row->gender";
		$output['data']['Family'] = "$row->marital_status";
		$output['data']['Birth'] = "$row->birthdate";
		$output['data']['Description'] = "$row->description";
		$output['data']['PhoneNumber'] = "$row->phone";
		$output['data']['WebSite'] = "$row->website";
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	} else {
		$output['result'] = "failed";
		$output['error'] = "1";
	}
	echo json_encode($output);
}

//++
if ($method == "CheckUsername") {
<<<<<<< HEAD
	$username = mysql_escape_string(substr($_REQUEST['UserName'], 0 , 32));
	
	$query = "SELECT COUNT(*) AS total FROM users WHERE username = '$username' LIMIT 0, 1";
=======
	$username = mysql_escape_string(substr($_POST['UserName'], 0 , 32));
	
	$query = "SELECT COUNT(*) AS total FROM users WHERE username LIKE '$username' LIMIT 0, 1";
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
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
<<<<<<< HEAD
	$email = mysql_escape_string(substr($_REQUEST['Email'], 0 , 128));
	
	$query = "SELECT COUNT(*) AS total FROM users WHERE email = '$email' LIMIT 0, 1";
=======
	$email = mysql_escape_string(substr($_POST['Email'], 0 , 128));
	
	$query = "SELECT COUNT(*) AS total FROM users WHERE email LIKE '$email' LIMIT 0, 1";
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);

	if ($row->total)
		$output['result'] = "failed";
	else
		$output['result'] = "success";

	sleep(1);		
	echo json_encode($output);
}

<<<<<<< HEAD
//+
if ($method == "UserInfo") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$id = (int)$_REQUEST['UserID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT user_id FROM follow WHERE user_id = '$row->id' AND following_id = '$id' LIMIT 0, 1";
	$result = mysql_query($query);
	$followedbyme = mysql_num_rows($result);
	
	$query = "SELECT * FROM users WHERE id = '$id' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT id FROM posts WHERE userid = '$id' AND subid = 0";
	$result = mysql_query($query);
	$created = mysql_num_rows($result);
	
	$query = "SELECT user_id FROM follow WHERE following_id = '$id'";
	$result = mysql_query($query);
	$followers = mysql_num_rows($result);
	
	$query = "SELECT user_id FROM follow WHERE user_id = '$id'";
	$result = mysql_query($query);
	$following = mysql_num_rows($result);

	$output['result'] = "success";
	$output['data']['ID'] = "$row->id";
	$output['data']['UserName'] = "$row->username";
	$output['data']['Status'] = "$row->status";
	$output['data']['FirstName'] = "$row->firstname";
	$output['data']['LastName'] = "$row->lastname";
	$output['data']['Email'] = "$row->email";
	$output['data']['Photo'] = "$row->avatar";
	$output['data']['Facebook_Connected'] = "$row->fb";
	$output['data']['Twitter_Connected'] = "$row->tw";
	$output['data']['Gender'] = "$row->gender";
	$output['data']['Family'] = "$row->marital_status";
	$output['data']['Birth'] = "$row->birthdate";
	$output['data']['Description'] = "$row->description";
	$output['data']['PhoneNumber'] = "$row->phone";
	$output['data']['WebSite'] = "$row->website";
	$output['data']['Wins'] = "$row->wins";					////////////////
	$output['data']['Entries'] = "$row->entries";			////////////////
	$output['data']['Followers'] = "$followers";
	$output['data']['Following'] = "$following";
	$output['data']['Level'] = "$row->level";
	$output['data']['FollowedByMe'] = "$followedbyme";
	$output['data']['Created'] = "$created";

	sleep(1);
	echo json_encode($output);
}

//++
if ($method == "ChangePassword") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$pass_old = mysql_escape_string(substr($_REQUEST['PasswordOld'], 0 , 32));
	$pass_new1 = mysql_escape_string(substr($_REQUEST['PasswordNew'], 0 , 32));
	$pass_new2 = mysql_escape_string(substr($_REQUEST['PasswordRepeat'], 0 , 32));
	
	$query = "SELECT COUNT(*) AS total FROM users WHERE hash = '$hash' AND password = '$pass_old' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	if ($row->total) {
		if ($pass_new1 == $pass_new2) {
			$query = "UPDATE users SET password = '$pass_new1' WHERE hash = '$hash'";
			$result = mysql_query($query);
		
			$output['result'] = "success";
		} else {
			$output['result'] = "failed";
		}
	} else {
		$output['result'] = "failed";
	}
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
		
	echo json_encode($output);
}

<<<<<<< HEAD
//++
if ($method == "UserInfoUpdate") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$username = mysql_escape_string(substr($_REQUEST['UserName'], 0 , 32));
	$firstname = mysql_escape_string(substr($_REQUEST['FirstName'], 0 , 32));
	$lastname = mysql_escape_string(substr($_REQUEST['LastName'], 0 , 32));
	$gender = (int)$_REQUEST['Gender'];
	$marital_status = (int)$_REQUEST['Family'];
	$birthdate = mysql_escape_string(substr($_REQUEST['Birth'], 0 , 32));
	$description = mysql_escape_string(substr($_REQUEST['Description'], 0 , 1024));
	$email = mysql_escape_string(substr($_REQUEST['Email'], 0 , 128));
	$phone = mysql_escape_string(substr($_REQUEST['PhoneNumber'], 0 , 32));
	$website = mysql_escape_string(substr($_REQUEST['WebSite'], 0 , 256));
	$avatar = $_FILES['Photo']['name'];
	$avatar_ext = explode(".", $avatar);
	$avatar_ext = $avatar_ext[sizeof($avatar_ext) - 1];
	
	if ($username != "") $username_query = "username = '$username', "; else $username_query = "";
	if ($firstname != "") $firstname_query = "firstname = '$firstname', "; else $firstname_query = "";
	if ($lastname != "") $lastname_query = "lastname = '$lastname', "; else $lastname_query = "";
	if ($birthdate != "") $birthdate_query = "birthdate = '$birthdate', "; else $birthdate_query = "";
	if ($description != "") $description_query = "description = '$description', "; else $description_query = "";
	if ($email != "") $email_query = "email = '$email', "; else $email_query = "";
	if ($phone != "") $phone_query = "phone = '$phone', "; else $phone_query = "";
	if ($website != "") $website_query = "website = '$website', "; else $website_query = "";
		
	if ($avatar != "") {
		$filename = rand_string(20).".$avatar_ext";
		$uploadfile = dirname(__FILE__)."/../users/avatars/$filename";
		move_uploaded_file($_FILES['Photo']['tmp_name'], $uploadfile);
		$avatar_file = "'http://".$_SERVER['SERVER_NAME']."/users/avatars/$filename'";
		$avatar_query = "avatar = $avatar_file, ";
	} else {
		$avatar_query = "";
	}

	$query = "UPDATE users SET $avatar_query $username_query  $firstname_query $lastname_query $birthdate_query $description_query $email_query $phone_query $website_query gender = '$gender', marital_status = '$marital_status' WHERE hash = '$hash'";
	$result = mysql_query($query);
	
	$query = "SELECT * FROM users WHERE hash = '$hash'";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$output['result'] = "success";
	$output['data']['ID'] = "$row->id";
	$output['data']['hash'] = "$hash";
	$output['data']['UserName'] = "$row->username";
	$output['data']['FirstName'] = "$row->firstname";
	$output['data']['LastName'] = "$row->lastname";
	$output['data']['Gender'] = "$row->gender";
	$output['data']['Family'] = "$row->marital_status";
	$output['data']['Photo'] = "$row->avatar";
	$output['data']['Birth'] = "$row->birthdate";
	$output['data']['Description'] = "$row->description";
	$output['data']['Email'] = "$row->email";
	$output['data']['PhoneNumber'] = "$row->phone";
	$output['data']['WebSite'] = "$row->website";
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
		
	echo json_encode($output);
}

<<<<<<< HEAD
//++
if ($method == "MyTeam") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "(SELECT user_id FROM follow WHERE following_id = '$row->id') UNION (SELECT following_id FROM follow WHERE user_id = '$row->id')";
	$result = mysql_query($query);
	
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT * FROM users WHERE id = '$row->user_id' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		$output['data'][$n]['ID'] = "$row1->id";
		$output['data'][$n]['UserName'] = "$row1->username";
		$output['data'][$n]['Status'] = "$row1->status";
		$output['data'][$n]['FirstName'] = "$row1->firstname";
		$output['data'][$n]['LastName'] = "$row1->lastname";
		$output['data'][$n]['Photo'] = "$row1->avatar";
		$output['data'][$n]['Level'] = "$row1->level";
		$n++;
	}
	
	$output['result'] = "success";	
	echo json_encode($output);
}

//++
if ($method == "Get_followers") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT user_id FROM follow WHERE following_id = '$row->id'";
	$result = mysql_query($query);
	
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT * FROM users WHERE id = '$row->user_id' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		$output['data'][$n]['ID'] = "$row1->id";
		$output['data'][$n]['UserName'] = "$row1->username";
		$output['data'][$n]['Status'] = "$row1->status";
		$output['data'][$n]['FirstName'] = "$row1->firstname";
		$output['data'][$n]['LastName'] = "$row1->lastname";
		$output['data'][$n]['Photo'] = "$row1->avatar";
		$output['data'][$n]['Level'] = "$row1->level";
		$n++;
	}
	
	$output['result'] = "success";	
	echo json_encode($output);
}

//++
if ($method == "Get_following") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT following_id FROM follow WHERE user_id = '$row->id'";
	$result = mysql_query($query);
	
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT * FROM users WHERE id = '$row->following_id' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$row1 = mysql_fetch_object($result1);
		
		$output['data'][$n]['ID'] = "$row1->id";
		$output['data'][$n]['UserName'] = "$row1->username";
		$output['data'][$n]['Status'] = "$row1->status";
		$output['data'][$n]['FirstName'] = "$row1->firstname";
		$output['data'][$n]['LastName'] = "$row1->lastname";
		$output['data'][$n]['Photo'] = "$row1->avatar";
		$output['data'][$n]['Level'] = "$row1->level";
		$n++;
	}
	
	$output['result'] = "success";	
	echo json_encode($output);
}

//++
if ($method == "MyNotificationsNum") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT COUNT(*) AS total FROM notifications WHERE user_id = '$row->id'";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);

	$output['result'] = "success";
	$output['total'] = "$row->total";
=======
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
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
		
	echo json_encode($output);
}

<<<<<<< HEAD
//------------------
if ($method == "MyNotifications") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	
	$query = "SELECT * FROM notifications WHERE user_id = '$row->id'";
=======
if ($method == "MyNotifications") {
	$hash = $_POST['Hash'];
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$userid = $row->id;
	
	$query = "SELECT * FROM notifications WHERE user_id = $userid";
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	$result = mysql_query($query);

	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
<<<<<<< HEAD
		$query1 = "SELECT * FROM users WHERE id = '$row->user_id'";
		$result1 = mysql_query($query1);
		
		$output['data'][$n]['ID'] = "$row1->id";
		$output['data'][$n]['UserName'] = "$row1->username";
		$output['data'][$n]['Photo'] = "$row1->avatar";
		$output['data'][$n]['Level'] = "$row1->level";
=======
		$query1 = "SELECT * FROM users WHERE id = $row->user_id";
		$result1 = mysql_query($query1);
		
		$output['data'][$n]['ID'] = $row1->id;
		$output['data'][$n]['UserName'] = $row1->username;
		$output['data'][$n]['Photo'] = $row1->avatar;
		$output['data'][$n]['Level'] = $row1->level;
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
		$output['data'][$n]['Action'] = "";
		$output['data'][$n]['Title'] = "";
		$n++;
	}
		
	echo json_encode($output);
}

<<<<<<< HEAD
//++
if ($method == "Search_User") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$user_name = mysql_escape_string(substr($_REQUEST['Search_User'], 0 , 32));
	$user_id = (int)$_REQUEST['ID'];
	
	$query = "SELECT id FROM users WHERE hash = '$hash' LIMIT 0, 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$id = $row->id;
	
	if ($user_name != "") {
		$query = "SELECT * FROM users WHERE (username LIKE '$user_name%') OR (firstname LIKE '$user_name%') OR (lastname LIKE '$user_name%')";
	} elseif ($user_id) {
		$query = "SELECT * FROM users WHERE id = '$user_id'";
	}
	
	$result = mysql_query($query);
	
	$output['result'] = "success";
	$n = 0;
	while ($row = mysql_fetch_object($result)) {
		$query1 = "SELECT user_id FROM follow WHERE user_id = '$id' AND following_id = '$row->id' LIMIT 0, 1";
		$result1 = mysql_query($query1);
		$followedbyme = mysql_num_rows($result1);

		$output['data'][$n]['ID'] = "$row->id";
		$output['data'][$n]['UserName'] = "$row->username";
		$output['data'][$n]['Photo'] = "$row->avatar";
		$output['data'][$n]['Level'] = "$row->level";
		$output['data'][$n]['Status'] = "$row->status";
		$output['data'][$n]['FollowedByMe'] = "$followedbyme";
		$n++;
	}

	sleep(1);
	echo json_encode($output);
}

//++
if ($method == "Logout") {
	$hash = mysql_escape_string(substr($_REQUEST['Hash'], 0 , 32));
	$token = mysql_escape_string(substr($_REQUEST['Token'], 0 , 512));
		
	$query = "UPDATE users SET hash = '', token = '' WHERE hash = '$hash'";
	$result = mysql_query($query);
	
	$output['result'] = "success";
	echo json_encode($output);
}

if ($method == "ForgotPassword") {
	$email = mysql_escape_string(substr($_REQUEST['Email'], 0 , 128));
	if ($email != "") {
		$query = "SELECT COUNT(*) AS total FROM users WHERE email = '$email' LIMIT 0, 1";
		$result = mysql_query($query);
		$row = mysql_fetch_object($result);
		
		if ($row->total){
			$password_restore = rand_string(10);
			$hash = md5($password_restore);
			
			$query = "UPDATE users SET password_restore = '$hash' WHERE email = '$email'";
			$result = mysql_query($query);
			
			include("templates/email/forgot_password.php");			
			
			$output['result'] = "success";
	
		} else {
			$output['result'] = "failed";
		}
	} else {
		$output['result'] = "failed";
	}
	
=======
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
		
>>>>>>> 6efe23e6e14fb0778c95d52173f3548a10bf3a80
	echo json_encode($output);
}
?>