<?
include ("header.php");

$challenge_search_title = $_REQUEST['challenge_search_title'];
$challenge_search_category = $_REQUEST['challenge_search_category'];

echo '
<table width="100%" height="0" border="1" align="center">
	<tr align="center">
		<td>Все челленджи</td>
	</tr>
</table>
<table width="100%" height="0" border="1" align="center">
	<tr align="center">
		<td>
			<form action="" method="post">
			<input type="hidden" name="search" value="1">
			Название челленджа: <input type="text" name="challenge_search_title" size="50" value="">&nbsp;&nbsp;&nbsp;&nbsp;
			Категория челленджа: 
			<select name="challenge_search_category">
				<option value="">Все категории</option>
				';
				$query = "SELECT title FROM posts ORDER BY date";
				$result = mysql_query($query);
				while ($row = mysql_fetch_object($result)) {
					//echo '
					//<option value="'.$row->title.'">'.$row->title.'</option>
					//';
				}
			echo '
			</select><br>
			<input type="submit" value="Поиск">
			</form>
		</td>
	</tr>
</table>
';

$query = "SELECT ID, group_members, challenge_title, category FROM fgp_group";
if ($challenge_search_title != "") {
	$query .= " WHERE challenge_title LIKE '%$challenge_search_title%'";
	if ($challenge_search_category != "") {
		$query .= " AND category LIKE '%$challenge_search_category%'";
	}
} else {
	if ($challenge_search_category != "") {
		$query .= " WHERE category LIKE '%$challenge_search_category%'";
	}
}

$query = "SELECT id, userid, type, title, category, file FROM posts WHERE subid = 0 ";
if ($challenge_search_title != "") {
	$query .= " AND (title LIKE '%$challenge_search_title%')";
	if ($challenge_search_category != "") {
		$query .= " AND (category LIKE '%$challenge_search_category%')";
	}
} else {
	if ($challenge_search_category != "") {
		$query .= " AND (category LIKE '%$challenge_search_category%')";
	}
}
$query .= " ORDER BY date";
$result = mysql_query($query);
while ($row = mysql_fetch_object($result)) {
	$challenge_id = $row->id;
	$challenge_title = $row->title;
	$challenge_category = $row->category;
	$challenge_user_id = $row->userid;
	$challenge_avatar = $row->file;
	
	$query1 = "SELECT username FROM users WHERE id = '$challenge_user_id' LIMIT 0, 1";
	$result1 = mysql_query($query1);
	$row1 = mysql_fetch_object($result1);
	$challenge_nickname = $row1->username;
	
	echo '
		<table width="100%" height="0" border="1" align="left">
		<tr align="left">
			<td>
			Название челленджа: '.$challenge_title.'<br>	
			Категория челленджа: '.$challenge_category.'<br>
			Автор челленджа (ник): '.$challenge_nickname.'<br>
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
			<form action="challenge_view.php" method="post">
			<input type="hidden" name="challenge_id" value="'.$challenge_id.'">
			<input type="submit" value="Просмотреть челлендж">
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