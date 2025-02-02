<?php
include '../includes/db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("UPDATE notinhas SET status = 'paga', pago_em = NOW() WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: notinhas.php?success=3');
exit;
?>
