<div class="container app-main">
   <div class="app-title">
      <h1>⚡ Prêmios</h1>
      <div class="app-title-desc">Escolha sua sorte</div>
   </div>
   <div class="app-card card mb-2">
      <div class="app-body d-flex align-items-center justify-content-center py-2">
         <p class="text-muted font-xs text-uppercase mb-0 me-2">Listar</p>
         <div class="btn-group btn-group-sm" role="group" aria-label="Filtros de listagem">
            <button type="button" class="btn btn-light"><a href="/sorteios">Ativos</a></button>
            <button type="button" class="btn btn-light"><a href="/concluidos">Concluídos</a></button>
            <button type="button" class="btn btn-info text-white"><a href="/em-breve">Em breve</a></button>
         </div>
      </div>
   </div>
   <div class="sorteios-listagem">
      <?php 
      $qry = $conn->query("SELECT * FROM `product_list` WHERE status = '2' ORDER BY id DESC");
      if($qry->num_rows > 0){
         while($row = $qry->fetch_assoc()):
            ?>
            <div class="mb-2">
              <a href="/sorteio/<?= $row['slug'] ?>"> 
                 <div class="SorteioTpl_sorteioTpl__2s2Wu   pointer">
                  <div class="SorteioTpl_imagemContainer__2-pl4 col-auto ">
                     <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
                        <img alt="1.500,00 com apenas 0,03 centavos" src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
                        <noscript><img alt="1.500,00 com apenas 0,03 centavos" src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" class="SorteioTpl_imagem__2GXxI" loading="lazy"/></noscript>
                     </div>
                  </div>
                  <div class="SorteioTpl_info__t1BZr">
                     <h1 class="SorteioTpl_title__3RLtu"><?= $row['name'] ?></h1>
                     <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px"><?php echo isset($row['subtitle']) ? $row['subtitle'] : ''; ?></p>
                     <?php if($row['status_display'] == 1){ ?>
                        <span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>
                     <?php } ?>
                     <?php if($row['status_display'] == 2){ ?>
                        <span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>
                     <?php } ?>
                     <?php if($row['status_display'] == 3){ ?>
                        <span class="badge bg-dark font-xsss mobile badge-status-3">Aguarde o sorteio!</span>
                     <?php } ?>
                     <?php if($row['status_display'] == 4){ ?>
                        <span class="badge bg-dark font-xsss">Concluído</span>
                     <?php } ?>
                     <?php if($row['status_display'] == 5){ ?>
                        <span class="badge bg-dark font-xsss">Em breve!</span>
                     <?php } ?>
                  </div>
               </div>
            </a>
         </div>
      <?php endwhile; ?>
   <?php }else{ ?>
      <div class="alert alert-info"><i class="bi bi-info-circle"></i> Nenhuma ação encontrada</div>
   <?php } ?>

</div>
<div class="row">
   <div class="col"></div>
   <div class="col"></div>
</div>
</div>