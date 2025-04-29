<div class="container app-main">
	<div class="app-title mb-2">
		<h1>🏆 Ganhadores</h1>
		<div class="app-title-desc">confira os sortudos</div>
	</div>
	<?php
           $sql = "
           SELECT name AS product_name, draw_number, draw_winner, image_path, slug
           FROM product_list
           WHERE draw_number <> ''
            ";

	$products = $conn->query($sql);
	?>  
	<div class="app-content">
		<?php while ($row = $products->fetch_assoc()) { 
                       $product_name = $row['product_name'];
                       $draw_number = $row['draw_number'];
                       $draw_name = $row['draw_winner'];
                       $draw_number_arr = json_decode($draw_number);
                       $draw_winner_arr = json_decode($draw_name);
                       $draw_number = $draw_number_arr[0];
                       $draw_name = $draw_winner_arr[0];
                       $image_path = validate_image($row['image_path']);
			?>
                        <div class="ganhadorItem_ganhadorContainer__1Sbxm mb-2">
                           <div class="ganhadorItem_ganhadorFoto__324kH box-shadow-08">                              
                              <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
                                 <img alt="<?= $draw_name; ?> ganhador do prêmio <?= $product_name; ?>" src="<?php echo base_url ?>assets/img/avatar.jpg" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
                                 <noscript><img alt="<?= $draw_name; ?> ganhador do prêmio <?= $product_name; ?>" src="<?php echo base_url ?>assets/img/avatar.jpg" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" loading="lazy"/></noscript>
                              </div>
                           
                           </div>
                           <div class="undefined w-100">
                              <h3 class="ganhadorItem_ganhadorNome__2j_J-"><?= $draw_name; ?></h3>
                              <p class="ganhadorItem_ganhadorDescricao__Z4kO2">
                                 Ganhou <b><?= $product_name; ?></b> cota <!-- --><?= $draw_number; ?>
                              </p>
                           </div>
                           <div>
                              <div class="rounded-pill" style="width:40px;height:40px;position:relative;overflow:hidden">
                                 <a href="/sorteio/<?= $row['slug'] ?>">
                                 <div style="display:block;overflow:hidden;position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;margin:0">
                                    <img alt="<?= $product_name; ?>" src="<?= $image_path; ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%">
                                    <noscript><img alt="<?= $product_name; ?>" src="<?= $image_path; ?>" decoding="async" data-nimg="fill" style="position:absolute;top:0;left:0;bottom:0;right:0;box-sizing:border-box;padding:0;border:none;margin:auto;display:block;width:0;height:0;min-width:100%;max-width:100%;min-height:100%;max-height:100%" loading="lazy"/></noscript>
                                 </div>
                              </a>
                              </div>
                           </div>
                        </div>
		<?php } ?>

	</div>


	
</div>