<?php 
header('Content-Type: application/json');
$root_dir = $_SERVER['DOCUMENT_ROOT'];
//require_once $root_dir . '/config.php';
require_once $root_dir . '/classes/Master.php';
$master = new Master();

#SE A EXPIRAÇÃO DOS PEDIDOS NÃO ACONTECER AUTOMATICAMENTE PRECISA DEFINIR MANUALMENTE AQUI O DIRETÓRIO ROOOT
#require_once('/home/u551616191/domains/realizapremiacoes.com/public_html/config.php'); 

$sql = 'SELECT `date_created`, `order_expiration`, `status`, `product_id`, `quantity`, `id`, `id_mp` FROM `order_list` WHERE `status` <> 2';
$result = $conn->query($sql);
$payment_date = date('Y-m-d H:i:s');
$resp = array(
    'log' => array()
);

if (0 < $result->num_rows) {
    $pid = [];
    $updatePendingStatements = [];
    $deleteOrderStatements = [];

    while ($row = $result->fetch_assoc()) {
        $dateCreated = $row['date_created'];
        $orderExpiration = $row['order_expiration'];
        $status_order = $row['status'];
        $product_id = $row['product_id'];
        $pid[] = $row['product_id'];
        $quantity = $row['quantity'];
        $order_id = $row['id'];
        $id_mp = $row['id_mp'];
        $expirationTime = date('Y-m-d H:i:s', strtotime($dateCreated . ' + ' . $orderExpiration . ' minutes'));
        $currentDateTime = date('Y-m-d H:i:s');
        if (($expirationTime < $currentDateTime) && 0 < $orderExpiration) {

            if (($id_mp) && ($master->check_order_mp($order_id, $id_mp) == 'approved') && ($status_order == '1')) {
                $insert = $conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('CRON', 'Pedido $order_id não DELETADO, consta como PAGO no MP', '$payment_date')");
                $resp['log'][] = 'Pedido #' .$order_id. ' não DELETADO, consta como PAGO no MP.';
			} else {
				$updatePendingStatements[] = 'UPDATE order_list SET status = 3, date_updated = \'' . $currentDateTime . '\' WHERE id = \'' . $order_id . '\'';

                $result_json = $master->check_order_expired($order_id);
                $result_array = json_decode($result_json, true);
            
                if (isset($result_array['action']) && $result_array['action'] === 'success') {
                    $deleteOrderStatements[] = "DELETE FROM order_list WHERE id = '{$order_id}'";                    
                    $insert = $conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('CRON', 'Pedido $order_id DELETADO pelo CRON', '$payment_date')");
                    $resp['log'][] = 'Pedido #' .$order_id. ' DELETADO pelo CRON.';
                }
            }
            continue;            
           
        }else{
            $resp['log'][] = 'Pedido #' .$order_id. ' válido!';
        }
        
    }
    
    $conn->begin_transaction();
    
    try {
        foreach ($updatePendingStatements as $updateStatement) {
            $conn->query($updateStatement);
        }
        
        foreach ($deleteOrderStatements as $deleteStatement) {
            $conn->query($deleteStatement);
        }
        
        $conn->commit();

        if ($pid) {
			$pid = array_unique($pid);

			foreach ($pid as $id) {
				$master->revert_product($id);
			}
		}

        $insert = $conn->query("INSERT INTO `logs` (`origin`, `description`, `date`) VALUES ('CRON', 'Atualizações e exclusões realizadas com sucesso.', '$payment_date')");
        $resp['log'][] = 'Limpeza realizada com sucesso!';
    }
    catch (Exception $e) {
        $conn->rollback();
        $resp['log'][] = 'Erro ao processar o CRON: ' . $e->getMessage();
	}    
}
else {
    $resp['log'][] = 'Não há pedidos a serem processados.';
}
echo json_encode($resp);
?>