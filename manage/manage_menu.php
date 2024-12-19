<div id="sideMenu">
	<div>&nbsp;</div>
	<div id="profileBlock">
	<img src="drHouse.jpg">
	<br>
	<?php
	mb_internal_encoding("UTF-8");
	echo mb_substr($user['fname'], 0, 1);
	echo ". ";
	echo mb_substr($user['patronym'], 0, 1);
	echo ". ";
	echo $user['lname'];
	?>
	</div>
	<a href="check_applications.php" class="menuItem">Прием заявлений</a>
	<a href="participant_list.php" class="menuItem">Список участников</a>
	<a href="result_list.php" class="menuItem">Таблица результатов</a>
	<a href="/logout.php" class="menuItem">Выход</a>
	<br>
	<?php
		if ($user['status'] == 1)
			echo '<a target="_blank" href="/admin">Админка</a>';
	?>
</div>