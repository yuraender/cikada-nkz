<?php require_once 'metodist_redirect_logic.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="metodist.css">
	<title>Личный кабинет методиста</title>
</head>
<body>
	<?php require "header.html"; ?>
	<div id="pageContainer">
		<?php require "metodist_menu.php"; ?>
		<div id="userContent">
			<?php
			require "../info.html";
			?>
		</div>
	</div>
</body>
</html>