<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    <a class="navbar-brand" href="<?= utf8_encode($base_url) ?>/"><?= utf8_encode($blog_name) ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="<?= utf8_encode($base_url) ?>/">Home</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= utf8_encode($base_url) ?>/articles">Articles</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= utf8_encode($base_url) ?>/authors">Authors</a>
        </li>
      </ul>
      <?php
        if (isset($_SESSION["username"])) {
            ?>
        <div class="user nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= utf8_encode($_SESSION["username"]) ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?= utf8_encode($base_url) ?>/create">Create Article</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?= utf8_encode($base_url) ?>/logout">Logout</a>
          </div>
        </div>
      <?php
        } else { ?>
        <a class="btn btn-outline-primary mr-sm-2" href="<?= utf8_encode($base_url) ?>/register" role="button">Register</a>
        <a class="btn btn-primary" href="<?= utf8_encode($base_url) ?>/login" role="button">Login</a>
      <?php } ?>
    </div>
  </div>
</nav>