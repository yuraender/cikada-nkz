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

	<title>Анкета участника олимпиады</title>

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
			<h2>Анкета участника олимпиады</h2>


			<form id="pdForm" enctype="multipart/form-data" method="post" action="save_pd.php">

			ФИО:<br>
			<input type="text"	disabled="disabled"
				value="<?php echo $user["lname"] . ' ' . $user["fname"] . ' ' . $user["patronym"]; ?>" >
			
			<br><br>

			Дата рождения:<br>
			<input  id="bday" name="bday" type="text" placeholder="дд.мм.гггг" class="form-control"
				<?php if ( isset($pData) ) echo 'value="'.$pData['format_bday'].'"'; ?> >
			<br>

			<h3>Образовательное учреждение</h3>
			Город:<br>
			<select name="db_town" id="db_town" onchange="newTownCheck(this);">
			<option selected disabled hidden style='display: none' value=''></option>
			<?php
			$result = mysqli_query($ctn, "SELECT DISTINCT town FROM School");
			while ( $record = mysqli_fetch_assoc($result) ) {
				echo "<option ";
				if ( isset($School) && $record["town"] == $School["town"] ) echo "selected ";
				printf ('value="%s">%s</option>', $record["town"], $record["town"]);
			}
			?>
			<option value="0">Города нет в списке</option>
			</select>
			<br>

			<div id="add_town"  style="display: none;">
				Введите город:<br>
				<input type="text" name="new_town" id="new_town" placeholder="например: Луховицы"
				style="background-color: #FF4;">
				<br>
			</div>

			<div id="select_school"  style="display: none;">
				Образовательное учреждение:<br>
				<select name="db_school_name" id="school_list" onchange="newSchoolCheck(this);">
				<option selected disabled hidden style='display: none' value=''></option>
				</select>
				<br>
			</div>

			<div id="add_school"  style="display: none;">
				Введите название образовательного учреждения:<br>
				<input type="text" name="new_school_name" id="new_school_name"
				placeholder="например: МБОУ СОШ № 5"
				style="background-color: #FF4;">
				<br>
			</div>

			Класс:<br>
			<input type="text" name="grade" placeholder="например: 10"
				<?php if ( isset($pData) ) echo 'value="'.$pData['grade'].'"'; ?> >
			<br>

			<h3> Контакты </h3>

			Электронная почта:<br>
			<input type="text" name="email" placeholder="E-mail" 
				<?php if ( isset($pData) ) echo 'value="'.$pData['email'].'"'; ?> >
			<br> 

			Телефон:<br>
			<input  id="phone" name="phone" type="text" placeholder="Номер телефона" class="form-control"
				<?php if ( isset($pData) ) echo 'value="'.$pData['phone'].'"'; ?> >
			<br> 

			Законный представитель участника:<br>
			<span style="font-size: 14px; color: #999;">
			родитель, усыновитель или опекун несовершеннолетнего <br>
			</span>
			<input  id="nameParent" name="nameParent" type="text" placeholder="например: Агапова Анна Алексеевна"
				<?php if ( isset($pData) ) echo 'value="'.$pData['nameParent'].'"'; ?> >
			<br>

			Телефон законного представителя:<br>
			<input  id="phoneParent" name="phoneParent" type="text" placeholder="Номер телефона" class="form-control"
				<?php if ( isset($pData) ) echo 'value="'.$pData['phoneParent'].'"'; ?> >
			<br>


			<h3> Место проживания </h3>

			Область:<br>
			<input  id="oblast" name="oblast" type="text" placeholder="например: Московская"
				<?php if ( isset($pData) ) echo 'value="'.$pData['oblast'].'"'; ?> >
			<br> 

			Населенный пункт:<br>
			<input  id="locality" name="locality" type="text" placeholder="например: Коломна"
				<?php if ( isset($pData) ) echo 'value="'.$pData['locality'].'"'; ?> >
			<br>

			Улица:<br>
			<input  id="street" name="street" type="text" placeholder="например: Ленина"
				<?php if ( isset($pData) ) echo 'value="'.$pData['street'].'"'; ?> >
			<br>

			Дом:<br>
			<input  id="home" name="home" type="text" placeholder="например: 12"
				<?php if ( isset($pData) ) echo 'value="'.$pData['home'].'"'; ?> >
			<br>

			Квартира:<br>
			<input  id="apartment" name="apartment" type="text" placeholder="например: 34"
				<?php if ( isset($pData) ) echo 'value="'.$pData['apartment'].'"'; ?> >
			<br>

			<h3> Преподаватели </h3>

			Учитель, осуществляющий подготовку по информатике и ИКТ:<br>
			<input  id="teacherIKT" name="teacherIKT" type="text"
			placeholder="например: Баринов Богдан Борисович"
				<?php if ( isset($pData) ) echo 'value="'.$pData['teacherIKT'].'"'; ?> >
			<br>

			Классный руководитель (куратор):<br>
			<input  id="classTeacher" name="classTeacher" type="text"
			placeholder="например: Волкова Вера Викторовна"
				<?php if ( isset($pData) ) echo 'value="'.$pData['classTeacher'].'"'; ?> >
			<br>

			<h3> Интересы </h3>

			Укажите <b>языки программирования</b>,<br>которые предполагаете использовать на Олимпиаде:<br>
			<input  id="prog_lang" name="prog_lang" type="text" placeholder="Например: Pascal" class="form-control"
				<?php if ( isset($pData) ) echo 'value="'.$pData['programming_languages'].'"'; ?> >
			
			<br><br>

			<?php if ( isset($pData) AND ( preg_match("/10/", $pData['grade'])  OR  preg_match("/11/", $pData['grade']) ) ) 
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


			<input type="submit" <?php if ($user['status'] < 5) echo ' disabled="disabled" '; ?> value="Сохранить">

			<?php
			if ($user['status'] < 5)
				echo "<b style='color: red;'>Вы не можете изменять данные после подачи заявки</b>";
			?>
		</form>


		</div>
	</div>
</body>
</html>