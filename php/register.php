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
        die("Query failed: " . $ex->getMessage());
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
          die("Insert failed: " . $ex->getMessage());
        }
        header("Location: ../form.htm");
        die();
      }
    }
    die("Vinsamlegast fylltu inn kennitölu og lykilorð");
  }
  die();
?>
