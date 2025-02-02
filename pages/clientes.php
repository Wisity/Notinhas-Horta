<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM clientes");
$clientes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <a class="navbar-brand" href="../index.php">Controle de Notinhas</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="notinhas.php">Notinhas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adicionar_cliente.php">Adicionar Cliente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adicionar_notinha.php">Adicionar Notinha</a>
                        </li>
                
                </ul>
            </div>
        </nav>
    <div class="container mt-5">
        <h2>Clientes</h2>
        <a href="adicionar_cliente.php" class="btn btn-primary mb-3">Adicionar Cliente</a>

        <div class="card">
            <div class="card-header">
                <strong>Lista de Clientes</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Endereço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                                <td><?= htmlspecialchars($cliente['email']) ?></td>
                                <td>
                                    <a href="detalhes_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                                    <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
