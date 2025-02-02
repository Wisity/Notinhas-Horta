<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = $_GET['id'] ?? null;
if (!$cliente_id) {
    echo "Cliente não encontrado.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->execute([$cliente_id]);
$cliente = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Detalhes do Cliente</h2>

        <div class="card">
            <div class="card-header">
                <strong>Informações do Cliente</strong>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>Nome</th>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                    </tr>
                    <tr>
                        <th>Telefone</th>
                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                    </tr>
                    <tr>
                        <th>Endereço</th>
                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="clientes.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
