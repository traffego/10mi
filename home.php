<?php
// public/home.php

include_once 'inc/meta.php';

$first_name = 'NomeDoCliente';
$last_name = 'SobrenomeDoCliente';
$phone_number = '5511999999999'; // Exemplo de telefone

$event_name = 'PageView';
$event_id = uniqid();
$event_time = time();
$user_data = [
    'fn' => hash('sha256', strtolower($first_name)),
    'ln' => hash('sha256', strtolower($last_name)),
    'ph' => hash('sha256', preg_replace('/\D/', '', $phone_number)),
];
$custom_data = [
    // Dados customizados que você queira enviar
];

sendConversionEvent($event_name, $event_id, $event_time, $user_data, $custom_data);

?>
<style>
    .SorteioTpl_title__3RLtu a {
        text-transform:uppercase !important;
        font-size:18px;
        font-weight: 700;
    }
    
    .SorteioTpl_imagem__2GXxI {
        max-width: 100% !important;
        height: auto !important;
        object-fit: contain !important;
    }
    
    .SorteioTpl_imagemContainer__2-pl4 {
        width: 100% !important;
        max-width: 100% !important;
        position: relative !important;
        overflow: hidden !important;
    }
    
    /* Correção específica para iPhone e dispositivos móveis */
    @media screen and (max-width: 767px) {
        .SorteioTpl_imagem__2GXxI {
            width: 100% !important;
            max-height: 250px !important;
        }
        
        .carousel-item {
            width: 100% !important;
            text-align: center !important;
        }
        
        .SorteioTpl_imagemContainer__2-pl4 {
            width: 100% !important;
            padding-right: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Correção para o contenedor da imagem */
        [style*="display:block;overflow:hidden;position:absolute"] {
            position: relative !important;
            height: 200px !important;
        }
    }
    
    
    .SorteioTpl_info__t1BZr {
        width:100%;
    }
    
    .badgeVerde {
width: fit-content;
    padding: 3px 9px 3px 9px;
    border-radius: 4px;
    font-size: 1em;
    color: #000;
    margin-right:7px;
    
    float: left;
    background-color: #0f2 !important;
    }
    
    
    
    .preco {
    background: #000;
width: fit-content;
    padding: 3px 9px 3px 9px;
    border-radius: 4px;
    font-size: 1em;
    color: #fff;
    float: left;
}

/* Correção para o contenedor da imagem */
[style*="display:block;overflow:hidden;position:absolute"] {
    position: relative !important;
    height: 200px !important;
}

/* Novo contêiner de imagem */
.produto-img-container {
    width: 100%;
    height: 200px;
    overflow: hidden;
    position: relative;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.produto-img-container img {
    object-fit: cover;
    height: 100%;
    width: 100%;
}
</style>
         <div class="container app-main">
            <div class="row">
               <div class="col-12">
                  <div class="app-title">
                     <h1>⚡ Prêmios</h1>
                     <div class="app-title-desc">Escolha sua sorte</div>
                  </div>
               </div>
               
               
               <?php 
               $qry = $conn->query("SELECT * FROM `product_list` WHERE status = '1' AND featured_draw = '1' ORDER BY RAND() LIMIT 1");
               while($row = $qry->fetch_assoc()):
               ?>
               
                  <div class="col-12 mb-2">
                      
                     <div class="SorteioTpl_sorteioTpl__2s2Wu SorteioTpl_destaque__3vnWR pointer">
                         
                        <a href="/sorteio/<?= $row['slug'] ?>">
                           <div class="SorteioTpl_imagemContainer__2-pl4">
                              <div id="carouselSorteio640d0a84b1fef407920230311" class="carousel slide carousel-dark carousel-fade" data-bs-ride="carousel">
                                 <div class="carousel-inner">
                                    <div class="carousel-item active">
                                       <img alt="<?= $row['name'] ?>" src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI d-block w-100">
                                       <noscript><img alt="<?= $row['name'] ?>" src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI d-block w-100" loading="lazy"/></noscript>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </a>
                        
                        <div class="SorteioTpl_info__t1BZr">
                            
                           <h1 class="SorteioTpl_title__3RLtu"><a href="/sorteio/<?= $row['slug'] ?>"><?= $row['name'] ?></a></h1>
                           
                           
                           
                           <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom:1px"><?php echo isset($row['subtitle']) ? $row['subtitle'] : ''; ?></p>
                           
                           <?php if($row['status_display'] == 1){ ?>
                              <!--<span class="badge bg-success blink bg-opacity-75 font-xsss">Adquira já!</span>-->
                              <span class="badgeVerde">Adquira já!</span>
                           <?php } ?>
                           <?php if($row['status_display'] == 2){ ?>
                              <!--<span class="badge bg-dark blink font-xsss mobile badge-status-1">Corre que está acabando!</span>-->
                              <span class="badge bg-dark font-xsss mobile badge-status-1">Corre que está acabando!</span>
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
                           
                           <div class="preco">R$ <?=$row['price'];?></div>
                        
                        </div>
                        
                        
                        
                        
                        
                     </div>
                  </div>
               <?php endwhile; ?>

               <?php 
               $qry = $conn->query("SELECT * FROM `product_list` WHERE featured_draw = '0' AND private_draw = '0' ORDER BY id DESC");
               if($qry->num_rows > 0){
                  while($row = $qry->fetch_assoc()):
                     ?>
                     <div class="col-12 mb-2">
                      <a href="/sorteio/<?= $row['slug'] ?>"> 
                         <div class="SorteioTpl_sorteioTpl__2s2Wu pointer">
                           <div class="SorteioTpl_imagemContainer__2-pl4">
                              <div class="produto-img-container">
                                 <img alt="<?= $row['name'] ?>" src="<?= validate_image($row['image_path']) ?>" decoding="async" class="SorteioTpl_imagem__2GXxI w-100">
                                 <noscript><img alt="<?= $row['name'] ?>" src="<?= validate_image($row['image_path']) ?>" decoding="async" class="SorteioTpl_imagem__2GXxI w-100" loading="lazy"/></noscript>
                              </div>
                           </div>
                           <div class="SorteioTpl_info__t1BZr">
                              <h1 class="SorteioTpl_title__3RLtu"><div class="preco"><?=$row['price'];?></div><?= $row['name'] ?></h1>
                              
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
               <!--<div class="alert alert-info"><i class="bi bi-info-circle"></i> Nenhuma ação encontrada</div>-->
            <?php } ?>

            <div class="col-12">
               <div class="app-helpers mb-2">
                  <div class="row">
                     <div class="col col-contato-display">
                        <div class="d-flex align-items-center w-100 justify-content-center font-xs bg-white bg-opacity-25 box-shadow-08 p-2 rounded-10">
                           <div class="icone font-lg bg-dark rounded p-2 me-2 bg-opacity-10">🤷</div>
                           <a href="/contato">
                              <div class="txt">
                                 <h3 class="mb-0 font-md">Dúvidas</h3>
                                 <p class="mb-0 font-xs text-muted">Fale conosco</p>
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php
           $sql = "
           SELECT name AS product_name, draw_number, draw_winner, image_path, slug
           FROM product_list
           WHERE draw_number <> ''
            ";

            $products = $conn->query($sql);
            if($products->num_rows > 0){
            ?>
            <div class="app-ganhadores mb-2 ">
               <div class="col-12">
                  <div class="app-title">
                     <h1>🎉 Ganhadores</h1>
                     <div class="app-title-desc">sortudos</div>
                  </div>
               </div>  

               <div class="col-12">
                  <div class="row">
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
                       <div class="col-12">
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
                     </div>
                  <?php } ?>
               </div>
            </div>
         </div>
      <?php } ?>
         <!-- Perguntas frequentes -->
         <div class="app-perguntas">
            <div class="app-title">
               <h1>🤷 Perguntas frequentes</h1>
            </div>
            <div id="perguntas-box">
               <div class="mb-2">
                  <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
                     <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-63c30d4b6bd40368220230114" aria-expanded="false" aria-controls="pergunta-63c30d4b6bd40368220230114"><i class="bi bi-arrow-right me-2 text-cor-primaria"></i> <span>Como acessar minhas compras?</span></div>
                     <div class="d-block">
                        <div class="pergunta-item--resp mt-1 text-muted collapse" id="pergunta-63c30d4b6bd40368220230114" data-bs-parent="#perguntas-box" style="">
                           <p>Fazendo login no site e abrindo o Menu Principal, você consegue consultar suas últimas compras no menu "Minhas compras".</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="mb-2">
                  <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
                     <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-63c30d9b86a97602220230114" aria-expanded="false" aria-controls="pergunta-63c30d9b86a97602220230114"><i class="bi bi-arrow-right me-2 text-cor-primaria"></i> <span>Como envio o comprovante?</span></div>
                     <div class="d-block">
                        <div class="pergunta-item--resp mt-1 text-muted collapse" id="pergunta-63c30d9b86a97602220230114" data-bs-parent="#perguntas-box" style="">
                           <p>Caso você tenha feito o pagamento via Pix QR Code ou copiando o código, não é necessário enviar o comprovante, aguardando até 5 minutos após o pagamento, o sistema irá dar baixa automaticamente, para mais dúvidas entre em contato conosco <a href="/contato">clicando aqui</a>.</p>
                        </div>
                     </div>
                  </div>
               </div>
               <?php global $enable_password; if($enable_password == 1){ ?>
               <div class="mb-2">
                  <div class="pergunta-item d-flex flex-column p-2 bg-card box-shadow-08 rounded-10 font-weight-500 font-xs">
                     <div class="pergunta-item--pergunta collapsed" data-bs-toggle="collapse" data-bs-target="#pergunta-63c30d6c33f26255820230114" aria-expanded="false" aria-controls="pergunta-63c30d6c33f26255820230114"><i class="bi bi-arrow-right me-2 text-cor-primaria"></i> <span>Esqueci minha senha, como faço?</span></div>
                     <div class="d-block">
                        <div class="pergunta-item--resp mt-1 text-muted collapse" id="pergunta-63c30d6c33f26255820230114" data-bs-parent="#perguntas-box" style="">
                           <p>Você consegue recuperar sua senha indo no menu do site, depois em "Entrar" e logo a baixo tem "Esqueci&nbsp;minha senha".</p>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
            </div>
         </div>
         <!--Fim perguntas frequentes -->
      </div>
   </div>
</div>