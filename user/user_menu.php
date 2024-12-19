<?php 

	switch ($user['status']) {
		case 5:
		$stid = "redStatus";
		$stmsg = "Подайте заявку";
		break;
		case 4:
		$stid = "yellowStatus";
		$stmsg = "Обработка заявки";
		break;
		case 3:
		$stid = "greenStatus";
		$stmsg = "Ждем на олимпиаде";
		break;
	}
?>

	
		<div id="sideMenu">
			<div id="<?php echo $stid; ?>" title="Текущий статус">
				<?php echo $stmsg; ?>
			</div>

			<div id="profileBlock">

				<img src="<?php if ($user['sex'] == 2)
					echo 'Ada_Lovelace.jpg';
					else echo 'Alan_Turing.jpg';  ?>">
				<br>
				<?php
				printf("%s %s", $user['fname'], $user['lname']);
				?>
			</div>
			<a href="personal_data.php" class="menuItem">Анкета</a>
			<a href="application.php" class="menuItem">Заявка</a>
		<?php 
			if ( $user['status'] == 3 ) echo '<a href="certificate.php" class="menuItem">Сертификат</a>'
		?>
			
			<a href="/logout.php" class="menuItem">Выход</a>
	</div>