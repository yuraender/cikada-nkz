<?php
	require_once 'user_redirect_logic.php';

	$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
	mysqli_set_charset($ctn, "utf8");

	$var_part_value = 0;
	if ( isset($_POST['third_part']) ) {
		switch ( $_POST['third_part'] ) {
			case 'robotics': $var_part_value = 1;
			break;
			case 'programming': $var_part_value = 2;
			break;
			case 'graphics': $var_part_value = 3;
			break;
		}
	}

	$result = mysqli_query($ctn,"
		UPDATE PersonalData
		SET
		programming_languages = '{$_POST['prog_lang']}',
		var_part = {$var_part_value}
		
		WHERE u_id={$user['id']}
	");



	if ( $result ) {

		// Все норм, запись создана
		
		header("Location: application.php"); /* Перенаправление браузера */
		/* Убедиться, что код ниже не выполнится после перенаправления .*/
		exit;

	} else {
		echo 'Произошла ошибка при записи в БД';
	}

?>