<form class="create-post" action="./articles/create" method="POST" enctype="multipart/form-data">
  <div class="content">
    <input type="text" name="post_title" id="post_title" placeholder="Seu titulo...">
    <div class="article_url">
      <i class="fas fa-external-link-alt"></i>
      <a class="url_link" id="url">https://my.blog/2020/11/<span class="permalink">unknow-post</span>.html</a>
    </div>
    <div class="article-tags" contenteditable="true">
      <div class="tag">Tag 1</div>
      <div class="tag tag-plus" contenteditable="false">+</div>
      <input type="hidden" name="post_tags" value="minha tag, Tagzona">
    </div>
    <myb-editor>
      <div class="myb-texteditor">
        <iframe class="editor-text" src="about:blank"></iframe>
      </div>
      <div class="myb-htmleditor">
        <textarea name="post_content" id="" cols="30" rows="10" class="editor-code"></textarea>
      </div>
      <editor-tab>
        <button data-action="undo" class="item"><i class="fas fa-undo"></i></button>
        <button data-action="redo" class="item"><i class="fas fa-redo"></i></button>
        <!--<button href="" class="item item-selector"><i class="fas fa-heading"></i><span>Title 1</span></button>-->
        <custom-selector mode="top" class="item item-selector">
          <item value="h1" default>Title 1</item>
          <item value="h1" default>Title 1</item>
          <item value="h1" default>Title 1</item>
          <item value="h1" default>Title 1</item>
          <item value="h1" default>Title 1</item>
          <item value="h1" default>Title 1</item>
        </custom-selector>
        <button data-action="bold" class="item"><i class="fas fa-bold"></i></button>
        <button data-action="italic" class="item"><i class="fas fa-italic"></i></button>
        <button data-action="underline" class="item"><i class="fas fa-underline"></i></button>
        <button data-action="justifyLeft" class="item"><i class="fas fa-align-left"></i></button>
        <button data-action="justifyCenter" class="item"><i class="fas fa-align-center"></i></button>
        <button data-action="justifyRight" class="item"><i class="fas fa-align-right"></i></button>
        <button data-action="justifyFull" class="item"><i class="fas fa-align-justify"></i></button>
        <custom-selector class="item item-selector" mode="top">
          <item value="arial"><i class="fas fa-font"></i> Helvetica</item>
          <item value="arial"><i class="fas fa-font"></i> Arial</item>
          <item value="arial"><i class="fas fa-font"></i> Sans Serif</item>
        </custom-selector>
        <button href="" class="item"><i class="fas fa-link"></i></a>
        <button data-action="insertUnorderedList" class="item"><i class="fas fa-list"></i></button>
        <button data-action="insertOrderedList" class="item"><i class="fas fa-list-ol"></i></button>
        <div class="divider"></div>
        <button href="" class="item"><i class="fas fa-code"></i></button>
      </editor-tab>
    </myb-editor>
  </div>
  <div class="sidebar">
    <div class="side-box publish" id="publish">
      <figure class="thumbnail">
        <picture class="thumbnail">
          <img src="https://image.tmdb.org/t/p/w342/dRV58n6krTWxVVLrEX8FDGYTPU5.jpg" alt="" class="cover" />
          <button class="cover-btn" type="button">Alterar capa</button>
        </picture>
        <h1 class="pic-title">Publish</h1>
      </figure>
      <div class="box-content">
        <div class="pub-option">
          <label><i class="fas fa-eye-slash"></i>Visibilidade</label>
          <span>Publico</span>
        </div>
        <div class="pub-option">
          <label><i class="fas fa-unlock-alt"></i>Protected</label>
          <span>Password</span>
        </div>
        <div class="pub-option">
          <label><i class="far fa-calendar"></i>Publicar em</label>
          <span>22 de dezembro de 2020 ás 00:15</span>
        </div>
      </div>
    </div>
    <button class="side-button ico-btn" type="submit">
      <i class="fas fa-cog"></i>
      <span>Publicar</span>
    </button>
    <a class="side-button pub-btn" href="#">
      <i class="fas fa-cog"></i>
      <span>Avançado</span>
    </a>
    <div class="side-box cat-box">
      <input type="search" class="box-title" name="" id="" placeholder="Categorias...">
      <div class="box-content cat-results">
        <ul>
          <li>Categoria 1</li>
          <li>Categoria 2</li>
          <li>Categoria 3</li>
          <li>Categoria 4</li>
          <li>Categoria 5</li>
        </ul>
      </div>
    </div>
    <div class="side-grid">
      <a href="" class="box">
        <i class="fas fa-images"></i>
        <span>Upload photos</span>
      </a>
      <a href="" class="box">
        <i class="fas fa-film"></i>
        <span>Upload videos</span>
      </a>
      <a href="" class="box">
        <i class="fas fa-cog"></i>
        <span>Avançado</span>
      </a>
      <a href="" class="box">
        <i class="fas fa-cog"></i>
        <span>Avançado</span>
      </a>
    </div>
  </section>
</form>
<script src="./assets/js/myb.editor.js"></script>