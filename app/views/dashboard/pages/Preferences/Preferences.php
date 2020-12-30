<?php
  use MyB\CustomRouter as Router;
  $page = '/'.implode('/', $req['params']['page']);
  Router::Clear();
  require_once __DIR__ . '/routes.php';

  ob_start();
  Router::Router($page);
  $router = ob_get_contents();
  ob_end_clean();
  echo<<<HTML
    <nav class="custom-nav">
      <ul>
        <li><a href="http://" class="active">Configurações Gerais</a></li>
        <li><a href="http://">Escrita e Leitura</a></li>
        <li><a href="http://">Permalinks</a></li>
        <li><a href="http://">Segurança e Privacidade</a></li>
        <li><a href="http://">Atualizações</a></li>
        <li><a href="http://">Sobre o MyBlog</a></li>
      </ul>
    </nav>
    <div class="preferences">
      {$router}
    </div>
  HTML;

?>
<form action="./preferences" method="POST">
</form>