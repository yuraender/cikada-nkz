<?php require_once 'PHPMailer-5.2-stable/PHPMailerAutoload.php';

	require_once 'manage_redirect_logic.php';

	if ( !isset($_GET["userid"]) ) {
		eсho("Не указан пользователь");
		exit();
	}

	$userid = $_GET["userid"];

	$uinfo = mysqli_query($ctn, "
	  				SELECT lname, fname, patronym, email, grade, sum(score) AS sumscore FROM User, PersonalData, Result
	  				WHERE User.id = PersonalData.u_id AND  User.id = Result.u_id AND User.id = {$userid}
	  				GROUP BY Result.u_id;
	  			");

	if ( !$urow = mysqli_fetch_assoc($uinfo) ) {
		echo "Нет результатов у данного пользователя";
		exit();
	}

	$result_by_grade = "";
	switch ( $urow['grade'] ) {
		case 8:
			$result_by_grade = "Среди участников <b>8 классов</b> максимальный балл составил <b>27</b> из 100</p>";
			break;

		case 9:
			$result_by_grade = "Среди участников <b>9 классов</b> максимальный балл составил <b>52</b> из 100</p>";
			break;

		case 10:
			$result_by_grade = "Среди участников <b>10 классов</b> максимальный балл составил <b>60</b> из 100</p>";
			break;
		
		default:
			$result_by_grade = "Среди участников <b>11 классов</b> максимальный балл составил <b>33</b> из 100</p>";
			break;
	}

	$message = "
	<h2>{$urow['fname']}, приветствуем!</h2>
	<div style='font-size: 20px; line-height: 170%'>
	<p>
	Благодарим за участие в Политехнической олимпиаде школьников 16 марта 2022 года в Коломенском институте (филиале) Московского политехнического университета.</p>

	<p>Общие результаты:<br>
	{$result_by_grade}

	<p>Индивидуальные результаты:<br>
	<b>{$urow['lname']} {$urow['fname']} {$urow['patronym']}</b> — общий балл <b>{$urow['sumscore']}</b> из 100</p>
	</div>
	<div style='font-size: 24px; line-height: 150%; color: #444'>
	<p>Уже пора задуматься о получении <b>высшего образования</b> в Коломне! <b><a href='https://click.lobanov.site/?q=154'>Переходи по ссылке</a></b> и узнай, на кого можно учиться в родном городе и получить <b>диплом московского вуза</b>!
	</div>
	<br>
	С уважением, команда<br>
	Политехнической олимпиады школьников<br><br>
	<img width='300' src='https://olympiad.lobanov.site/images/polyolymp_logo.png'>";

		$mail = new PHPMailer();

		try {
			$mail->isSMTP();
			$mail->CharSet = "UTF-8";
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'smtp.yandex.ru';
			$mail->Port = 465;
			$mail->isHTML();
			$mail->Username = 'DistantPK@yandex.ru';
			$mail->Password = 'Gjkbnt[Lbcnfyn2022';

			$mail->setFrom('DistantPK@yandex.ru', 'Политехническая олимпиада');

			$mail->Subject = "Персональные результаты";
			$mail->Body = $message;
			$mail->AddAddress($urow['email']);

			if ( $mail->send() ) {
				echo "Все удачно! Сообщение отправлено на почту";
				
			} else {
				echo "Сообщение с данными для входа не было отправлено";
			}

			echo "<br>";

		} catch (Exception $e) {
			echo $e->getMessage(); //Boring error messages
		}

?>