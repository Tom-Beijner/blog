<?php
  require_once '../resources/pageTemplate.php';

  if (!isset($TPL)) {
      $TPL = new PageTemplate();
      $TPL->PageTitle = "Register";
      $TPL->ContentBody = __FILE__;
      require "../resources/layout.php";
      exit;
  }
?>

<h1 class="text-center">Register</h1>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      try {
          $errors = array();
          $name = pure_input($_POST["name"]);
          $username = pure_input($_POST["username"]);
          $form_password = pure_input($_POST["password"]);
          $password = hash("sha512", $form_password);
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          if (empty($name)) {
              $errors["name"] = "Name field can not be empty";
          }
          if (empty($username)) {
              $errors["username"] = "Username field can not be empty";
          }
          if (empty($form_password)) {
              $errors["password"] = "Password field can not be empty";
          }

          if (strlen($name) > 255) {
              $errors["name"] = "Name too long, (Max 255 chars)";
          }
          if (strlen($username) > 255) {
              $errors["username"] = "Username too long, (Max 255 chars)";
          }
          if (strlen($form_password) > 255) {
              $errors["password"] = "Password too long, (Max 255 chars)";
          }

          if (empty($errors)) {
              $connect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
              $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $query = "INSERT INTO users (name, username, password) VALUES('$name', '$username', '$hashed_password')";

              if ($connect -> query($query)) {
                  header("Location: login?success=true");
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
          $error -> getMessage();
      }
  }
?>
<form action='register' method="POST" autocomplete="off">
  <div class="form-group">
    <label class="control-label" for="name">Name</label>
    <input type="text" value="<?php if (!empty($_POST)) {
    echo $_POST["name"];
} ?>" class="form-control <?php if (isset($errors["name"])) {
    echo "is-invalid";
} ?>" id="name" name="name" />
    <?php if (isset($errors["name"])) { ?>
      <div id="nameFeedback" class="invalid-feedback">
        <?php echo $errors["name"]; ?>
      </div>
    <?php } ?>
  </div>
  <div class="form-group">
    <label class="control-label" for="username">Username</label>
    <input type="text" value="<?php if (!empty($_POST)) {
    echo $_POST["username"];
} ?>" class="form-control <?php if (isset($errors["username"])) {
    echo "is-invalid";
} ?>" id="username" name="username" />
    <?php if (isset($errors["username"])) { ?>
      <div id="usernameFeedback" class="invalid-feedback">
        <?php echo $errors["username"]; ?>
      </div>
    <?php } ?>
  </div>
  <div class="form-group">
    <label class="control-label" for="password">Password</label>
    <input type="password" class="form-control <?php if (isset($errors["password"])) {
    echo "is-invalid";
} ?>" id="password" name="password" />
    <?php if (isset($errors["password"])) { ?>
      <div id="passwordFeedback" class="invalid-feedback">
        <?php echo $errors["password"]; ?>
      </div>
    <?php } ?>
  </div>
  <input type="submit" class="btn btn-primary" value="Register" name="submit" />
  <a href="login">Already have an account? Login here.</a>
</form>
