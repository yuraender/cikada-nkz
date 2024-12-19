<?php
	require_once 'user_redirect_logic.php';
	if ( $user['status'] < 5) {
		// Если попытка сохранить данные уже подавшего заявку участника
		header("Location: personal_data.php"); /* Перенаправление браузера */
		exit;
	}

	$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
	mysqli_set_charset($ctn, "utf8");

	$school_id = -1;
	if ( isset($_POST['db_town']) && isset($_POST['db_school_name']) ) {
		$result = mysqli_query($ctn, "
			SELECT * FROM School WHERE town = '{$_POST['db_town']}' AND  name = '{$_POST['db_school_name']}'
		");

		if ( mysqli_num_rows( $result ) > 0 ) {
			$record = mysqli_fetch_assoc($result);
			$school_id = $record['id'];
		}
	}

	$the_town = "";
	if ( isset($_POST['db_town']) && $_POST['db_town'] != "" ) $the_town = $_POST['db_town'];
	if ( isset($_POST['new_town']) && $_POST['new_town'] != "" ) $the_town = $_POST['new_town'];

	if ( $school_id < 0 && $the_town != "" &&
		isset($_POST['new_school_name']) && $_POST['new_school_name'] != "" ) {
		$result = mysqli_query($ctn,"
			INSERT INTO School (town, name) VALUES ('{$the_town}', '{$_POST['new_school_name']}')");
		if ( $result ) $school_id = mysqli_insert_id($ctn); else $school_id = -1;
	}

	if ( $school_id < 0 ) $school_id = 'NULL';

	$result = mysqli_query($ctn, "SELECT * FROM PersonalData
			WHERE u_id = '{$user['id']}'
			");

	if ( mysqli_num_rows( $result ) > 0 ) {
		// Если запись была -- удаляем её
		$result = mysqli_query($ctn,"DELETE FROM PersonalData WHERE u_id={$user['id']}");
	}


	// Добавление новой записи в таблицу

	$result = mysqli_query($ctn,"
		INSERT INTO PersonalData(
			u_id,
			bday,
			school_id,
			grade,
			oblast,
			locality,
			street,
			home,
			apartment,
			email,
			phone,
			phoneParent,
			nameParent,
			teacherIKT,
			classTeacher
		)
		VALUES (
			{$user['id']},
			STR_TO_DATE('{$_POST['bday']}', '%d.%m.%Y'),
			{$school_id},
			'{$_POST['grade']}',
			'{$_POST['oblast']}',
			'{$_POST['locality']}',
			'{$_POST['street']}',
			'{$_POST['home']}',
			'{$_POST['apartment']}',
			'{$_POST['email']}',
			'{$_POST['phone']}',
			'{$_POST['phoneParent']}',
			'{$_POST['nameParent']}',
			'{$_POST['teacherIKT']}',
			'{$_POST['classTeacher']}'

		);
	");



	if ( $result ) {

		// Все норм, запись создана
		
		header("Location: application.php"); /* Перенаправление браузера */
		/* Убедиться, что код ниже не выполнится после перенаправления .*/
		exit;

	} else {
		echo 'Произошла ошибка при записи в БД' . mysqli_error($ctn);
	}

?>