<?
include ("header.php");

echo '
<table width="100%" height="0" border="1" align="center">
	<tr align="center">
		<td>Ответы на челлендж</td>
	</tr>
</table>
';

$challenge_id = $_REQUEST['challenge_id'];
$callenge_answers_id = $_REQUEST['challenge_answer_id'];

/*
$query = "SELECT challenge_title, category FROM fgp_group WHERE ID = $challenge_id LIMIT 0, 1";
$result = mysql_query($query);
$row = mysql_fetch_object($result);
$challenge_title = $row->challenge_title;
$challnge_category = $row->category;

$query = "SELECT group_members FROM fgp_group WHERE ID = $challenge_id LIMIT 0, 1";
$result = mysql_query($query);
$row = mysql_fetch_object($result);
$temp = explode(",", $row->group_members);
$callenge_answers_array = array();
for ($n = 1; $n < sizeof($temp); $n++) {
	$callenge_answers_array[$n-1] = $temp[$n];	
}

if ($_REQUEST['challenge_answer_id']) {
	$callenge_answers_array = array();
	$callenge_answers_array[0] = $_REQUEST['challenge_answer_id'];	
}
*/
for ($n = 0; $n < sizeof($callenge_answers_array); $n++) {
	$query = "SELECT userID, URL FROM fgp_posts WHERE ID = $callenge_answers_array[$n] LIMIT 0, 1";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if (!$num_rows) continue;
	$row = mysql_fetch_object($result);
	$challnge_user_id = $row->userID;
	$challnge_avatar = $row->URL;
	
	$query1 = "SELECT firstname FROM fgp_users WHERE ID = $challnge_user_id LIMIT 0, 1";
	$result1 = mysql_query($query1);
	$row1 = mysql_fetch_object($result1);
	$challnge_nickname = $row1->firstname;
	
	echo '
		<table width="100%" height="0" border="1" align="left">
		<tr align="left">
			<td>
			Название челленджа: '.$challenge_title.'<br>	
			Категория челленджа: '.$challnge_category.'<br>
			Автор ответа на челлендж (ник): '.$challnge_nickname.'<br>
			';
			$temp = explode(".", $challnge_avatar);
			$ext = $temp[1];
			if ($ext == "mov") {
				echo '
				<video width="320" controls src="../page/uploaded_files/'.$challnge_avatar.'" type="video/mov"></video><br>
				';
			} elseif ($ext == "jpg") {
				echo '
				<img src="../page/uploaded_files/'.$challnge_avatar.'" width="320"><br>
				';
			}
			if (!$_REQUEST['challenge_answer_id']) echo '
			<form action="challenge_answers.php" method="post">
			<input type="hidden" name="challenge_id" value="'.$challenge_id.'">
			<input type="hidden" name="challenge_answer_id" value="'.$callenge_answers_array[$n].'">
			<input type="submit" value="Просмотреть ответ">
			</form>
			';
			echo '
			<form action="answer_delete.php" method="post">
			<input type="hidden" name="challenge_id" value="'.$challenge_id.'">
			<input type="hidden" name="challenge_answer_id" value="'.$callenge_answers_array[$n].'">
			<input type="submit" value="Удалить ответ" onclick="return confirm(\'Вы уверены, что хотите удалить этот ответ?\');">
			</form>
			</td>
		</tr>
		</table>
	';
}	

include ("footer.php");
?>