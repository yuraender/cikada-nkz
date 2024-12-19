<?php require_once 'PHPMailer-5.2-stable/PHPMailerAutoload.php';

	require_once 'manage_redirect_logic.php';

	
	$text = trim($_POST['list_of_mails']);
	    $text = explode ("\n", $text);

	    foreach ($text as $line) {
	    	echo "<br><hr>";
	    	$line = trim( $line );
	       	echo $line;

			$uinfo = mysqli_query($ctn, "
			  				SELECT * FROM User, PersonalData WHERE u_id = id AND email = '{$line}';
			  			");

			if ( !$urow = mysqli_fetch_assoc($uinfo) ) {
				echo "Нет пользователя с этой почтой";
				continue;
			}

			$message = "
			<h2>Привет, {$urow['fname']}!</h2>
			<div style='font-size: 20px; line-height: 170%'>
			{$_POST['message_text']}
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

					$mail->Subject = "Информация о заявке";
					$mail->Body = $message;
					$mail->AddAddress($urow['email']);

					echo $urow['u_id'];
					echo ". ";

					if ( $mail->send() ) {
						echo "Все удачно! Сообщение отправлено на почту";
						
					} else {
						echo "Сообщение с данными для входа не было отправлено";
					}

					echo "<br>";

				} catch (Exception $e) {
					echo $e->getMessage(); //Boring error messages
				}
	}

?>