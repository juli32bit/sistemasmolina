<?php
// Incluir conexão
require_once('conexao.php');

// Verificar se foi passado ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?msg=error");
    exit();
}

$id = $_GET['id'];

// Buscar dados do aluno
try {
    $sql = "SELECT * FROM alunos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$aluno) {
        header("Location: index.php?msg=not_found");
        exit();
    }
} catch (PDOException $e) {
    header("Location: index.php?msg=error");
    exit();
}

// Mensagens
$message = '';
$messageType = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'ra_duplicado') {
        $message = 'Este RA já está cadastrado para outro aluno!';
        $messageType = 'danger';
    } elseif ($_GET['msg'] == 'error') {
        $message = 'Erro ao atualizar. Tente novamente.';
        $messageType = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <title>Editar Aluno - Sistema</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1e293b;
            --gray: #64748b;
            --light-gray: #f1f5f9;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .edit-container {
            background: var(--white);
            border-radius: 1.5rem;
            padding: 2.5rem;
            width: 100%;
            max-width: 600px;
            box-shadow: var(--shadow-xl);
            animation: fadeInUp 0.5s ease;
        }

        .edit-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--light-gray);
        }

        .edit-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .edit-title h1 {
            font-size: 1.75rem;
            color: var(--dark);
            font-weight: 700;
        }

        .edit-title i {
            font-size: 1.75rem;
            color: var(--primary);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border: 2px solid var(--light-gray);
            border-radius: 0.75rem;
            transition: var(--transition);
        }

        .btn-back:hover {
            background: var(--light-gray);
            color: var(--dark);
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideInRight 0.5s ease;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--white);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgb(99 102 241 / 0.1);
        }

        .student-info {
            background: var(--light-gray);
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .student-info i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .student-info-text {
            flex: 1;
        }

        .student-info-label {
            font-size: 0.875rem;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }

        .student-info-value {
            font-weight: 600;
            color: var(--dark);
        }

        .btn-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--gray);
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            color: var(--dark);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .edit-container {
                padding: 1.5rem;
            }

            .edit-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .btn-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <div class="edit-header">
            <div class="edit-title">
                <i class="fas fa-user-edit"></i>
                <h1>Editar Aluno</h1>
            </div>
            <a href="index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>">
                <i class="fas fa-exclamation-triangle"></i>
                <span><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <div class="student-info">
            <i class="fas fa-info-circle"></i>
            <div class="student-info-text">
                <div class="student-info-label">Editando o aluno:</div>
                <div class="student-info-value"><?php echo htmlspecialchars($aluno['nome']); ?> (RA: <?php echo htmlspecialchars($aluno['ra']); ?>)</div>
            </div>
        </div>

        <form method="POST" action="salvar.php">
            <!-- Campo hidden com o ID para indicar que é atualização -->
            <input type="hidden" name="id" value="<?php echo $aluno['id']; ?>">
            
            <div class="form-group">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" 
                       id="nome" 
                       name="nome" 
                       class="form-input" 
                       value="<?php echo htmlspecialchars($aluno['nome']); ?>"
                       placeholder="Digite o nome completo" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="ra" class="form-label">Registro Acadêmico (RA)</label>
                <input type="text" 
                       id="ra" 
                       name="ra" 
                       class="form-input" 
                       value="<?php echo htmlspecialchars($aluno['ra']); ?>"
                       placeholder="Digite o RA" 
                       maxlength="9" 
                       required>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Salvar Alterações
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        // Format RA input (only numbers)
        document.getElementById('ra').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>