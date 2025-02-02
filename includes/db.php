<?php
// includes/db.php
$host = 'sql111.infinityfree.com';
$dbname = 'if0_38209858_financas';
$user = 'if0_38209858';
$password = '99094562horta';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
