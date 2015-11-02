<?php
  require("session.php");
  if(isset($_POST)) {
    if(isset($_SESSION['user'])) {
      $query = "SELECT 1 FROM registrations WHERE user_id = :uid AND event_id = :event";
      $uid = $_SESSION['user'];
      $event = $_POST['event'];
      if(!empty($event)) {
        try {
          $uniqueCheck = $connection->prepare($query);
          $uniqueCheck->execute(array(
            ':uid'=>$uid,
            ':event'=>$event
          ));
          $row = $uniqueCheck->fetch();
          if(!$row) {
            $query = "INSERT INTO registrations(user_id, event_id) VALUES(:uid, :event)";
            try {
              $insert = $connection->prepare($query);
              $insert->execute(array(
                ':uid'=>$uid,
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
          else {
            $_SESSION['message'] = "Þú ert núþegar skráður í þennan viðburð.";
            header("Location: ../profile.php");
            die();
          }
        } catch (PDOException $e) {
          $_SESSION['message'] = "Eitthvað fór úrskeiðis, reyndu aftur.";
          header("Location: ../profile.php");
          die();
        }
      }
    }
  }
?>
