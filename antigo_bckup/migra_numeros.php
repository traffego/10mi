<?php require_once('config.php'); ?>
<?php
global $_settings;
$product_id = "75";
$order_id = "197";
$quantity = $_GET['qtd'];

$stmt_plist = $conn->prepare('SELECT name, qty_numbers, max_purchase, limit_order_remove, type_of_draw, cotapremiada FROM `product_list` WHERE id = ?');
$stmt_plist->bind_param('i', $product_id);
$stmt_plist->execute();
$product_list = $stmt_plist->get_result();

if ($product_list->num_rows > 0) {
    $product = $product_list->fetch_assoc();
    $qty_numbers = $product['qty_numbers'];
    $max_purchase = $product['max_purchase'];
    $cotapremiada = $product['cotapremiada'];
    $qty_numbers = $qty_numbers - 1;
}

/////////// TESTE
// Verificação da disponibilidade de um número
//if ($this->root_check_number($product_id, $number_to_check)) {
    //echo "O número $number_to_check está disponível.";
//} else {
    //echo "O número $number_to_check já foi comprado.";
//}


// Consulta para buscar todos os registros da tabela order_list
$sql = "SELECT id, code, quantity, product_id, order_numbers FROM order_list WHERE order_numbers IS NOT NULL AND status <> 3";
$result = $conn->query($sql);
$order_date = date('Y-m-d H:i:s');

$stmt_migrate = $conn->prepare("INSERT INTO order_numbers (order_id, product_id, number) VALUES (?, ?, ?)");
$inserted_count = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['id'];
        $code = $row['code'];
        $quantity = $row['quantity'];
        $product_id = $row['product_id'];
        $order_numbers = $row['order_numbers'];

        $numbers = explode(',', $order_numbers);

        $numbers = array_map('trim', $numbers);

        if (isset($order_numbers) && !empty($order_numbers)) {
            foreach ($numbers as $number) {
                // Remover zeros à esquerda, gravar '000000' como '0'
                if (ctype_digit($number)) {
                    $number = ltrim($number, '0');
                    if ($number === '') {
                        $number = 0; // Se o número for '000000', ele se torna ''
                    }
                } else {
                    continue; // Ignorar valores não numéricos
                }
    
                echo 'order: ' . $order_id . ' add: ' . $number . '</br>';
    
                $stmt_migrate->bind_param("iii", $order_id, $product_id, $number);
                if ($stmt_migrate->execute()) {
                    $inserted_count++;
                } else {
                    throw new Exception("Falha na execução da instrução: " . $stmt_migrate->error);
                }
            }
    
            if ($inserted_count > 0) {
                // Verifica se todos os números foram inseridos
                $stmt_count = $conn->prepare("SELECT COUNT(DISTINCT number) as total FROM order_numbers WHERE order_id = ?");
                $stmt_count->bind_param("i", $order_id);
                $stmt_count->execute();
                $result_count = $stmt_count->get_result();
                $row_count = $result_count->fetch_assoc();
                $total_unique_numbers = $row_count['total'];
                $stmt_count->close();
    
                if ($total_unique_numbers != $quantity) {
                    // Exclui todos os números do pedido se a quantidade não for igual
                    $stmt_delete = $conn->prepare("DELETE FROM order_numbers WHERE order_id = ?");
                    $stmt_delete->bind_param("i", $order_id);
                    $stmt_delete->execute();
                    $stmt_delete->close();
                    
                    echo 'Não foi possível copiar os números do pedido ' . $order_id . ' para order_numbers.</br>';
                    $conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('CRON', 'Não foi possível copiar os números do pedido #$order_id para order_numbers.', '$order_date')");
                } else {
                    $conn->query("UPDATE `order_list` SET `order_numbers` = '' WHERE `id` = '$order_id'");
                    $conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('CRON', 'Todos os números do pedido #$order_id foram copiados para order_numbers.', '$order_date')");
                }
            }            
        }
    }
}
//$conn->close();
echo "Total de números inseridos com sucesso: " . $inserted_count;