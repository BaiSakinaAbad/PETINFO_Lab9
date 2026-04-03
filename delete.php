<?php
include('database.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'delete') {
    $stmt = $pdo->prepare('DELETE FROM pets WHERE id = :id');
    $stmt->execute(['id' => $_POST['id']]);
    header("Location: index.php");
    exit;
}
?>