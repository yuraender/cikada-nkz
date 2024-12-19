<?php require_once 'user_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="user.css">
	<title>Личный кабинет участника</title>
</head>
<body>
	<?php require "../header.html"; ?>
	<div id="pageContainer">
		<?php require "user_menu.php"; ?>
		<div id="userContent">
			<?php
			require "../info.html";
			?>
		</div>
	</div>

</body>
</html>