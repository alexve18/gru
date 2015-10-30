<?php
  //I really need to check every single case something can go wrong, because you can't underestimate the lengths the user will go to to fuck things up.
  require("session.php");
  if(isset($_POST) && isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    if($user != $_POST['uid']) {
      $_SESSION['message'] = "Eitthvað fór úrskeiðis, reyndu aftur #1";
      header("Location: ../form.php");
      die();
    }
    if(empty($_POST['name']) || empty($_POST['uid']) || empty($_POST['email'])) {
      $_SESSION['message'] = "Þú verður að slá inn nafn og netfang";
      header("Location: ../form.php");
      die();
    }
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = '';
    $phone = '';
    $size = '';
    if(isset($_POST['address'])) {
      $address = $_POST['address'];
    }
    if(isset($_POST['phone'])) {
      $phone = $_POST['phone'];
    }
    if(isset($_POST['size'])) {
      $size = $_POST['size'];
    }
    try {
      $query = "UPDATE users SET name = :name, email = :email, address = :address, phone = :phone, size = :size WHERE id = :id";
      $update = $connection->prepare($query);
      $update->execute(array(
        ':name'=>$name,
        ':email'=>$email,
        ':address'=>$address,
        ':phone'=>$phone,
        ':size'=>$size,
        ':id'=>$user,
      ));
    } catch (PDOException $e) {
      $_SESSION['message'] = "Eitthvað fór úrskeiðis, reyndu aftur";
      echo($e);
      exit();

      ///header("Location: ../form.php");
      //die();
    }
    $_SESSION['event'] = 1;
    header("Location: logout.php");
    die();
  }
  else {
    $_SESSION['message'] = "Vinsamlegast skráðu þig inn fyrst.";
    header("Location: ../form.php");
    die();
  }
?>
