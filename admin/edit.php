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
			<select name='status' method='POST'>
				<option value='1' <?php if ($record["status"] == '1') echo 'selected'; ?>>Администратор</option>
				<option value='2' <?php if ($record["status"] == '2') echo 'selected'; ?>>Организатор</option>
				<option value='3' <?php if ($record["status"] == '3') echo 'selected'; ?>>Участник олимпиады</option>
				<option value='4' <?php if ($record["status"] == '4') echo 'selected'; ?>>Подана заявка</option>
				<option value='5' <?php if ($record["status"] == '5') echo 'selected'; ?>>Зарегистрированный пользователь</option>
				<option value='6' <?php if ($record["status"] == '6') echo 'selected'; ?>>Методист</option>
				
				<option value='7' <?php if ($record["status"] == '7') echo 'selected'; ?>>Финалист</option>
				<option value='8' <?php if ($record["status"] == '8') echo 'selected'; ?>>Участник</option>
			</select>

			<br><br>

			
			<input type="submit" value="Обновить запись" >
		</form>
		<br>
		<a href="./"><< Вернуться</a>

	  
</body>
</html>