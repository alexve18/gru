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
      <div class="pure-g">
        <div class="pure-u-1 pure-u-xl-14-24">
          <h1>Viðburðir?</h1>
            <table class="pure-table pure-table-horizontal">
              <tbody>
                <tr>
                  <td>08:00</td>
                  <td>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ipsum risus, ultrices in nibh et, elementum iaculis tortor.
                  </td>
                </tr>
                <tr>
                    <td>12:00</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ipsum risus, ultrices in nibh et, elementum iaculis tortor.</td>
                </tr>
                <tr>
                    <td>16:00</td>
                    <td>asdf</td>
                </tr>
                <tr>
                    <td>18:00</td>
                    <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ipsum risus, ultrices in nibh et, elementum iaculis tortor.</td>
                </tr>
            </tbody>
          </table>
          <form action="set.php" method="GET">
            <select>
              <!-- TODO: implement event option selection with a way for users to actually register to events -->
              <?php
                $query = "SELECT * FROM events";
                $result = $connection->query($query);
                $row = $result->fetchAll();
                foreach($row as $option) {
                  echo("<option value=\"" . $option['id'] . "\">" . $option['id'] . " - " . $option['name'] . " - " . $option['date'] . "</option>");
                }
              ?>
            </select>
            <input type="submit">
          </form>
        </div>
        <div class="pure-u-1 pure-u-xl-1-24">
        </div>
        <div class="pure-u-1 pure-u-xl-9-24">
          <h1>Upplýsingar um notanda</h1>
          <div class="pure-g">
            <form class="pure-form pure-form-aligned pure-u-1 pure-u-lg-12-24 pure-u-xl-1" action="php/update.php" method="post">
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
            <div class="pure-u-1 pure-u-lg-12-24 pure-u-xl-1">
              <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ipsum risus, ultrices in nibh et, elementum iaculis tortor. Duis eget risus vel odio egestas faucibus. Praesent et orci vehicula eros gravida feugiat. Donec eleifend velit a quam volutpat, sit amet porta nulla sodales. Donec porta lacinia mauris non porta. Vivamus fermentum tellus in sem sollicitudin, sit amet maximus purus congue. Integer vel quam tellus. Proin bibendum mi purus, ut mattis erat finibus eu. Pellentesque venenatis est in lorem imperdiet aliquet. Sed vel dapibus ante. Phasellus finibus purus eu diam semper scelerisque. Sed semper tellus ut nisi eleifend, eu placerat orci blandit. Morbi eu tincidunt odio. Cras gravida at ligula nec interdum. Maecenas lacinia leo eu erat fermentum, rutrum faucibus arcu elementum. Sed a ultrices diam, sed euismod sapien. Sed aliquam volutpat suscipit. Nam ac lacus posuere, placerat mauris vitae, interdum lacus. Pellentesque pharetra velit pharetra, pellentesque felis luctus, tempus nunc. Vivamus pretium finibus lorem, ut semper ligula iaculis interdum. Duis vel molestie leo. Integer tincidunt, magna vel iaculis posuere, metus nisi tempor nulla, sit amet venenatis velit sapien in nunc. Aliquam sit amet ultrices erat, id tristique arcu. Curabitur fringilla quam ut felis viverra iaculis. Nulla luctus ornare ipsum quis bibendum. Fusce ac libero sed odio placerat feugiat.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
