<?php require_once 'manage_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="manage.css">
	<title>Список результатов</title>
	<style type="text/css">

		#list_table table, #list_table th, #list_table td {
			border: 1px solid #888;
		}

		#list_table th, #list_table td
		{
			padding: 20px;
		}


		tr.yellow {
			background-color: #FFA;
		}

		tr.red {
			background-color: #FCC;
		}

		tr.green {
			background-color: #DFD;
		}


	</style>
</head>
<body>
	<?php require "header.html"; ?>
	<div id="pageContainer">
		<?php require "manage_menu.php"; ?>

		<div id="userContent">

		<h2>Список результатов</h2>

		<b><a href="?grade=eight">8 класс</a></b> | 
		<b><a href="?grade=nine">9 класс</a></b> | 
		<b><a href="?grade=ten">10 класс</a></b> | 
		<b><a href="?grade=eleven">11 класс</a></b>

		<br><br>

		<table id="list_table">
			<th>№</th>
			<th>ФИО</th>
			<th>Город</th>
			<th>Школа</th>
			<th>Класс</th>
			<th>Оценено заданий</th>
			<th>Набрано баллов</th>
  			<th>Телефон</th>
  			<th>Почта</th>
  			<th>Родители</th>
  			<th>Телефон родителя</th>
  			<th>Преподаватель</th>
  			<th>Классный руководитель</th>

  			<?php

  			$where_grade = "";
  			if ( isset($_GET['grade']) ) {
  				switch ($_GET['grade']) {
					case 'eight': $where_grade = ' AND ( grade LIKE "%8%" )';
					break;
					case 'nine': $where_grade = ' AND ( grade LIKE "%9%" )';
					break;
					case 'ten': $where_grade = ' AND ( grade LIKE "%10%" )';
					break;
					case 'eleven': $where_grade = ' AND ( grade LIKE "%11%" )';
					break;
				}
  			}

  			$result = mysqli_query($ctn, "
				SELECT User.id as userid, lname, fname, patronym, town, name, grade, cntscore, sumscore,  phone, email, nameParent, phoneParent, teacherIKT, classTeacher
				FROM User, PersonalData, School,
				(SELECT u_id, COUNT(score) as cntscore, SUM(score) as sumscore FROM Result GROUP BY u_id) TotalResult
				WHERE User.status = 3 AND TotalResult.u_id = User.id
				AND PersonalData.u_id = User.id AND school_id = School.id {$where_grade}
			    ORDER BY sumscore DESC
				");

  			$idx = 1;

			while ($row = mysqli_fetch_assoc($result)) {
				echo '<tr class=';
				switch ($row['cntscore']) {
					case 1: echo "red";
					break;
					case 2: echo "yellow";
					break;
					default: echo "green";
					break;
				}
				echo ">";

				// echo '<td>' . $idx;
				echo '<td><a href="result_send.php?userid=' . $row["userid"] . '">' . $row["userid"] . '</a>';
				
				$idx++;

				printf ("<td>%s %s %s</td>", $row["lname"], $row["fname"], $row["patronym"]);

				printf ("<td>%s</td>", $row["town"]);
				printf ("<td>%s</td>", $row["name"]);
				printf ("<td>%s</td>", $row["grade"]);

				printf ("<td>%s</td>", $row["cntscore"]);
				printf ("<td>%s</td>", $row["sumscore"]);

				printf ("<td>%s</td>", $row["phone"]);
				printf ("<td>%s</td>", $row["email"]);

				printf ("<td>%s</td>", $row["nameParent"]);
				printf ("<td>%s</td>", $row["phoneParent"]);

				printf ("<td>%s</td>", $row["teacherIKT"]);
				printf ("<td>%s</td>", $row["classTeacher"]);


			}
  			?>

  		</table>
			
		</div>
	</div>
</body>
</html>