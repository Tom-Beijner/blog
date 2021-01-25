<?php
require_once '../resources/pageTemplate.php';

if (!isset($TPL))
{
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Post";
    $TPL->ContentBody = __FILE__;
    require "../resources/layout.php";
    exit;
}
?>

<?php
try
{
    $query = "SELECT * FROM `articles` JOIN users ON users.id = articles.userId WHERE articles.id = :id";
    $q = $connect -> prepare($query);
    $q -> bindValue(':id', $_GET['id']);
    $q -> execute();
    $article = $q -> fetch(); 

    if (!$article) {
      require "./404.php";
      exit;
    }
?>
    <section class="banner-section" style="background-image: url(<?= $article["image"] ?>)">
</section>
      <section class="article-content-section">
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 article-title-block">
                    
                      <h1 class="text-center"><?= $article["name"] ?></h1>
                      <ul class="list-inline text-center">
                          <li>Author | <?= $article["username"] ?></li>
                          <li>Date | <?php if (!isset($article["updatedAt"])) { echo "Posted ". time_elapsed_string(utf8_encode($article["createdAt"])); } else { echo "Updated ". time_elapsed_string(utf8_encode($article["updatedAt"])); } ?></li>
                      </ul>
                  </div>
                  <div class="col">
                    <?= $article["description"] ?>
                  </div>   
          </div> 
      </section>
    <?php
}
catch(PDOException $error)
{
    $error->getMessage();
    echo $error;
}
?>
