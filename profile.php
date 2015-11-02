<?php
//This little block checks if the user is actually logged in.
    require("php/session.php");
    if(!isset($_SESSION['user'])) {
      $_SESSION['message'] = "Vinsamlegast skráðu þig inn fyrst.";
      header("Location: form.php");
      die();
    }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>bar</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/profile.css">
  </head>
  <body>
    <div class="pure-g">
      <div class="pure-u-1 header">
        <!-- Holy fuck, this is a mess -->
          <div class="textwrap">
            <?php
              echo("<p class=\"left\">" . $_SESSION['user'] . " - " . $_SESSION['name'] . "</p>");
            ?>
            <p class="center">Lorem ipsum</p>
            <p class="right"><a href="php/logout.php">Logout</a></p>
        </div>
      </div>
    </div>
    <div class="wrapper">
      <?php
      if(isset($_SESSION['message'])) {
        echo("<div class=\"pure-g\">");
        echo("<div class=\"pure-u-1\">");
        echo("<p style='color:red;text-align:center'>" . $_SESSION['message'] . "</p>");
        echo("</div>");
        echo("</div>");
        unset($_SESSION['message']);
      }
      ?>
      <div class="pure-g">
        <div class="pure-u-1 pure-u-xl-9-24">
          <div class="registeredEvents">
            <h1>Viðburðir sem þú ert skráður í</h1>
            <table class="pure-table pure-table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nafn viðburðs</th>
                  <th>Dagsetning</th>
                  <th>foo</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $query = "SELECT events.id AS eventId, name, events.date AS eventDate FROM events
                JOIN registrations ON event_id = events.id
                WHERE user_id = :user";
                $eventCheck = $connection->prepare($query);
                $eventCheck->execute(array(
                  ':user'=>$_SESSION['user']
                ));
                $result = $eventCheck->fetchAll();
                if(!empty($result)) {
                  foreach($result as $row) {
                    echo("<tr>");
                    echo("<td>" . $row['eventId'] . "</td>");
                    echo("<td>" . $row['name'] . "</td>");
                    echo("<td>" . $row['eventDate'] . "</td>");
                    echo("<td>");
                    echo("<form method=\"POST\" action=\"php/delete.php\">");
                    echo("<input type=\"hidden\" name=\"event\" value=\"" . $row['eventId'] . "\">");
                    echo("<br><button type=\"submit\" class=\"pure-button-primary pure-button\">Skrá úr viðburði</button>");
                    echo("</form>");
                    echo("</td>");
                    echo("</tr>");
                  }
                }
                else {
                  echo("<tr><td></td><td>Engir skráðir viðburðir :(</td><td></td><td></td></tr>");
                }
              ?>
              </tbody>
            </table>
            <br><br>
            <form class="pure-form pure-u-1" action="php/events.php" method="POST">
              <div class="pure-control-group">
                <label>Skrá í viðburð: </label>
                <select name="event">
                  <?php
                    $result = $connection->query("SELECT id, name FROM events");
                    $result = $result->fetchAll();
                    foreach($result as $row) {
                      echo("<option value=\"" . $row['id'] . "\">");
                      echo($row['name']);
                      echo("</option>");
                    }
                  ?>
                </select>
                <button type="submit" class="pure-button pure-button-primary">Register</button>
              </div>
            </form>
          </div>
        </div>
        <div class="pure-u-1 pure-u-xl-1-24">
        </div>
        <div class="pure-u-1 pure-u-xl-12-24 info">
          <h1>Upplýsingar um notanda</h1>
          <div class="pure-g">
            <form class="pure-form pure-form-aligned pure-u-1" action="php/update.php" method="post">
              <fieldset>
                <div class="pure-control-group">
                  <label>Kennitala</label>
                  <input name="uid" type="text" style="color:#555" readonly="readonly" value="<?php echo($_SESSION['user']); ?>">
                </div>
                <div class="pure-control-group">
                  <label>Nafn</label>
                  <input name="name" type="text" value="<?php echo($_SESSION['name']); ?>">
                </div>
                <div class="pure-control-group">
                  <label>Netfang</label>
                  <input name="email" type="text" value="<?php echo($_SESSION['email']); ?>">
                </div>
                <div class="pure-control-group">
                  <label>Heimilisfang</label>
                  <input name="address" type="text" value="<?php if(isset($_SESSION['address'])) { echo ($_SESSION['address']);} ?>">
                </div>
                <div class="pure-control-group">
                  <label>Símanúmer</label>
                  <input name="phone" type="text" value="<?php if(isset($_SESSION['phone'])) { echo ($_SESSION['phone']);} ?>">
                </div>
                <div class="pure-control-group">
                  <label>Bolastærð</label>
                  <select name="size">
                    <option><?php if(isset($_SESSION['size'])) { echo ($_SESSION['size']); } ?></option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                    <option>XXL</option>
                  </select>
                </div>
                <div class="pure-controls">
                  <button type="submit" class="pure-button pure-button-primary">Uppfæra upplýsingar</button>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
      <div class="pure-g">
        <div class="pure-u-1">
          <h1>Viðburðir í boði</h1>
          <table class="pure-table">
            <tbody>
              <tr>
                <th>ID</th>
                <th>Nafn viðburðs</th>
                <th>Dagsetning</th>
                <th>Lýsing</th>
              </tr>
              <?php
                $query = "SELECT * FROM events";
                $result = $connection->query($query);
                $result = $result->fetchAll();
                foreach($result as $row) {
                  echo("<tr>");
                  echo("<td>" . $row['id'] . "</td>");
                  echo("<td>" . $row['name'] . "</td>");
                  echo("<td>" . $row['date'] . "</td>");
                  echo("<td>" . $row['description'] . "</td>");
                  echo("</tr>");
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </body>
</html>
