<?php include('db_config.php');?>
<?php 
$authenticated = false;
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Supondo que as senhas estão armazenadas como MD5 na tabela users

    $result = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password' AND type = 1");

    if ($result->num_rows > 0) {
        $authenticated = true;
    } else {
        $error_message = "Usuário ou senha inválidos.";
    }
}

if (!$authenticated) {

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Atualização de Cotas Premiadas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Altera Cota</h1>
<?php
$sorteios = $conn->query("SELECT id, name FROM product_list");
?>

<form method="POST" action="form.php">
    <label for="sorteio">Selecione o Sorteio:</label>
    <select name="sorteio" id="sorteio" onchange="this.form.submit()">
        <option value="">--Selecione--</option>
        <?php while($row = $sorteios->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>" <?= isset($_POST['sorteio']) && $_POST['sorteio'] == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select>
</form>
</br>
<?php
if (isset($_POST['sorteio'])) {
    $sorteio_id = $_POST['sorteio'];

    // Buscar todas as cotas premiadas
    $cotas_premiadas_result = $conn->query("SELECT cotapremiada FROM product_list WHERE id = $sorteio_id")->fetch_assoc();
    $cotas_premiadas = json_decode($cotas_premiadas_result['cotapremiada'], true);
    $cotas_premiadas_numeros = array_column($cotas_premiadas, 'aw_number');

    // Buscar IDs de pedidos que já possuem cotas premiadas
    $pedidos_com_cotas_premiadas_ids = [];
    if (!empty($cotas_premiadas_numeros)) {
        $cotas_premiadas_str = implode(",", array_map('intval', $cotas_premiadas_numeros));
        $result = $conn->query("
            SELECT DISTINCT ol.id
            FROM order_list ol
            JOIN order_numbers onr ON ol.id = onr.order_id
            WHERE ol.product_id = $sorteio_id AND onr.number IN ($cotas_premiadas_str)
        ");
        while ($row = $result->fetch_assoc()) {
            $pedidos_com_cotas_premiadas_ids[] = $row['id'];
        }
    }

    // Listar os últimos 20 pedidos relacionados ao sorteio com status "paid" (2), excluindo aqueles que já possuem cotas premiadas
    $pedidos = $conn->query("
        SELECT ol.id, ol.code, cl.firstname, cl.lastname, ol.date_created 
        FROM order_list ol 
        JOIN customer_list cl ON ol.customer_id = cl.id 
        WHERE ol.product_id = $sorteio_id AND ol.status = 2 
        " . (empty($pedidos_com_cotas_premiadas_ids) ? "" : "AND ol.id NOT IN (" . implode(",", $pedidos_com_cotas_premiadas_ids) . ")") . "
        ORDER BY ol.date_created DESC 
        LIMIT 20
    ");
    ?>

    <form method="POST" action="process.php">
        <input type="hidden" name="sorteio_id" value="<?= $sorteio_id ?>">
        
        <label for="pedido">Selecione o Pedido:</label>
        <select name="pedido" id="pedido">
            <option value="">--Selecione--</option>
            <?php while($row = $pedidos->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['date_created'] ?> - <?= $row['firstname'] ?> <?= $row['lastname'] ?></option>
            <?php endwhile; ?>
        </select>
        
        <label for="cota_premiada">Selecione a Cota Premiada:</label>
        <select name="cota_premiada" id="cota_premiada">
            <option value="">--Selecione--</option>
            <?php foreach($cotas_premiadas as $cota): ?>
                <?php if (!$cota['aw_view']): // Filtra as cotas premiadas que não foram encontradas ?>
                    <option value="<?= $cota['aw_number'] ?>"><?= $cota['aw_label'] ?> (<?= $cota['aw_number'] ?>)</option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" name="atualizar">Atualizar Cota Premiada</button>
    </form>
<?php } ?>
</div>
<?php } ?>
</body>
</html>

<?php $conn->close(); ?>
