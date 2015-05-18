<?
require_once ("../config.php");
$conn = connect_db($hostdb, $userdb, $passdb, $db);
mysql_query("SET NAMES utf8");

echo '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin panel</title>
</head>
<body>
<table width="100%" height="0" border="1" align="center">
	<tr align="center">
		<td><a href="index.php">Список челленджей</a></td>
		<td><a href="logout.php">Выход</a></td>
	</tr>
</table>
<br><br><br><br>
';
?>