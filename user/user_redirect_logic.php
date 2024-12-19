<?php

// Логика перенаправления для страниц пользователя

// Если не установлена cookie, перенаправить на форму входа
if ( !isset($_COOKIE['userid']) ) {
	header("Location: /login.php");
	exit;
}

require_once '../db_config.php';
$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
mysqli_set_charset($ctn, "utf8");

$findres = mysqli_query($ctn, "SELECT * FROM OnSite
	WHERE u_id = '{$_COOKIE['userid']}'
	AND token = '{$_COOKIE['token']}'
	");

$id = -1;

if ( mysqli_num_rows($findres) > 0 ) {
	$row = mysqli_fetch_assoc($findres);
	$id = $row['u_id'];

	$result = mysqli_query($ctn, "SELECT * FROM User WHERE id = '{$id}' ");

	if ( mysqli_num_rows($result) > 0 ) {

		$user = mysqli_fetch_assoc($result);
		$id = $user['id'];
		$status = $user['status'];

	} else {
		$id = -1;
	}

}

if ( $id < 0 ) {
	header("Location: /logout.php");
	exit;
}

// Если пользователь зашел НЕ как школьник —
// перенаправить на главную
if ( $status < 3 || $status > 5 ) {
	header("Location: /");
	exit;
}

?>