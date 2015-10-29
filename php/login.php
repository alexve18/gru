<?php
    require("session.php");
    if(isset($_POST)) {
      if(isset($_POST['loginId']) && isset($_POST['loginPassword'])) {
        $id = $_POST['loginId'];
        $query = "SELECT id, password FROM users WHERE id = :id";
        try {
          $verifyLogin = $connection->prepare($query);
          $result = $verifyLogin->execute(array(
            ':id'=>$id
          ));
          $row = $verifyLogin->fetch();
          $hashpass = $row['password'];
          echo($row['password']);
          if(password_verify($_POST['loginPassword'], $hashpass)) {
            unset($hashpass);
            $_SESSION['user'] = $row['id'];
            header("Location: ../profile.php");
            die();
          }
          else {
            //Wrong password
            $_SESSION['message'] = "Rangt lykilorð.";
            header("Location: ../form.php");
            die();
          }
        }
        catch(PDOException $ex) {
          die($ex->getMessage());
        }
      }
      else {
        //No ID or password entered
        $_SESSION['message'] = "Þú verður að slá inn bæði lykilorð og kennitölu.";
        header("Location: ../form.php");
        die();
      }
    }
    else {
      //Didn't use the POST form
      $_SESSION['message'] = "Eitthvað fór úrskeiðis, reyndu aftur.";
      header("Location: ../form.php");
      die();
    }
?>
