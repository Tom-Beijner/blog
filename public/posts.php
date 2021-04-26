<?php
require_once '../resources/pageTemplate.php';

if (!isset($TPL)) {
    $TPL = new PageTemplate();
    $TPL->PageTitle = "Post";
    $TPL->ContentBody = __FILE__;
    require "../resources/layout.php";
    exit;
}
?>

<?php
try {
    $query = "SELECT * FROM `articles` JOIN users ON users.id = articles.userId WHERE articles.id = :id";
    $q = $connect -> prepare($query);
    $q -> bindValue(':id', $_GET['id']);
    $q -> execute();
    $article = $q -> fetch();

    if (!$article) {
        require "./404.php";
    } else { ?>
    <section class="banner-section" style="background-image: url(<?= $article["image"] ?>)">
</section>
      <section class="article-content-section">
              <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12 article-title-block">
                    
                      <h1 class="text-center"><?= $article["title"] ?></h1>
                      <ul class="list-inline text-center">
                          <li>Author | <?= $article["username"] ?></li>
                          <li>Date | <?php
        echo "Posted ". time_elapsed_string(utf8_encode($article["createdAt"]));
     if ($article["updatedAt"]) {
         echo "Updated ". time_elapsed_string(utf8_encode($article["updatedAt"]));
     } ?></li>
     <?php if (isset($_SESSION["userId"]) && $_SESSION["userId"] == $article["userId"]) { ?><li>
     <a class="btn btn-primary" role="button" href="<?= utf8_encode($base_url) ?>/edit?id=<?= $_GET['id'] ?>">Edit</a>
     <a class="btn btn-danger" role="button" href="<?= utf8_encode($base_url) ?>/delete?id=<?= $_GET['id'] ?>">Delete</a>
     </li><?php } ?>
                      </ul>
                  </div>
                  <div class="col">
                    <?= $article["description"] ?>
                  </div>   
          </div> 
      </section>
    <?php }
} catch (PDOException $error) {
    $error->getMessage();
    echo $error;
}
?>
