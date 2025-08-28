<?php
//REQUIRE_ONCE, REQUIRE
include ("conexao.php");

// Mostrar mensagens de feedback mais detalhadas
$message = '';
$messageType = '';
$messageIcon = '';

// if (isset($_GET['msg'])) {
//     switch($_GET['msg']) {
//         case 'success':
//             $nome = isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : '';
//             $message = "✅ Aluno <strong>{$nome}</strong> cadastrado com sucesso!";
//             $messageType = 'success';
//             $messageIcon = 'check-circle';
//             break;
            
//         case 'updated':
//             $nome = isset($_GET['nome']) ? htmlspecialchars($_GET['nome']) : '';
//             $message = "✅ Aluno <strong>{$nome}</strong> atualizado com sucesso!";
//             $messageType = 'success';
//             $messageIcon = 'check-circle';
//             break;
            
//         case 'deleted':
//             $message = '✅ Aluno excluído com sucesso!';
//             $messageType = 'success';
//             $messageIcon
               
//         }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <title>Sistema de Alunos - Dashboard</title>
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
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        /* Header Navigation */
        .header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.5s ease;
        }

        .nav-container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--white);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            transition: var(--transition);
        }

        .logo i {
            font-size: 1.75rem;
            animation: bounce 2s infinite;
        }

        .nav-menu {
            display: flex;
            gap: 1rem;
        }

        .nav-btn {
            background: rgba(255, 255, 255, 0.1);
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* Main Container */
        .main-container {
            max-width: 1320px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            animation: fadeInUp 0.6s ease;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            border-radius: 1.5rem;
            padding: 1.75rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            transition: var(--transition);
            animation: fadeInUp 0.6s ease backwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl), 0 25px 50px -12px rgb(99 102 241 / 0.25);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideInRight 0.5s ease;
            box-shadow: var(--shadow-md);
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            border-left: 4px solid var(--success);
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }

        .alert-close {
            margin-left: auto;
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.5;
            transition: var(--transition);
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Form Section */
        .form-card {
            background: var(--white);
            border-radius: 1.5rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-xl);
            animation: fadeInUp 0.7s ease;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--light-gray);
        }

        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }

        .form-header i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            position: relative;
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

        .form-input::placeholder {
            color: #cbd5e1;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
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
        }

        /* Table Section */
        .table-card {
            background: var(--white);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            animation: fadeInUp 0.8s ease;
        }

        .table-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .table-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--light-gray);
        }

        th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        tbody tr {
            transition: var(--transition);
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .student-id {
            font-weight: 700;
            color: var(--primary);
        }

        .student-name {
            font-weight: 500;
            color: var(--dark);
        }

        .badge-ra {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            background: linear-gradient(135deg, #ddd6fe, #c4b5fd);
            color: #5b21b6;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            text-decoration: none;
        }

        .btn-edit {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-edit:hover {
            background: #fde68a;
            transform: scale(1.05);
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-delete:hover {
            background: #fecaca;
            transform: scale(1.05);
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: var(--gray);
        }

        /* Animations */
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

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-100%);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: transparent;
            border: none;
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-container {
                padding: 1rem;
            }

            .logo {
                font-size: 1.25rem;
            }

            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                padding: 1rem;
                flex-direction: column;
                box-shadow: var(--shadow-lg);
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-btn {
                color: var(--dark);
                border-color: var(--gray);
                width: 100%;
                justify-content: center;
            }

            .mobile-menu-btn {
                display: block;
            }

            .main-container {
                padding: 0 1rem;
                margin: 1rem auto;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .stat-card {
                padding: 1.25rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .form-card {
                padding: 1.5rem;
                border-radius: 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .table-header {
                padding: 1rem 1.5rem;
            }

            th, td {
                padding: 0.75rem;
                font-size: 0.875rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }

            .stat-value {
                font-size: 1.75rem;
            }

            .form-header h2 {
                font-size: 1.25rem;
            }

            .table-container {
                font-size: 0.8rem;
            }

            th, td {
                padding: 0.5rem;
            }

            .empty-icon {
                font-size: 3rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Tooltip */
        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]:hover::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 0.5rem 0.75rem;
            background: var(--dark);
            color: var(--white);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            white-space: nowrap;
            z-index: 1000;
            margin-bottom: 0.5rem;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-gray);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <header class="header">
        <nav class="nav-container">
            <a href="#" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>Sistema de Alunos</span>
            </a>
            
            <div class="nav-menu" id="navMenu">
                <a href="#" class="nav-btn">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>
                <a href="#" class="nav-btn">
                    <i class="fas fa-chart-bar"></i>
                    Relatórios
                </a>
                <a href="#" class="nav-btn">
                    <i class="fas fa-cog"></i>
                    Configurações
                </a>
            </div>
            
            <button class="mobile-menu-btn" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value"><?php echo count($resultado); ?></div>
                <div class="stat-label">Total de Alunos</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-value"><?php echo count($resultado); ?></div>
                <div class="stat-label">Alunos Ativos</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="stat-value">2024</div>
                <div class="stat-label">Ano Letivo</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stat-value">100%</div>
                <div class="stat-label">Taxa de Atividade</div>
            </div>
        </div>

        <!-- Alert Messages -->
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>" id="alertMessage">
                <i class="fas fa-<?php echo $messageType == 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                <span><?php echo $message; ?></span>
                <button class="alert-close" onclick="closeAlert()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        <!-- Form Section -->
        <div class="form-card">
            <div class="form-header">
                <i class="fas fa-user-plus"></i>
                <h2>Cadastrar Novo Aluno</h2>
            </div>
            
            <form method="POST" action="salvar.php">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" 
                               id="nome" 
                               name="nome" 
                               class="form-input" 
                               placeholder="Digite o nome completo do aluno" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="ra" class="form-label">Registro Acadêmico (RA)</label>
                        <input type="text" 
                               id="ra" 
                               name="ra" 
                               class="form-input" 
                               placeholder="Digite o RA do aluno" 
                               maxlength="9" 
                               required>
                    </div>
                </div>
                
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Cadastrar Aluno
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-eraser"></i>
                        Limpar Campos
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="table-card">
            <div class="table-header">
                <i class="fas fa-list"></i>
                <h2>Lista de Alunos Cadastrados</h2>
            </div>
            
            <div class="table-container">
                <?php if(!empty($resultado)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome do Aluno</th>
                                <th>RA</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($resultado as $aluno): ?>
                            <tr>
                                <td>
                                    <span class="student-id">#<?php echo htmlspecialchars($aluno['id']); ?></span>
                                </td>
                                <td>
                                    <span class="student-name"><?php echo htmlspecialchars($aluno['nome']); ?></span>
                                </td>
                                <td>
                                    <span class="badge-ra"><?php echo htmlspecialchars($aluno['ra']); ?></span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="editar.php?id=<?php echo $aluno['id']; ?>" 
                                           class="btn-action btn-edit"
                                           data-tooltip="Editar aluno">
                                            <i class="fas fa-edit"></i>
                                            Editar
                                        </a>
                                        <a href="excluir.php?id=<?php echo $aluno['id']; ?>" 
                                           class="btn-action btn-delete"
                                           onclick="return confirm('Tem certeza que deseja excluir <?php echo htmlspecialchars($aluno['nome']); ?>?')"
                                           data-tooltip="Excluir aluno">
                                            <i class="fas fa-trash"></i>
                                            Excluir
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-user-slash empty-icon"></i>
                        <h3 class="empty-title">Nenhum aluno cadastrado</h3>
                        <p class="empty-text">Use o formulário acima para adicionar o primeiro aluno ao sistema.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script>
        // Toggle mobile menu
        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        // Close alert
        function closeAlert() {
            const alert = document.getElementById('alertMessage');
            if (alert) {
                alert.style.animation = 'slideInRight 0.5s ease reverse';
                setTimeout(() => alert.remove(), 500);
            }
        }

        // Auto-hide alert after 5 seconds
        setTimeout(() => {
            const alert = document.getElementById('alertMessage');
            if (alert) {
                closeAlert();
            }
        }, 5000);

        // Format RA input (only numbers)
        document.getElementById('ra').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.stat-card, .form-card, .table-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style