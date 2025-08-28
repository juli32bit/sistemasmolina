<?php
require_once('conexao.php');

// Validate that ID was provided and is numeric
if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
    die("ID inválido fornecido.");
}

$id = (int)$_REQUEST['id'];

try {
    // Prepare and execute DELETE query
    $sql = "DELETE FROM alunos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $resultado = $stmt->execute();
    
    // Check if any row was actually deleted
    if ($stmt->rowCount() > 0) {
        // Success - redirect immediately
        header("Location: index.php?msg=success");
        exit();
    } else {
        // No rows affected - student might not exist
        header("Location: index.php?msg=notfound");
        exit();
    }
    
} catch (PDOException $e) {
    // Handle database errors
    error_log("Database error: " . $e->getMessage());
    header("Location: index.php?msg=error");
    exit();
}
?>