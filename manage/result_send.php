<?php require_once 'PHPMailer-5.2-stable/PHPMailerAutoload.php';

	require_once 'manage_redirect_logic.php';

	if ( !isset($_GET["userid"]) ) {
		eсho("Не указан пользователь");
		exit();
	}

	$userid = $_GET["userid"];

	$uinfo = mysqli_query($ctn, "
	  				SELECT lname, fname, patronym, email, grade, User.id AS userid, sum(score) AS sumscore FROM User, PersonalData, Result
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

	<p>Личный сертификат участника Политехнической олимпиады школьников доступен для скачивания в личном кабинете <b>в разделе «Сертификат»</b>. Для входа в свой личный кабинет пройдите по <a href='https://olympiad.lobanov.site/direct_login.php?id={$urow['userid']}'>этой ссылке</a>.</p>

	<p>28 апреля прошла торжественная церемония награждения победителей Политехнической олимпиады школьников. Новость о меропритии размещена в <a href='https://vk.com/polytechkolomna?w=wall-169312_2037%2Fall'>официальной группе института</a> в социальных сетях. Каждый победитель сможет найти там свою фотографию с вручения дипломов.</p>
	</div>
	
	<div style='font-size: 30px; line-height: 170%; text-align: center; font-weight: bold'>
	<p><a href='https://vk.com/polytechkolomna?w=wall-169312_2037%2Fall'>Читать новость о награждении</a></p>
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

			$mail->Subject = "Сертификаты и фото с церемонии награждение победителей";
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