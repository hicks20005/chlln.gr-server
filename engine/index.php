<?
define("ENGINE", TRUE);
require_once ("../config.php");
$conn = connect_db($hostdb, $userdb, $passdb, $db);
mysql_query("SET NAMES utf8");

$type = $_GET['type'];

switch ($type) {
	case 'User':
		require_once ("User.php");
		break;
	case 'Challenge':
		require_once ("Challenge.php");
		break;
	case 'Comments':
		require_once ("Comments.php");
		break;
	case 'Follow':
		require_once ("Follow.php");
		break;
	case 'Likes':
		require_once ("Likes.php");
		break;
	default:
		echo "Hack attempt...";
		break;
}

disconnect_db($conn);
/*
	$filename = 'test.txt';
	$somecontent = $query;
	$handle = fopen($filename, 'w');
	fwrite($handle, $somecontent);
    fclose($handle);
*/
?>