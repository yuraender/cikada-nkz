<?php require_once 'metodist_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="metodist.css">
	<title>Определение команд</title>
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

		<h2>Список финалистов</h2>

		<table id="list_table">
			<th>ФИО</th>
			<th>Нас. пункт</th>
			<th>Школа</th>
			<th>Класс</th>
			<th>Команда</th>
  			<?php

  			$result = mysqli_query($ctn, "
	  				SELECT *, User.id as user_id FROM User
	  				LEFT JOIN PersonalData ON User.id = PersonalData.u_id 
	  				LEFT JOIN School ON school_id = School.id
	  				WHERE User.status='7'
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
					
					echo "<td><a href='participant_team.php?id=" . $row["user_id"] . "'>";

					$team_res = mysqli_query($ctn, "SELECT * FROM Team WHERE id = " . $row['team'] . "");
					
					if ($team_res == null) echo "не выбрано";
					else {
						$team = mysqli_fetch_assoc($team_res);
						switch ($row['team']) 
						{
							case 0: echo "не выбрано";
							break;
							default: echo $team['name'];
						}
					}
					echo "</a></td>";
				}
  			?>

  		</table>
			
  		<a href="team_editor.php" class="menuItem">Создать / редактировать команды</a>

		</div>
	</div>
</body>
</html>