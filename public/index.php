<?php
  require_once '../resources/pageTemplate.php';

  if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Home";
    $TPL->ContentBody = __FILE__;
    require "../resources/layout.php";
    exit;
  }
?>

<h1>Blog</h1>
<?php 
  session_start();

  if (isset($_SESSION["username"])) {
    echo $_SESSION["username"]; 
    ?>
      <a href="./logout.php">Logout</a>
    <?php 
  } else { 
    ?>
      <a href="./login.php">Login</a>
    <?php 
  } 

  try {
    $query = "SELECT * FROM articles";
    $bilar = $connect -> query($query);
    ?>
    <div class="container">
      <h1 class="text-center">Alla bilar</h1>
      <div style="float: left;">
        <a href="./uppdateraBil.html">Ändra</a>
        <br>
        <a href="./infogaBil.html">Lägga till</a>
      </div>
      <div style="float: right;">
        <?php echo $_SESSION["username"]; ?>
        <br>
        <a href="./logout.php">Logga ut</a>
      </div>
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th>Reg. Nr</th>
            <th>Märke</th>
            <th>Årsmodell</th>
            <th>Timpris</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($bilar as $bil): ?>
            <tr>
              <td><?= utf8_encode($bil["regnr"]) ?></td>
              <td><?= utf8_encode($bil["marke"]) ?></td>
              <td><?= utf8_encode($bil["arsmodell"]) ?></td>
              <td><?= utf8_encode($bil["timpris"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php
  } catch(PDOException $error) {
    $error -> getMessage();
    echo $error;
  }
?>