<?php
  session_start();
  
  if (isset($_SESSION["username"])) {
      try {
          session_destroy();
      } catch (PDOException $error) {
          $error -> getMessage();
      }
  }

  // Fix so this is using the website base url
  header("Location: index.php/?redirect=true");
