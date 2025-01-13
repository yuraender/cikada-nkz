<?php
	require_once '../db_config.php';
 	require_once 'metodist_redirect_logic.php'; 
 	
	if ( !isset($_GET['id']) && !isset($_POST['id'])) 
	{
		header("Location: team_list.php");
    	exit;
	}

	if ( isset($_POST['team']) ) 
	{
		if ( isset($_GET['id']) ) $id = $_GET['id'];
		if ( isset($_POST['id']) ) $id = $_POST['id'];
		$result = mysqli_query($ctn, "UPDATE User SET team = {$_POST['team']} WHERE id = {$id}");
		header("Location: team_list.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="manage.css">
	<title>Составление команд</title>
	<style type="text/css">

		body {
			padding: 50px;
		}

	</style>
</head>
<body>

	<form id="appForm" enctype="multipart/form-data" method="post" action="participant_team.php">
		ID<br>
		<input readonly required type="text" name="id" size="50" value="<?php echo $_GET["id"]; ?>">
		<br><br>
		Определить участника в команду
		
		<?php
	    $result = mysqli_query($ctn, "SELECT * FROM Team ORDER BY id");
	    echo "<select name='team' method='POST'>";
	    echo '<option value="0">Не выбрано</option>';

      	while ($row = $result->fetch_assoc()) 
      	{
	        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
      	}
    	echo "</select>";
		?>
		
		<br><br>
   		<input type="submit" value="Сохранить">
	</form>

		
</body>
</html>