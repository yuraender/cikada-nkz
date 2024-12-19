<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Ваш QR-код</title>
  </head>
  <body>
    <?php
      header('Content-type: text/html; charset=utf-8');

      if ( isset($_GET['lname']) && isset($_GET['passtype']) ) {
        
        require 'db_config.php';
        $ctn = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE) or die( mysqli_error() );
        mysqli_set_charset($ctn, "utf8");

        if ( $_GET['passtype'] == "code" ) {
          $result = mysqli_query($ctn, "SELECT * FROM Voters
            WHERE lname = '{$_GET['lname']}'
            AND smscode = '{$_GET['pass']}'
            AND smscode <> ''
          ");

        }

        if ( $_GET['passtype'] == "id" ) {
          $result = mysqli_query($ctn, "SELECT * FROM Voters
            WHERE lname = '{$_GET['lname']}'
            AND teamid = '{$_GET['pass']}'
          ");
        }

        if ( mysqli_num_rows($result) > 0 ) {

          $row = mysqli_fetch_assoc($result);

          $imgpath = "qr/" . $row['qrfile'];

          echo '<a href="' . $imgpath . '">';
          echo '<img id="qr" src="'  . $imgpath . '">';
          echo '</a> <br>';
          echo '<div id="fullname">';
          printf("%s<br>%s<br>%s\n", $row['lname'], $row['fname'], $row['patronym']);
          echo '</div>';

        } else {
          echo '<div id="error">';
          echo 'Не удалось найти QR-код по запросу <br>
          Возможно, он еще не внесен в базу. Попробуйте повторить запрос через некоторое время';
          echo '</div>';
        }
      } else {
        echo '<div id="error">';
        echo 'Введены не все данные';
        echo '</div>';
      }

    ?>
    <br>
    <div id="back">
      <a href="./">вернуться к вводу</a>
    </div>
  </body>
</html>