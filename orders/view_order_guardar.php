<?php 
$enable_hide_numbers = $_settings->info('enable_hide_numbers');

if(isset($_GET['id']) && $_GET['id'] > 0){
   $customer_id = $_settings->userdata('id') ? $_settings->userdata('id') : null;   

   $id_get = $_GET['id'];

   $stmt = $conn->prepare("
   SELECT 
      oi.*,
      p.cotapremiada,
      p.qty_numbers,
      (
         SELECT GROUP_CONCAT(DISTINCT LPAD(onum.number, FLOOR(LOG10(p.qty_numbers - 1)) + 1, '0') ORDER BY onum.number ASC) 
         FROM order_numbers onum 
         WHERE onum.order_id = oi.id
      ) AS o_numbers 
   FROM `order_list` oi
   JOIN `product_list` p ON oi.product_id = p.id
   WHERE oi.order_token = ?
   ");
   $stmt->bind_param("s", $id_get);
   $stmt->execute();
   $qry = $stmt->get_result();

   if($qry->num_rows > 0) {
      foreach($qry->fetch_assoc() as $k => $v){
         $$k = $v;
      }
   } else {
      if($customer_id) {

         $stmt = $conn->prepare("SELECT c.product_id, c.quantity FROM `cart_list` c INNER JOIN product_list p ON c.product_id = p.id WHERE customer_id = ?");
         $stmt->bind_param("i", $customer_id);     
         $stmt->execute();
     
         $result = $stmt->get_result();
     
         if ($result->num_rows > 0) {
             while ($row = $result->fetch_assoc()) {
                  $product_id = $row['product_id'];
                  $quantity = isset($quantity) ? $quantity : $row['quantity'];
                  //echo "<script>location.replace('/carrinho');</script>";
                  //exit;	
                  $status = '3';
             }
         } else {
             echo "<script>alert('Você não tem permissão para acessar essa página.'); location.replace('/');</script>";
             exit;
         }
         $stmt->close();         
      }else {
         echo "<script>alert('Você não tem permissão para acessar essa página.'); 
         location.replace('/');</script>";
         exit;
      }      
   }
}else{
	echo "<script>alert('Você não tem permissão para acessar essa página.'); 
   location.replace('/');</script>";
   exit;
}
//
$open_url = base_url .'classes/Master.php?f=check_order_status';
$check_url = array(
   'order_token' => $order_token
);
$options = array(
   'http' => array(
       'method' => 'POST',
       'header' => 'Content-type: application/x-www-form-urlencoded',
       'content' => http_build_query($check_url)
   )
);
$context = stream_context_create($options);
$resp = file_get_contents($open_url, false, $context);
$returnedData = json_decode($resp, true);
echo $returnedData;
if ($returnedData && $returnedData['status'] == '3' || $returnedData && $returnedData['status'] == 'deleted' || !$returnedData) {
   //header('Location: ' . $_SERVER['REQUEST_URI']);//exit;
   $status = '3';
}
?>
<div class="app-main container">
   <div class="compra-status">
      <?php if($status == '1'){ ?>
         <div class="app-alerta-msg mb-2">
            <i class="app-alerta-msg--icone bi bi-check-circle text-warning"></i>
            <div class="app-alerta-msg--txt">
               <h3 class="app-alerta-msg--titulo">Aguardando Pagamento!</h3>
               <p>Finalize o pagamento</p>
            </div>
         </div>
      <?php } ?>

      <?php if($status == '2'){ ?>
         <div class="app-alerta-msg mb-2">
            <i class="app-alerta-msg--icone bi bi-check-circle text-success"></i>
            <div class="app-alerta-msg--txt">
               <h3 class="app-alerta-msg--titulo">Compra Aprovada!</h3>
               <p>Agora é só torcer!</p>
            </div>
         </div>
      <?php } ?>

      <?php if($status == '3'){ ?>
         <div class="app-alerta-msg mb-2">
            <i class="app-alerta-msg--icone bi bi-exclamation-circle text-danger"></i>
            <div class="app-alerta-msg--txt">
               <h3 class="app-alerta-msg--titulo">Cancelado!</h3>
               <p>Pedido cancelado</p>
            </div>
         </div>
      <?php } ?>

      <hr class="my-2">
   </div>
   <?php if($status == '1'){ ?>
      <div class="compra-pagamento">
         <div class="pagamentoQrCode text-center">
            <div class="pagamento-rapido">
               <div class="app-card card rounded-top rounded-0 shadow-none border-bottom">
                  <div class="card-body">
                     <div class="pagamento-rapido--progress">
                      <div class="d-flex justify-content-center align-items-center mb-1 font-md">
                       <div><small>Você tem</small></div>
                       <div class="mx-1"><b class="font-md" id="tempo-restante"></b></div>
                       <div><small>para pagar</small></div>
                    </div>
                    <div class="progress bg-dark bg-opacity-50">
                       <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="barra-progresso"></div>
                    </div>
                 </div>                  

              </div>
           </div>
        </div>
        <div class="app-card card rounded-bottom rounded-0 rounded-bottom b-1 border-dark mb-2">
         <div class="card-body">
            <div class="row justify-content-center mb-2">
               <div class="col-12 text-start">
                  <div class="mb-1"><span class="badge bg-success badge-xs">1</span><span class="font-xs"> Copie o código PIX abaixo.</span></div>
                  <div class="input-group mb-2">
                     <input id="pixCopiaCola" type="text" class="form-control" value="<?= $pix_code; ?>">
                     <div class="input-group-append">
                        <button onclick="copyPix()" class="app-btn btn btn-success rounded-0 rounded-end">Copiar</button>
                     </div>
                  </div>
                  <div class="mb-2"><span class="badge bg-success">2</span> <span class="font-xs">Abra o app do seu banco e escolha a opção PIX, como se fosse fazer uma transferência.</span></div>
                  <p><span class="badge bg-success">3</span> <span class="font-xs">Selecione a opção PIX cópia e cola, cole a chave copiada e confirme o pagamento.</span></p>
               </div>
               <div class="col-12 my-2">
                  <p class="alert alert-warning p-2 font-xss" style="text-align: justify;">Este pagamento só pode ser realizado dentro do tempo, após este período, caso o pagamento não for confirmado os números voltam a ficar disponíveis.</p>
               </div>
               <div class="col-12">
                  <a href="">
                     <button class="app-btn btn btn-success btn-sm" disabled=""><i class="bi bi-check-all"></i> Já fiz o pagamento</button>
                  </a>
               </div>
            </div>
            <hr>
            <div class="row justify-content-center">
               <div class="col-8">
                  <div class="d-block text-center">
                     <?php 
                        if ($payment_method == 'MercadoPago') {
                           echo '<div id="img-qrcode" class="d-inline-block bg-white rounded w-50">' . "\r\n";
                           echo '<img src="data:image/png;base64,' . $pix_qrcode . '" class="img-fluid">' . "\r\n";
                           echo '</div>' . "\r\n";
                       } else {
                           echo '<div id="img-qrcode" class="d-inline-block bg-white rounded w-50">' . "\r\n";
                           echo '<img src="https://chart.googleapis.com/chart?chs=290x290&amp;cht=qr&amp;chl=' . $pix_code . '&amp;chld=H%7C1" class="img-fluid">' . "\r\n";
                           echo '</div>' . "\r\n";
                       }
                     ?>
                  </div>
               </div>
               <div class="col-12 pb-3">
                  <div class="font-xss">
                     <h5><i class="bi bi-qr-code"></i> QR Code</h5>
                     <div>Acesse o APP do seu banco e escolha a opção pagar com QR Code, escaneie o código ao lado e confirme o pagamento.</div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="alert alert-info p-2 font-xss mb-2"><i class="bi bi-info-circle"></i> Após o pagamento aguarde até 5 minutos para a confirmação, caso já tenha efetuado o pagamento, clique no botão <b>Já fiz o pagamento</b>.</div>
   </div>
   <hr class="my-2">
</div>
<?php } ?>
<div class="detalhes-compra">
   <div class="compra-sorteio mb-2">                 
    <?php 
    $gt = 0;
    if($status == '3'){
         $order_items = $conn->query("SELECT p.name as product, p.price, p.qty_numbers, p.status_display, p.subtitle, p.image_path, p.slug, p.type_of_draw FROM `product_list` p where id = '{$product_id}' ");
    }else{
         $order_items = $conn->query("SELECT o.*, p.name as product, p.price, p.qty_numbers, p.status_display, p.subtitle, p.image_path, p.slug, p.type_of_draw FROM `order_items` o inner join product_list p on o.product_id = p.id where order_id = '{$id}' ");
    }
    //$order_items = $conn->query("SELECT o.*, p.name as product, p.price, p.qty_numbers, p.status_display, p.subtitle, p.image_path, p.slug, p.type_of_draw FROM `order_items` o inner join product_list p on o.product_id = p.id where order_id = '{$id}' ");
    while($row = $order_items->fetch_assoc()):
         if($status != '3'){
            $gt += $row['price'] * $row['quantity'];
         }
      ?>

      <div class="SorteioTpl_sorteioTpl__2s2Wu   pointer">
         <div class="SorteioTpl_imagemContainer__2-pl4 col-auto ">
            <div style="display: block; overflow: hidden; position: absolute; inset: 0px; box-sizing: border-box; margin: 0px;">
               <img alt="Pop 110i 2022 0km" src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" class="SorteioTpl_imagem__2GXxI" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
               <noscript></noscript>
            </div>
         </div>

         <div class="SorteioTpl_info__t1BZr">
            <h1 class="SorteioTpl_title__3RLtu"><a href="/sorteio/<?= $row['slug'] ?>"><?= $row['product'] ?></a></h1>
            <p class="SorteioTpl_descricao__1b7iL" style="margin-bottom: 1px;"><?php echo isset($row['subtitle']) ? $row['subtitle'] : ''; ?></p>
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

         </div>
      </div>
      <?php 
      if($status == '3') { ?>
            <div class="alert alert-danger p-2 font-xss mt-2 mb-2">
               <i class="bi bi-info-circle"></i> 
                  O prazo de pagamento expirou, resultando no cancelamento do seu pedido. Clique no botão abaixo para <b>repetir a compra</b>.
            </div>
            <?php
            $quantity = isset($quantity) ? $quantity : null;
            $customer_id = $_settings->userdata('id');
            $check = $conn->query("SELECT id FROM `cart_list` WHERE customer_id = '{$customer_id}' AND quantity = '{$quantity}'")->num_rows;
            if($customer_id && $check > 0) { ?>
               <button id="place_order" class="btn btn-success w-100 mb-0">REPETIR A COMPRA <i class="bi bi-cart-check"></i></button>                 
            <?php } else { ?>
               <a  href="<?php echo base_url ?>sorteio/<?php echo $row['slug'] ?>" class="btn btn-success w-100 mb-0">VOLTAR AO SORTEIO <i class="bi bi-cart-check"></i></a>  
            <?php } ?>                
      <?php } ?>
   </div>
   <?php if($status != '3'){?>
   <div class="detalhes app-card card mb-2">
      <div class="card-body font-xs">
         <div class="font-xs opacity-75 mb-2">
            <i class="bi bi-info-circle"></i> Detalhes da sua compra&nbsp;
            <div class="pt-1 opacity-50"><?= isset($order_token) ? $order_token : '' ?></div>
         </div>
         <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1">
            <div class="title font-weight-500 me-1">Comprador:</div>
            <div class="result font-xs">
               <?php 
               $customerQuery = $conn->query("SELECT firstname, lastname, phone FROM `customer_list` WHERE id = '{$customer_id}'");

               if ($customerQuery && $customerQuery->num_rows > 0) {
                $customer = $customerQuery->fetch_assoc();
                $firstname = $customer['firstname'];
                $lastname = $customer['lastname'];
                $phone = $customer['phone'];

             }
             $firstname = ucwords($firstname); 
             $lastname = ucwords($lastname); 
             echo $firstname.' '.$lastname.'';
             ?>

          </div>
       </div>
       <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1">
         <div class="title font-weight-500 me-1">Telefone:</div>
         <div class="result font-xs"><?= formatPhoneNumber($phone); ?></div>
      </div>
      <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1">
         <div class="title font-weight-500 me-1">Data/horário:</div>
         <div class="result font-xs"><?php echo date("d-m-Y H:i",strtotime($date_created)) ?></div>
      </div>
      <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1">
         <div class="title font-weight-500 me-1">Situação:</div>
         <div class="result font-xs">
            <?php 
            $status = isset($status) ? $status : '';
            switch($status){
               case 1:
               echo 'Aguardando Pagamento';
               break;
               case 2:
               echo 'Pago';
               break;
               case 3:
               echo 'Cancelado';
               break;
            }
            ?>                         

         </div>
      </div>
      <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1">
         <div class="title font-weight-500 me-1">Qtd. Cotas:</div>
         <div class="result font-xs"><?= $quantity; ?></div>
      </div>
      <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1">
         <div class="title font-weight-500 me-1">Total:</div>
         <div class="result font-xs">R$ <?= number_format($total_amount,2, ',', '.'); ?></div>
      </div>     
      <?php 
      //ob_start(); // Inicia a captura de saída 
      $mensagem = '';
      // Array para armazenar os números premiados encontrados
      $numeros_premiados = [];

      // Verificar o status de pagamento na tabela 'order_list'
      $stmt_status = $conn->prepare("SELECT status FROM order_list WHERE order_token = ?");
      $stmt_status->bind_param("s", $_GET['id']);
      $stmt_status->execute();
      $result_status = $stmt_status->get_result();
      $row_status = $result_status->fetch_assoc();

      // Verifica se o status da ordem é 'pago'
      if($row_status['status'] == 2){    
         
         $data_aw = json_decode($cotapremiada, true);
         if ($data_aw) {
            foreach ($data_aw as $linha) {
               $aw_number = $linha['aw_number'];
               $aw_locked = $linha['aw_locked'];
               if ($aw_locked == false) {         
                  $aw_number = ltrim($aw_number, '0');
                  if ($aw_number === '') {
                     $aw_number = 0; // Se o número for '000000', ele se torna ''
                  }
                  // Iterar sobre cada número comprado e verificar se algum deles é o número premiado
                  $stmt = $conn->prepare("
                     SELECT EXISTS (
                        SELECT 1 
                        FROM order_numbers onum 
                        JOIN order_list oi ON onum.order_id = oi.id 
                        WHERE oi.order_token = ? AND onum.number = ?
                     ) AS number_exists
                  ");
                  $stmt->bind_param("ss", $_GET['id'], $aw_number);
                  $stmt->execute();
                  $qry = $stmt->get_result();
                  $row_exists = $qry->fetch_assoc();
                  $number_exists = $row_exists['number_exists'];
   
                  if ($number_exists) {
                     // Adiciona o número ao array de números premiados
                     $numeros_premiados[] = str_pad($aw_number, strlen($qty_numbers-1), '0', STR_PAD_LEFT);
                  }
               }         
            }
         }       
         if(!empty($numeros_premiados)){
               $quantidade_premiados = count($numeros_premiados);
               $numeros_encontrados = implode(', ', $numeros_premiados);
               $mensagem = "<div class='alert alert-success text-center mb-0'>Parabéns, você encontrou $quantidade_premiados números premiados!<br>Números: $numeros_encontrados.</div>";
         } else {
               $mensagem = "<div class='alert alert-info mb-0'>Nenhum dos seus números foi premiado.</div>";
         }
      } else {
         $mensagem = "<div class='alert alert-warning mb-0'>O pagamento da sua cota ainda está pendente.</div>";
      }
      if($status != '3') {
         echo $mensagem; 
      }?>
      <div class="item d-flex align-items-baseline mb-1 pb-1 border-bottom-rgba border-1"></div>
      <div class="item d-flex align-items-baseline">      
         <div class="title font-weight-500 me-1">Cotas:</div>
         <div class="result font-xs" data-nosnippet="true" style="overflow: auto;max-height: 250px;">
         <?php               
               ob_start(); // Inicia a captura de saída

               $type_of_draw = $row['type_of_draw']; 
               if($type_of_draw > 1){
                  echo leowp_format_luck_numbers($o_numbers, $row['qty_numbers'], $class = 'bg-warning', $opt = false, $type_of_draw);
               }elseif($type_of_draw == 1 && $status == 1 && $enable_hide_numbers == 1){            
                  echo 'As cotas serão geradas após o pagamento.';
               }else{
                  echo leowp_format_luck_numbers($o_numbers, $row['qty_numbers'], $class = 'bg-warning', $opt = false, $type_of_draw);
               } 
                                    
               // Suponha que $o_numbers seja uma string de números separados por vírgula, como "123,456,789"
               //$numero_comprado = $o_numbers;
               // Dividir a string em um array de números, removendo espaços em branco e elementos vazios
               //$numeros_comprados = array_filter(array_map('trim', explode(',', $numero_comprado)));                     
                        
               $saida = ob_get_clean(); // Obtém o conteúdo capturado
               echo $saida;
               ?> 
         </div>
   </div>

   </div>
</div>
<?php }?>
</div>
<div class="problems"><a class="font-xs text-muted" href="/contato">Problemas com sua compra? clique aqui.</a></div>
</div>
</div>
<?php endwhile; ?>

<script>
   function place_order(){
      $('#overlay').fadeIn(300);
      $.ajax({
         url: _base_url_ + 'classes/Master.php?f=place_order',
         method:'POST',
         data:{product_id: parseInt('<?php echo (isset($product_id) ? $product_id : ''); ?>')},
         dataType:'json',
         error:err=>{
               //console.log(err)          
         },
         success:function(resp){
               if(resp.status == 'success'){ 
                  location.replace(resp.redirect)
               }else{
                  console.log(resp.error);
                  location.reload();
               }
         }
      })
   }
   function copyPix() {
      var copyText = document.getElementById("pixCopiaCola");

      copyText.select();
      copyText.setSelectionRange(0, 99999); 

      document.execCommand("copy");
      navigator.clipboard.writeText(copyText.value);

      alert("Chave pix 'Copia e Cola' copiada com sucesso!");
   }  
   $(document).ready(function() {          
          
      $('#place_order').click(function(){
         place_order();
      });

      var tempoInicial = <?= isset($order_expiration) ? $order_expiration : 15 ?>;
      var dataDefault = '<?= isset($date_created) ? date("c", strtotime($date_created)) : date("Y-m-d H:i:s") ?>';
      var dataStatus = <?= isset($status) ? $status : null ?>;

      var dataReferencia = new Date(dataDefault);
      if (isNaN(dataReferencia.getTime())) {
         console.error("Data padrão inválida:", dataDefault);
         return;
      }

      dataReferencia.setMinutes(dataReferencia.getMinutes() + tempoInicial);

      function atualizarTimer() {
         var diferencaMilissegundos = dataReferencia - new Date();

         if (diferencaMilissegundos <= 0) {
               clearInterval(timerInterval);
               $('#tempo-restante').text('00:00');
               return;
         }

         var minutos = Math.floor(diferencaMilissegundos / (1000 * 60));
         var segundos = Math.floor((diferencaMilissegundos % (1000 * 60)) / 1000);

         var tempoFormatado = minutos.toString().padStart(2, '0') + ':' + segundos.toString().padStart(2, '0');
         $('#tempo-restante').text(tempoFormatado);

         var tempoTotalMilissegundos = tempoInicial * 60 * 1000;
         var progresso = ((tempoTotalMilissegundos - diferencaMilissegundos) / tempoTotalMilissegundos) * 100;
         $('#barra-progresso').css('width', progresso + '%').attr('aria-valuenow', progresso);
      }

      atualizarTimer();
      var timerInterval = setInterval(atualizarTimer, 1000);

   }); 
   $(document).ready(function() {
         //var tempoInicial = parseInt(''); 
         //var token = '';
         //var progressoMaximo = 100;
         //var tempoRestante;

         //if (localStorage.getItem(token)) {
            //tempoRestante = parseInt(localStorage.getItem(token));
         //} else {
            //tempoRestante = tempoInicial * 60;
            //localStorage.setItem(token, tempoRestante);
         //}

         //var intervalo = setInterval(function() {
            //var minutos = Math.floor(tempoRestante / 60);
            //var segundos = tempoRestante % 60;
            //var tempoFormatado = minutos.toString().padStart(2, '0') + ':' + segundos.toString().padStart(2, '0');    
            //$('#tempo-restante').text(tempoFormatado);
            //var progresso = ((tempoInicial * 60 - tempoRestante) / (tempoInicial * 60)) * progressoMaximo;
            //$('#barra-progresso').css('width', progresso + '%').attr('aria-valuenow', progresso);
            //tempoRestante--;
            //localStorage.setItem(token, tempoRestante);
            //if (tempoRestante < 0) {
               //clearInterval(intervalo);
               //localStorage.removeItem(token);
            //}
            //}, 1000);

         <?php if($status == 1){ ?>

            setInterval(function() {
               var check = {
                  order_token: '<?php echo $order_token; ?>'
               };

               $.ajax({
                  type: 'POST',
                  url: _base_url_ + "classes/Master.php?f=check_order_status",
                  data: check,
                  error: err=>{
                     console.log(err)          
                  },
                  success: function(resp) {
                     var returnedData = JSON.parse(resp);

                     if (returnedData && returnedData.status != '1' || returnedData.status == 'deleted' || !returnedData) {
                        location.reload();
                     }

                     if (returnedData.msg) {
                        console.log(returnedData.msg);
                     }
                  }
               });
            }, 3000);

         <?php } ?>     
   });

</script>