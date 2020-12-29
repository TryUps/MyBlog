<?php
  use MyB\CustomRouter as Router;

  require_once __DIR__ . '/routes.php';

  ob_start();
  Router::Router($route);
  $router = ob_get_contents();
  ob_end_clean();

  require_once __DIR__ . '/layout/header.php';
  require_once __DIR__ . '/layout/sidebar.php';

  if(defined('title')){
    $title = __(title);
  }else{
    $title = '';
  }
  echo<<<HTML
    <header class="top-header">
      <div class="heading">
        <h1>{$title}</h1>
      </div>
      <div class="primary-header">
        <form action="" method="get">
          <input type="text" placeholder="Pesquisar no MyBlog...">
          <button><i class="fas fa-search"></i></button>
        </form>
      </div>
    </header>
    <main>
      {$router}
    </main>
  HTML;

  require_once __DIR__ . '/layout/footer.php';
?>