<?php
include '../includes/header.php';
include '../includes/db.php';

// Busca as notinhas pagas no banco
$query = $pdo->query("SELECT * FROM notinhas WHERE status = 'paga' ORDER BY pago_em DESC");
$notinhasPagas = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Notinhas Pagas</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Valor</th>
            <th>Descrição</th>
            <th>Data de Pagamento</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($notinhasPagas as $notinha): ?>
            <tr>
                <td><?= $notinha['id']; ?></td>
                <td><?= $notinha['cliente_nome']; ?></td>
                <td>R$ <?= number_format($notinha['valor'], 2, ',', '.'); ?></td>
                <td><?= $notinha['descricao']; ?></td>
                <td><?= date('d/m/Y H:i', strtotime($notinha['pago_em'])); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
