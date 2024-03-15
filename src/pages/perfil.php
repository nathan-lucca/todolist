<?php
session_start();
require '../php/connect.php';

$_SESSION['login_arquivadas'] = 0;

if (is_null($_SESSION["user_logado"])) {
    header("Location: login.php");
}

$id_logado = $_SESSION['id_logado'];

$all_list = "SELECT usuarios.*, categorias.*, tarefas.* FROM usuarios
    INNER JOIN tarefas ON usuarios.id_usuario = tarefas.id_usuario
    INNER JOIN categorias ON categorias.id_categoria = tarefas.id_categoria
    WHERE usuarios.id_usuario = $id_logado ORDER BY titulo_tarefa ASC";

$exec_allList = mysqli_query($con, $all_list);

$usuario_assoc = mysqli_fetch_assoc($exec_allList);

$nome_usuario = $usuario_assoc['nome_usuario'];

$query = "SELECT COUNT(*) AS total FROM tarefas WHERE id_usuario = '$id_logado'";
$exec_query = mysqli_query($con, $query);
$total_tarefas_assoc = mysqli_fetch_assoc($exec_query);
$total_tarefas = $total_tarefas_assoc['total'];

$query_concluidas = "SELECT COUNT(*) AS total FROM tarefas WHERE id_usuario = '$id_logado' AND id_categoria = 2";
$exec_query_concluidas = mysqli_query($con, $query_concluidas);
$total_concluidas_assoc = mysqli_fetch_assoc($exec_query_concluidas);
$total_concluidas = $total_concluidas_assoc['total'];

$query_pendentes = "SELECT COUNT(*) AS total FROM tarefas WHERE id_usuario = '$id_logado' AND id_categoria = 1";
$exec_query_pendentes = mysqli_query($con, $query_pendentes);
$total_pendentes_assoc = mysqli_fetch_assoc($exec_query_pendentes);
$total_pendentes = $total_pendentes_assoc['total'];

$query_outros = "SELECT COUNT(*) AS total FROM tarefas WHERE id_usuario = '$id_logado' AND id_categoria = 3";
$exec_query_outros = mysqli_query($con, $query_outros);
$total_outros_assoc = mysqli_fetch_assoc($exec_query_outros);
$total_outros = $total_outros_assoc['total'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List | Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/perfil.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <div class="container-fluid justify-content-center custom-logo">
        <h1>
            <a class="navbar-brand" href="index.php"><i class="bi bi-clipboard2-check"></i> Lista de Tarefas</a>
        </h1>
    </div>

    <div class="container-fluid justify-content-center custom-navbar">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../../index.php"><i class="bi bi-house"></i> Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="pendentes.php"><i class="bi bi-exclamation-circle"></i> Pendentes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="concluidas.php"><i class="bi bi-check-circle"></i> Concluídas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="arquivadas.php"><i class="bi bi-archive"></i> Arquivadas</a>
                        </li>
                        <?php
                        if (isset($_SESSION['user_logado'])) {
                        ?>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> <?php echo $_SESSION['user_logado']; ?>
                                </a>
                                <ul class="dropdown-menu profile-dropdown" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item active" href="perfil.php"><i class="bi bi-person-standing"></i> Perfil</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../php/backend/sair.php"><i class="bi bi-box-arrow-in-left"></i> Sair</a></li>
                                </ul>
                            </div>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Entrar</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="col-12 mt-5 mb-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                <div class="card m-1 border rounded-3 h-100" style="background-color: #282c34; color: white; box-shadow: 5px 10px 15px #14141472;">
                    <div class="card-body w-100 p-0 d-flex flex-column justify-content-center align-items-center">
                        <div class="row w-100 mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
                            </svg>

                            <h4 class="card-title p-0 m-0 text-center mt-2">
                                <?php echo $nome_usuario; ?>
                            </h4>

                            <hr class="text-white border border-light w-100 mb-2">
                        </div>

                        <div class="row w-100">
                            <h5 class="text-center">Tarefas:</h5>
                        </div>

                        <div class="row w-100">
                            <div class="d-flex flex-row gap-5 justify-content-center align-items-center">
                                <div>
                                    <p>Total: <?php echo $total_tarefas; ?></p>
                                </div>
                                <div>
                                    <p>Concluídas: <?php echo $total_concluidas; ?></p>
                                </div>
                                <div>
                                    <p>Pendentes: <?php echo $total_pendentes; ?></p>
                                </div>
                                <div>
                                    <p>Arquivadas: <?php echo $total_outros; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center text-light">
                    <hr>
                    <p>Desenvolvido com ❤️ por Nathan Lucca Covre</p>
                    <p>
                        <a href="https://www.linkedin.com/in/nathan-lucca-covre-358078266/" target="_blank">LinkedIn</a> |
                        <a href="https://github.com/nathan-lucca/" target="_blank">GitHub</a> |
                        <a href="https://www.instagram.com/ofc_nathan_lucca/" target="_blank">Instagram</a>
                    </p>
                    <p>Copyright © 2024 Nathan Lucca Covre</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <script src="../assets/js/procedures.js"></script>
</body>

</html>