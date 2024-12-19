<?php

	require_once 'metodist_redirect_logic.php';


	if ( !isset( $_POST['taskid'] ) ) {
		echo "Нет данных для сохранения";
		exit();
	}

	$tid = $_POST['taskid'];

	//echo $tid . "<br><br><br>";

	$idx = 1;
	while ( isset( $_POST['userid' . $idx] ) ) {
		if ( $_POST['score' . $idx] != "" ) {
			//echo $_POST['score' . $idx] . "<br>";

			$r = mysqli_query($ctn, "INSERT INTO Result(u_id, teacher_id, task_id, score)
				VALUES ('{$_POST['userid' . $idx]}', '{$user['id']}', '{$tid}', '{$_POST['score' . $idx]}' )");
		}
		$idx++;

		//INSERT INTO `u0753756_default`.`Result` (`u_id`, `teacher_id`, `task_id`, `score`) VALUES ('124', '23', '2', '5');

	}

	header("Location: /metodist/grade_list.php");
	exit;

?>