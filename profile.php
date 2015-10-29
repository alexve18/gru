<?php
    require("php/session.php");
    //TODO: EVERYTHING
    if(!isset($_SESSION['user'])) {
      header("Location: form.htm");
      die();
    }
?>
<h1>Yay, you're logged in successfully!</h1>
