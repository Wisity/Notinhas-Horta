<?php
// Incluir o arquivo de conexão com o banco de dados
include('../includes/db.php');

// Verificar se o ID da notinha foi fornecido via GET
if (isset($_GET['id'])) {
    $id_notinha = $_GET['id'];

    try {
        // Preparar a consulta SQL para excluir a notinha
        $sql = "DELETE FROM notinhas WHERE id = :id_notinha";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_notinha', $id_notinha, PDO::PARAM_INT);

        // Executar a consulta
        if ($stmt->execute()) {
            echo "<script>alert('Notinha excluída com sucesso!');</script>";
            echo "<script>window.location.href = 'notinhas.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir notinha.');</script>";
        }
    } catch (PDOException $e) {
        echo "Erro ao excluir notinha: " . $e->getMessage();
    }
} else {
    echo "<script>alert('ID da notinha não encontrado.');</script>";
    echo "<script>window.location.href = 'notinhas.php';</script>";
}
?>
