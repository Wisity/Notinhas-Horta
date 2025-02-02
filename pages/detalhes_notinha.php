<?php
session_start();
include '../includes\db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$notinha_id = $_GET['id'] ?? null;
if (!$notinha_id) {
    echo "Notinha não encontrada.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM notinhas WHERE id = ?");
$stmt->execute([$notinha_id]);
$notinha = $stmt->fetch();

$stmt_cliente = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt_cliente->execute([$notinha['cliente_id']]);
$cliente = $stmt_cliente->fetch();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Notinha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Detalhes da Notinha</h2>

        <div class="card">
            <div class="card-header">
                <strong>Informações da Notinha</strong>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>Cliente</th>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                    </tr>
                    <tr>
                        <th>Data</th>
                        <td><?= htmlspecialchars($notinha['data']) ?></td>
                    </tr>
                    <tr>
                        <th>Valor</th>
                        <td><?= htmlspecialchars($notinha['valor']) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="notinhas.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
