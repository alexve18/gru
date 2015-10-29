<?php
    require("session.php");
    if(isset($_POST)) {
      $validLogin = false;
      if(isset($_POST['id']) && isset($_POST['password'])) {
        $id = $_POST['loginId'];
        $query = "SELECT id, password FROM users WHERE id = :id";
        try {
          $verifyLogin = $connection->prepare($query);
          $result = $verifyLogin->execute(array(
            ':id'=>$id
          ));
          $row = $result->fetch();
          $hashpass = $row['password'];
          if(password_verify($_POST['loginPassword'], $hashpass)) {
            $validLogin = true;
            unset($hashpass);
            $_SESSION('user') = $row['id'];
            header("Location: profile.php");
            die("Redirection...");
          }
        }
        catch(PDOException $ex) {
          die($ex->getMessage());
        }
      }
    }
    else {
      die();
    }
?>
