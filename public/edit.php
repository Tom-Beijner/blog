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
              $title = pure_input($_POST["title"]);
              $summary = pure_input($_POST["summary"]);
              $description = pure_input($_POST["description"]);
              $image = pure_input($_POST["image"]);

              if (empty($title)) {
                  $errors["title"] = "Title field can not be empty";
              }
              if (empty($summary)) {
                  $errors["summary"] = "Summary field can not be empty";
              }
              if (empty($description)) {
                  $errors["description"] = "Description field can not be empty";
              }
              if (empty($image)) {
                  $errors["image"] = "Image field can not be empty";
              }

              if (strlen($title) > 255) {
                  $errors["title"] = "Title too long, (Max 255 chars)";
              }
              if (strlen($summary) > 255) {
                  $errors["summary"] = "Summary too long, (Max 255 chars)";
              }
              if (strlen($description) > 5000) {
                  $errors["description"] = "Description too long, (Max 5000 chars)";
              }
              if (strlen($image) > 255) {
                  $errors["image"] = "Image URL too long, (Max 255 chars)";
              }

              if (empty($errors)) {
                  // $connect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                  // $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  $query = "UPDATE articles SET title='$title', summary='$summary', description='$description', image='$image' WHERE articles.id = :id AND articles.userId = :userId";
                  $q = $connect -> prepare($query);
                  $q -> bindValue(':id', $postId);
                  $q -> bindValue(':userId', $_SESSION['userId']);
                  $execute = $q -> execute();

                  if ($execute) {
                      ?>
                <div class="alert alert-success" role="alert">
                  The edits has been saved <a href='posts?id=<?= $postId ?>'>click here</a> to view it
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
<h1 class="text-center">Edit Article - <?= $article["title"] ?></h1>

  <form action='edit?id=<?= $postId ?>' method="POST" autocomplete="off">
    <div class="form-group">
      <label class="control-label" for="title">Title</label>
      <input type="text" value="<?php if (empty($_POST)) {
          echo $article["title"];
      } else {
          echo $_POST["title"];
      } ?>" class="form-control <?php if (isset($errors["title"])) {
          echo "is-invalid";
      } ?>" id="title" name="title" />
      <?php if (isset($errors["title"])) { ?>
        <div id="titleFeedback" class="invalid-feedback">
          <?php echo $errors["title"]; ?>
        </div>
      <?php } ?>
    </div>
    <div class="form-group">
      <label class="control-label" for="summary">Summary</label>
      <input type="text" value="<?php if (empty($_POST)) {
          echo $article["summary"];
      } else {
          echo $_POST["summary"];
      } ?>" class="form-control <?php if (isset($errors["summary"])) {
          echo "is-invalid";
      } ?>" id="summary" name="summary" />
      <?php if (isset($errors["summary"])) { ?>
        <div id="summaryFeedback" class="invalid-feedback">
          <?php echo $errors["summary"]; ?>
        </div>
      <?php } ?>
    </div>
    <div class="form-group">
      <label class="control-label" for="description">Description</label>
      <textarea type="text" class="form-control <?php if (isset($errors["description"])) {
          echo "is-invalid";
      } ?>" id="description" name="description" /><?php if (empty($_POST)) {
          echo $article["description"];
      } else {
          echo $_POST["description"];
      } ?></textarea>
      <?php if (isset($errors["description"])) { ?>
        <div id="descriptionFeedback" class="invalid-feedback">
          <?php echo $errors["description"]; ?>
        </div>
      <?php } ?>
    </div>
    <div class="form-group">
      <label class="control-label" for="image">Image URL</label>
      <input type="text" value="<?php if (empty($_POST)) {
          echo $article["image"];
      } else {
          echo $_POST["image"];
      } ?>" class="form-control <?php if (isset($errors["image"])) {
          echo "is-invalid";
      } ?>" id="image" name="image" />
      <?php if (isset($errors["image"])) { ?>
        <div id="imageFeedback" class="invalid-feedback">
          <?php echo $errors["image"]; ?>
        </div>
      <?php } ?>
    </div>
    <input type="submit" class="btn btn-primary" value="Save Article" name="submit" />
  </form>
  <?php
  } ?>