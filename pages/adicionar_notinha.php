<?php
session_start();
include '../includes\db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente_id = $_POST['cliente_id'];
    $data = $_POST['data'];
    $valor = $_POST['valor'];

    $stmt = $pdo->prepare("INSERT INTO notinhas (cliente_id, data, valor) VALUES (?, ?, ?)");
    $stmt->execute([$cliente_id, $data, $valor]);

    header("Location: notinhas.php");
}

$stmt = $pdo->query("SELECT * FROM clientes");
$clientes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Notinha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <a class="navbar-brand" href="../index.php">Controle de Notinhas</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                            <a class="nav-link" href="../index.php">Inicio</a>
                        </li><li class="nav-item">
                            <a class="nav-link" href="clientes.php">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adicionar_cliente.php">Adicionar Cliente</a>
                        </li>
                        
                
                </ul>
            </div>
        </nav>
    <div class="container mt-5">
        <h2>Adicionar Notinha</h2>

        <div class="card">
            <div class="card-header">
                <strong>Preencha as informações da notinha</strong>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select name="cliente_id" class="form-select" required>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>"><?= $cliente['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="date" class="form-control" name="data" id="data" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="text" class="form-control" name="valor" id="valor" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Notinha</button>
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
