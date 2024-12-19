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
	<a href="./"><< Вернуться</a>
	<h1>Редактировать учетную запись</h1>
	<?php
	  

	  if ( !isset($_GET['id']) ) exit;

		require_once '../db_config.php';
		$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
		mysqli_set_charset($ctn, "utf8");

	    $recid = $_GET['id'];
	    $result = mysqli_query($ctn, "SELECT * FROM User WHERE id=" . $recid);
	    $record = mysqli_fetch_assoc($result);

	    if ( !$record ) {
	    	echo 'Нет записи для удаления. Возможно, ее удалили ранее';
	    	exit;
	    }
	    ?>

		<form method="post" action="update.php">
			ID<br>
			<input readonly required type="text" name="id" size="50" value="<?php echo $record["id"]; ?>">
			<br><br>

			Фамилия<br>
			<input type="text" name="lname" size="50" value="<?php echo $record["lname"]; ?>">
			<br><br>

			Имя<br>
			<input type="text" name="fname" size="50" value="<?php echo $record["fname"]; ?>">
			<br><br>

			Отчество<br>
			<input type="text" name="patronym" size="50" value="<?php echo $record["patronym"]; ?>">
			<br><br>

			Статус<br>
			<input type="text" name="status" size="50" value="<?php echo $record["status"]; ?>">
			
			<ul style="list-style-type:none;">
				<li>1 — Администратор</li>
				<li>2 — Организатор</li>
				<li>3 — Участник олимпиады</li>
				<li>4 — Подана заявка</li>
				<li>5 — Зарегистрированный пользователь</li>
				<li>6 — Методист</li>
			</ul>

			<br>

			
			<input type="submit" value="Обновить запись" >
		</form>
		<br>
		<a href="./"><< Вернуться</a>

	  
</body>
</html>