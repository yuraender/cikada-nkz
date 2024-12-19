<?php
  require_once 'manage_redirect_logic.php';

  if ( empty($_FILES['agree_scan']) || empty($_FILES['app_scan']) ) {
    header("Location: application.php");
    exit;
  }


if ( !isset( $_POST['userid'] ) ) {
  echo "Не задан пользователь";
  exit();
}

$userid = $_POST['userid'];

$findpd = mysqli_query($ctn, "SELECT *, DATE_FORMAT(bday, '%d.%m.%Y') as format_bday FROM PersonalData
  WHERE u_id = {$userid}
  ");

if ( mysqli_num_rows($findpd) > 0 ) {
  $pData = mysqli_fetch_assoc($findpd);


  $findschool = mysqli_query($ctn, "SELECT * FROM School WHERE id = {$pData['school_id']} ");
  if ( $findschool && mysqli_num_rows($findschool) > 0 ) {
    $School = mysqli_fetch_assoc($findschool);
  }

}

$result = mysqli_query($ctn, "SELECT * FROM User WHERE id = '{$userid}' ");

  if ( mysqli_num_rows($result) > 0 ) {

    $user = mysqli_fetch_assoc($result);
    $id = $user['id'];
    $status = $user['status'];

  } else {
    $id = -1;
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
        $app_path = '../user/scan/' . $app_filename;

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
        $agree_path = '../user/scan/' . $agree_filename;

        $result = mysqli_query($ctn, "SELECT * FROM Scan
          WHERE application = '{$agree_filename}' OR agreement = '{$agree_filename}' ");

        $counter++;

      } while ( mysqli_num_rows($result) > 0 );


      if (  !move_uploaded_file($_FILES['app_scan']['tmp_name'], $app_path) ||
            !move_uploaded_file($_FILES['agree_scan']['tmp_name'], $agree_path) ) {
          session_start();
          $_SESSION['error_text'] = "Не удалось загрузить файлы. Попробуйте повторить позже";
          header("Location: check_applications.php");
          exit;
      }

      $result = mysqli_query($ctn, "INSERT INTO Scan(u_id, application, agreement, status)
      VALUES ({$user['id']}, '{$app_filename}', '{$agree_filename}', 4)");

      if ( $result ) {
        // Изменение статуса у пользователя на "Заявка подана"
      $result = mysqli_query($ctn, "
        UPDATE User SET status = 4 WHERE id = {$user['id']}");
      }

      header("Location: check_applications.php");
      exit;
?>