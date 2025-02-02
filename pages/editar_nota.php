<?php
session_start();
include 'db.php';

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

$stmt_cliente = $pdo->query("SELECT * FROM clientes");
$clientes = $stmt_cliente->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $data = $_POST['data'];
    $valor = $_POST['valor'];

    $stmt_update = $pdo->prepare("UPDATE notinhas SET cliente_id = ?, data = ?, valor = ? WHERE id = ?");
    $stmt_update->execute([$cliente_id, $data, $valor, $notinha_id]);

    header("Location: notinhas.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Notinha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Notinha</h2>

        <div class="card">
            <div class="card-header">
                <strong>Alterar as informações da notinha</strong>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select" required>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $notinha['cliente_id'] ? 'selected' : '' ?>><?= $cliente['nome_cliente'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control" name="data" id="data" value="<?= htmlspecialchars($notinha['data']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="text" class="form-control" name="valor" id="valor" value="<?= htmlspecialchars($notinha['valor']) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>

        <div class="mt-3">
            <a href="notinhas.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
