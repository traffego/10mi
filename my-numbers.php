<?php
$enable_hide_numbers = $_settings->info('enable_hide_numbers');
?>
<style>
  /* Estilos para os badges de números */
  .numbers-container {
    position: relative;
    padding: 5px;
    display: flex;
    flex-wrap: wrap;
    align-content: flex-start;
  }
  
  /* Aplicando a altura fixa à área compra-cotas */
  .compra-cotas.font-xs {
    height: 300px;
    overflow-y: auto;
    position: relative;
    margin-bottom: 0;
    padding: 10px;
    padding-bottom: 110px; /* Espaço extra para o gradiente não cobrir números */
    border: 1px solid #e9e9e9;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
    transition: height 0.3s ease;
    scrollbar-width: thin;
    -ms-overflow-style: none;
  }
  
  .compra-cotas.font-xs::-webkit-scrollbar {
    width: 6px;
  }
  
  .compra-cotas.font-xs::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
  }
  
  /* Contenedor para o efeito de blur */
  .blur-container {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 120px;
    pointer-events: none;
    z-index: 5;
    overflow: hidden;
  }
  
  /* Efeito de blur como elemento separado para facilitar o controle */
  .blur-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 120px;
    background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,0.85) 50%, rgba(255,255,255,1) 100%);
    pointer-events: none;
    transition: opacity 0.3s ease;
  }
  
  /* Modo escuro para o gradiente */
  .dark .blur-overlay {
    background: linear-gradient(to bottom, rgba(30,30,30,0) 0%, rgba(30,30,30,0.85) 50%, rgba(30,30,30,1) 100%);
  }
  
  /* Esconder o gradiente quando expandido */
  .blur-hidden {
    opacity: 0;
    visibility: hidden;
  }
  
  .compra-cotas.font-xs.expanded {
    height: auto;
    max-height: 600px;
  }
  
  .badge.bg-success.me-1, .badge.bg-warning.me-1, .badge.bg-danger.me-1 {
    min-width: 60px;
    text-align: center;
    margin-bottom: 8px;
    flex: 0 0 calc(20% - 8px);
    margin: 4px;
    padding: 6px 4px;
    font-size: 0.75rem;
  }
  
  .expand-button {
    display: block;
    width: 100%;
    text-align: center;
    margin-top: 0;
    padding: 10px;
    background-color: #6c5ce7;
    color: white;
    border: 1px solid #e9e9e9;
    border-top: none;
    border-radius: 0 0 8px 8px;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: relative;
    z-index: 3;
  }
  
  .expand-button:hover {
    background-color: #5541e0;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }
  
  .expand-button i {
    margin-right: 5px;
    font-size: 0.8rem;
  }
  
  @media (max-width: 768px) {
    .badge.bg-success.me-1, .badge.bg-warning.me-1, .badge.bg-danger.me-1 {
      flex: 0 0 calc(25% - 8px);
    }
  }
  
  @media (max-width: 576px) {
    .badge.bg-success.me-1, .badge.bg-warning.me-1, .badge.bg-danger.me-1 {
      flex: 0 0 calc(33.33% - 8px);
    }
    
    .blur-overlay {
      height: 80px;
    }
  }
</style>

<div class="container app-main">
   <div class="mb-3">
      <div class="row justify-content-between w-100 align-items-center">
         <div class="col">
            <div class="app-title">
               <h1>🛒 Meus números</h1>

            </div>
         </div>
         <div class="col-auto text-end"><button type="button" data-bs-toggle="modal" data-bs-target="#modal-buscar" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Buscar</button></div>
      </div>
   </div>
   <form id="modal-buscar" class="modal fade" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-sm modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Buscar compras</h5>
            </div>
            <div class="modal-body">
               <div class="form-group mb-3"><label class="form-label">Informe seu telefone</label>
                  <input onkeyup="leowpMask(this);" maxlength="15" name="phone" required="" class="form-control" value=""></div>
                  <div class="text-end"><button type="submit" class="btn btn-primary">Buscar compras</button></div>
               </div>
            </div>
         </div>
      </form>
      <div class="alert alert-warning"><i class="bi bi-exclamation-triangle"></i> Clique em buscar para localizar suas compras</div>

      <div>
         <?php 
         $i = 1;
         $phone = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';
         if(!$phone){
         $phone = 'leowp';
         }
         $phone = $conn->real_escape_string($phone);
         $phoneQuery = $conn->query("
          SELECT id
          FROM customer_list
          WHERE phone = '{$phone}'
          ");

         if ($phoneQuery && $phoneQuery->num_rows > 0) {
          $customerId = $phoneQuery->fetch_assoc()['id'];

         $stmt = $conn->prepare("
         SELECT 
            o.*, 
            p.image_path, 
            p.qty_numbers, 
            oi.product_id, 
            p.type_of_draw,
            (
               SELECT GROUP_CONCAT(DISTINCT LPAD(onum.number, FLOOR(LOG10(p.qty_numbers - 1)) + 1, '0') ORDER BY onum.number ASC) 
               FROM order_numbers onum 
               WHERE onum.order_id = oi.order_id
            ) AS o_numbers 
         FROM 
            order_list o
         INNER JOIN 
            order_items oi ON o.id = oi.order_id
         INNER JOIN 
            product_list p ON oi.product_id = p.id
         WHERE 
            o.customer_id = ? 
         ORDER BY ABS(UNIX_TIMESTAMP(o.date_created)) DESC
         ");

         $stmt->bind_param("i", $customerId);
         $stmt->execute();
         $orders = $stmt->get_result();

          if ($orders && $orders->num_rows > 0) {
            while ($orderRow = $orders->fetch_assoc()) {
             ?>
             <?php              
             $class = '';
             $border = '';
             $btn = '';
             $status = $orderRow['status'];
             if($orderRow['status'] == '1'){
               $class = 'bg-warning';
               $border = 'border-warning';
               $btn = 'btn-warning';
            }
            if($orderRow['status'] == '2'){
               $class = 'bg-success';
               $border = 'border-success';
               $btn = 'btn-success';
            }
            if($orderRow['status'] == '3'){
               $class = 'bg-danger';
               $border = 'border-danger';
               $btn = 'btn-danger';
            }
            ?>
            <div class="card app-card mb-2 pointer border-bottom border-2 <?= $border; ?>">
               <div class="card-body">

                <div class="row align-items-center row-gutter-sm">
                 <div class="col-auto">
                  <div class="position-relative rounded-pill overflow-hidden box-shadow-08" style="width: 56px; height: 56px;">
                   <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
                    <img src="<?= validate_image($orderRow['image_path']) ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                    <noscript></noscript>
                 </div>
              </div>
           </div>
           <div class="col ps-2">
            <small class="compra-data font-xss opacity-50"><?= date("d-m-Y H:i", strtotime($orderRow['date_created'])) ?></small>
            <div class="compra-title font-weight-500"><?= $orderRow['product_name'] ?></div>
            <?php if($status == '1'){ ?>
               <small class="font-xss opacity-75 text-uppercase">Aguardando Pagamento</small>
            <?php } ?>
            <?php if($status == '2'){ ?>
               <small class="font-xss opacity-75 text-uppercase">Pago</small>
            <?php } ?>
            <?php if($status == '3'){ ?>
               <small class="font-xss opacity-75 text-uppercase">Cancelado</small>
            <?php } ?>
            <?php if($status != 3){ ?>
               <div class="compra-cotas font-xs" id="compra-cotas-<?= $orderRow['id'] ?>">
                  <?php 
                  $type_of_draw = $orderRow['type_of_draw'];
                  if($type_of_draw > 1){
                     // Captura os números em uma variável para usar no contêiner
                     $numbersDisplay = leowp_format_luck_numbers($orderRow['o_numbers'], $orderRow['qty_numbers'], $class, $opt = true, $type_of_draw);
                     ?>
                     <div class="numbers-container">
                       <?= $numbersDisplay ?>
                     </div>
                     <div class="blur-container">
                       <div class="blur-overlay" id="blur-overlay-<?= $orderRow['id'] ?>"></div>
                     </div>
                  <?php
                  } elseif($type_of_draw == 1 && $status == 1 && $enable_hide_numbers == 1){
                     echo 'As cotas serão geradas após o pagamento.';
                  } else {
                     // Captura os números em uma variável para usar no contêiner
                     $numbersDisplay = leowp_format_luck_numbers($orderRow['o_numbers'], $orderRow['qty_numbers'], $class, $opt = true, $type_of_draw);
                     ?>
                     <div class="numbers-container">
                       <?= $numbersDisplay ?>
                     </div>
                     <div class="blur-container">
                       <div class="blur-overlay" id="blur-overlay-<?= $orderRow['id'] ?>"></div>
                     </div>
                  <?php
                  }
                  unset($_SESSION['phone']);
                  ?>              
               </div>
               <button type="button" class="expand-button" id="expand-button-<?= $orderRow['id'] ?>" onclick="toggleExpand('<?= $orderRow['id'] ?>')">
                 <i class="bi bi-eye"></i> Mostrar todos os números
               </button>
            <?php } ?>
      </div>
      <div class="col-auto">
        <i class="bi bi-chevron-right opacity-50"></i>
     </div>
     <div class="col-12 pt-2">
        <a href="/compra/<?= $orderRow['order_token'] ?>">
           <span class="btn <?= $btn; ?> btn-sm p-1 px-2 w-100 font-xss"><?php if($status == '1'){echo 'Efetuar pagamento';} ?><?php if($status == '2'){echo 'Visualizar compra';} ?><?php if($status == '3'){echo 'Compra cancelada';} ?><i class="bi bi-chevron-right"></i></span>
        </a>
     </div>
  </div>



</div>
</div>
<?php } ?>
<?php } ?>
<?php } ?>
</div>
</div>

<script>
  function toggleExpand(id) {
    const container = document.getElementById('compra-cotas-' + id);
    const button = document.getElementById('expand-button-' + id);
    const blurOverlay = document.getElementById('blur-overlay-' + id);
    
    if (container.classList.contains('expanded')) {
      container.classList.remove('expanded');
      button.innerHTML = '<i class="bi bi-eye"></i> Mostrar todos os números';
      // Mostrar o efeito de blur novamente
      blurOverlay.classList.remove('blur-hidden');
    } else {
      container.classList.add('expanded');
      button.innerHTML = '<i class="bi bi-eye-slash"></i> Ocultar números';
      // Esconder o efeito de blur
      blurOverlay.classList.add('blur-hidden');
    }
  }

  $(document).ready(function(){
    $('#modal-buscar').submit(function(e){
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
       console.log(err)
       alert('An error occurred')

    },
    success:function(resp){
       if(resp.status == 'success'){
         location.href = (resp.redirect)                                    
      }else{
        alert('Nenhum registro de compra foi encontrado')
        console.log(resp)
     }
  }
})
  })
 })
</script>