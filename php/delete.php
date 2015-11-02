<?php
  require("session.php");
  $query = "DELETE FROM registrations WHERE user_id = :user AND event_id = :event";
  if(isset($_POST) && isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $event = $_POST['event'];
    try {
      $delete = $connection->prepare($query);
      $delete->execute(array(
        ':user'=>$user,
        ':event'=>$event
      ));
    } catch (PDOException $e) {
      $_SESSION['message'] = "Eitthvað fór úrskeiðis, reyndu aftur.";
      header("Location: ../profile.php");
      die();
    }
    header("Location: ../profile.php");
    die();
  }
?>
