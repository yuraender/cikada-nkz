<?php

require_once 'db_config.php';
$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
// Удаление записи о входе пользователя из БД
mysqli_query($ctn, "DELETE FROM OnSite WHERE u_id = '{$_COOKIE['userid']}'");

// Удаление cookie пользователя
setcookie('userid', null, -1);
setcookie('token', null, -1);

header("Location: /"); /* Перенаправить на главную страницу */
exit;

?>