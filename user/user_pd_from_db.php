<?php

// Получение ПДн пользователя из БД

$findpd = mysqli_query($ctn, "SELECT *, DATE_FORMAT(bday, '%d.%m.%Y') as format_bday FROM PersonalData
	WHERE u_id = {$user['id']}
	");

if ( mysqli_num_rows($findpd) > 0 ) {
	$pData = mysqli_fetch_assoc($findpd);


	$findschool = mysqli_query($ctn, "SELECT * FROM School WHERE id = {$pData['school_id']} ");
	if ( $findschool && mysqli_num_rows($findschool) > 0 ) {
		$School = mysqli_fetch_assoc($findschool);
	}

}

?>