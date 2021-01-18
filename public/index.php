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

<h1>Blog</h1>

<!-- <a href="/articles/<?= $article["id"] ?>">
  <div class="card mb-3" style="max-width: 540px;">
    <div class="row no-gutters">
      <div class="col-md-4">
        <img src="<?= utf8_encode($article["image"]) ?>" class="card-img" alt="<?= utf8_encode($article["name"]) ?>">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title"><?= utf8_encode($article["name"]) ?></h5>
          <p class="card-text"><?= utf8_encode($article["summary"]) ?></p>
          <p class="card-text"><small class="text-muted"><? if (!isset($article["updatedAt"])) echo time_elapsed_string(utf8_encode($article["createdAt"])) else echo time_elapsed_string(utf8_encode($article["updatedAt"])) ?></small></p>
        </div>
      </div>
    </div>
  </div>
</a> -->

<?php 
  try {
    $query = "SELECT * FROM articles";
    $articles = $connect -> query($query);
    ?>
    <div class="container">
      <div class="row">
        <?php foreach($articles as $article): ?>
          <div class="col-sm-4">
            <a href="/articles/<?= $article["id"] ?>">
              <div class="card mb-3">
                <img src="<?= utf8_encode($article["image"]) ?>" class="card-img" alt="<?= utf8_encode($article["name"]) ?>">
                <div class="card-body">
                  <h5 class="card-title"><?= utf8_encode($article["name"]) ?></h5>
                  <p class="card-text"><?= utf8_encode($article["summary"]) ?></p>
                  <p class="card-text"><small class="text-muted"><?php if (!isset($article["updatedAt"])) { echo "Posted ". time_elapsed_string(utf8_encode($article["createdAt"])); } else { echo "Updated ". time_elapsed_string(utf8_encode($article["updatedAt"])); } ?></small></p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php
  } catch(PDOException $error) {
    $error -> getMessage();
    echo $error;
  }
?>