<?php
  require_once '../resources/pageTemplate.php';

  if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "404";
    $TPL->ContentBody = __FILE__;
    require "../resources/layout.php";
    exit;
  }
?>

<style>
  .error {
      padding: 40px;
      text-align: center;
  }

  .error h1 {
      font-size: 125px;
      padding: 0;
      margin: 0;
      font-weight: 700;
  }

  .error h2 {
      margin: -30px 0 0 0;
      padding: 0px;
      font-size: 47px;
      letter-spacing: 12px;
  }
</style>

<div class="error">
  <h1>404</h1>
  <h2>error</h2>
  <p>Page not found</p>

  <a class="btn btn-primary" href="<?= utf8_encode($base_url) ?>/" role="button">Home</a>
</div>