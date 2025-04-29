<?php
$servername = "localhost";
$username = "platafo5_uraffle";
$password = "Rifas333444#";
$dbname = "platafo5_raffle";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
