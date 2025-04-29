 <?php 
 $enable_hide_numbers = $_settings->info('enable_hide_numbers');
if($_settings->userdata('id') != '' && $_settings->userdata('id') != 2){
    $qry = $conn->query("SELECT * FROM `customer_list` where id = '{$_settings->userdata('id')}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_array() as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }
}else{
    echo "<script>alert('Você não tem permissão para acessar essa página'); 
    location.replace('/');</script>";
    exit;
}
?>
<div class="container app-main">
    <div class="app-title mb-3">
        <h1>🛒 Compras</h1>
        <div class="app-title-desc">recentes</div>
    </div>
    <div>
        <?php 
            $i = 1;
            //
            // Consulta para obter os dados dos itens do pedido e a quantidade da tabela order_list
            //

            $customer_id = $_settings->userdata('id');

            $stmt = $conn->prepare("
                SELECT 
                    o.*, 
                    p.image_path, 
                    p.qty_numbers, 
                    oi.product_id, 
                    p.type_of_draw
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

            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $order_items = $stmt->get_result();            

            while ($row = $order_items->fetch_assoc()):
            //
            ?>
            <?php              
                $class = '';
                $border = '';
                $btn = '';
                $status = $row['status'];
                if($row['status'] == '1'){
                $class = 'bg-warning';
                $border = 'border-warning';
                $btn = 'btn-warning';
                }
                if($row['status'] == '2'){
                $class = 'bg-success';
                $border = 'border-success';
                $btn = 'btn-success';
                }
                if($row['status'] == '3'){
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
                                    <img src="<?= validate_image($row['image_path']) ?>" decoding="async" data-nimg="fill" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;">
                                    <noscript></noscript>
                                </div>
                            </div>
                        </div>
                        <div class="col ps-2">
                            <small class="compra-data font-xss opacity-50"><?= date("d-m-Y H:i", strtotime($row['date_created'])) ?></small>
                            <div class="compra-title font-weight-500"><?= $row['product_name'] ?></div>
                                <?php if($status == '1'){ ?>
                                <small class="font-xss opacity-75 text-uppercase">Aguardando Pagamento</small>
                                <?php } ?>
                                <?php if($status == '2'){ ?>
                                <small class="font-xss opacity-75 text-uppercase">Pago</small>
                                <?php } ?>
                                <?php if($status == '3'){ ?>
                                <small class="font-xss opacity-75 text-uppercase">Cancelado</small>
                                <?php } ?>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-chevron-right opacity-50"></i>
                        </div>
                        <div class="col-12 pt-2">
                            <a href="/compra/<?= $row['order_token'] ?>">
                                <span class="btn <?= $btn; ?> btn-sm p-1 px-2 w-100 font-xss"><?php if($status == '1'){echo 'Efetuar pagamento';} ?><?php if($status == '2'){echo 'Ver detalhes da compra';} ?><?php if($status == '3'){echo 'Compra cancelada';} ?> <i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; 
            $stmt->close(); ?>
    </div>
    <div class="row">
        <div class="col"></div>
        <div class="col"></div>
    </div>
</div>