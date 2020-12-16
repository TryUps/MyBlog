<section class="create-post">
  <div class="content">
    <input type="text" name="post-title" id="" placeholder="Seu titulo...">
    <div class="article-url">
      <i class="fas fa-external-link-alt"></i>
      <div class="url-link">https://my.blog/2020/11/hello-world-welcome-to-myblog.html</div>
    </div>
    <div class="article-tags" contenteditable="true">
      <div class="tag">Tag 1</div>
      <div class="tag tag-plus" contenteditable="false">+</div>
    </div>
    <myb-editor>
      <div class="myb-texteditor">
        <iframe class="editor-text" src="about:blank"></iframe>
      </div>
      <div class="myb-htmleditor">
        <textarea name="" id="" cols="30" rows="10" class="editor-code"></textarea>
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
          <item value="arial"><i class="fas fa-font"></i> Arial</item>
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
    <picture class="side-box cover">
      <img src="https://image.tmdb.org/t/p/w342/dRV58n6krTWxVVLrEX8FDGYTPU5.jpg" alt="" class="cover">
      <button class="cover-btn">Alterar capa</button>
    </picture>
    <a class="side-button" href="#">
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
</section>
<script src="./assets/js/myb.editor.js"></script>