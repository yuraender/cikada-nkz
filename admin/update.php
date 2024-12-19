<?php require_once 'admin_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="refresh" content="1;URL='/admin'">
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="admin.css">
	<title>Личный кабинет администратора</title>
</head>
<body>
	<h1>Редактировать учетную запись</h1>
	<?php
	  

	  if ( !isset($_POST['id']) ) exit;

		require_once '../db_config.php';
		$ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
		mysqli_set_charset($ctn, "utf8");

	    $result = mysqli_query($ctn, "UPDATE User
	    	SET lname = '{$_POST['lname']}',
	    	 	fname = '{$_POST['fname']}',
	    	 	patronym = '{$_POST['patronym']}',
	    	 	status = '{$_POST['status']}'
			WHERE id = '{$_POST['id']}'");

		if ( $result ) {
			echo "<h2 style='color:green;''>Изменено успешно</h2>";
			// header("Refresh:1; url=/admin");
		} else {
			echo "Что-то пошло не так...";
			echo "<a href='/admin'>Вернуться к списку</a>";
		}


	?>

	  
</body>
</html>