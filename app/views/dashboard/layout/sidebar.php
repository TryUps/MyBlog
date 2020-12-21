
<aside class="sidebar">
    <div class="nav-bar">
      <div class="logo">
        <h1>MyB</h1>
        <img src="" alt="">
      </div>
      <nav>
        <ul>
          <li><a href="./" class="active"><i class="fas fa-home"></i></a></li>
          <li><a href="./articles"><i class="far fa-newspaper"></i></a></li>
          <li><a href="/media"><i class="fas fa-photo-video"></i></a></li>
          <li><a href="/comments"><i class="fas fa-comments"></i></a></li>
          <li><a href="/users"><i class="fas fa-users"></i></a></li>
          <li><a href="./preferences"><i class="fas fa-cog"></i></a></li>
        </ul>
        <ul>
          <li><a href="http://"><i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
      </nav>
    </div>
    <?php
      if(defined("sidebar") && sidebar === false){
        
      }else{
        echo<<<HTML
          <div class="nav-container">
            <header>
              <h1>Dashboard</h1>
            </header>
            <div class="container">
              <div class="container-btns content">
                <ul>
                  <li><a href="">Meus Artigos</a></li>
                  <li><a href="">Meu Perfil</a></li>
                  <li><a href="">Estatisticas</a></li>
                  <li><a href="">Novo</a></li>
                </ul>
              </div>
                <div class="latest-articles content">
                <div class="content-title">
                  <h3>Ultimos artigos</h3>
                </div>
                <div class="article-list list">
                  <a class="article" href="/">
                    <h5 class="article-title">Olá Mundo...</h5>
                    <span class="article-content">Sejam bem vindos ao novo MyBlog %version%</span>
                  </a>
                  <a class="article" href="/">
                    <h5 class="article-title">Olá Mundo...</h5>
                    <span class="article-content">Sejam bem vindos ao novo MyBlog %version%</span>
                  </a>
                  <a class="article" href="/">
                    <h5 class="article-title">Olá Mundo...</h5>
                    <span class="article-content">Sejam bem vindos ao novo MyBlog %version%</span>
                  </a>
                </div>
              </div>
              <div class="last-content content">
                <a class="ico-btn" href="./articles/create">
                  <i class="fas fa-pen"></i>
                  <span>Escrever novo artigo</span>
                </a>
              </div>
            </div>
          </div>
        HTML;
      }
    ?>
    </aside>