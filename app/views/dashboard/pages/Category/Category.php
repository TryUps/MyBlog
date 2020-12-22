<section class="container">
  <h1 style="margin-top: 30px;">Tópicos</h1>
  <div class="search-cat">
    <form action="">
      <input type="search" name="" id="" placeholder="Procurar">
    </form>
    <button class="ico-btn" style="width: 200px;"><i class="fas fa-plus"></i><span>Adicionar Categoria</span></button>
  </div>
  <table class="category-list">
    <tr>
      <th style="min-width: 60px;max-width: 60px; width: 60px">#</th>
      <th style="max-width: 90px;">Category Name</th>
      <th style="min-width: 200px;">Description</th>
      <th>Postagens</th>
    </tr>
    <tbody style="overflow-y: scroll;max-height: 30px;">
      <?php
        $categories = MyB\Query::category();
        foreach($categories as $category){
          echo<<<HTML
            <tr>
              <td>$category[id]</td>
              <td>$category[name]</td>
              <td>$category[description]</td>
              <td>{number_not_encountered}</td>
            </tr>
          HTML;
        }
      ?>
    </tbody>
  </table>
</section>