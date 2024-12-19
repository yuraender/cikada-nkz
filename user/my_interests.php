<?php
require_once 'user_redirect_logic.php'; 
require_once 'user_pd_from_db.php'; 
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="/style.css">
	<link rel="stylesheet" href="user.css">

	<title>Мои интересы</title>

	<style type="text/css">

		input, select {
			padding: 10px;
			margin: 20px;
			font-size: 15px;

			-moz-box-sizing:border-box;
			-webkit-box-sizing:border-box;
			box-sizing:border-box;
		}

		input[type="text"], select {
			width: 500px;
		}


	</style>

	<!-- Подключение библиотеки jQuery -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<!-- Подключение jQuery плагина Masked Input -->
	<script src="js/jquery.maskedinput.min.js"></script>

	<script type="text/javascript">
		$(function(){
			$("#phone").mask("+7 999 999-99-99");
		});

		$(function(){
			$("#phoneParent").mask("+7 999 999-99-99");
		});

		$(function(){
			$("#bday").mask("99.99.9999");
		});

		// Асинхронное получение контента

		function httpGetAsync(theUrl, callback)
		{
		    var xmlHttp = new XMLHttpRequest();
		    xmlHttp.onreadystatechange = function() { 
		        if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
		            callback(xmlHttp.responseText);
		    }
		    xmlHttp.open("GET", theUrl, true); // true for asynchronous 
		    xmlHttp.send(null);
		}

		function newSchoolCheck(that) {
			if (that.value == "0") {
				document.getElementById("add_school").style.display = "block";
			} else {
				document.getElementById("add_school").style.display = "none";
			}
		}


		function ready() {
			var selop = document.getElementById("db_town").options;
			// Эмуляция выбора города для прогрузки списка школ
			newTownCheck(selop[selop.selectedIndex]);
		}

		document.addEventListener("DOMContentLoaded", ready);

		function newTownCheck(that) {
			if (that.value == "0") {
				document.getElementById("add_town").style.display = "block";
				document.getElementById("add_school").style.display = "block";
				document.getElementById("select_school").style.display = "none";
			} else {
				document.getElementById("add_town").style.display = "none";
				document.getElementById("add_school").style.display = "none";
				document.getElementById("select_school").style.display = "block";

				// Очистка списка школ
				var select = document.getElementById("school_list");
				// var length = select.options.length;
				select.options.length = 1;


				// Получение массива с названиями школ из выбранного города

				var req_url = "get_school_names.php?town=";
				req_url += that.value;

				var selected_school = "<?php if ( isset($School) ) echo $School['name']; ?>";
				var s = false;

				httpGetAsync(req_url, function (response) {
					var schools = response.split(";");
					for(i in schools)
					{
						s = schools[i] == selected_school;
						select.options[select.options.length] = new Option(schools[i], schools[i], s, s);

					}

					select.options[select.options.length] = new Option("ОУ нет в списке", "0");
				}
				);
			}
		}

	</script>

</head>
<body>
	<?php require "../header.html"; ?>
	<div id="pageContainer">
		<?php require "user_menu.php"; ?>
		<div id="userContent">
			<h2>Мои интересы</h2>

			<?php
			if ( !isSet($pData) ) {
				echo "<br><br><h3 style='color: red;'>Сначала необходимо заполнить анкету</h3>";
				echo "</body>";
				echo "</html>";
				exit;
			}
			?>

			<br>

			<form id="pdForm" enctype="multipart/form-data" method="post" action="save_interests.php">

			Укажите <b>языки программирования</b>,<br>которые предполагаете использовать на Олимпиаде:<br>
			<input  id="prog_lang" name="prog_lang" type="text" placeholder="Например: Pascal" class="form-control"
				<?php if ( isset($pData) ) echo 'value="'.$pData['programming_languages'].'"'; ?> >
			
			<br><br>

			<?php if ( preg_match("/10/", $pData['grade'])  OR  preg_match("/11/", $pData['grade']) ) 
			{ ?>

			Укажите, задание по какой теме будете выполнять в 3 части:<br>
			<input type="radio" id="robotics"
		     name="third_part" value="robotics" 
		     <?php if ( isset($pData) && $pData['var_part'] == 1  ) echo ' checked="true"'; ?>
		    >
		    <label for="robotics">Робототехника (платформа Arduino)</label>
		    <br>

		    <input type="radio" id="programming"
		     name="third_part" value="programming"
		     <?php if ( isset($pData) && $pData['var_part'] == 2  ) echo ' checked="true"'; ?>
		    >
		    <label for="programming">Программирование</label>
		    <br>

		    <input type="radio" id="graphics"
		     name="third_part" value="graphics"
		     <?php if ( isset($pData) && $pData['var_part'] == 3  ) echo ' checked="true"'; ?>
		    >
		    <label for="graphics">Компьютерная графика и черчение</label>
			<br>
			<?php
			}
			?>

			<input type="submit" value="Сохранить">
		</form>


		</div>
	</div>
</body>
</html>