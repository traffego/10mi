<?php
if(isset($_GET['id']) && $_GET['id'] > 0) {
    //View root
    $paid_n = 0;
    $pending_n = 0;

    $stmt_product = $conn->prepare('SELECT * FROM product_list WHERE slug = ?');
    $stmt_product->bind_param('s', $_GET['id']);
    $stmt_product->execute();
    $result_product = $stmt_product->get_result();

    if ($result_product->num_rows > 0) {
        $row_product = $result_product->fetch_assoc();
        foreach ($row_product as $k => $v) {
            $$k = $v;
            $product_data[$k] = $v;
        }

        $stmt = $conn->prepare('SELECT * FROM product_order_status WHERE product_id = ?');
        $stmt->bind_param('i', $product_data['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $paid_n = $row['paid'];
            $pending_n = $row['pending'];
          }
        } 
        $stmt->close();
    } else {
        echo "<script>alert('Você não tem permissão para acessar essa página.'); 
        location.replace('./');
        </script>";
        exit;
    }
    $stmt_product->close();

} else {
        echo "<script>alert('Você não tem permissão para acessar essa página.');
        location.replace('./');
        </script>";
        exit;
}

if($date_of_draw) {
      $expirationTime = date('Y-m-d H:i:s', strtotime($date_of_draw));
      $currentDateTime = date('Y-m-d H:i:s');

      if ($currentDateTime > $expirationTime) {
        $selectStatement = "SELECT * FROM product_list WHERE id = '{$id}'";
        $selectResult = $conn->query($selectStatement);
        if ($selectResult->num_rows > 0) {
          $updatePendingStatements = $conn->query("UPDATE product_list SET status = '3', status_display = '4' WHERE id = '{$id}'");     
        } 
      }
}
if($type_of_draw == '1') { #Automático
    require_once('automatic.php');
}
if($type_of_draw == '2') { #Normal
    require_once('numbers.php');
}
if($type_of_draw == '3') { # Fazendinha Inteira
    require_once('farm.php');
}
if($type_of_draw == '4') { # Fazendinha Metade
    require_once('half-farm.php');
}
?>
