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
	<a href="grade_list.php" class="menuItem">Проставить баллы</a>
	<a href="team_list.php" class="menuItem">Составление команд</a>
	<a href="participant_status_list.php" class="menuItem">Определение финалистов</a>
	<a href="/logout.php" class="menuItem">Выход</a>
</div>