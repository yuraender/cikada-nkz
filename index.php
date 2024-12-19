<?php require_once 'redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<title>Личный кабинет участника</title>
</head>
<body>
	<?php
	require "header.html";

	if ( $id < 0 ) {

		echo '<div id="error">';
		echo 'Не удалось найти QR-код по запросу <br>
		Возможно, он еще не внесен в базу. Попробуйте повторить запрос через некоторое время';
		echo '</div>';
		
		
	} else {

		echo '<div align="center"><a href="logout.php">[выход]</a></div>';
		echo '<br>';
		echo '<div id="fullname">';
		printf("%s<br>%s<br>%s\n", $user['lname'], $user['fname'], $user['patronym']);
		echo '</div>';
		
	}


	?>

	<br>
	<div id="back">
		<a href="./">вернуться к вводу</a>
	</div>
</body>
</html>