<?php

	function isPasswordBad($password) {
		// Validate password strength

		$allowed = preg_match("/^[A-Za-z0-9_!@#$%&+-]*$/", $password);
		$letter = preg_match('@[A-Za-z]@', $password);
		$number = preg_match('@[0-9]@', $password);

		return (!$allowed || !$letter || !$number || strlen($password) < 8);
	}

	session_start();

	if ( isset($_POST['lname']) ) $_SESSION['lname'] = $_POST['lname'];
	if ( isset($_POST['fname']) ) $_SESSION['fname'] = $_POST['fname'];
	if ( isset($_POST['patronym']) ) $_SESSION['patronym'] = $_POST['patronym'];
	if ( isset($_POST['sex']) ) $_SESSION['sex'] = $_POST['sex'];

	if ( isset($_POST['lname']) && isset($_POST['password']) ) {

		require 'db_config.php';
		$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
		mysqli_set_charset($ctn, "utf8");

		$result = mysqli_query($ctn, "SELECT id, psw_hash FROM User
			WHERE lname = '{$_POST['lname']}'
			");
		$id = -1;
		while ( $record = mysqli_fetch_assoc($result) ) {
			if ( password_verify($_POST['password'], $record['psw_hash']) ) $id = $record['id'];
		}

		if ( $id > 0 ) {
			$_SESSION['error_text'] = "Похоже, Вы уже были зарегистрированы ранее.
				Попробуйте войти в <a href=\"./login.php\">личный кабинет</a>.<br>
				Если уверены, что не проходили регистрацию — используйте другой пароль";

			header("Location: /register.php"); /* Перенаправление браузера */
			exit;

		} else {

			if ( isPasswordBad($_POST['password']) ) {
				$_SESSION['error_text'] = "Заданный пароль не удовлетворяет критериям. Придумайте другой.<br>
					Пароль должен быть длинной как минимум 8 знаков и содержать цифры и буквы.<br>
					<br>В пароле допускается использовать:<br>
					цифры, латинские буквы и специальные символы: _!@#$%&+-";
				header("Location: /register.php"); /* Перенаправление браузера */
				exit;
			}

			$hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
			$result = mysqli_query($ctn, "INSERT INTO User(lname, fname, patronym, sex, status, psw_hash)
				VALUES ('{$_POST['lname']}', '{$_POST['fname']}', '{$_POST['patronym']}', {$_POST['sex']},
				5, '{$hash}')");

			if ( $result ) {

				// echo "Все норм, запись создана";
				session_unset();

				// Запомнить пользователя на 90 суток (путем установления cookie)
				$id = mysqli_insert_id($ctn);
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

			} else {
				echo 'Произошла ошибка при записи в БД';
			}
		}
	}

?>