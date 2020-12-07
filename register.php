<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Register</title>
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">Register</h1>
      <?php 
        include "dbconfig.php";
        include "utils.php";

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
              var_dump($password);
              echo "<br>";
              var_dump($hashed_password);

              $connect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
              $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $query = "INSERT INTO users (name, username, password) VALUES('$name', '$username', '$hashed_password')";

              if($connect -> query($query)) {
                header("Location: login.php?success=true");
              } else {
                echo "Error inserting data: " . $conn->error;
              }
            }
          } catch(PDOException $error) {
            $error -> getMessage();
          }
        }
      ?>
      <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="POST">
        <div class="form-group">
          <label class="control-label" for="name">Name</label>
          <input type="text" value="<?php if (!empty($_POST)) echo $_POST["name"]; ?>" class="form-control <?php if (isset($errors["name"])) echo "is-invalid"; ?>" id="name" name="name" />
          <?php if (isset($errors["name"])) { ?>
            <div id="nameFeedback" class="invalid-feedback">
              <?php echo $errors["name"]; ?>
            </div>
          <?php } ?>
        </div>
        <div class="form-group">
          <label class="control-label" for="username">Username</label>
          <input type="text" value="<?php if (!empty($_POST)) echo $_POST["username"]; ?>" class="form-control <?php if (isset($errors["username"])) echo "is-invalid"; ?>" id="username" name="username" />
          <?php if (isset($errors["username"])) { ?>
            <div id="usernameFeedback" class="invalid-feedback">
              <?php echo $errors["username"]; ?>
            </div>
          <?php } ?>
        </div>
        <div class="form-group">
          <label class="control-label" for="password">Password</label>
          <input type="password" class="form-control <?php if (isset($errors["password"])) echo "is-invalid"; ?>" id="password" name="password" />
          <?php if (isset($errors["password"])) { ?>
            <div id="passwordFeedback" class="invalid-feedback">
              <?php echo $errors["password"]; ?>
            </div>
          <?php } ?>
        </div>
        <input type="submit" class="btn btn-info" value="Register" name="submit" />
      </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>