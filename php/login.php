<?php
    require("session.php");
    if(isset($_POST)) {
      if(isset($_POST['loginId']) && isset($_POST['loginPassword'])) {
        $id = $_POST['loginId'];
        $query = "SELECT id, password, name, email, address, phone, size FROM users WHERE id = :id";
        try {
          $verifyLogin = $connection->prepare($query);
          $result = $verifyLogin->execute(array(
            ':id'=>$id
          ));
          $row = $verifyLogin->fetch();
          if(!isset($row['id'])) {
            //SQL query returned no user with such ID
            $_SESSION['message'] = "Notandi fannst ekki í gagnagrunni.";
            header("Location: ../form.php");
            die();
          }
          $hashpass = $row['password'];
          echo($row['password']);
          if(password_verify($_POST['loginPassword'], $hashpass)) {
            unset($hashpass);
            $_SESSION['user'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['size'] = $row['size'];
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
