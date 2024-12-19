<?php require_once 'manage_redirect_logic.php'; ?>
<?php
	if ( !isset($_GET['id']) && !isset($_POST['id'])) {
		header("Location: check_applications.php");
    	exit;
	}

	if ( isset($_POST['status']) ) {

	if ( isset($_GET['id']) ) $id = $_GET['id'];
	if ( isset($_POST['id']) ) $id = $_POST['id'];

	mysqli_query($ctn, "UPDATE Scan SET status = {$_POST['status']} WHERE id = {$id}");
	if ( isset($_POST['comment']) ) {
		$result = mysqli_query($ctn, "UPDATE Scan SET comment = '{$_POST['comment']}' WHERE id = {$id}");
	}

	$result = mysqli_query($ctn, "SELECT u_id FROM Scan WHERE id = {$id}");
	$r = mysqli_fetch_assoc($result);
	$result = mysqli_query($ctn, "UPDATE User SET status = {$_POST['status']} WHERE id = {$r['u_id']}");

	

	header("Location: check_applications.php");
	exit;
	}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="manage.css">
	<title>Приём заявки</title>
	<style type="text/css">

		body {
			padding: 50px;
		}

	</style>
</head>
<body>

	<h2>Что сделать с заявкой?</h2>

	<form id="appForm" enctype="multipart/form-data" method="post" action="app_status.php">
		ID<br>
		<input readonly required type="text" name="id" size="50" value="<?php echo $_GET["id"]; ?>">
		<br><br>
		Действие:<br>
		<select name="status" >
			<option value='5'>Отклонить</option>
			<option value='3'>Принять</option>
			<option value='4'>В обработку</option>
		</select>

		<p>Комментарий<Br>
   <textarea name="comment" cols="50" rows="5"></textarea></p>

   	<input type="submit" value="Отправить">
	</form>

		
</body>
</html>