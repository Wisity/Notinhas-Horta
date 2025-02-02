<?php
// Incluir o arquivo de conexão com o banco de dados
include('../includes/db.php');

// Verificar se o ID foi fornecido via GET
if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];

    try {
        // Preparar a consulta SQL para excluir o cliente
        $sql = "DELETE FROM clientes WHERE id = :id_cliente";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);

        // Executar a consulta
        if ($stmt->execute()) {
            echo "<script>alert('Cliente excluído com sucesso!');</script>";
            echo "<script>window.location.href = 'clientes.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir cliente.');</script>";
        }
    } catch (PDOException $e) {
        echo "Erro ao excluir cliente: " . $e->getMessage();
    }
} else {
    echo "<script>alert('ID do cliente não encontrado.');</script>";
    echo "<script>window.location.href = 'clientes.php';</script>";
}
?>
