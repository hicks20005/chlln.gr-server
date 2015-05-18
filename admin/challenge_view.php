<?
include ("header.php");

echo '
<table width="100%" height="0" border="1" align="center">
	<tr align="center">
		<td>Просмотр челленджа</td>
	</tr>
</table>
';

if ($_REQUEST['action'] == "edit") {
	$challenge_id = $_REQUEST['challenge_id'];
	$challenge_title = $_REQUEST['challenge_title'];
	$challenge_description = $_REQUEST['challenge_description'];
		
	$query = "UPDATE posts SET title = '$challenge_title', description = '$challenge_description' WHERE id = '$challenge_id'";
	$result = mysql_query($query);
}

$challenge_id = $_REQUEST['challenge_id'];
$query = "SELECT userid, file, title, category, description FROM posts WHERE id = '$challenge_id' AND subid = 0 LIMIT 0, 1";
$result = mysql_query($query);
while ($row = mysql_fetch_object($result)) {
	$challenge_title = $row->title;
	$challenge_category = $row->category;
	$challenge_user_id = $row->userid;
	$challenge_avatar = $row->file;
	$challenge_description = $row->description;

	$query1 = "SELECT username FROM users WHERE id = '$challenge_user_id' LIMIT 0, 1";
	$result1 = mysql_query($query1);
	$row1 = mysql_fetch_object($result1);
	$challenge_nickname = $row1->username;
	
	echo '
		<table width="100%" height="0" border="1" align="left">
		<tr align="left">
			<td>
			<form action="challenge_view.php" method="post">
			Название челленджа: <input type="text" name="challenge_title" size="100" value="'.$challenge_title.'"><br>
			Категория челленджа: '.$challenge_category.'<br>
			Автор челленджа (ник): '.$challenge_nickname.'<br>
			Описание челленджа: <input type="text" name="challenge_description" size="100" value="'.$challenge_description.'"><br>
			';
			if ($row->type == 2) {
				echo '
				<video width="320" controls src="'.$challenge_avatar.'" type="video/mov"></video><br>
				';
			} elseif ($row->type == 1) {
				echo '
				<img src="'.$challenge_avatar.'" width="320"><br>
				';
			}
			echo '
			<input type="hidden" name="challenge_id" value="'.$challenge_id.'">
			<input type="hidden" name="action" value="edit">
			<input type="submit" value="Сохранить изменения" onclick="return confirm(\'Вы уверены, что хотите сохранить изменения?\');">
			</form>
			<form action="challenge_answers.php" method="post">
			<input type="hidden" name="challenge_id" value="'.$challenge_id.'">
			<input type="submit" value="Просмотр списка ответов">
			</form>
			<form action="challenge_delete.php" method="post">
			<input type="hidden" name="challenge_id" value="'.$challenge_id.'">
			<input type="submit" value="Удалить челлендж" onclick="return confirm(\'Вы уверены, что хотите удалить этот челлендж?\');">
			</form>
			</td>
		</tr>
		</table>
	';
}

include ("footer.php");
?>