<?php require_once 'metodist_redirect_logic.php'; ?>
<?php
	if ( !isset($_GET['id']) && !isset($_POST['id'])) 
	{
		header("Location: participant_status_list.php");
    	exit;
	}

	if ( isset($_POST['status']) ) 
	{
		if ( isset($_GET['id']) ) $id = $_GET['id'];
		if ( isset($_POST['id']) ) $id = $_POST['id'];
		$result = mysqli_query($ctn, "UPDATE User SET status = {$_POST['status']} WHERE id = {$id}");
		header("Location: participant_status_list.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="metodist.css">
	<title>Определение финалистов</title>
	<style type="text/css">

		body {
			padding: 50px;
		}

	</style>
</head>
<body>

	<form id="appForm" enctype="multipart/form-data" method="post" action="participant_status.php">
		ID<br>
		<input readonly required type="text" name="id" size="50" value="<?php echo $_GET["id"]; ?>">
		<br><br>
		Назначьте участнику статус:<br>
		<select name='status' method='POST'>
			<option value='3'>Не выбрано</option>
			<option value='7'>Финалист</option>
			<option value='8'>Нефиналист</option>
		</select>
		<br><br>
   		<input type="submit" value="Сохранить">
	</form>

		
</body>
</html>