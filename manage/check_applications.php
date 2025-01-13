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

		<h2>Заявки участников</h2>

		<a href="?status=5">Вывести отклонённые</a>
		<br><br>

		<table id="list_table">
			<th>ФИО</th>
			<th>Дата подачи</th>
			<th>Школа</th>
			<th>Класс</th>
			<th>Заявка</th>
			<th>Согласие (ПДн)</th>
  			<th>Статус</th>
  			<th>Комментарий</th>

  			<?php
  			$condition = '';
  			if ( isset($_GET['status']) ) {
  				$condition = " AND Scan.status = " . $_GET['status'] . " GROUP BY Scan.id ";
  			}

  			$result = mysqli_query($ctn, "
  				SELECT User.*, Scan.*, PersonalData.*, School.*,  DATE_FORMAT(send_date, '%d.%m.%Y %H:%i') as sended, Scan.id as sid, Scan.status as scanstatus, User.id as user_id
  				FROM Scan, User
  				LEFT JOIN PersonalData ON User.id = PersonalData.u_id 
  				LEFT JOIN School ON school_id = School.id
  				WHERE User.id = Scan.u_id {$condition}
  				ORDER BY User.id DESC, send_date DESC
  			");

			while ($row = mysqli_fetch_assoc($result)) {
				echo '<tr class=';
				switch ($row['scanstatus']) {
					case 4: echo "yellow";
					break;
					case 3: echo "green";
					break;
					case 5: echo "red";
				}
				echo ">";

				printf ("<td><a href='user_application.php?userid=%s'>%s %s %s</a></td>", $row["user_id"], $row["lname"], $row["fname"], $row["patronym"]);
				printf ("<td>%s</td>", $row["sended"]);

				printf ("<td>%s</td>", $row["name"]);
				printf ("<td>%s</td>", $row["grade"]);

				printf ("<td><a target='_blank' href='/user/scan/%s'><img src='paper.png'></a></td>\n", $row["application"]);
				printf ("<td><a target='_blank' href='/user/scan/%s'><img src='paper.png'></a></td>\n", $row["agreement"]);
				
				echo "<td><a href='app_status.php?id=" . $row["sid"] . "'>";
				switch ($row['scanstatus']) {
					case 4: echo "обработка";
					break;
					case 3: echo "принято";
					break;
					case 5: echo "отклонено";
				}
				echo "</a>";

				printf ("<td>%s</td>\n", $row["comment"]);
				echo "</td>";
			}
  			?>

  		</table>
			
		</div>
	</div>
</body>
</html>