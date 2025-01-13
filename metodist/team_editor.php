<?php
		require_once 'metodist_redirect_logic.php';
		require_once '../db_config.php';
		$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
		mysqli_set_charset($ctn, "utf8");

		if ( isset($_POST['team'])) 
		{
			$result = mysqli_query($ctn, "INSERT INTO Team (name, status, score) VALUES ('{$_POST['team']}', 'не выбрано', '0')");
		}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<title>Редактор команд</title>
	<style type="text/css">

		#list_table table, #list_table th, #list_table td {
			border: 1px solid #888;
		}

		#list_table th, #list_table td
		{
			padding: 20px;
		}

	</style>
</head>
<body>
	<a href="team_list.php"><< Вернуться</a>

	<h1>Редактировать команды</h1>
	<?php
		require_once '../db_config.php';
		$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
		mysqli_set_charset($ctn, "utf8");

		$result = mysqli_query($ctn, "SELECT * FROM Team ORDER BY id");

		echo '<h2>Зарегистрировано команд: ';
		echo mysqli_num_rows($result);
		echo '</h2> <br>';

		echo '<table id="list_table">
		<th>Название</th>
		<th>Место / номинация</th>
		<th>Результат</th>
		<th>Ред.</th>';

		while ($row = mysqli_fetch_assoc($result)) 
		{
		    echo '<tr>';
		    printf ("<td>%s</td>\n", $row["name"]);
		    printf ("<td>%s</td>\n", $row["status"]);
		    printf ("<td>%s</td>\n", $row["score"]);
		    printf ("<td><a href=\"edit_team.php?id=%s\"> <img src=\"../admin/editw.png\"> </a> </td>\n", $row["id"]);
		    echo '</tr>';
		}

	  	echo '<tr>';
	?>
		<tr>
		  <form id="appForm" enctype="multipart/form-data" method="POST">
		  <td colspan='3'><input type='text' name='team' placeholder='Введите название новой команды' size='50'></td>
		  <td> <input type="submit" value="Добавить команду">
		</tr>
	  </form>
	</table>

	<br>
	<a href="team_list.php"><< Вернуться</a>
</body>
</html>