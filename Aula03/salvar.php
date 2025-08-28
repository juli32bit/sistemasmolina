<?php
// Incluir conexão
require_once('conexao.php');

// Verificar se veio ID (se sim, é atualização; se não, é inserção)
$id = isset($_POST['id']) ? $_POST['id'] : null;
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$ra = isset($_POST['ra']) ? trim($_POST['ra']) : '';

// Validações
if (empty($nome) || empty($ra)) {
    header("Location: index.php?msg=error");
    exit();
}

try {
    if ($id) {
        // ========== ATUALIZAÇÃO ==========
        
        // Verificar se RA já existe em outro registro
        $check_sql = "SELECT id FROM alunos WHERE ra = :ra AND id != :id";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':ra', $ra);
        $check_stmt->bindParam(':id', $id);
        $check_stmt->execute();
        
        if ($check_stmt->fetch()) {
            // RA duplicado - volta para editar.php com erro
            header("Location: editar.php?id=$id&msg=ra_duplicado");
            exit();
        }
        
        // Atualizar o registro
        $sql = "UPDATE alunos SET nome = :nome, ra = :ra WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':ra', $ra);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            header("Location: index.php?msg=updated");
        } else {
            header("Location: editar.php?id=$id&msg=error");
        }
        
    } else {
        // ========== INSERÇÃO ==========
        
        // Verificar se RA já existe
        $check_sql = "SELECT id FROM alunos WHERE ra = :ra";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':ra', $ra);
        $check_stmt->execute();
        
        if ($check_stmt->fetch()) {
            // RA duplicado
            header("Location: index.php?msg=ra_duplicado");
            exit();
        }
        
        // Inserir novo registro
        $sql = "INSERT INTO alunos (nome, ra) VALUES (:nome, :ra)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':ra', $ra);
        
        if ($stmt->execute()) {
            header("Location: index.php?msg=success");
        } else {
            header("Location: index.php?msg=error");
        }
    }
    
} catch (PDOException $e) {
    // Em caso de erro, volta para index
    header("Location: index.php?msg=error");
}

exit();
?>