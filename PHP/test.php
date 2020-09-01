<?php
  echo "Thanks for filling out our survey!" . "<br>";
  print_r($_POST);
  foreach($_POST as $value){
    echo $value . "<br>";
  }
  echo('<form method = "Post" action = index.php>');

  echo('<section class = "Submit">');
    echo('<input type = "submit" value = "submit">');
  echo('</section>');

  echo('</form>');
?>
