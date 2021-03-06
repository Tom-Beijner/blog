<?php
  include_once "../config/config.php";

  // Database connection
  if (!strlen($db_host)) {
      echo "Database host is required";
  }
  if (!strlen($db_name)) {
      echo "Database name is required";
  }
  if (!strlen($db_user)) {
      echo "Database user is required";
  }

  try {
      $connect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
      $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
      $error = $e->getMessage();
      if ($environment === "development") {
          echo $error;
      }
      // Database connection failed
      elseif (strpos($error, "2002")) {
          echo "Database connection could not be made";
      }
      // Access to the database was denied
      elseif (strpos($error, "1045")) {
          echo "Databse access denied, is the credentials correct?";
      }
      // Unknown database
      if (strpos($error, "1049")) {
          echo "Database missing from the MySQL server, created one";
          $connect = new PDO("mysql:host=$db_host", $db_user, $db_pass);
          $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          // Create database with the provided name
          $connect -> query("create database $db_name");
          $connect -> query("use $db_name");
          // Create users table
          $connect -> query("CREATE TABLE users(
            id int(11) NOT NULL AUTO_INCREMENT, 
            name varchar(20) NOT NULL,
            username varchar(255) NOT NULL,
            password varchar(255) NOT NULL,
            createdAt timestamp DEFAULT CURRENT_TIMESTAMP,
            updatedAt timestamp NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
          )");
          $connect -> query("CREATE TABLE articles(
            id int(11) NOT NULL AUTO_INCREMENT,
            userId int(11), 
            title varchar(20) NOT NULL,
            summary varchar(255) NOT NULL,
            description text NOT NULL,
            image varchar(255) NOT NULL,
            createdAt timestamp DEFAULT CURRENT_TIMESTAMP,
            updatedAt timestamp NULL ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (userId) REFERENCES users (id) 
          )");
      }
  }

  include_once "utils.php";

  function page_title($name)
  {
      $name = $name. " - ";
      return $name;
  }

  session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= utf8_encode($base_url) ?>/assets/css/main.css" crossorigin="anonymous">

    <title><?php if (isset($TPL->PageTitle)) {
    echo page_title($TPL->PageTitle). utf8_encode($blog_name);
} ?></title>

    <?php if (isset($TPL->ContentHead)) {
    include $TPL->ContentHead;
} ?>
  </head>
  <body>
    <?php include_once "navbar.php" ?>

    <div class="container">
      <?php if (isset($TPL->ContentBody)) {
    include $TPL->ContentBody;
} ?>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>