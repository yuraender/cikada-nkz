<?php
		require_once 'metodist_redirect_logic.php';

	  if ( !isset($_GET['id'])) exit;

		require_once '../db_config.php';
		$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
		mysqli_set_charset($ctn, "utf8");

		$id = $_GET['id'];

		if ( isset($_POST['name']) ) 
		{
			$result = mysqli_query($ctn, "UPDATE Team SET name = '{$_POST['name']}' WHERE id = '{$id}'");

			if ( $result ) 
			{
				header("Location: team_editor.php");
			} 
			else 
			{
				echo "Что-то пошло не так...";
				echo "<a href='team_editor.php'>Вернуться к списку</a>";
			}
		}

		if ( isset($_POST['status']) ) 
		{
			$result = mysqli_query($ctn, "UPDATE Team SET status = '{$_POST['status']}' WHERE id = '{$id}'");

			if ( $result ) 
			{
				header("Location: team_editor.php");
			} 
			else 
			{
				echo "Что-то пошло не так...";
				echo "<a href='team_editor.php'>Вернуться к списку</a>";
			}
		}

		if ( isset($_POST['score']) ) 
		{
			$result = mysqli_query($ctn, "UPDATE Team SET score = '{$_POST['score']}' WHERE id = '{$id}'");

			if ( $result ) 
			{
				header("Location: team_editor.php");
			} 
			else 
			{
				echo "Что-то пошло не так...";
				echo "<a href='team_editor.php'>Вернуться к списку</a>";
			}
		}
		if ( isset($_POST['idForDeletion']) ) 
		{
			$result = mysqli_query($ctn, "DELETE FROM Team WHERE id = '{$id}'");

			if ( $result ) 
			{
				header("Location: team_editor.php");
			} 
			else 
			{
				echo "Что-то пошло не так...";
				echo "<a href='team_editor.php'>Вернуться к списку</a>";
			}
		}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<title>Редактировать команду</title>
</head>
<body>
	<h1>Редактировать команду</h1>
	<?php

	    $id = $_GET['id'];
	    $result = mysqli_query($ctn, "SELECT * FROM Team WHERE id=" . $id);
	    $record = mysqli_fetch_assoc($result);

	    if ( !$record ) {
	    	echo 'Нет записи для удаления. Возможно, ее удалили ранее';
	    	exit;
	    }
	    ?>

		<form id="appForm" enctype="multipart/form-data" method="POST">

			Название<br>
			<input type="text" name="name" size="50" <?php if ( isset($record) ) echo 'value="'.$record['name'].'"'; ?> >
			<br><br>

			Номинация / место<br>
			<select name='status' method='POST'>
				<option value='не выбрано' <?php if ($record["status"] == 'не выбрано') echo 'selected'; ?>>не выбрано</option>
				<option value='1 место' <?php if ($record["status"] == '1 место') echo 'selected'; ?>>1 место</option>
				<option value='2 место' <?php if ($record["status"] == '2 место') echo 'selected'; ?>>2 место</option>
				<option value='3 место' <?php if ($record["status"] == '3 место') echo 'selected'; ?>>3 место</option>
			</select>
			<br><br>

			Результат<br>
			<input type="text" name="score" size="50" <?php if ( isset($record) ) echo 'value="'.$record['score'].'"'; ?> >
			<br><br>
			
			<input type="submit" value="Обновить команду">
			<input type="submit" name="idForDeletion" class="button" value="Удалить команду">
		</form>
		<br>
	  
</body>
</html>