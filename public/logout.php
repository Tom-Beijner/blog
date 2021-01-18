<?php
  session_start();
  
  if (isset($_SESSION["username"])) {
    try {
        session_destroy();
    } catch(PDOException $error) {
      $error -> getMessage();
    }
  } 

  header("Location: index.php?redirect=true");
?>