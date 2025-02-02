<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_role = $_SESSION['usuario_role'];

// Verificar se o botão de exclusão foi pressionado
if (isset($_POST['excluir_cliente'])) {
    $cliente_id = $_POST['cliente_id'];
    
    // Excluir o cliente do banco de dados
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = ?");
    $stmt->execute([$cliente_id]);

    // Redirecionar após a exclusão
    header("Location: index.php");
    exit;
}

// Pesquisa por nome do cliente
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM clientes WHERE nome LIKE ?";

$stmt = $pdo->prepare($query);
$stmt->execute(['%' . $search . '%']);
$clientes = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Finanças</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Controle de Finanças</h2>
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <a class="navbar-brand" href="index.php">Controle de Notinhas</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <?php if ($usuario_role == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="pages\clientes.php">Clientes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages\notinhas.php">Notinhas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages\adicionar_cliente.php">Adicionar Cliente</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages\adicionar_notinha.php">Adicionar Notinha</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </nav>

        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="search" placeholder="Pesquisar Cliente" value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Pesquisar</button>
                </div>
            </div>
        </form>

        <h3>Clientes Encontrados</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= $cliente['nome'] ?></td>
                        <td><?= $cliente['telefone'] ?></td>
                        <td><?= $cliente['email'] ?></td>
                        <td>
                            <a href="pages\editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="cliente_id" value="<?= $cliente['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm" name="excluir_cliente" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
