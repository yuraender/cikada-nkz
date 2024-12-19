<?php require_once 'admin_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="admin.css">
	<title>Личный кабинет администратора</title>
</head>
<body>
	<h1>Личный кабинет администратора</h1>
	<?php
	  require_once '../db_config.php';
	  $ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
	  mysqli_set_charset($ctn, "utf8");

	  $result = mysqli_query($ctn, "SELECT * FROM User order by id DESC");

	  echo '<h2>Количество пользователей: ';
	  echo mysqli_num_rows($result);
	  echo '</h2> <br>';

	  echo '<table>
	  <th>Фамилия</th>
	  <th>Имя</th>
	  <th>Отчество</th>
	  <th>Пол</th>
	  <th>Статус</th>
	  <th>Ред.</th>';

	  while ($row = mysqli_fetch_assoc($result)) {
	    echo '<tr>';
	    printf ("<td>%s</td>\n", $row["lname"]);
	    printf ("<td>%s</td>\n", $row["fname"]);
	    printf ("<td>%s</td>\n", $row["patronym"]);
	    echo "<td>";
	    switch ($row['sex']) {
			case 0: echo "?";
			break;
			case 1: echo "м";
			break;
			case 2: echo "ж";
		}
		echo "</td>";
	    printf ("<td>%s</td>\n", $row["status"]);
	    printf ("<td><a href=\"edit.php?id=%s\"> <img src=\"editw.png\"> </a> </td>\n", $row["id"]);
	    echo '</tr>';
	  }

	  echo '</table>';

	?>
</body>
</html>