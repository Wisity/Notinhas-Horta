<?php
include '../includes/header.php';
include '../includes/db.php';

// Total de valores
$totalPendentesQuery = $pdo->query("SELECT SUM(valor) as total FROM notinhas WHERE status = 'pendente'");
$totalPendentes = $totalPendentesQuery->fetchColumn();

$totalPagosQuery = $pdo->query("SELECT SUM(valor) as total FROM notinhas WHERE status = 'paga'");
$totalPagos = $totalPagosQuery->fetchColumn();

// Notinhas pendentes
$notinhasPendentesQuery = $pdo->query("SELECT n.id, n.valor, n.descricao, c.nome 
    FROM notinhas n 
    JOIN clientes c ON n.cliente_id = c.id 
    WHERE n.status = 'pendente' ORDER BY n.id ASC");
$notinhasPendentes = $notinhasPendentesQuery->fetchAll(PDO::FETCH_ASSOC);

// Notinhas pagas
$notinhasPagasQuery = $pdo->query("SELECT n.id, n.valor, n.descricao, c.nome, n.pago_em 
    FROM notinhas n 
    JOIN clientes c ON n.cliente_id = c.id 
    WHERE n.status = 'paga' ORDER BY n.pago_em DESC");
$notinhasPagas = $notinhasPagasQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Relatórios Financeiros</h2>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Total a Receber</h5>
                <p class="h4">R$ <?= number_format($totalPendentes ?: 0, 2, ',', '.'); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Total Recebido</h5>
                <p class="h4">R$ <?= number_format($totalPagos ?: 0, 2, ',', '.'); ?></p>
            </div>
        </div>
    </div>
</div>

<h3 class="mt-4">Notinhas Pendentes</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Valor</th>
            <th>Descrição</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($notinhasPendentes) > 0): ?>
            <?php foreach ($notinhasPendentes as $notinha): ?>
                <tr>
                    <td><?= $notinha['id']; ?></td>
                    <td><?= htmlspecialchars($notinha['nome']); ?></td>
                    <td>R$ <?= number_format($notinha['valor'], 2, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($notinha['descricao']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Nenhuma notinha pendente.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<h3 class="mt-4">Notinhas Pagas</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Valor</th>
            <th>Descrição</th>
            <th>Pago em</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($notinhasPagas) > 0): ?>
            <?php foreach ($notinhasPagas as $notinha): ?>
                <tr>
                    <td><?= $notinha['id']; ?></td>
                    <td><?= htmlspecialchars($notinha['nome']); ?></td>
                    <td>R$ <?= number_format($notinha['valor'], 2, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($notinha['descricao']); ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($notinha['pago_em'])); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Nenhuma notinha paga.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
