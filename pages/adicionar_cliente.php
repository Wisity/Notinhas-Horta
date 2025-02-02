<?php
// Conexão com o banco de dados
include '../includes/db.php';

// Verificando se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtendo os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Preparando a consulta para inserir o cliente
    $sql = "INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)";
    $stmt = $pdo->prepare($sql);

    // Bind dos parâmetros
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);

    // Executando a consulta
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Cliente adicionado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao adicionar cliente.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Cliente</title>
    <!-- Incluindo o Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                            <a class="nav-link" href="notinhas.php">Notinhas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adicionar_notinha.php">Adicionar Notinha</a>
                        </li>
                
                </ul>
            </div>
        </nav>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Adicionar Novo Cliente</h2>

        <form method="POST" action="adicionar_cliente.php">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
            </div>

            <button type="submit" class="btn btn-primary">Adicionar Cliente</button>
        </form>

        <br>
        <a href="clientes.php" class="btn btn-secondary">Voltar para a lista de clientes</a>
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
