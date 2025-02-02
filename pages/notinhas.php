<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Selecionar as notinhas com os dados do cliente (nome)
$stmt = $pdo->query("SELECT n.id, n.cliente_id, n.data, n.valor, c.nome
                     FROM notinhas n
                     JOIN clientes c ON n.cliente_id = c.id");
$notinhas = $stmt->fetchAll();

// Array para armazenar a soma das dívidas de clientes repetidos
$clientesDividas = [];

// Processar as notinhas para somar as dívidas dos clientes repetidos
foreach ($notinhas as $key => $notinha) {
    $nomeCliente = $notinha['nome'];

    // Se o cliente já existir no array, somamos o valor da dívida
    if (isset($clientesDividas[$nomeCliente])) {
        $clientesDividas[$nomeCliente] += $notinha['valor'];
        // Remover a linha original, pois vamos exibir somente uma vez o nome
        unset($notinhas[$key]);
    } else {
        // Caso contrário, adicionamos o nome do cliente no array
        $clientesDividas[$nomeCliente] = $notinha['valor'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notinhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <a class="navbar-brand" href="../index.php">Controle de Notinhas</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="clientes.php">Clientes</a>
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
        <h2>Notinhas</h2>
        <a href="adicionar_notinha.php" class="btn btn-primary mb-3">Adicionar Notinha</a>

        <div class="card">
            <div class="card-header">
                <strong>Lista de Notinhas</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Exibir as notinhas, levando em consideração a soma das dívidas para clientes repetidos
                        foreach ($notinhas as $notinha):
                            $nomeCliente = $notinha['nome'];
                            $dividaTotal = isset($clientesDividas[$nomeCliente]) ? $clientesDividas[$nomeCliente] : 0;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($nomeCliente) ?></td>
                                <td><?= htmlspecialchars($notinha['data']) ?></td>
                                <td>R$ <?= number_format($dividaTotal, 2, ',', '.') ?></td>
                                <td>
                                    <a href="detalhes_notinha.php?id=<?= $notinha['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                                    <a href="editar_notinha.php?id=<?= $notinha['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="excluir_notinha.php?id=<?= $notinha['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
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
