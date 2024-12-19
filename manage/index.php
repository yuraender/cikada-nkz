<?php require_once 'manage_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="manage.css">
	<title>Личный кабинет организатора</title>
</head>
<body>
	<?php require "header.html"; ?>
	<div id="pageContainer">
		<?php require "manage_menu.php"; ?>
		<div id="userContent">
			<?php
			require "../info.html";
			?>
		</div>
	</div>
</body>
</html>