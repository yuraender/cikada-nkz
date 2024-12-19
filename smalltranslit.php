<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Транслитерация</title>
  </head>
  <body>
    <form method="get" action="smalltranslit.php">
        Для транслитерации:<br>
        <input type="text" name="rustxt" size="40">
        <br>
        <input type="submit" value="В транслит">
      </form>
    <?php
      header('Content-type: text/html; charset=utf-8');

      function translit($str) {
          $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
          $lat = array('a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'ju', 'ja', 'a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'ju', 'ja');
          return str_replace($rus, $lat, $str);
      }

      if ( isset($_GET['rustxt']) ) {

          $translittxt = translit($_GET['rustxt']);

          echo '<br><br>';
          echo '<H3>';
          echo $_GET['rustxt'];
          echo '</H3>';

          echo '<H1>';
          echo $translittxt;
          echo '</H1>';
      }

    ?>

  </body>
</html>