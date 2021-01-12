<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">Login</h1>
      <?php
        include "utils.php";

        session_start();

        if (isset($_SESSION["username"])) header("Location: index.php?login=true");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          try {
            $username = pure_input($_POST["username"]);
            $passform_form = pure_input($_POST["password"]);
            $password = hash("sha512", $passform_form);

            $connect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM users WHERE username='$username'";

            $user = $connect -> query($query) -> fetch();

            if(!empty($user) && password_verify($password, $user["password"])) {
              session_regenerate_id();
              $_SESSION["username"] = $_POST["username"];
              header("Location: index.php?login=true");
            } else {
              ?>
                <div class="alert alert-danger" role="alert">
                  Invalid Credentials
                </div>
              <?php
            }

          } catch(PDOException $error) {
            $error -> getMessage();
          }
        }
      ?>
      <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="POST">
        <div class="form-group">
          <label class="control-label" for="username">Username</label>
          <input type="text" value="<?php if (!empty($_POST)) echo $_POST["username"]; ?>" class="form-control" id="username" name="username" />
        </div>
        <div class="form-group">
          <label class="control-label" for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" />
        </div>
        <input type="submit" class="btn btn-info" value="Login" name="submit" /> 
        <a href="register.php">Need an account? Register here.</a>
      </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>