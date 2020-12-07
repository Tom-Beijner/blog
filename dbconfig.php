<?php
  $db_host = "localhost";
  $db_name = "flightsdb";
  $db_user = "root";
  $db_pass = "15935742680";

  $connect = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
  $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
