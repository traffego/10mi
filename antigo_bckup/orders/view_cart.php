<?php 
$product_id = 0;
$customer_id = $_settings->userdata('id');

if ($customer_id) {
    $stmt = $conn->prepare("SELECT c.product_id FROM `cart_list` c INNER JOIN product_list p ON c.product_id = p.id WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
        }
    } else {
        echo "<script>alert('Você não tem permissão para acessar essa página.'); location.replace('/');</script>";
        exit;
    }
    $stmt->close();
} else {
    echo "<script>alert('Você não tem permissão para acessar essa página.'); location.replace('/');</script>";
    exit;
}

?>
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
<div id="overlay">
    <div class="cv-spinner">
        <div class="card" style="border:none; padding:10px;background: transparent;color: #fff !important;font-weight: 800;">
            <span class="spinner mb-2" style="align-self:center;"></span>
            <div class="text-center font-xs">
                <div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <div class="flex items-center">
                        <h3 class="text-lg font-medium">Carregando <span class="dot dot-1">.</span><span class="dot dot-2">.</span><span class="dot dot-3">.</span></h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        Estamos gerando seu pedido, aguarde!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="app-main container">
    <div class="compra-status">
        <div class="app-alerta-msg mb-2">
            <i class="app-alerta-msg--icone bi bi-exclamation-circle text-danger"></i>
            <div class="app-alerta-msg--txt">
               <h3 class="app-alerta-msg--titulo">Cancelado!</h3>
               <p>Pedido cancelado</p>
            </div>
         </div>
        <hr class="my-2">
    </div>
    <div class="detalhes-compra">
        <div class="compra-sorteio mb-2">                 
        <?php 
        $order_items = $conn->query("SELECT p.name as product, p.price, p.qty_numbers, p.status_display, p.subtitle, p.image_path, p.slug, p.type_of_draw FROM `product_list` p where id = '{$product_id}' ");
        while($row = $order_items->fetch_assoc()):
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
        </div>
        <div class="alert alert-danger p-2 font-xss mb-2 mt-2">
            <i class="bi bi-info-circle"></i> 
                O prazo de pagamento expirou, resultando no cancelamento do seu pedido. Clique no botão abaixo para <b>repetir a compra</b>.
        </div>
        <button id="place_order" class="btn btn-success w-100 mb-2">REPETIR A COMPRA <i class="bi bi-cart-check"></i></button>
    </div>
    <div class="problems"><a class="font-xs text-muted" href="/contato">Problemas com sua compra? clique aqui.</a></div>
</div>
<?php endwhile; ?>

<script>
    $(function(){
        $('#place_order').click(function(){
            place_order();
        })
    })
    function place_order(){
        $('#overlay').fadeIn(300).css('display', 'inline-grid');

        $.ajax({
            url: _base_url_ + 'classes/Master.php?f=place_order',
            method: 'POST',
            data: {product_id: parseInt('<?php echo (isset($product_id) ? $product_id : ''); ?>')},
            dataType: 'json',
            error: err=>{
                //console.log(err)          
            },
            success: function(resp){
                if(resp.status == 'success'){ 
                    location.replace(resp.redirect)
                }else{
                    console.log(resp.error);
                    location.reload();
                }
            }
        })
    }
    $(document).ready(function() {
        setInterval(function() {
            //location.reload();
        }, 8000);  
    });
</script>