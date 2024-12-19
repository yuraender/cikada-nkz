<?php
session_start();
require_once 'metodist_redirect_logic.php';

if ( isset($_POST['result_id']) && isset($_POST['new_score']) ) {

	//echo "UPDATE Result SET score = {$_POST['new_score']} WHERE id = {$_POST['result_id']})";
	//exit();

	$r = mysqli_query($ctn, "UPDATE Result SET score = {$_POST['new_score']} WHERE id = {$_POST['result_id']}");
	header("Location: /metodist/grade_list.php");
	exit;
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="metodist.css">
	<title>Изменить балл участнику</title>

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
	<?php require "header.html"; ?>
	<div id="pageContainer">
		<?php require "metodist_menu.php"; ?>
		<div id="userContent">
			<h3>Изменить балл участнику</h3>
	<?php 

		$sameteacher = "AND teacher_id = {$user['id']}";
		if ( $user['id'] == 23 ) $sameteacher = "";

		$result = mysqli_query($ctn, "
			SELECT *
			FROM Result
			LEFT JOIN Task ON Task.id = task_id
			LEFT JOIN User ON User.id = u_id
			WHERE Result.id = {$_GET['result']} {$sameteacher}
			");
		
		if ( ! $result ){
			echo "Невозможно изменить балл";
			exit();
		}

		$row = mysqli_fetch_assoc($result);
		if ( !isset( $row ) ){
			echo "Невозможно изменить балл";
			exit();
		}

		echo "Участник:";
		echo "<h3>". $row['lname'] . " " . $row['fname'] . " " . $row['patronym'] . "</h3>";
		echo "Задание:";
		echo "<h3>{$row['title']}</h3>";
		echo "Балл:";
		echo "<form method='post' action='change_score.php'>";
		echo "<input type='hidden' name='result_id' value='{$_GET['result']}'>";
		echo "<input type='text' name='new_score' value='{$row['score']}'><br><br>";
		echo "<input type='submit' value='Сохранить изменения'></form>";
	?>

	</div> 

</body>
</html>