<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Buscar todos os clientes
$stmt = $pdo->query("SELECT * FROM clientes");
$clientes = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecionar Notinha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Selecionar Cliente</h2>
        
        <div class="list-group">
            <?php foreach ($clientes as $cliente): ?>
                <a href="listar_notinhas.php?cliente_id=<?= $cliente['id'] ?>" class="list-group-item list-group-item-action">
                    <?= htmlspecialchars($cliente['nome']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
