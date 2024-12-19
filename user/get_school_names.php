<?php
// get_shool_names

require_once 'user_redirect_logic.php';

$result = mysqli_query($ctn, "
	SELECT DISTINCT name FROM School WHERE town = '{$_GET['town']}' ORDER BY name
");

$semicolon = false;
while ( $record = mysqli_fetch_assoc($result) ) {
	if ( $semicolon ) echo ";"; else $semicolon = true;
	echo $record['name'];
}
?>