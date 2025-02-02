<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['cliente_id'])) {
    echo "ID do cliente não fornecido!";
    exit;
}

$cliente_id = $_GET['cliente_id'];

// Buscar todas as notinhas do cliente
$stmt = $pdo->prepare("SELECT * FROM notinhas WHERE cliente_id = ?");
$stmt->execute([$cliente_id]);
$notinhas = $stmt->fetchAll();

// Buscar o nome do cliente para exibir na página
$stmt = $pdo->prepare("SELECT nome FROM clientes WHERE id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notinhas de <?= htmlspecialchars($cliente['nome']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Notinhas de <?= htmlspecialchars($cliente['nome']) ?></h2>
        <a href="selecionar_notinha.php" class="btn btn-secondary mb-3">Voltar para Selecionar Cliente</a>
        <a href="notinhas.php" class="btn btn-secondary mb-3">Voltar para as notinhas</a>

        <?php if (count($notinhas) > 0): ?>
            <ul class="list-group">
                <?php foreach ($notinhas as $notinha): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= "Data: " . htmlspecialchars($notinha['data']) . " | Valor: R$ " . htmlspecialchars($notinha['valor']) ?>
                        <a href="editar_notinha.php?id=<?= $notinha['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="excluir_notinha.php?id=<?= $notinha['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta notinha?')">Excluir</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Este cliente não possui dívidas registradas.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
