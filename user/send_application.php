<?php
  require_once 'user_redirect_logic.php';

  if ( empty($_FILES['agree_scan']) || empty($_FILES['app_scan']) ) {
    header("Location: application.php");
    exit;
  }

  function translit($str) {
      $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
      $lat = array('a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'ju', 'ja', 'a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'ju', 'ja');
      return str_replace($rus, $lat, $str);
  }


      // Формирование имени файла скана заявки
      $extfile = pathinfo( basename($_FILES['app_scan']['name']), PATHINFO_EXTENSION );
      $translitname = translit($user['lname']);

      $counter = 0;

      do {
        $app_filename =  $translitname . '_app';
        if ( $counter > 0 ) $app_filename .= '_' . $counter;
        $app_filename .= '.' . $extfile;
        $app_path = 'scan/' . $app_filename;

        $result = mysqli_query($ctn, "SELECT * FROM Scan
          WHERE application = '{$app_filename}' OR agreement = '{$app_filename}' ");

        $counter++;

      } while ( mysqli_num_rows($result) > 0 );



      // Формирование имени файла скана согласия
      $extfile = pathinfo( basename($_FILES['agree_scan']['name']), PATHINFO_EXTENSION );
      $translitname = translit($user['lname']);

      $counter = 0;

      do {
        $agree_filename =  $translitname . '_agree';
        if ( $counter > 0 ) $agree_filename .= '_' . $counter;
        $agree_filename .= '.' . $extfile;
        $agree_path = 'scan/' . $agree_filename;

        $result = mysqli_query($ctn, "SELECT * FROM Scan
          WHERE application = '{$agree_filename}' OR agreement = '{$agree_filename}' ");

        $counter++;

      } while ( mysqli_num_rows($result) > 0 );


      if (  !move_uploaded_file($_FILES['app_scan']['tmp_name'], $app_path) ||
            !move_uploaded_file($_FILES['agree_scan']['tmp_name'], $agree_path) ) {
          session_start();
          $_SESSION['error_text'] = "Не удалось загрузить файлы. Попробуйте повторить позже";
          header("Location: application.php");
          exit;
      }

      $result = mysqli_query($ctn, "INSERT INTO Scan(u_id, application, agreement, status)
      VALUES ({$user['id']}, '{$app_filename}', '{$agree_filename}', 4)");

      if ( $result ) {
        // Изменение статуса у пользователя на "Заявка подана"
      $result = mysqli_query($ctn, "
        UPDATE User SET status = 4 WHERE id = {$user['id']}");
      }

      header("Location: application.php");
      exit;
?>