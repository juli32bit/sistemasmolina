<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🔍 DEBUG COMPLETO</h2>";

// 1. Testar dados recebidos
echo "<h3>1. Dados recebidos:</h3>";
echo "<strong>POST:</strong><pre>"; print_r($_POST); echo "</pre>";
echo "<strong>GET:</strong><pre>"; print_r($_GET); echo "</pre>";
echo "<strong>REQUEST:</strong><pre>"; print_r($_REQUEST); echo "</pre>";

// 2. Testar conexão
echo "<h3>2. Testando conexão:</h3>";
try {
    require_once('conexao.php');
    if (isset($conn)) {
        echo "✅ Variável \$conn existe<br>";
        echo "✅ Conexão OK<br>";
    } else {
        echo "❌ Variável \$conn não existe<br>";
        die("ERRO: Conexão falhou");
    }
} catch (Exception $e) {
    echo "❌ Erro ao incluir conexao.php: " . $e->getMessage();
    die();
}

// 3. Verificar se a tabela existe
echo "<h3>3. Testando tabela 'alunos':</h3>";
try {
    $test_sql = "DESCRIBE alunos";
    $test_stmt = $conn->prepare($test_sql);
    $test_stmt->execute();
    $columns = $test_stmt->fetchAll();
    echo "✅ Tabela 'alunos' existe<br>";
    echo "Colunas: ";
    foreach ($columns as $col) {
        echo $col['Field'] . " (" . $col['Type'] . ") ";
    }
    echo "<br>";
} catch (PDOException $e) {
    echo "❌ Erro na tabela: " . $e->getMessage() . "<br>";
}

// 4. Pegar dados (tanto GET quanto POST)
$nome = '';
$ra = '';

if (isset($_POST['nome']) && isset($_POST['ra'])) {
    $nome = trim($_POST['nome']);
    $ra = trim($_POST['ra']);
    echo "<h3>4. Dados vêm do POST</h3>";
} elseif (isset($_GET['nome']) && isset($_GET['ra'])) {
    $nome = trim($_GET['nome']);
    $ra = trim($_GET['ra']);
    echo "<h3>4. Dados vêm do GET</h3>";
} else {
    echo "<h3>4. ❌ NENHUM DADO ENCONTRADO</h3>";
    echo "Verifique seu formulário!<br>";
    echo "<a href='index.php'>Voltar</a>";
    die();
}

echo "Nome: '$nome'<br>";
echo "RA: '$ra'<br>";

if (empty($nome) || empty($ra)) {
    echo "❌ Nome ou RA estão vazios!<br>";
    die();
}

// 5. Tentar inserir
echo "<h3>5. Tentando inserir...</h3>";
try {
    $sql = "INSERT INTO alunos (nome, ra) VALUES (:nome, :ra)";
    echo "SQL: $sql<br>";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':ra', $ra);
    
    echo "Executando...<br>";
    $resultado = $stmt->execute();
    
    if ($resultado) {
        echo "✅ Execute() retornou TRUE<br>";
        echo "Linhas afetadas: " . $stmt->rowCount() . "<br>";
        
        // Verificar se realmente inseriu
        $check_sql = "SELECT * FROM alunos WHERE nome = :nome AND ra = :ra";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':nome', $nome);
        $check_stmt->bindParam(':ra', $ra);
        $check_stmt->execute();
        $found = $check_stmt->fetch();
        
        if ($found) {
            echo "✅ SUCESSO! Aluno inserido no banco!<br>";
            echo "ID gerado: " . $found['id'] . "<br>";
            echo "<a href='index.php'>Ver lista</a>";
        } else {
            echo "❌ Execute() foi TRUE mas não encontrei o registro no banco!<br>";
        }
    } else {
        echo "❌ Execute() retornou FALSE<br>";
        $errorInfo = $stmt->errorInfo();
        echo "Erro: "; print_r($errorInfo);
    }
    
} catch (PDOException $e) {
    echo "❌ Erro PDO: " . $e->getMessage() . "<br>";
}
?>