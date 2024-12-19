<?php
	if ( isset($_COOKIE['userid']) ) {
		header("Location: /"); /* Перенаправление браузера */
		/* Убедиться, что код ниже не выполнится после перенаправления .*/
		exit;
	}

	$wrong_password = FALSE;

	if ( isset($_POST['lname']) && isset($_POST['pass']) ) {

		require_once 'db_config.php';
		$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
		mysqli_set_charset($ctn, "utf8");

		$result = mysqli_query($ctn, "SELECT id, psw_hash FROM User
			WHERE lname = '{$_POST['lname']}'");

		$id = -1;
		while ( $record = mysqli_fetch_assoc($result) ) {
			// echo $record['id'];
			if ( password_verify($_POST['pass'], $record['psw_hash']) ) $id = $record['id'];
		}

		if ( $id > 0 ) {

			// При удачном входе запомнить пользователя на 90 суток (путем установления cookie)
			setcookie('userid', $id, time() + 60*60*24*90);
			$num = rand();
			setcookie('token', $num, time() + 60*60*24*90);

			$r = mysqli_query($ctn, "DELETE FROM OnSite WHERE u_id = '{$id}'");
			// if ( $r ) echo "Удалена запись из БД";

			$r = mysqli_query($ctn, "INSERT INTO OnSite(u_id, token) VALUES ('{$id}', '{$num}')");
			// if ( $r ) echo 'Успешная запись регистрации пользователя в базу данных';

			header("Location: /user"); /* Перенаправление браузера */
			/* Убедиться, что код ниже не выполнится после перенаправления .*/
			exit;
		} else
			$wrong_password = TRUE;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
	<title>Политехническая олимпиада школьников</title>
</head>
<body>

	<?php require "header.html"; ?>

	<div id="container">
		<?php if ( $wrong_password ) { ?>
			<br><br>
			<div id="error">
				Не удалось войти. Пожалуйста, проверьте правильность ввода данных.
			</div>
		<?php } /* Конец блока по условию, что пароль неверный */ ?>

		<div id="form">
			<h1>Вход в личный кабинет</h1>
			<form method="post" action="login.php">
				Фамилия<br>
				<input required type="text" name="lname" size="50"
					<?php if ( isset($_POST['lname']) ) echo 'value="' . $_POST['lname'] . '"'; ?>
				>
				<br><br>

				Пароль<br>
				<input required type="password" name="pass" size="50">
				<br><br>
				<div align="right">
					<input type="submit" value="Войти" >
				</div>
			</form>

			<br><br>
			<a href="register.php">Регистрация участника</a>


		</div>

	</div>
	<br>
	<?php require "footer.html"; ?>
</body>
</html>