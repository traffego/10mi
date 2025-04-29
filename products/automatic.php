<?php
// public/single.php

include_once 'inc/meta.php';

$first_name = 'NomeDoCliente';
$last_name = 'SobrenomeDoCliente';
$phone_number = '5511999999999'; // Exemplo de telefone

$event_name = 'ViewContent';
$event_id = uniqid();
$event_time = time();
$user_data = [
    'fn' => hash('sha256', strtolower($first_name)),
    'ln' => hash('sha256', strtolower($last_name)),
    'ph' => hash('sha256', preg_replace('/\D/', '', $phone_number)),
];
$custom_data = [
    'content_name' => 'Nome do Produto',
    'content_ids' => ['ID_DO_PRODUTO'],
    'content_type' => 'product',
    'value' => 123.45,
    'currency' => 'BRL'
];

sendConversionEvent($event_name, $event_id, $event_time, $user_data, $custom_data);

?>
<div id="overlay">
    <div class="cv-spinner">
        <div class="card" style="border:none; padding:10px;background: transparent;color: #fff !important;font-weight: 800;">
            <span class="spinner mb-2" style="align-self:center;"></span>
            <div class="text-center font-xs">
                <div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <div class="flex items-center">
                        <h3 class="text-lg font-medium">Carregando <span class="dot dot-1">.</span><span class="dot dot-2">.</span><span class="dot dot-3">.</span></h3>
                    </div>
                    <div id="loading-message" class="mt-2 mb-4 text-sm">
                        Estamos gerando seu pedido, aguarde!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$paid_and_pending = $pending_n + $paid_n;
$available = intval($qty_numbers) - $paid_and_pending;
$percent = ($paid_and_pending * 100 / $qty_numbers);
$enable_share = $_settings->info('enable_share');
$enable_groups = $_settings->info('enable_groups');
$telegram_group_url = $_settings->info('telegram_group_url');
$whatsapp_group_url = $_settings->info('whatsapp_group_url');
$max_discount = 0;
if($min_purchase > $available){
   $min_purchase = $available;
}
?>
<style>
@media (min-width:1200px){h3{font-size:1.75rem}}p{margin-top:0;margin-bottom:1rem}img{vertical-align:middle}button{border-radius:0}button:focus:not(:focus-visible){outline:0}button{margin:0;font-family:inherit;font-size:inherit;line-height:inherit}button{text-transform:none}[type=button],button{-webkit-appearance:button}[type=button]:not(:disabled),[type=reset]:not(:disabled),[type=submit]:not(:disabled),button:not(:disabled){cursor:pointer}::-moz-focus-inner{padding:0;border-style:none}::-webkit-datetime-edit-day-field,::-webkit-datetime-edit-fields-wrapper,::-webkit-datetime-edit-hour-field,::-webkit-datetime-edit-minute,::-webkit-datetime-edit-month-field,::-webkit-datetime-edit-text,::-webkit-datetime-edit-year-field{padding:0}::-webkit-inner-spin-button{height:auto}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-color-swatch-wrapper{padding:0}::-webkit-file-upload-button{font:inherit;-webkit-appearance:button}::file-selector-button{font:inherit;-webkit-appearance:button}.container-fluid{--bs-gutter-x:1.5rem;--bs-gutter-y:0;width:100%;padding-right:calc(var(--bs-gutter-x) * .5);padding-left:calc(var(--bs-gutter-x) * .5);margin-right:auto;margin-left:auto}.form-control[type=file]:not(:disabled):not([readonly]){cursor:pointer}.form-control::file-selector-button{padding:.375rem .75rem;margin:-.375rem -.75rem;-webkit-margin-end:.75rem;margin-inline-end:.75rem;color:#212529;background-color:#e9ecef;pointer-events:none;border-color:inherit;border-style:solid;border-width:0;border-inline-end-width:1px;border-radius:0;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out}@media (prefers-reduced-motion:reduce){.form-control::file-selector-button{transition:none}}.form-control:hover:not(:disabled):not([readonly])::-webkit-file-upload-button{background-color:#dde0e3}.form-control:hover:not(:disabled):not([readonly])::file-selector-button{background-color:#dde0e3}.form-control-sm::file-selector-button{padding:.25rem .5rem;margin:-.25rem -.5rem;-webkit-margin-end:.5rem;margin-inline-end:.5rem}.form-control-lg::file-selector-button{padding:.5rem 1rem;margin:-.5rem -1rem;-webkit-margin-end:1rem;margin-inline-end:1rem}.form-control-color:not(:disabled):not([readonly]){cursor:pointer}.form-floating>.form-control-plaintext:not(:-moz-placeholder-shown),.form-floating>.form-control:not(:-moz-placeholder-shown){padding-top:1.625rem;padding-bottom:.625rem}.form-floating>.form-control:not(:-moz-placeholder-shown)~label{opacity:.65;transform:scale(.85) translateY(-.5rem) translateX(.15rem)}.input-group>.form-control:not(:focus).is-valid,.input-group>.form-floating:not(:focus-within).is-valid,.input-group>.form-select:not(:focus).is-valid,.was-validated .input-group>.form-control:not(:focus):valid,.was-validated .input-group>.form-floating:not(:focus-within):valid,.was-validated .input-group>.form-select:not(:focus):valid{z-index:3}.input-group>.form-control:not(:focus).is-invalid,.input-group>.form-floating:not(:focus-within).is-invalid,.input-group>.form-select:not(:focus).is-invalid,.was-validated .input-group>.form-control:not(:focus):invalid,.was-validated .input-group>.form-floating:not(:focus-within):invalid,.was-validated .input-group>.form-select:not(:focus):invalid{z-index:4}.btn:focus-visible{color:var(--bs-btn-hover-color);background-color:var(--bs-btn-hover-bg);border-color:var(--bs-btn-hover-border-color);outline:0;box-shadow:var(--bs-btn-focus-box-shadow)}.btn-check:focus-visible+.btn{border-color:var(--bs-btn-hover-border-color);outline:0;box-shadow:var(--bs-btn-focus-box-shadow)}.btn-check:checked+.btn:focus-visible,.btn.active:focus-visible,.btn.show:focus-visible,.btn:first-child:active:focus-visible,:not(.btn-check)+.btn:active:focus-visible{box-shadow:var(--bs-btn-focus-box-shadow)}.btn-link:focus-visible{color:var(--bs-btn-color)}.carousel{position:relative}.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner::after{display:block;clear:both;content:""}.carousel-item{position:relative;display:none;float:left;width:100%;margin-right:-100%;-webkit-backface-visibility:hidden;backface-visibility:hidden;transition:transform .6s ease-in-out}@media (prefers-reduced-motion:reduce){.carousel-item{transition:none}}.carousel-item.active{display:block}.carousel-control-next,.carousel-control-prev{position:absolute;top:0;bottom:0;z-index:1;display:flex;align-items:center;justify-content:center;width:15%;padding:0;color:#fff;text-align:center;background:0 0;border:0;opacity:.5;transition:opacity .15s ease}@media (prefers-reduced-motion:reduce){.carousel-control-next,.carousel-control-prev{transition:none}}.carousel-control-next:focus,.carousel-control-next:hover,.carousel-control-prev:focus,.carousel-control-prev:hover{color:#fff;text-decoration:none;outline:0;opacity:.9}.carousel-control-prev{left:0}.carousel-control-next{right:0}.carousel-control-next-icon,.carousel-control-prev-icon{display:inline-block;width:2rem;height:2rem;background-repeat:no-repeat;background-position:50%;background-size:100% 100%}.carousel-control-prev-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e")}.carousel-control-next-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e")}.carousel-indicators{position:absolute;right:0;bottom:0;left:0;z-index:2;display:flex;justify-content:center;padding:0;margin-right:15%;margin-bottom:1rem;margin-left:15%;list-style:none}.carousel-indicators [data-bs-target]{box-sizing:content-box;flex:0 1 auto;width:30px;height:3px;padding:0;margin-right:3px;margin-left:3px;text-indent:-999px;cursor:pointer;background-color:#fff;background-clip:padding-box;border:0;border-top:10px solid transparent;border-bottom:10px solid transparent;opacity:.5;transition:opacity .6s ease}@media (prefers-reduced-motion:reduce){.carousel-indicators [data-bs-target]{transition:none}}.carousel-indicators .active{opacity:1}.visually-hidden-focusable:not(:focus):not(:focus-within){position:absolute!important;width:1px!important;height:1px!important;padding:0!important;margin:-1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important;white-space:nowrap!important;border:0!important}.d-block{display:block!important}.mt-3{margin-top:1rem!important}
.sorteio_sorteioShare__247_t {
   position: fixed;
   bottom: 120px;
   right: 12px;
   display: -moz-box;
   display: flex;
   -moz-box-orient: vertical;
   -moz-box-direction: normal;
   flex-direction: column;
}
.top-compradores {
   display: flex;
   flex-wrap: wrap;
}
.comprador {
   padding: 5px 0px 0px 13px;
   text-align: center;
   color: #fff;
   background: #000;
   border-radius: 10px;
   width: 95%;
   margin: 7px 0 0 10px;
}
.ranking {
   margin-bottom: 5px;
   font-weight: bold;
   font-size: 16px;
   float:left !important;
}
.customer-details {
   text-transform: uppercase;
   font-weight: bold;
   font-size: 18px;
}
.customer-details-nome {
   text-transform: capitalize;
   font-weight: bold;
   font-size: 16px;
   display: flex;
   width: 60%;
   /*background: antiquewhite;*/
   float: left;
   margin-left:4px;
}
.customer-details-cotas {
   text-transform: capitalize;
   font-weight: bold;
   font-size: 16px;
}
.premiocotapremiada {
   font-size: small !important;
   font-weight: 500;
   display: flex !important;
   margin-bottom: 3px !important;
   min-width: 20% !important;
}
.btn-cotapremiada {
   min-width: 100px !important;
   background:#333;
   border-color:#353535;    
}
.div-btn-cotapremiada {
   max-width: 25% !important;
   display: inline-table;
}
.cv-spinner {
   height: 100%;
   display: flex;
   justify-content: center;
   align-items: center;  
}
.spinner {
   width: 40px;
   height: 40px;
   border: 4px #ddd solid;
   border-top: 4px #2e93e6 solid;
   border-radius: 50%;
   animation: sp-anime 0.8s infinite linear;
}
@keyframes sp-anime {
100% { 
   transform: rotate(360deg); 
}
}
.is-hide{
   display:none;
}
.app_awarded_container {
   display: flex;
   justify-content: space-around;
   flex-wrap: wrap;
   overflow-x: hidden;
   border-radius: 10px;
   background:#eee;
   /*max-height: 200px;*/
   padding: 10px;
   border-top:solid #ccc 2px;
   border-bottom:solid #ccc 2px;
}
@media (max-width: 639px) { 
   .xs\:font-xss {
      font-size: .8em;
   }
}
.app-vendas-express .app-card {
   background-color:#353535 !important;
   padding-top:10px !important;
}
.app-vendas-express .titulo-seleciona-quantidade {
   color: #fff !important;
   display: inline;
   font-size: 1.4em;
   text-transform: uppercase;
   float: left;
   text-align: left;
   font-weight: bold;
   margin: auto;
   width: 100%;
   padding: 0px !important;
}
.titulo-seleciona-quantidade, p {
   color: #bababa !important;
   text-align: left;
   font-size: 85%;
}
.numero-select {
   font-size:28px !important;
   font-weight: bold !important;
   color: #000;
}
.linha-adicionar {
   width: 100%;
   text-align: center;
   border-top: solid 2px #cdcdcd;
   /*border-top: solid 1px #14e614;*/
   padding-top: 5px;
   font-size: 12px;
      color: #333 !important;
   font-weight: 500;
}
.vendasExpressNumsSelect {
   margin-top: 20px !important;
   margin-bottom: 20px !important;
}
.vendasExpressNumsSelect .mais-popular-novo {
   background-color:#00ff00 !important;
   /*border-bottom: 4px solid #078907;*/
   color:#333;
}
.mais-popular-novo .linha-adicionar {
   width: 100%;
   text-align: center;
   border-top: solid 2px #14e614;
   padding-top: 5px;
   font-size: 12px;
   color: #333 !important;
   font-weight: 500;
}
.vendasExpressNums {
   font-size: 1.4em;
   display: flex;
   width: 49% !important;
   min-height: 10px;
   height: 54px;
   float: left;
   border: 1px solid #555855; 
   /*border-bottom: 4px solid #555855;*/
   border-radius: 10px;
   box-shadow: 0px 0px 2px 2px rgb(0 0 0 / 33%);
}
/*.btn-participar {*/
/*width: 45% !important;*/
/*    min-height: 10px;*/
/*    height: 54px;*/
/*    max-height: 100px !important;*/
/*    border-radius: 9px;*/
/*    padding: 0px !important;*/
/*    float: right !important;*/
/*    background-color:#00ff00 !important;*/
/*    color:#000;*/
/*}*/
.SeletorDeQuantidadeENums .btn-success {
   width: 49% !important;
   min-height: 10px;
   /*display:flex;*/
   height: 54px;
   max-height: 100px !important;
   border-radius: 10px;
   padding: 0px !important;
   float: right !important;
   background-color:#178c00 !important;
   color:#fff;
   /*border-bottom: 4px solid #078907;*/
   box-shadow: 0 0 0 0 rgba(0, 0, 0, 1);
   transform: scale(1);
}
.pointer {
   color:#fff !important;
   font-size:1.4em;
}
.mostraNums {
   display:flex;
}
.vendasExpressNums input {
   border-radius: 5px;
   text-align: center !important;
   font-weight: 700;
   font-size: .8em;
   height: 37px;
   align-self: center !important;
   padding: 0;
}
.SeletorDeQuantidadeENums {
   display: block;
   align-self: center !important;
   width: 100%;
}
.icon-plus-btn-participar {
   width: 40px;
   height: 40px;
   font-size: 30px;
   font-weight: 900 !important;
   border-radius: 5px;
   background: #fff;
   color: #2c9a39;
   float: left;
   margin-left: 7px;
   margin-top: 2px;
   margin-right: 3px;
   padding-top: 6px;
   padding-left: 3px;
   box-shadow: 0px 0px 2px 2px rgb(3 3 3 / 5%);
   /*animation: myAnim 2000ms ease 3s 25 normal forwards;*/
}
/*@keyframes myAnim {*/
/*	0% {*/
/*		opacity: 0;*/
/*	}*/

/*	100% {*/
/*		opacity: 1;*/
/*	}*/
/*}*/
.ctn-participar {
   display: flex;
   /*background: red;*/
   padding-left: 3px;
   padding-top: 0px;
   margin-bottom: -3px;
   /*text-transform:uppercase;*/    
}
.ctn-total {
   display: flex;
   /*background: #03A9F4;*/
   padding-left: 3px;
   text-align: left;
   font-size: 15px;
   letter-spacing: -1px;
   /*font-family: monospace;*/
   font-weight: bold;
}
.titulo-sorteio, .app-title {
   color: #000000;
   margin-bottom: 1px;
   text-transform: uppercase;
   font-weight: 700;
   font-size: 14px;
}
.badgeMensagem {
   display: inline-block;
   padding: 7px;
   font-size: 0.6em;
   font-weight: 700;
   line-height: 1;
   color: #000;
   text-align: center;
   white-space: nowrap;
   vertical-align: baseline;
   border-radius: 5px;
   float: left;
   margin-right: 6px;
   background-color: #0f2 !important;
}
.preco-topo {
   display: inline-block;
   padding: 7px;
   font-size: 0.6em;
   font-weight: 700;
   line-height: 1;
   color: #fff;
   text-align: center;
   white-space: nowrap;
   vertical-align: baseline;
   border-radius: 5px;
   float: left;
   margin-right: 6px;
   background-color: #000 !important;
}
.progress {
   height: 27px !important;
   width: 89px !important;
   margin-right: 5px;
   float: left !important;
}
.porcentagem {
   text-align: center;
   align-self: center;
   width: 90px;
   background: #33333314;
   height: 26px;
   line-height: 26px;
   font-weight: 600;
   text-shadow: 0 0 3px black !important;
   position: absolute;
}
.data-e-hora {
   display: inline-block;
   padding: 4px;
   height: 27px;
   font-size: 0.5em;
   font-weight: 700;
   line-height: 17px;
   color: #000;
   text-align: center;
   white-space: nowrap;
   vertical-align: baseline;
   border-radius: 5px;
   float: left;
   margin-right: 6px;
   background-color: #e9ecef !important;
}
.infoSorteio {
   padding: 6px 6px 7px 6px;
   width: 100%;
}
.imagemDestaque {
   border-bottom: 7px solid #333 !important;
   border-bottom-right-radius: 13px !important;
   border-bottom-left-radius: 13px !important;
   margin-bottom:10px !important;
}
.vendasExpressNumsSelect .item {
   max-height: 58px !important;
   box-shadow: 0px 0px 2px 2px rgb(0 0 0 / 33%)  !important;
}
.numero-select {
   font-size: 22px !important ;
   font-weight: bold !important ;
   color: #000 !important;
}
.top-compradores p {
   width: 100%;
   padding: 12px;
   color: #333 !important;
   font-style: italic;
   margin: 0px;
   display: block;
}
.sorteio-share {    
   display:none !important;
}
/*ESTILO*/
</style>
<style>
   #overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      z-index: 99999999;
      display: none;
      justify-content: center;
      align-items: center;
      backdrop-filter: blur(5px);
   }
   .dot {
      opacity: 0;
      animation: dotAnimation 1.5s infinite;
   }
   .dot-1 {
      animation-delay: 0.5s;
   }
   .dot-2 {
      animation-delay: 1s;
   }
   .dot-3 {
      animation-delay: 1.5s;
   }
   @keyframes dotAnimation {
      0%, 60%, 100% {
         opacity: 0;
      }
      30% {
         opacity: 1;
      }
   }
</style>

<div class="container app-main">
   <div class="sorteio-header mb-2">        
      <div class="SorteioTpl_sorteioTpl__2s2Wu SorteioTpl_destaque__3vnWR  pointer">
         <div class="imagemDestaque SorteioTpl_imagemContainer__2-pl4 col-auto ">
            <div id="carouselSorteio640d0a84b1fef407920230311" class="carousel slide carousel-dark carousel-fade" data-bs-ride="carousel">
               <div class="carousel-inner">
                <?php
                  $image_gallery = isset($image_gallery) ? $image_gallery : ''; 
                  if($image_gallery != '[]' && !empty($image_gallery)){
                     $image_gallery = json_decode($image_gallery, true);
                     array_unshift($image_gallery, $image_path);
                  ?>
                  <?php $slide =0; foreach($image_gallery as $image){ $slide++; ?>
                     <div class="carousel-item <?php if($slide == 1){echo 'active';} ?>">
                        <img src="<?php echo base_url ?><?= $image; ?>" alt="<?= isset($name) ? $name : '' ?>" class="d-block" style="width:100%">
                     </div>
                  <?php } ?>
               <?php }else{ ?>
                  <div class="carousel-item active">
                     <img src="<?= validate_image(isset($image_path) ? $image_path : '') ?>" alt="<?= isset($name) ? $name : '' ?>" class="d-block" style="width:100%">
                  </div>
               <?php } ?>
               </div>
            </div>
         <?php if($image_gallery != '[]' && !empty($image_gallery)){ ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselSorteio640d0a84b1fef407920230311" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
           </button>
           <button class="carousel-control-next" type="button" data-bs-target="#carouselSorteio640d0a84b1fef407920230311" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
           </button>
         <?php } ?>
         </div>     
     
         <div class="infoSorteio">         
            <h1 class="titulo-sorteio"><?= isset($name) ? $name : "" ?></h1>
            <!--<p class="SorteioTpl_descricao__1b7iL" style="margin-bottom: 1px;">-->
            <p><?php echo isset($subtitle) ? $subtitle : ''; ?></p>            
            <?php if($status_display == 1){ ?>
               <span class="badgeMensagem bg-success  bg-opacity-75 font-xsss">Adquira já!</span>
            <?php } ?>
            <?php if($status_display == 2){ ?>
               <span class="badgeMensagem bg-dark  font-xsss mobile badge-status-1">Corre que está acabando!</span>
            <?php } ?>
            <?php if($status_display == 3){ ?>
               <span class="badgeMensagem bg-dark font-xsss mobile badge-status-3">Aguarde o sorteio!</span>
            <?php } ?>
            <?php if($status_display == 4){ ?>
               <span class="badgeMensagem bg-dark font-xsss">Concluído</span>
            <?php } ?>
            <?php if($status_display == 5){ ?>
               <span class="badgeMensagem bg-dark font-xsss">Em breve!</span>
            <?php } ?>           
            <div class="preco-topo">R$ <?= isset($price) ? format_num($price,2) : "" ?></div>

            <!--MOSTRA BARRA DE PROGRESSO-->                 
            <?php if($percent > 0 && $enable_progress_bar == 1){ ?>           
               <div class="progress"> 
                  <span class="porcentagem">Falta
                     <?= number_format(100-$percent, 1, '.', ''); ?>%
                  </span>                
                  <div class="progress-bar bg-info progress-bar-striped fw-bold progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                  <div class="progress-bar bg-success progress-bar-striped fw-bold progress-bar-animated" role="progressbar" aria-valuenow="<?= number_format($percent, 1, '.', ''); ?>" aria-valuemin="0" aria-valuemax="<?= $qty_numbers; ?>" style="width: <?= number_format($percent, 1, '.', ''); ?>%;"></div>
               </div>
            <?php } ?>      
            <!--FECHA BARRA DE PROGRESSO-->   
   
            <div class="data-e-hora">
               <?php if(!empty($date_of_draw) && $date_of_draw != '0000-00-00 00:00:00' && $status_display != '5'){ ?>
                     <?php
                        $dataFormatada = date('d/m/y', strtotime($date_of_draw));
                        $horaFormatada = date('H\hi', strtotime($date_of_draw));
                        $date_of_draw = $dataFormatada . ' às ' . $horaFormatada;
                        echo $date_of_draw;
                     ?>
               <?php } ?>
            </div>      
         </div>   
      </div>
   </div>
   <br>
   <!--COMEÇA ÁREA DE ESCOLHA DE QUANTIDADE-->
   <?php if($status_display < '3' && intval($percent) < 100 && $status == '1'){ ?>
   <?php } ?>
   <div class="row row-gutter-sm">
      <div class="col"></div>
   </div>

   <div class="app-card card font-xs mb-3 sorteio_sorteioDesc__TBYaL">
      <div class="card-body sorteio_sorteioDescBody__3n4ko">
         <p><?php echo isset($row['subtitle']) ? $row['subtitle'] : ''; ?></p>
         <?= isset($description) ? str_replace(["\n\r", "\n", "\r"],"<br>", $description) : '' ?>
      </div>
   </div>

   <!--GANHADORES--> 
   <?php if(!empty($draw_number)){ ?>
   <?php 
   $winners_qty = 5; 
   $draw_number = isset($draw_number) ? $draw_number : ''; 

   if($winners_qty && $draw_number){ 
      $draw_winner = json_decode($draw_winner, true);
      $draw_number = json_decode($draw_number, true);
      $winners = [];
      foreach ($draw_winner as $qty_index => $name) {
         foreach ($draw_number as $amount_index => $number) {
            if ($qty_index === $amount_index) {
               $winners[$qty_index] = [
                  'name' => $name,
                  'number' => $number
               ];
            }
         }
      }
     }
      ?>
      <?php $count = 0; foreach($winners as $winner){ $count++; ?>
         <div class="app-card card bg-success text-white mb-2">
            <div class="card-body">
               <div class="row align-items-center">
                  <div class="col-auto">
                     <div class="rounded-pill" style="width: 56px; height: 56px; position: relative; overflow: hidden;">
                        <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                           <img alt="<?= $winner['name']; ?>" src="<?php echo base_url ?>assets/img/avatar.jpg" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                           <noscript></noscript>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <h5 class="mb-0"><?= $count; ?>º - <?= $winner['name']; ?>&nbsp;<i class="bi bi-check-circle text-white-50"></i></h5>
                     <div class="text-white-50"><small>Ganhador(a) com a cota <?= $winner['number']; ?></small></div>
                  </div>
               </div>
            </div>
         </div>
      <?php } ?>
   <?php } ?> 

      <!--COTA PREMIADA-->
      <?php if (isset($cotapremiada) && $cotapremiada != '' && $status == '1'): ?>   
      <div class="app-card card mb-2 mt-3">       
         <div class="card-body pb-1">
            <div class="app-title mb-2">
               <h1>🔥 Cotas premiadas</h1>
               <!--<div class="app-title-desc">Achou ganhou!</div>-->
            </div>       
            <div class="app_awarded_container justify-content-start">          
               <div class="row px-3">
                  <?php
                  $cotapremiada = isset($cotapremiada) ? $cotapremiada : '';
                  $data_aw = json_decode($cotapremiada, true);
                  if ($data_aw) {
                     foreach ($data_aw as $linha) {
                        $aw_number = $linha['aw_number'];
                        $aw_label = $linha['aw_label'];
                        $aw_view = $linha['aw_view'];
                     ?>                    
                           <div class="col px-1 mb-2 position-relative div-btn-cotapremiada ">
                              <div class="font-weight-200 text-center mb-2 premiocotapremiada"><?php echo $linha['aw_label']; ?></div>
                              <button class="btn btn-cotapremiada btn-success w-100 btn-sm p-0 text-nowrap font-xs xs:font-xss relative position-relative">
                                 <?php if($aw_view) {?>
                                    <span class="position-absolute inset-0 d-flex align-items-center justify-content-center" style="background-color: rgb(0 0 0 / 27%); width: 100%; height: 100%;">
                                    </span>
                                 <?php } ?>
                                 <div class="btn-cotapremiada"><!--<div class="py-1 px-2">-->
                                       <span class="font-weight-600">
                                       <?php if($aw_view) {?> 
                                          <div style="position: relative;display: inline-block;margin-right: 2px;border: 1px solid black;border-radius: 100%;font-size: 14.4px;">
                                             <i class="bi bi-circle-fill" style="color: red;"></i>
                                          </div>
                                       <?php } else { ?> 
                                          <div style="position: relative;display: inline-block;margin-right: 2px;border: 1px solid black;border-radius: 100%;font-size: 14.4px;">
                                             <i class="bi bi-circle-fill" style="color: green;"></i>
                                          </div>                                      
                                       <?php } ?>
                                       <?php echo $linha['aw_number']; ?>
                                       </span>
                                 </div>                                                
                              </button>
                           </div>
                     <?php
                     }
                  }
                  ?>
               </div>        
            </div>
         </div>
         <div style="font-size:0.75rem;font-style:italic;margin: 12px 50px 20px 50px;padding:3px;text-align:center;">
            <?php echo isset($cotapremiada_descricao) ? $cotapremiada_descricao : ''; ?>
         </div>
      </div>
   <?php endif; ?>   

   <!--PROMOÇÃO--> 
   <?php 
   $discount_qty = isset($discount_qty) ? $discount_qty : ''; 
   $discount_amount = isset($discount_amount) ? $discount_amount : '';

   if($discount_qty && $discount_amount && $enable_discount == 1){ 
      $discount_qty = json_decode($discount_qty, true);
      $discount_amount = json_decode($discount_amount, true);
      $discounts = [];
      foreach ($discount_qty as $qty_index => $qty) {
         foreach ($discount_amount as $amount_index => $amount) {
            if ($qty_index === $amount_index) {
               $discounts[$qty_index] = [
                  'qty' => $qty,
                  'amount' => $amount
               ];
            }
         }
      }
      if(isset($discounts)){
         $max_discount = count($discounts);
      }else{
         $max_discount = 0;
      }
   ?>
      <?php if($status == '1'){ ?>
         <div class="app-promocao-numeros mb-3 mt-3">
            <div class="app-card card">
               <div class="card-body pb-1">
                  <div class="row px-2">
                        <div class="app-title mb-2">
                           <h1>📣 Promoção</h1>
                           <div class="app-title-desc">Compre mais barato!</div>
                        </div>
                        <?php $count = 0; foreach($discounts as $discount){ 
                           if($discount['amount'] > 0 && $discount['qty'] > 0) { ?>
                              <div class="col-auto px-1 mb-2">
                                 <button onclick="qtyExpress('<?= $discount['qty']; ?>', true);" class="btn btn-success w-100 btn-sm py-0 px-2 text-nowrap font-xss">
                                    <span class="font-weight-500">
                                       <b class="font-weight-600">
                                          <span id="discount_qty_<?= $count; ?>"><?= $discount['qty']; ?></span>
                                       </b> 
                                       <small>por R$</small> 
                                       <span class="font-weight-600">
                                          <span id="discount_amount_<?= $count; ?>" style="display:none"><?= $discount['amount']; ?></span>
                                          <?php                   
                                             $discount_price = $price * $discount['qty'] - $discount['amount']; 
                                             echo number_format($discount_price, 2, ',', '.');                                     
                                          ?>
                                       </span>
                                    </span>
                                 </button>
                              </div>
                        <?php $count++; } } ?>
                  </div>
               </div>
            </div>
         </div>
      <?php } ?>
   <?php } ?>

   <!--CHECKOUT--> 
   <?php if(intval($percent) < 100 && $status == '1'){ ?>
   <div class="app-vendas-express mb-2">
      <div class="app-card card mb-2">
         <div class="card-body text-center">
            <!--<h1 class="text-muted font-xs mb-3 pt-2">Selecione a quantidade</h1>-->            
            <div>
               <h1 class="titulo-seleciona-quantidade">Selecione a quantidade</h1>
               <p>Quanto mais títulos, mais chances de ganhar!</p>
            </div>
           
            <div class="numeros-select d-flex justify-content-center flex-column">
               <div class="vendasExpressNumsSelect">
                  <div onclick="qtyExpress(15, false);" class="item p-2 me-2 mb-2  flex-column ">
                     <h3 class="mb-1 numero-select">+15</h3>
                     <p class="text-muted font-xss text-uppercase linha-adicionar">ADICIONAR</p>
                  </div>
                  <div onclick="qtyExpress(30, false);" class="item p-2 me-2 mb-2  flex-column mais-popular-novo">
                     <h3 class="mb-1 numero-select">+30</h3>
                     <p class="text-muted font-xss text-uppercase linha-adicionar">ADICIONAR</p>
                  </div>
                  <div onclick="qtyExpress(80, false);" class="item p-2 me-2 mb-2  flex-column ">
                     <h3 class="mb-1 numero-select">+80</h3>
                     <p class="text-muted font-xss text-uppercase linha-adicionar">ADICIONAR</p>
                  </div>
                  <div onclick="qtyExpress(100, false);" class="item p-2 me-2 mb-2  flex-column">
                     <h3 class="mb-1 numero-select">+100</h3>
                     <p class="text-muted font-xss text-uppercase linha-adicionar">ADICIONAR</p>
                  </div>
                  <div onclick="qtyExpress(500, false);" class="item p-2 me-2 mb-2  flex-column ">
                     <h3 class="mb-1 numero-select">+500</h3>
                     <p class="text-muted font-xss text-uppercase linha-adicionar">ADICIONAR</p>
                  </div>
                  <div onclick="qtyExpress(1000, false);" class="item p-2 me-2 mb-2  flex-column ">
                     <h3 class="mb-1 numero-select">+1000</h3>
                     <p class="text-muted font-xss text-uppercase linha-adicionar">ADICIONAR</p>
                  </div>
               </div>
               <div class="SeletorDeQuantidadeENums">
                  <div class="vendasExpressNums">                   
                     <div class="left pointer">
                        <div class="removeNumero numeroChange"><i class="bi bi-dash-square-fill"></i></div>
                     </div>                  
                     <div class="mostraNums">                      
                        <input class="form-control text-center qty" value="<?= isset($min_purchase) ? $min_purchase : "" ?>" aria-label="Quantidade de números" placeholder="<?= isset($min_purchase) ? $min_purchase : "" ?>">
                     </div>
                     <div class="right pointer">
                        <div class="addNumero numeroChange"><i class="bi bi-plus-square-fill"></i></div>
                     </div>
                  </div>
               
                  <!-- BOTÃO PARTICIPAR -->
                  <?php if($user_id){ ?>
                     <button id="add_to_cart" data-bs-toggle="modal" data-bs-target="#modal-checkout" class="btn btn-success w-100 py-2">
                  <?php }else{ ?>
                     <span id="add_to_cart"></span>
                     <button data-bs-toggle="modal" data-bs-target="#loginModal" class="btn btn-success btn-participar w-100 py-2">
                  <?php } ?>
                        <!--<div class="row align-items-center" style="line-height: 85%;">-->
                        <div class="">                           
                           <div class="icon-plus-btn-participar">
                              <i class="bi bi-check2-circle me-1"></i>
                           </div>
                           <div class="ctn-participar">                          
                              <span>Participe Aqui</span>                          
                           </div>                          
                           <div class="ctn-total">                          
                              <span id="total">R$
                                    <?php                                   
                                       if(isset($price)){
                                          $price_total = $price * $min_purchase;
                                          echo format_num($price_total,2);
                                       }?>                     
                              </span>                                   
                           </div>
                        </div>
                     </button>
                  <!-- FECHA BOTÃO PARTICIPAR -->                     
               </div>               
            </div>
         </div>
      </div>
   </div>
   <?php } ?>           

   <?php if($enable_sale == 1 && $enable_discount == 0 && $status == '1'){ ?>
      <div class="app-promocao-numeros mb-2">
         <div class="app-title mb-2">
            <h1>📣 Promoção</h1>
            <div class="app-title-desc">Compre mais barato!</div>
         </div>
         <div class="app-card card">
            <div class="card-body pb-1">
               <div class="row px-2">
                  <div class="col-auto px-1 mb-2">
                     <button onclick="qtyExpress('<?= $sale_qty; ?>', false);" class="btn btn-success w-100 btn-sm py-0 px-2 text-nowrap font-xss">
                        <span class="font-weight-500">Comprando <b class="font-weight-600"><span><?= $sale_qty; ?> cotas</span></b> sai por apenas<small> R$</small> <span class="font-weight-600">
                           <?php echo number_format($sale_price, 2, ',', '.');?></span> cada
                        </span>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   <?php } ?> 

   <!--RANKING COMPRADORES--> 
   <!--<div class="top-compradores">-->      
   <div class="app-card card mb-3 mt-3">
      <?php if($enable_ranking > 0){
         if($enable_ranking_date && !empty($ranking_date_start) && !empty($ranking_date_end)) {
            $date_start = new DateTime($ranking_date_start);
            $date_end = new DateTime($ranking_date_end);         
            $date_start_formatted = $date_start->format('Y-m-d') . " 00:00:00";
            $date_end_formatted = $date_end->format('Y-m-d') . " 23:59:59";
            
            $type_definition = "issi";
            $id = $id;
            
            $stmt = $conn->prepare("
               SELECT c.firstname, c.lastname, c.phone, SUM(o.quantity) AS total_quantity, SUM(o.total_amount) AS total_amount, 
               o.code, CONCAT(' ', o.product_name) AS product, o.date_created
               FROM order_list o
               INNER JOIN customer_list c ON o.customer_id = c.id
               WHERE o.product_id = ? AND o.status = 2
               AND o.date_created >= ? AND o.date_created <= ?
               GROUP BY o.customer_id
               ORDER BY total_quantity DESC
               LIMIT ?
            ");
            
            $stmt->bind_param($type_definition, $id, $date_start_formatted, $date_end_formatted, $ranking_qty);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();       
         }else{
            $stmt = $conn->prepare("
            SELECT c.firstname, c.lastname, c.phone, SUM(o.quantity) AS total_quantity, SUM(o.total_amount) AS total_amount, 
            o.code, CONCAT(' ', o.product_name) AS product
            FROM order_list o
            INNER JOIN customer_list c ON o.customer_id = c.id
            WHERE o.product_id = ? AND o.status = 2
            GROUP BY o.customer_id
            ORDER BY total_quantity DESC
            LIMIT ?
            ");

            $stmt->bind_param("ii", $id, $ranking_qty);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
         }
         if ($result->num_rows > 0) {?>   
            <div class="app-title mb-2">
               <h1>🏆 RANKING DE COMPRADORES</h1>
            </div>   
   
            <div class="top-compradores">
               <?php
               $count = 0;
               while ($row = $result->fetch_assoc()) {
               $count++;
               ?>
                  <div class="comprador">
                     <div class="ranking">🥇 <?= $count; ?>º </div>          
                     <div class="customer-details">
                        <div class="customer-details-nome"><?= $row['firstname']." ".$row['lastname'] ?></div>
                        <?php if($enable_ranking_show == 1){ ?>
                           <div class="customer-details-cotas"> <?= $row['total_quantity'] ?> COTAS</div>
                        <?php } ?>
                     </div>
                  </div>
               <?php } ?>
   
               <?php if($ranking_message){ ?>
                  <p><?= $ranking_message; ?></p>
               <?php } ?>
            </div>
         <?php } 
      } ?>
   </div>    

   <div class="sorteio-share d-flex mb-2 justify-content-between align-items-center">
      <?php if($enable_share == 1){ ?>
         <div class="item d-flex align-items-center">
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= base_url; ?>sorteio/<?= $slug; ?>" target="_blank">
               <div alt="Compartilhe no Facebook" class="sorteio_sorteioShareLinkFacebook__2McKU" style="margin-right:5px;">
                  <i class="bi bi-facebook"></i>
               </div>
            </a>
            <a href="https://t.me/share/url?url=<?= base_url; ?>sorteio/<?= $slug; ?>text=<?= $name; ?>" target="_blank">
               <div alt="Compartilhe no Telegram" class="sorteio_sorteioShareLinkTelegram__3a2_s" style="margin-right:5px;">
                  <i class="bi bi-telegram"></i>
               </div>
            </a>
            <a href="https://www.twitter.com/share?url=<?= base_url; ?>sorteio/<?= $slug; ?>" target="_blank">
               <div alt="Compartilhe no Twitter" class="sorteio_sorteioShareLinkTwitter__1E4XC" style="margin-right:5px;">
                  <i class="bi bi-twitter"></i>
               </div>
            </a>
            <a href="https://api.whatsapp.com/send/?text=<?= $name; ?>%21%21%3A+<?= base_url; ?>sorteio/<?= $slug; ?>&type=custom_url&app_absent=0" target="_blank"><div alt="Compartilhe no WhatsApp" class="sorteio_sorteioShareLinkWhatsApp__2Vqhy"><i class="bi bi-whatsapp"></i></div></a>
         </div>
      <?php } ?>
   </div> 

</div>

<div class="modal fade" id="modal-consultaCompras">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <form id="consultMyNumbers">
            <div class="modal-header">
               <h6 class="modal-title">Consulta de compras</h6>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label class="form-label">Informe seu telefone</label>
                  <div class="input-group mb-2">
                     <input onkeyup="leowpMask(this);" maxlength="15" class="form-control" aria-label="Número de telefone" id="phone" name="phone" required="" value="">
                     <button class="btn btn-secondary" type="submit" id="button-addon2">
                        <div class=""><i class="bi bi-check-circle"></i></div>
                     </button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<!-- Modal checkout -->
<div class="modal fade" id="modal-checkout">
   <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
      <div class="modal-content rounded-0">
         <span class="d-none">Usuário não autenticado</span>
         <div class="modal-header">
            <h5 class="modal-title">Checkout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body checkout">
            <div class="alert alert-info p-2 mb-2 font-xs"><i class="bi bi-check-circle"></i> Você está adquirindo<span class="font-weight-500">&nbsp;<span id="qty_cotas"></span> cotas</span><span>&nbsp;da ação entre amigos</span><span class="font-weight-500">&nbsp;<?= isset($name) ? $name : "" ?></span>,<span>&nbsp;seus números serão gerados</span><span>&nbsp;assim que concluir a compra.</span></div>
            <div class="mb-3">
               <div class="card app-card">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col-auto">
                           <div class="rounded-pill p-1 bg-white box-shadow-08" style="width: 56px; height: 56px; position: relative; overflow: hidden;">
                              <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                                 <img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                                 <noscript></noscript>
                              </div>
                           </div>
                        </div>
                        <div class="col">
                           <h5 class="mb-1"><?= $_settings->userdata('firstname'); ?> <?= $_settings->userdata('lastname'); ?></h5>
                           <div class="text-muted"><small><?php echo formatPhoneNumber($_settings->userdata('phone')); ?></small></div>
                        </div>
                        <div class="col-auto"><i class="bi bi-chevron-compact-right"></i></div>
                     </div>
                  </div>
               </div>
            </div>
            <button id="place_order" class="btn btn-success w-100 mb-2">Concluir reserva <i class="bi bi-arrow-right-circle"></i></button>
            <button type="button" class="btn btn-link btn-sm text-secondary text-decoration-none w-100 my-2"><a href="<?php echo base_url.'logout?'.$_SERVER['REQUEST_URI']; ?>">Utilizar outra conta</a></button>




         </div>
      </div>
   </div>
</div>
<!-- Modal checkout -->

<!-- Modal Aviso -->
<button id="aviso_sorteio" data-bs-toggle="modal" data-bs-target="#modal-aviso" class="btn btn-success w-100 py-2" style="display:none"></button>
<div class="modal fade" id="modal-aviso">
   <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered">
      <div class="modal-content rounded-0">
         <div class="modal-header">
            <h5 class="modal-title">Aviso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body checkout">
            <div class="alert alert-danger p-2 mb-2 font-xs aviso-content">


            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal Aviso -->

<div class="modal fade" id="modal-indique">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Indique e ganhe!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body text-center">Faça login para ter seu link de indicao, e ganhe at 0,00% de créditos nas compras aprovadas!</div>
      </div>
   </div>
</div>
<?php if($enable_groups == 1){ ?>
   <div class="sorteio_sorteioShare__247_t">
      <?php if($whatsapp_group_url){ ?>
         <a href="<?= $whatsapp_group_url; ?>" target="_blank">   
            <div class="whatsapp-grupo">
               <div class="btn btn-sm btn-success mb-1 w-100"><i class="bi bi-whatsapp"></i> Grupo</div>
            </div>
         </a>
      <?php } ?>
      <?php if($telegram_group_url){ ?>
         <a href="<?= $telegram_group_url; ?>" target="_blank">
            <div class="telegram-grupo">
               <div class="btn btn-sm btn-info btn-block text-white mb-1 w-100"><i class="bi bi-telegram"></i> Telegram</div>
            </div>
         </a>
      <?php } ?>
   </div>
<?php } ?>
</div>

<script>
  $(function(){
    $('#add_to_cart').click(function(){
      add_cart();
   })
    $('#place_order').click(function(){
      place_order();
   })

    $(".addNumero").click(function() {
       let value = parseInt($(".qty").val());
       value++;
       $(".qty").val(value);

       calculatePrice(value);

    })

    $(".removeNumero").click(function() {
       let value = parseInt($(".qty").val());
       if (value <= 1) {
         value = 1;
      } else {
         value--;
      }
      $(".qty").val(value);
      calculatePrice(value);
   })

   function place_order(){
      $('#overlay').fadeIn(300).css('display', 'inline-grid');
      $.ajax({
         url: _base_url_ + 'classes/Master.php?f=place_order',
         method:'POST',
         data:{product_id: parseInt('<?php echo (isset($id) ? $id : ''); ?>')},
         dataType:'json',
         error:err=>{
            console.log(err);  
            console.log('Nova tentativa de compra');
            place_order();           
         },
         success:function(resp){
            if(resp.status == 'success'){ 
               location.replace(resp.redirect)
            }else{
               console.log(resp.error);
               //location.reload();
            }
         }
      })
   }

   })
  function formatCurrency(total) {
    var decimalSeparator = ',';
    var thousandsSeparator = '.';

  var formattedTotal = total.toFixed(2); // Define 2 casas decimais
  
  // Substitui o ponto pelo separador decimal desejado
  formattedTotal = formattedTotal.replace('.', decimalSeparator);
  
  // Formata o separador de milhar
  var parts = formattedTotal.split(decimalSeparator);
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSeparator);
  
  // Retorna o valor formatado
  return parts.join(decimalSeparator);
}

function calculatePrice(qty){   
 let price = '<?= $price; ?>'; 
 let enable_sale = parseInt('<?= $enable_sale; ?>');
 let sale_qty = parseInt('<?= $sale_qty; ?>');
 let sale_price = '<?= $sale_price; ?>';

 let available = parseInt('<?= $available; ?>');
 let total = price * qty;  
 var max = parseInt('<?= isset($max_purchase) ? $max_purchase : "" ?>');
 var min = parseInt('<?= isset($min_purchase) ? $min_purchase : "" ?>');

 if (qty > available) {
    //calculatePrice(available);   
    //alert('Há apenas : ' + available + ' cotas disponíveis no momento.');
    $('.aviso-content').html('Há apenas : ' + available + ' cotas disponíveis no momento.');
    $('#aviso_sorteio').click();
    $(".qty").val(available);
     //total = price * available;
     //$('#total').html('R$ '+formatCurrency(total)+'');
    calculatePrice(available); 
    return; 
 } 

 if (qty < min) {
   // calculatePrice(min);   
    //alert('A quantidade mínima de cotas é de: ' + min + '');
    $('.aviso-content').html('A quantidade mínima de cotas é de: ' + min + '');
    $('#aviso_sorteio').click();
    $(".qty").val(min);
    total = price * min; 
    calculatePrice(min);
     //$('#total').html('R$ '+formatCurrency(total)+'');
    return; 
 } 

 if(qty > max){
    //alert('A quantidade máxima de cotas é de: ' + max + '');
   $('.aviso-content').html('A quantidade máxima de cotas é de: ' + max + '');
   $('#aviso_sorteio').click();
   $(".qty").val(max); 
   total = price * max;
   calculatePrice(max);
   //$('#total').html('R$ '+formatCurrency(total)+'');
   return;
}
// Desconto acumulativo
var qtd_desconto = parseInt('<?= $max_discount; ?>');

let leowpDescontos = [];
for (i = 0; i < qtd_desconto; i++) {
 leowpDescontos[i] = {
  qtd: parseInt($(`#discount_qty_${i}`).text()),
  vlr: parseFloat($(`#discount_amount_${i}`).text())
};
}
//console.log(leowpDescontos);

var leowp_desconto_qty = null;
var leowp_desconto = null;

for (i = 0; i < leowpDescontos.length; i++) {
 if (qty >= leowpDescontos[i].qtd) {
  leowp_desconto_qty = leowpDescontos[i].qtd;
  leowp_desconto = leowpDescontos[i].vlr;
}
}

var leowp_desconto_aplicado = total;
var desconto_acumulativo = false;
var quantidade_de_numeros = leowp_desconto_qty;
var valor_do_desconto = leowp_desconto;

<?php if ($enable_cumulative_discount == 1) { ?>
 desconto_acumulativo = true;
<?php } ?>

if (desconto_acumulativo && qty >= quantidade_de_numeros) {
 var multiplicador_do_desconto = Math.floor(qty / quantidade_de_numeros);
 leowp_desconto_aplicado = total - (valor_do_desconto * multiplicador_do_desconto);
}

// Aplicar desconto normal quando desconto acumulativo estiver desativado
if (!desconto_acumulativo && qty >= leowp_desconto_qty) {
 leowp_desconto_aplicado = total - valor_do_desconto;
}

if (parseInt(qty) >= parseInt(leowp_desconto_qty)) {
 $('#total').html('<strike>R$' + formatCurrency(total) + '</strike> > ' + formatCurrency(leowp_desconto_aplicado));
 $('#total').html('<strike>R$' + formatCurrency(total) + '</strike> > ' + formatCurrency(leowp_desconto_aplicado));
} else {
   if(enable_sale == 1 && qty >= sale_qty){
    total_sale = qty * sale_price;

    $('#total').html('De <strike>R$ ' + formatCurrency(total) + '</strike> por R$ ' + formatCurrency(total_sale));
 }else{
  $('#total').html('R$ ' + formatCurrency(total));  
}

}
//Fim desconto acumulativo

}

function qtyExpress(qty, opt) {
 qty = parseInt(qty);
 let value = parseInt($(".qty").val());  
 let qtyTotal = (value + qty);
 if(opt === true){
   qtyTotal = (qtyTotal - value);
}

$(".qty").val(qtyTotal);
calculatePrice(qtyTotal);  

}
function add_cart(){
 let qty = $('.qty').val();    
 $('#qty_cotas').text(qty);
 $.ajax({
   url:_base_url_+"classes/Master.php?f=add_to_card",
   method:"POST",
   data:{product_id: "<?= isset($id) ? $id :'' ?>", qty: qty},
   dataType:"json",
   error:err=>{
     //console.log(err)
     alert("An error occured.",'error');
  },
  success:function(resp){
     if(typeof resp== 'object' && resp.status == 'success'){
                    //location.reload();
     }else if(!!resp.msg){
       alert(resp.msg,'error');
    }else{
       alert("An error occured.",'error');
    }
 }
})
}

$(document).ready(function() {
 $('.qty').on('keyup', function() {
  var value = parseInt($(this).val());
  var min = parseInt('<?= isset($min_purchase) ? $min_purchase : "" ?>');
  var max = parseInt('<?= isset($max_purchase) ? $max_purchase : "" ?>');
  if (value < min) {
    calculatePrice(min);   
      //alert('A quantidade mínima de cotas é de: ' + min + '');
    $('.aviso-content').html('A quantidade mínima de cotas é de: ' + min + '');
    $('#aviso_sorteio').click();
    $(".qty").val(min);

 } 
 if(value > max){
   calculatePrice(max);
      //alert('A quantidade máxima de cotas é de: ' + max + '');
   $('.aviso-content').html('A quantidade máxima de cotas é de: ' + max + '');
   $('#aviso_sorteio').click();
   $(".qty").val(max);  

}
});
});   

$(document).ready(function(){
 $('#consultMyNumbers').submit(function(e){
  e.preventDefault()

  $.ajax({
   url:_base_url_+"classes/Master.php?f=search_orders_by_phone",
   method:'POST',
   type:'POST',
   data:new FormData($(this)[0]),
   dataType:'json',
   cache:false,
   processData:false,
   contentType: false,
   error:err=>{
    //console.log(err)
    alert('An error occurred')

 },
 success:function(resp){
    if(resp.status == 'success'){
      location.href = (resp.redirect)                                    
   }else{
     alert('Nenhum registro de compra foi encontrado')
     //console.log(resp)
  }
}
})
})
})
</script>
<script>
    const messages = [
        "Estamos gerando seu pedido, aguarde!",
        "Por favor, mantenha a página aberta.",
        "Estamos processando os detalhes do seu pedido.",
        "Quase lá, só mais um momento!"
    ];
    const messageElement = document.getElementById("loading-message");
    let index = 0;

    setInterval(() => {
        index = (index + 1) % messages.length;
        messageElement.textContent = messages[index];
    }, 20000);
</script>