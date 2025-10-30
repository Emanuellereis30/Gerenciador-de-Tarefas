<?php
session_start();


if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = [];
}
if (!isset($_SESSION['concluidas'])) {
    $_SESSION['concluidas'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_tarefa'])) {
    $nova_tarefa = trim($_POST['nova_tarefa']);
    if (!empty($nova_tarefa)) {
        $_SESSION['tarefas'][] = $nova_tarefa;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['concluir_tarefa'])) {
    $indice = (int)$_POST['concluir_tarefa'];
    if (isset($_SESSION['tarefas'][$indice]) && !in_array($indice, $_SESSION['concluidas'])) {
        $_SESSION['concluidas'][] = $indice;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #161616;
            color: #fff;
        }
        .container {
            background-color: whitesmoke;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 5px 5px 6px rgba(219, 217, 217, 0.56);
            color: #000;
        }
        h1, h2 {
            color: #c21515;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 70%;
            border: 1px solid #c70e0e;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #7a0e0e;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #bd0303;
        }
        button.concluir {
            background-color: #f32121;
            margin-left: 10px;
        }
        button.concluir:hover {
            background-color: #460404;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 10px;
            border-bottom: 1px solid #630303;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .concluida {
            text-decoration: line-through;
            color: #888;
        }
        .vazio {
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciador de Tarefas</h1>

       
        <form method="POST">
            <input type="text" name="nova_tarefa" placeholder="Digite uma nova tarefa..." required>
            <button type="submit">Adicionar Tarefa</button>
        </form>

        <h2>Lista de Tarefas</h2>

        <?php if (empty($_SESSION['tarefas'])): ?>
            <p class="vazio">Nenhuma tarefa cadastrada.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($_SESSION['tarefas'] as $indice => $tarefa): ?>
                    <li>
                        <span class="<?php echo in_array($indice, $_SESSION['concluidas']) ? 'concluida' : ''; ?>">
                            <?php
                                if (in_array($indice, $_SESSION['concluidas'])) {
                                    echo "[Concluída] ";
                                }
                                echo htmlspecialchars($tarefa);
                            ?>
                        </span>

                        <?php if (!in_array($indice, $_SESSION['concluidas'])): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="concluir_tarefa" value="<?php echo $indice; ?>">
                                <button type="submit" class="concluir">Concluir</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
