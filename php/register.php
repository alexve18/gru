<?php
  require("session.php");
  //Checks if you actually went through the form instead of just typing in the URI
  if(isset($_POST)) {
    //Checks if all the fields are set before continuing
    if(isset($_POST['id']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['name'])) {
      $id = $_POST['id'];
      $email = $_POST['email'];
      $name = $_POST['name'];
      $password = '';
      $salt = '';
      //Checks if the dude registering is already in the database
      //INSERT IGNORE is too quiet, we need actual errors, dawg
      $query = "SELECT 1 FROM users WHERE id = :id";
      try {
        $uniqueCheck = $connection->prepare($query);
        $result = $uniqueCheck->execute(array(
          ':id'=>$id
        ));
        $row = $uniqueCheck->fetch();
      }
      catch(PDOException $ex) {
        $_SESSION['message'] = "Query failed: " . $ex->getMessage();
        header("Location: ../form.php");
        die();
      }
      if(!$row) {
        $query = "INSERT INTO users (id, password, email, name)
        VALUES (:id, :password, :email, :name);";
        /*here be fancy salt & hash stuff
          http://php.net/manual/en/function.password-hash.php
          You don't have to have a specific column just for the hash with this function,
          it simply stores the hash alongside the salt. */
        if(password_hash($_POST['password'], PASSWORD_DEFAULT)) {
          $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        else {
          $_SESSION['message'] = "Eitthvað fór úrskeiðis, reyndu aftur.";
          header("Location: ../form.php");
          die();
        }
        try {
          $insert = $connection->prepare($query);
          $insert->execute(array(
            ':id'=>$id,
            ':password'=>$password,
            ':email'=>$email,
            ':name'=>$name
          ));
        }
        catch(PDOException $ex) {
          $_SESSION['message'] = "Eitthvað fór úrskeiðis, reyndu aftur.";
          header("Location: ../form.php");
          die();
        }
        $_SESSION['message'] = "Success";
        header("Location: ../form.php");
        die();
      }
      else {
        $_SESSION['message'] = "Notandi er núþegar í gagnagrunni.";
        header("Location: ../form.php");
        die();
      }
    }
    $_SESSION['message'] = "Vinsamlegast sláðu inn allar upplýsingarnar til að skrá þig.";
    header("Location: ../form.php");
    die();
  }
  header("Location: ../form.php");
  die();
?>
