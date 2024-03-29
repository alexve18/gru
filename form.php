<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>foo</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/forms.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
  </head>
  <body>
    <script>
      $(document).ready(function() {
        $(".loginClick").click(function() {
          $(".register").removeClass("hidden");
          $(".login").addClass("hidden");
        });
        $(".registerClick").click(function() {
          $(".login").removeClass("hidden");
          $(".register").addClass("hidden");
        });
      })
    </script>
    <div class="backWrap">
        <a href="index.htm">
          <p class="backButton"><i class="material-icons">arrow_back</i>Aftur á forsíðu</p>
        </a>
    </div>
    <div class="wrapperoni">
      <div class="login">
        <form class="pure-form" action="php/login.php" method="POST">
          <h2>Innskráning</h2>
          <p>Smelltu <a href="#" class="loginClick">hér</a> til að nýskrá þig</p>
          <fieldset class="pure-group">
              <input type="text" class="pure-input-1" required placeholder="Kennitala" name="loginId">
              <input type="password" class="pure-input-1" required placeholder="Lykilorð" name="loginPassword">
          </fieldset>
          <button type="submit" class="pure-button pure-input-1 pure-button-primary">Innskráning</button>
          <?php
          require("php/session.php");
          if(isset($_SESSION['message'])) {
            echo("<br><br><br><p style='color:red;text-align:center'>" . $_SESSION['message'] . "</p>");
            unset($_SESSION['message']);
          }
          ?>
        </form>
      </div>
      <div class="register hidden">
        <form class="pure-form" action="php/register.php" method="POST">
          <h2>Nýskráning</h2>
          <p>Smelltu <a href="#" class="registerClick">hér</a> til að innskrá þig</p>
          <fieldset class="pure-group">
              <input type="text" class="pure-input-1" required placeholder="Kennitala" name="id">
              <input type="text" class="pure-input-1" required placeholder="Nafn" name="name">
              <input type="email" class="pure-input-1" required placeholder="Netfang" name="email">
              <input type="password" class="pure-input-1" required placeholder="Lykilorð" name="password">
          </fieldset>
          <button type="submit" class="pure-button pure-input-1 pure-button-primary">Nýskráning</button>
        </form>
      </div>
    </div>
  </body>
</html>
