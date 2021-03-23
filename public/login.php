<?php
  require_once '../resources/pageTemplate.php';

  if (!isset($TPL)) {
      $TPL = new PageTemplate();
      $TPL->PageTitle = "Login";
      $TPL->ContentBody = __FILE__;
      require "../resources/layout.php";
      exit;
  }
?>

<h1 class="text-center">Login</h1>
<?php
  if (isset($_SESSION["userId"])) {
      header("Location: index?loggedin=true");
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
      if (isset($_GET['success'])) {
          ?>
        <div class="alert alert-success" role="alert">
          Your account has been created, try to login
        </div>
      <?php
      }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      try {
          $username = pure_input($_POST["username"]);
          $passform_form = pure_input($_POST["password"]);
          $password = hash("sha512", $passform_form);

          // $connect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
          // $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $query = "SELECT * FROM users WHERE username='$username'";

          $user = $connect -> query($query) -> fetch();

          if (!empty($user) && password_verify($password, $user["password"])) {
              session_regenerate_id();
              $_SESSION["userId"] = $user["id"];
              $_SESSION["username"] = $_POST["username"];
              header("Location: index?success=true");
          } else {
              ?>
          <div class="alert alert-danger" role="alert">
            Invalid Credentials
          </div>
        <?php
          }
      } catch (PDOException $error) {
          echo $error -> getMessage();
      }
  }
?>
<form action='login' method="POST" autocomplete="off">
  <div class="form-group">
    <label class="control-label" for="username">Username</label>
    <input type="text" value="<?php if (!empty($_POST)) {
    echo $_POST["username"];
} ?>" class="form-control" id="username" name="username" />
  </div>
  <div class="form-group">
    <label class="control-label" for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" />
  </div>
  <input type="submit" class="btn btn-primary" value="Login" name="submit" /> 
  <a href="register">Need an account? Register here.</a>
</form>
