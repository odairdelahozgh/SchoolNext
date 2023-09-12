<div class="w3-panel">
  <?= View::Encab($controller_name, $page_action, $breadcrumb).View::flash() ?>
</div>

<div class="w3-container">
  <?= OdaTags::buttonBars($buttons);?>
  <?= (new Seguimientos)::lnkPageSeguimientosGrupo()?>
  <div id="resultados"></div>
</div>

<?php
  echo Tag::js(src: 'dir_grupo/dg_index', cache: false);
?>  