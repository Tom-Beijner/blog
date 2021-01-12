<?php  
  function pure_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function page_title($name) {
    $name = $name. " - ";
    return $name;
  }
?>