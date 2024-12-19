<?php
session_start();
require_once 'manage_redirect_logic.php'; 
//require_once 'user_pd_from_db.php';

// Получение ПДн пользователя из БД

if ( !isset( $_GET['userid'] ) ) {
	echo "Не задан пользователь";
	exit();
}

$userid = $_GET['userid'];

$findpd = mysqli_query($ctn, "SELECT *, DATE_FORMAT(bday, '%d.%m.%Y') as format_bday FROM PersonalData
	WHERE u_id = {$userid}
	");

if ( mysqli_num_rows($findpd) > 0 ) {
	$pData = mysqli_fetch_assoc($findpd);


	$findschool = mysqli_query($ctn, "SELECT * FROM School WHERE id = {$pData['school_id']} ");
	if ( $findschool && mysqli_num_rows($findschool) > 0 ) {
		$School = mysqli_fetch_assoc($findschool);
	}

}

$result = mysqli_query($ctn, "SELECT * FROM User WHERE id = '{$userid}' ");

	if ( mysqli_num_rows($result) > 0 ) {

		$user = mysqli_fetch_assoc($result);
		$id = $user['id'];
		$status = $user['status'];

	} else {
		$id = -1;
	}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="manage.css">
	<title>Подать заявку за участника</title>

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
	<?php require "header.html"; ?>
	<div id="pageContainer">
		<?php require "manage_menu.php"; ?>
		<div id="userContent">

			<table id="form_table">
			<?php
				echo "<tr><td>Фамилия";
				echo "<td>" . $user['lname'];
				echo "<tr><td>Имя";
				echo "<td>" .  $user['fname'];
				echo "<tr><td>Отчество";
				echo "<td>" . $user['patronym'];
				echo "<tr><td>Дата рождения";
				echo "<td>" .$pData['format_bday'];
				echo "<tr><td>Учебное заведение";
				echo "<td>" . $School['name'] . ", " . $School['town'] . "<br>" . $pData['grade']." класс";
				echo "<tr><td>Область";
				echo "<td>" . $pData['oblast'];
				echo "<tr><td>Населенный пункт";
				echo "<td>" . $pData['locality'];
				echo "<tr><td>Улица";
				echo "<td>" . $pData['street'];
				echo "<tr><td>Дом";
				echo "<td>" . $pData['home'];
				echo "<tr><td>Квартира";
				echo "<td>" . $pData['apartment'];
				echo "<tr><td>Телефон участника";
				echo "<td>" . $pData['phone'];
				echo "<tr><td>Телефон законного представителя";
				echo "<td>" . $pData['phoneParent'] . "<br>" . $pData['nameParent'];
				echo "<tr><td>Электронная почта участника";
				echo "<td>" . $pData['email'];
				echo "<tr><td>Учитель, подготовивший к олимпиаде";
				echo "<td>" . $pData['teacherIKT'];
				echo "<tr><td>Классный руководитель";
				echo "<td>" . $pData['classTeacher'];
				echo "<tr><td>Язык программирования";
				echo "<td><b>" . $pData['programming_languages'] . "</b>";
				echo "<tr><td>3 часть";
				echo "<td><b>";
				switch ($pData['var_part']) {
					case 1: echo "Робототехника";
					break;
					case 2: echo "Программирование";
					break;
					case 3: echo "Графика";
				}
				echo "</b>";
			?>
			</table>

			<br><br>
			<h3>3. Подайте заявку</h3>

			<form enctype="multipart/form-data" method="post" action="send_application.php">
				ID<br>
				<input readonly required type="text" name="userid" size="50" value="<?php echo $user['id']; ?>">
				<br><br>

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
				<input type="submit" <?php if ($user['status'] < 3) echo ' disabled="disabled" '; ?>
				value="Подать заявку">

				<?php
				if ($user['status'] < 3) {
					echo "<b style='color: green;'>Заявка была подана</b><br>
					<span style='font-size: 16px; color: #444;'>
					Повторно подать заявку можно только если предыдущая будет отклонена организаторами</span>";
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
	  				FROM Scan WHERE u_id = {$userid} order by send_date DESC
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