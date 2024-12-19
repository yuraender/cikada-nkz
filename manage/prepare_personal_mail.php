<?php require_once 'manage_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="manage.css">
	<title>Персональное сообщение</title>
</head>
<body>

	<?php require "header.html"; ?>
	<div id="pageContainer">
		<?php require "manage_menu.php"; ?>

		<div id="userContent">
			
			<form method="post" action="personal_mail_send.php">
			Текст:<br>
				<textarea rows="20" cols="100" required name="message_text"></textarea>
			<br>
			Кому отправить:<br>
			<form method="post" action="send_mail.php">
				<textarea rows="20" cols="100" required name="list_of_mails"></textarea>
			<br>
			<input type="submit" value="Отправить">
			</form>

	</div>
</div>
</body>
</html>