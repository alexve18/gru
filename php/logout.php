<?php
  require("session.php");
  unset($_SESSION['user']);
  unset($_SESSION['name']);
  if($_SESSION['event'] == 1) {
    unset($_SESSION['event']);
    $_SESSION['message'] = "Upplýsingar uppfærðar. Vinsamlegast skráðu þig inn aftur.";
    header("Location: ../form.php");
    die();
  }
  $_SESSION['message'] = "Útskráning tókst.";
  header("Location: ../form.php");
  die();
?>
