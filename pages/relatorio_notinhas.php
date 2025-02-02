<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Dados para gráfico
$query = "SELECT status, COUNT(*) AS total FROM notinhas GROUP BY status";
$stmt = $pdo->query($query);
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Preparar dados para o gráfico
$status = ['Pendente', 'Pago'];
$quantidades = [0, 0];

foreach ($dados as $dado) {
    if ($dado['status'] == 'Pendente') {
        $quantidades[0] = $dado['total'];
    } elseif ($dado['status'] == 'Pago') {
        $quantidades[1] = $dado['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Notinhas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Relatório de Notinhas</h2>

        <div class="card">
            <div class="card-header">
                <strong>Gráfico de Status das Notinhas</strong>
            </div>
            <div class="card-body">
                <canvas id="notinhasChart" width="400" height="200"></canvas>
            </div>
        </div>

        <script>
            var ctx = document.getElementById('notinhasChart').getContext('2d');
            var notinhasChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Pendentes', 'Pagas'],
                    datasets: [{
                        label: 'Notinhas',
                        data: [<?= $quantidades[0] ?>, <?= $quantidades[1] ?>],
                        backgroundColor: ['#FF5733', '#4CAF50'],
                        borderColor: ['#FF5733', '#4CAF50'],
                        borderWidth: 1
                    }]
                }
            });
        </script>

        <div class="mt-3">
            <a href="notinhas.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
