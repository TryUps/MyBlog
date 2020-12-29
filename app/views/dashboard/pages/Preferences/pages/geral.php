<div class="preference-divider">
  <h2 class="pref-title">Configuração Geral</h2>
  <div class="pref">
    <input type="text" name="title" id="title" placeholder="Name" value="<?= MyB\Preferences::{'blog_name'}(); ?>">
    <label for="title">Titulo do site</label>
  </div>
  <div class="pref">
    <input type="text" name="description" id="description" placeholder="Description" value="<?= MyB\Preferences::{'blog_desc'}(); ?>">
    <label for="description">Descrição</label>
  </div>
  <div class="pref">
    <input type="email" name="email" id="email" placeholder="Ex: admin@email.domain" value="<?= MyB\Preferences::{'admin_email'}(); ?>">
    <label for="email">Email Administrativo</label>
  </div>
  <div class="pref">
    <label for="language">Idioma do Site</label>
    <custom-selector class="customselector">
      <item value="pt-BR" default>Português (Brasil)</item>
      <item value="en-US">Inglês (EUA)</item>
      <item value="en-US">Inglês (EUA)</item>
      <item value="en-US">Inglês (EUA)</item>
      <item value="en-US">Inglês (EUA)</item>
      <item value="en-US">Inglês (EUA)</item>
      <item value="en-US">Inglês (EUA)</item>
      <item value="en-US">Inglês (EUA)</item>
    </custom-selector>
  </div>
</div>
<div class="preference-divider">
  <h2 class="pref-title">Data e Hora</h2>
  <div class="pref">
    <label for="language">Fuso Horário</label>
    <custom-selector class="customselector">
      <item value="en-US" disabled>Africa</item>
      <item value="en-US" disabled>America</item>
      <item value="en-US" disabled>Asia</item>
      <item value="en-US" disabled>America</item>
      <item value="en-US" disabled>Europa</item>
    </custom-selector>
  </div>
  <div class="pref">
    <input type="text" name="" id="" placeholder="Ex: d/m/Y">
    <label for="">Formato de Data</label>
  </div>
  <div class="pref">
    <input type="text" name="" id="" placeholder="Ex: H:i:s">
    <label for="">Formato do Horário</label>
  </div>
</div>