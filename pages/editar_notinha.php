<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID da notinha não fornecido!";
    exit;
}

$id = $_GET['id'];

// Buscar as informações da notinha
$stmt = $pdo->prepare("SELECT * FROM notinhas WHERE id = ?");
$stmt->execute([$id]);
$notinha = $stmt->fetch();

if (!$notinha) {
    echo "Notinha não encontrada!";
    exit;
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $_POST['valor'];
    $data = $_POST['data'];

    // Validar os dados (você pode adicionar mais validações aqui)
    if (empty($valor) || empty($data)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        // Atualizar a notinha no banco de dados
        $stmt = $pdo->prepare("UPDATE notinhas SET valor = ?, data = ? WHERE id = ?");
        $stmt->execute([$valor, $data, $id]);

        // Redirecionar para a página de listagem de notinhas
        header("Location: listar_notinhas.php?cliente_id=" . $notinha['cliente_id']);
        exit;
    }
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
        <a href="listar_notinhas.php?cliente_id=<?= $notinha['cliente_id'] ?>" class="btn btn-secondary mb-3">LISTA DIVIDAS DO CLIENTE</a>

        <!-- Formulário para editar a notinha -->
        <form method="POST">
            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" class="form-control" id="valor" name="valor" value="<?= htmlspecialchars($notinha['valor']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="data" class="form-label">Data</label>
                <input type="date" class="form-control" id="data" name="data" value="<?= htmlspecialchars($notinha['data']) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
