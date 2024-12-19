<?php
session_start();
require_once 'metodist_redirect_logic.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="metodist.css">
	<title>Проставить баллы</title>

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
			<h3>Доступные задания для оценки</h3>
			<?php 
			$result = mysqli_query($ctn, "
				SELECT *, Task.id as tid
				FROM AllowCheck, Task
				WHERE task_id = Task.id  AND teacher_id = {$user['id']}
				");
			while ( $row = mysqli_fetch_assoc($result) ) {

				echo "<a href='?task={$row['tid']}'>{$row['title']}</a><br><br>";

			}
			
			if ( !isset($_GET['task']) ) { 
				echo "<h3>Выберите одно из доступных заданий</h3>";
				exit();
			}

			$current_task_id = $_GET['task'];
			$task_title = mysqli_fetch_assoc( mysqli_query($ctn, "SELECT * FROM AllowCheck, Task
				WHERE task_id = Task.id AND task_id = {$current_task_id}  AND teacher_id = {$user['id']}
				") );
			if ( isset($task_title) ) {
				echo "<h3>{$task_title['title']}</h3>";

			} else {
				echo "<h3>Выберите одно из доступных заданий</h3>";
				exit();
			}

			$where_grade = "";
			switch ( $current_task_id ) {
				case 1: 
				case 3:
				$where_grade = ' AND ( grade LIKE "%8%" OR grade LIKE "%9%" )';
				break;
				case 2:
				case 4:
				case 5:
				case 6:
				case 7:
				$where_grade = ' AND ( grade LIKE "%10%" OR grade LIKE "%11%" )';
				break;
			}


			$result = mysqli_query($ctn, "
				SELECT *, User.id as user_id, R.id as result_id
				FROM User
				LEFT JOIN PersonalData ON User.id = PersonalData.u_id
				LEFT JOIN (SELECT * FROM Result WHERE task_id = {$current_task_id} OR task_id IS NULL ) R ON User.id = R.u_id 
				WHERE User.status = 3 {$where_grade}
				ORDER BY lname
				");
				?>

				<form enctype="multipart/form-data" method="post" action="save_score.php">
					<input type='hidden' name='taskid' value='<?php echo $current_task_id; ?>'>
					<table id="list_table">
						<th>№</th>
						<th>ФИО</th>
						<th>Класс</th>
						<th>Проставлено</th>
						<th>Ответственный</th>
						<th>Ваш балл</th>

						<?php

						$idx = 1;
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";	
							echo "<td>" . $idx . "</td>";
							echo "<td>" . $row['lname'] . " " . $row['fname'] . " " . $row['patronym'] . "</td>";

							echo "<td>" . $row['grade'] . "</td>";
							echo "<td>" . $row['score'] . "</td>";
							echo "<td>";
							if ( isset($row['teacher_id']) ) {
								$teacher = mysqli_fetch_assoc( mysqli_query($ctn, "SELECT * FROM User WHERE id = {$row['teacher_id']}") );
								echo $teacher['lname'] . " ";

								mb_internal_encoding("UTF-8");
								echo mb_substr($teacher['fname'], 0, 1) . ". ";
								echo mb_substr($teacher['patronym'], 0, 1)  . ".";


							}

							echo "<input type='hidden' name='userid{$idx}' value='{$row['user_id']}'>";
							
							
							if ( isset($row['score']) ) {
								
								echo "<td> <input type='hidden' name='score{$idx}'> ";
								if ( $row['teacher_id'] == $user['id'] OR $user['id'] == 23 ) {
									echo "<a href='change_score.php?result=" . $row['result_id'] . "'>Изменить балл</a>";
								}
								echo "</td>";
							} else {
								echo "<td> <input type='text' name='score{$idx}'> </td>";
							}
							echo "";

							$idx++;

						}
						?>

						<tr>
							<td><td><td><td><td><td>
								<input type="submit" value="Сохранить оценки">

							</form>

						</table>

					</div> 

</body>
</html>