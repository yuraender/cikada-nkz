<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Регистрация участника</title>

	<link rel="stylesheet" href="style.css">
	
	<style type="text/css">

		input, select {
			padding: 10px;
			margin: 10px;
			font-size: 15px;

			-moz-box-sizing:border-box;
			-webkit-box-sizing:border-box;
			box-sizing:border-box;

			width: 90%;
		}


		#regcontainer {
			background-color: #cff2f8;
			background-image: url(images/register_background.jpg);
			background-size: cover;
			background-repeat:   no-repeat;
			background-position: center center; 

			padding:  50px 0;

			text-align: center;
		}

		form {
			display: inline-block;
			text-align: left;
		}


	</style>

</head>
<body>

	<br>
	<div id="olimpLogo">
		<h1>Регистрация участника</h1>
		<a href="/">
			<img src="images/polyolymp_logo.svg" align="right">
		</a>
	</div>

<div id="regcontainer">
	<?php

	if ( isset($_SESSION['error_text']) ) {
		echo '<div id="error">';
		echo $_SESSION['error_text'];
		echo '</div>';
		echo '<br><br>';
	}

	?>

	<br>
		<form enctype="multipart/form-data" method="post" action="newparticipant.php">

			Фамилия:<br>
			<input required type="text" name="lname" placeholder="Фамилия" size="50"
				<?php if ( isset($_SESSION['lname']) ) echo 'value="', $_SESSION['lname'], '"'; ?>
			>
			<br>

			Имя:<br>
			<input required type="text" name="fname" placeholder="Имя"
				<?php if ( isset($_SESSION['fname']) ) echo 'value="', $_SESSION['fname'], '"'; ?>
			>
			<br>

			Отчество:<br>
			<input required type="text" name="patronym" placeholder="Отчество"
				<?php if ( isset($_SESSION['patronym']) ) echo 'value="', $_SESSION['patronym'], '"'; ?>
			>
			<br>

			Пол:<br>
			<select required name="sex">
			<option value=1>мужской</option>
			<option value=2
				<?php if ( isset($_SESSION['sex']) ) if ( $_SESSION['sex'] == "2" ) echo 'selected'; ?>
			>женский</option>
			</select>
			<br>			

			Пароль:<br>
			<input required type="password" name="password" placeholder="Пароль">
			<br>
			<span style="font-size: 14px; color: #999;">
			Пароль должен быть длинной как минимум 8 знаков <br> и содержать цифры и буквы<br>
			</span>
			<br>

			<br><br>
			<!--
			<b style='color: red;'>Прием заявок завершен</b><br>
			<span style='font-size: 16px; color: #444;'>
			Прием заявок завершен 15 апреля 2022 года  в 00:01</span>
			<br>
			-->

			<input type="submit" value="Далее">
			

		</form>
	<br><br><br>
	</div>

	<br>

	<?php
	require "footer.html";
	session_unset();
	?>

</body>
</html>