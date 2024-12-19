<?php

	if ( isset($_GET['id']) ) {
		require_once 'db_config.php';
		$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
		mysqli_set_charset($ctn, "utf8");

		$id = $_GET['id'];

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
		}	
	}

	header("Location: /"); /* Перенаправление браузера, если не получилось войти по вышеуказанному способу */
?>