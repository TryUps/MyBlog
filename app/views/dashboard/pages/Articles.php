<?php
  use MyB\Query as Query;

  $posts = Query::posts();
?>
    <section class="container" id="articles">
      <div class="article-search">
        <form action="">
          <input type="text" placeholder="Pesquisar postagens">
          <button><i class="fas fa-search"></i></button>
        </form>
      </div>
      <div class="article-sort" style="display: none;">
        <div>Showing 100 posts</div>
        <div class="sortby">
          <span>Sort by:</span>
          <div class="dropdown">
            <span class="active">Featured</span>
            <span>Latest</span>
            <span>Trending</span>
          </div>
        </div>
      </div>
      <div class="article-list">
        <?php
          foreach($posts as $post){
            $summary = strip_tags($post['summary']);
            echo<<<HTML
              <a class="article" href="/">
                <div class="article-title">
                  <picture>
                    <img src="https://www.w3schools.com/css/rock600x400.jpg" alt="">
                  </picture>
                  <h2>$post[title]</h2>
                </div>
                <div class="article-cat">
                  <div class="cat">Sem Categoria</div>
                </div>
                <div class="article-content">$summary</div>
                <div class="article-footer">
                  <span class="article-date">
                    <i class="far fa-calendar"></i>
                    <span>$post[date]</span>
                  </span>
                  <span class="article-author">
                    <img src="https://scontent.fsdu5-1.fna.fbcdn.net/v/t1.0-9/117602689_3348843672008346_4968872459592146163_n.jpg?_nc_cat=105&ccb=2&_nc_sid=09cbfe&_nc_ohc=BvLXn93wYhQAX91vSjR&_nc_ht=scontent.fsdu5-1.fna&oh=9e8154679387b4ebd2590aa549d5ab49&oe=5FDFCCEA" alt="">
                    <span>Arilson B.</span>
                  </span>
                </div>
              </a>
            HTML;
          }
        ?>
      
      </div>
    </section>
