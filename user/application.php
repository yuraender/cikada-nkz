<?php
session_start();
require_once 'user_redirect_logic.php'; 
require_once 'user_pd_from_db.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="user.css">
	<title>Личный кабинет участника</title>

	<style type="text/css">

		input {
			font-size: 15px;
			padding: 10px;
		}

		input[type="submit"] {
			padding: 10px 50px;
			margin-right: 10px;
			margin-bottom: 20px;
		}

		tr.yellow {
			background-color: #EE0;
		}

		tr.red {
			background-color: #E44;
		}

		tr.green {
			background-color: #8F8;
		}

		#form_table {
			background-color: #EFEFEF;
		}

		#form_table td {
			border-bottom: 10px solid #444;
			padding: 20px;
		}

		#history_table table, #history_table th, #history_table td {
			border: 1px solid #888;
		}

		#history_table th, #history_table td
		{
			padding: 20px;
		}


		#error
		{
			color: white;
			background-color: rgba(180, 0, 0, 0.8);
			font-size: 30px;
			padding: 30px;
			margin: 0 50px;
			text-align: center;
		}

	</style>

</head>
<body>
	<?php require "../header.html"; ?>
	<div id="pageContainer">
		<?php require "user_menu.php"; ?>
		<div id="userContent">
			<?php

			if ( isset($_SESSION['error_text']) ) {
				echo '<div id="error">';
				echo $_SESSION['error_text'];
				echo '</div>';
				echo '<br><br>';
			}

			?>
			<h1>Заявка на участие</h1>

			<h3>1. Скачайте заявку</h3>

			<?php
			if ( !isSet($pData) ) {
				echo "<br><br><h3 style='color: red;'>Сначала необходимо заполнить анкету</h3>";
				echo "</body>";
				echo "</html>";
				exit;
			}
			?>

			<?php
			
			$date_1 = new DateTime( $pData['bday']) ;

			$date_2 = new DateTime( date( 'Y-m-d' ) );

			$difference = $date_2->diff( $date_1 );
			
			// echo "Полных лет: ";
			// echo (string)$difference->y;
			
			// echo "<br>";
			$years = 0;
			if ( $difference->y >= 18) {
				// echo "Совершеннолетний";
				$years=1;
			}
			// else
			// 	echo "Несовершеннолетний";
				
			$ok = 0;

			$all_ok = 17;

			if ( $user['lname'] != ""  )  $ok++;
			if ( $user['fname'] != ""  )  $ok++;
			if ( $user['patronym'] != ""  )  $ok++;
			if ( $pData['bday'] != ""  )  $ok++;
			if ( $pData['oblast'] != ""  )  $ok++;
			if ( $pData['locality'] != ""  )  $ok++;
			if ( $pData['street'] != ""  )  $ok++;
			if ( $pData['home'] != ""  )  $ok++;
			if ( $pData['grade'] != ""  )  $ok++;
			if ( $pData['email'] != "" ) $ok++;
			if ( $pData['phone'] != ""  )  $ok++;
			if ( $pData['teacherIKT'] != ""  )  $ok++;
			if ( $pData['classTeacher'] != ""  )  $ok++;
			if ( isSet($School) ) {
				if ( $School['town'] != ""  )  $ok++;
				if ( $School['name'] != ""  )  $ok++;
			}
			if ( $pData['programming_languages'] != ""  )  $ok++;
			if ( ( $pData['var_part'] != 0 ) OR ( $pData['grade'] < 10 ) )  $ok++;
			
			echo "Заполнено полей анкеты: <b>";
			echo $ok;
			echo "</b><br>";

			echo "<br><table><tr>";
			$i = 0;
			while ( $i < $ok ) {
				echo "<td style='background-color: green; width: 20px; height: 10px;'></td>";
				$i++;
			}
			while ( $i < $all_ok ) {
				echo "<td style='background-color: red;  width: 20px; height: 10px;'></td>";
				$i++;
			}
			echo "</table><br><br>";
			if ($ok==$all_ok) {
				echo '<a href="get_form.php">Скачать заявку на участие в олимпиаде</a>	<br><br>';
			} else {
				echo 'Заполните все поля анкеты для формирования заявки';
			}

			if ($ok==$all_ok and $years==0) 
			echo "\n<a href='obrabotka_do.php'>Скачать согласие на обработку персональных данных</a>";
			if ($ok==$all_ok and $years==1) 
			echo "\n<a href='obrabotka_posle.php'>Скачать согласие на обработку персональных данных</a>";
			?>

			<br><br>
			<h3>2. Подпишите и отсканируйте</h3>
			Необходимо скачать заявку и согласие на обработку персональных данных и <b>распечатать</b> их.<br>
			Поля, которые не были заполнены автоматически, необходимо вписать <b>вручную</b>.<br>
			Не забудьте поставить <b>дату</b> и <b>подпись</b>.<br><br>
			Отсканируйте заявку и согласие на обработку персональных данных. (<b>2 файла</b>, формат <b>.pdf</b> или <b>.jpeg</b>)<br>
			Для создания скан-копии можете использовать приложение <b>Microsoft Office Lens</b>, которое доступно для <a href="https://play.google.com/store/apps/details?id=com.microsoft.office.officelens&hl=ru">Android<a> и <a href="https://apps.apple.com/ru/app/microsoft-office-lens-pdf-scan/id975925059">iOS</a>.


			<br><br>
			<h3>3. Подайте заявку</h3>

			<form enctype="multipart/form-data" method="post" action="send_application.php">

				<table id="form_table">
				<tr>
				<td>
				<label  for="app_scan">Скан-копия заявки:</label>
				<td>
				<input required id="app_scan" type="file" accept=".pdf,.jpeg,.jpg" name="app_scan">

				<tr>
				<td>
				<label  for="agree_scan">Скан-копия согласия на обработку персональных данных:</label>
				<td>
				<input required id="agree_scan" type="file" accept=".pdf,.jpeg,.jpg" name="agree_scan">

				</table>
				<br>
				<input type="submit" <?php if ( $user['status'] < 5 OR $ok < $all_ok ) echo ' disabled="disabled" '; ?>
				value="Подать заявку">

				<?php
				if ($user['status'] < 5) {
					echo "<b style='color: green;'>Заявка была подана</b><br>
					<span style='font-size: 16px; color: #444;'>
					Повторно подать заявку можно только если предыдущая будет отклонена организаторами</span>";
				} 
				if ($user['status'] == 5)  {
					// echo "<b style='color: red;'>Прием заявок завершен</b><br>
					// <span style='font-size: 16px; color: #444;'>
					// Прием заявок завершен в 20:00 15 апреля 2021 года</span>";
				}
				if ( $ok < $all_ok )  {
					echo "<b style='color: red;'>Заполните анкету до конца</b><br>
					<span style='font-size: 16px; color: #444;'>
					Возможность подать заявку откроется после заполнения всех необходимых полей</span>";
				}
				?>
			</form>

			<br>
			<h3>4. Следите за статусом заявки</h3>

			<table id="history_table">
				<th>Дата подачи</th>
				<th>Заявка</th>
				<th>Согласие</th>
	  			<th>Статус</th>
	  			<th>Комментарий</th>

	  			<?php
	  			$result = mysqli_query($ctn, "
	  				SELECT *, DATE_FORMAT(send_date, '%d.%m.%Y %H:%i') as sended
	  				FROM Scan WHERE u_id = {$user['id']} order by send_date DESC
	  			");

				while ($row = mysqli_fetch_assoc($result)) {
					echo '<tr class=';
					switch ($row['status']) {
						case 4: echo "yellow";
						break;
						case 3: echo "green";
						break;
						case 5: echo "red";
					}
					echo '>';
					printf ("<td>%s</td>\n", $row["sended"]);
					printf ("<td><a href='get_file.php?file=%s'target='_blank'>
						<img src='paper.png'></a></td>\n", $row["application"]);
					printf ("<td><a href='get_file.php?file=%s' target='_blank'>
						<img src='paper.png'></a></td>\n", $row["agreement"]);
					echo "<td>";
					switch ($row['status']) {
						case 4: echo "обработка";
						break;
						case 3: echo "принято";
						break;
						case 5: echo "отклонено";
					}

					printf ("<td>%s</td>\n", $row["comment"]);
					echo "</td>";
				}
	  			?>

	  		</table>

		</div> 
		
</body>
</html>