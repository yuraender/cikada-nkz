<?php require_once 'metodist_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="metodist.css">
	<title>Назначение финалистов</title>
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

		<h2>Укажите статус участников</h2>

		<br><br>

			<table id="list_table">
				<th>ФИО</th>
				<th>Нас. пункт</th>
				<th>Школа</th>
				<th>Класс</th>
				<th>Статус</th>

	  			<?php

	  			$result = mysqli_query($ctn, "
	  				SELECT *, User.id as user_id FROM User
	  				LEFT JOIN PersonalData ON User.id = PersonalData.u_id 
	  				LEFT JOIN School ON school_id = School.id
	  				WHERE (User.status='3' OR User.status='7' OR User.status='8')
	  				ORDER BY User.id");

	  			$idx = 1;

				while ($row = mysqli_fetch_assoc($result)) 
				{
					echo '<tr class=';
					echo ">";

					printf ("<td>%s %s %s</td>", $row["lname"], $row["fname"], $row["patronym"]);
					printf ("<td>%s</td>", $row["locality"]);
					printf ("<td>%s</td>", $row["name"]);
					printf ("<td>%s</td>", $row["grade"]);
					
					echo "<td><a href='participant_status.php?id=" . $row["user_id"] . "'>";
					switch ($row['status']) 
					{
						case 3: echo "не выбрано";
						break;
						case 7: echo "финалист";
						break;
						case 8: echo "нефиналист";
					}
					echo "</a></td>";
				}
	  			?>

	  		</table>

		</div>
	</div>
</body>
</html>