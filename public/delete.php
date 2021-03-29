<?php
  require_once '../resources/pageTemplate.php';

  if (!isset($TPL)) {
      $TPL = new PageTemplate();
      $TPL->PageTitle = "Edit Article";
      $TPL->ContentBody = __FILE__;
      require "../resources/layout.php";
      exit;
  }
?>

<?php
$postId = $_GET['id'];
$query = "SELECT * FROM `articles` JOIN users ON users.id = articles.userId WHERE articles.id = :id";
$q = $connect -> prepare($query);
$q -> bindValue(':id', $postId);
$q -> execute();
$article = $q -> fetch();

  if (!$article) {
      require "./404.php";
  } elseif (!isset($_SESSION["username"]) || $article["userId"] !== $_SESSION["userId"]) {
      require "./401.php";
  } else {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          try {
              $errors = array();
              $confirm = !empty($_POST["confirm"]) ? pure_input($_POST["confirm"]) : null;

              if (empty($confirm)) {
                  $errors["confirm"] = "You must confirm the deletion";
              }
              
              if (empty($errors)) {
                  $connect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                  $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  $query = "DELETE FROM articles WHERE articles.id = :id AND articles.userId = :userId";
                  $q = $connect -> prepare($query);
                  $q -> bindValue(':id', $postId);
                  $q -> bindValue(':userId', $_SESSION['userId']);
                  $execute = $q -> execute();

                  if ($execute) {
              ?>
                <div class="alert alert-success" role="alert">
                  The article has been deleted <a href='<?= utf8_encode($base_url) ?>/'>click here</a> to go to homepage
                </div>
              <?php
                  } else {
                      echo "Error". die(mysqli_error($connect -> query($query)));
                  }
              } else {
                  ?>
          <div class="alert alert-danger" role="alert">
            <b>Fix these error<?php if (sizeof($errors) !== 1) {
                      echo "s";
                  } ?>:</b>
            <br>
            <?php
              foreach ($errors as $error) {
                  echo $error. "<br>";
              } ?>
          </div>
        <?php
              }
          } catch (PDOException $error) {
              echo $error -> getMessage();
          }
      } ?>
<h1 class="text-center">Delete Article - <?= $article["title"] ?></h1>
  <form class="text-center" action='delete?id=<?= $postId ?>' method="POST" autocomplete="off">
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input <?php if (isset($errors["confrm"])) {
          echo "is-invalid";
      } ?>" id="confirm" name="confirm" />
      <label class="form-check-label" for="confirm">Are you sure you want to delete this article?</label>
      <?php if (isset($errors["confirm"])) { ?>
        <div id="confirmFeedback" class="invalid-feedback">
          <?php echo $errors["confirm"]; ?>
        </div>
      <?php } ?>
    </div>
    <input type="submit" class="btn btn-danger" value="Delete Article" name="submit" />
  </form>
  <?php
  } ?>