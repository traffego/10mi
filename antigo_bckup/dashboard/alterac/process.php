<html>
    <head>
        <title>
            
        </title>
        
        <style>
            /* Resetando margens e padding para garantir consistência */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilização do corpo da página */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    line-height: 1.6;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Estilização do contêiner principal */
.container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    text-align: center;
}

/* Estilização do título */
h1 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #28a745;
}

/* Estilização da mensagem */
.message {
    margin-bottom: 20px;
    font-size: 18px;
}

/* Estilização do botão de voltar */
button {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
}

button:hover {
    background-color: #218838;
}

        </style>
    </head>
</html>
<?php
include('db_config.php');

if (isset($_POST['atualizar'])) {
    $sorteio_id = $_POST['sorteio_id'];
    $pedido_id = $_POST['pedido'];
    $cota_premiada_numero = $_POST['cota_premiada'];

    // Verificar se a cota premiada já foi comprada no pedido selecionado
    $verifica_cota = $conn->query("
        SELECT * 
        FROM order_numbers 
        WHERE order_id = $pedido_id AND product_id = $sorteio_id AND number = $cota_premiada_numero
    ");

    if ($verifica_cota->num_rows > 0) {
        echo "<script>alert('A cota premiada selecionada já está associada a este pedido.'); window.location.href = 'form.php';</script>";
        exit();
    }

    // Atualizar JSON cotapremiada
    $result = $conn->query("SELECT cotapremiada FROM product_list WHERE id = $sorteio_id");
    $row = $result->fetch_assoc();
    $cotas_premiadas = json_decode($row['cotapremiada'], true);

    foreach ($cotas_premiadas as &$cota) {
        if ($cota['aw_number'] == $cota_premiada_numero) {
            $cota['aw_locked'] = false;
            $cota['aw_view'] = true;
        }
    }

    $cotas_premiadas_json = $conn->real_escape_string(json_encode($cotas_premiadas));
    $conn->query("UPDATE product_list SET cotapremiada = '$cotas_premiadas_json' WHERE id = $sorteio_id");

    // Selecionar aleatoriamente uma linha na tabela order_numbers
    $result = $conn->query("SELECT * FROM order_numbers WHERE order_id = $pedido_id AND product_id = $sorteio_id ORDER BY RAND() LIMIT 1");
    $row = $result->fetch_assoc();
    $old_number = $row['number'];
    $conn->query("UPDATE order_numbers SET number = $cota_premiada_numero WHERE order_id = $pedido_id AND product_id = $sorteio_id AND number = $old_number");

    echo "Cota premiada atualizada com sucesso!";
}

$conn->close();
?>
