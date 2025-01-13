<?php require_once 'manage_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="manage.css">
	<title>Приём заявок</title>
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
		<?php require "manage_menu.php"; ?>

		<div id="userContent">

		<h2>Список участников</h2>

		<a href="?status=3">Показать только участников с принятыми заявками</a>

		<br><br>

		<table id="list_table">
			<th>№</th>
			<th>ФИО</th>
			<th>Статус</th>
			<th>Город</th>
			<th>Школа</th>
			<th>Класс</th>
  			<th>Телефон</th>
  			<th>Почта</th>
  			<th>Заявка</th>

  			<?php

  			$where_status = "";
  			if ( isset($_GET['status']) ) $where_status = "AND Scan.status = " . $_GET['status'];

  			$result = mysqli_query($ctn, "
  				SELECT User.*, DATE_FORMAT(created_at, '%d.%m.%Y %H:%i') as register_date,
  				Scan.status as scan_status, User.id as user_id, PersonalData.*, School.*
 				FROM User
 					LEFT JOIN Scan ON User.id = Scan.u_id
					LEFT JOIN PersonalData ON User.id = PersonalData.u_id
    				LEFT JOIN School ON school_id = School.id
    				WHERE User.status > 2 AND User.status < 6 {$where_status}
  					ORDER BY status, scan_status, lname, fname, patronym, register_date DESC
  			");

  			$idx = 1;

			while ($row = mysqli_fetch_assoc($result)) {
				echo '<tr>';
				echo '<td>' . $idx;
				$idx++;

				printf ("<td><a href='user_application.php?userid=%s'>%s %s %s</a></td>", $row["user_id"], $row["lname"], $row["fname"], $row["patronym"]);

				echo "<td>";
				switch ($row['status']) {
					case 4: echo "ожидает";
					break;
					case 3: echo "участник";
					break;
					case 5: echo "нет заявки";
				}
				echo "</td>";

				printf ("<td>%s</td>", $row["town"]);
				printf ("<td>%s</td>", $row["name"]);
				printf ("<td>%s</td>", $row["grade"]);

				printf ("<td>%s</td>", $row["phone"]);
				printf ("<td>%s</td>", $row["email"]);

				echo "<td>";
				switch ($row['scan_status']) {
					case 4: echo "обработка";
					break;
					case 3: echo "принято";
					break;
					case 5: echo "отклонено";
				}
				echo "</td>";
			}
  			?>

  		</table>
			
		</div>
	</div>
</body>
</html>