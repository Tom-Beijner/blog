<?php
  require_once '../resources/pageTemplate.php';

  if (!isset($TPL)) {
      $TPL = new PageTemplate();
      $TPL->PageTitle = "Home";
      $TPL->ContentBody = __FILE__;
      require "../resources/layout.php";
      exit;
  }
?>

<!-- Dynamic page https://stackoverflow.com/a/7975282 -->

<?php
  try {
      $query = "SELECT * FROM articles";
      $articles = $connect -> query($query); ?>
    <div class="container">
      <div class="row">
        <?php foreach ($articles as $article): ?>
          <div class="col-sm-4">
            <a href="<?= utf8_encode($base_url) ?>/posts?id=<?= $article["id"] ?>">
              <div class="card mb-3">
                <img src="<?= utf8_encode($article["image"]) ?>" class="card-img" alt="<?= utf8_encode($article["name"]) ?>">
                <div class="card-body">
                  <h5 class="card-title"><?= utf8_encode($article["name"]) ?></h5>
                  <p class="card-text"><?= utf8_encode($article["summary"]) ?></p>
                  <p class="card-text"><small class="text-muted"><?php if (!isset($article["updatedAt"])) {
          echo "Posted ". time_elapsed_string(utf8_encode($article["createdAt"]));
      } else {
          echo "Updated ". time_elapsed_string(utf8_encode($article["updatedAt"]));
      } ?></small></p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php
  } catch (PDOException $error) {
      if ($environment === "development") {
          echo $error -> getMessage();
      }
  }
?>