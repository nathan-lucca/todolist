<?php
session_start();
require '../php/connect.php';

$_SESSION['login_arquivadas'] = 0;

if (isset($_SESSION["user_logado"])) {
    header("Location: ../../index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/login.css">
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
                            <a class="nav-link active" aria-current="page" href="login.php"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="cadastro.php"><i class="bi bi-door-open"></i> Cadastro</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <main class="w-100 m-auto mt-3" style="max-width: 400px;">
        <h1 class="h3 mb-3 fw-normal text-center">Faça seu login</h1>

        <form class="forms-sample form-login" action="../php/backend/proc_login.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="email">Email</label><span style="color: red;"> *</span>
                <input type="email" class="form-control" name="email_usuario" placeholder="Insira seu email aqui" required>
            </div>

            <div class="form-group mt-2">
                <label for="senha">Senha</label><span style="color: red;"> *</span>
                <input type="password" class="form-control" name="senha_usuario" placeholder="Insira sua senha aqui" required>
            </div>

            <div class="form-check text-start my-3 mt-2">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Esqueceu senha?
                </label>
            </div>

            <button class="btn btn-primary w-100 py-2 btn-login" type="submit">Entrar</button>
            <p class="mt-3 mb-1 text-black">Não possui login? <a href="cadastro.php">Cadastre-se aqui.</a></p>
        </form>

        <footer class="mt-3">
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
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <script src="../assets/js/procedures.js"></script>
</body>

</html>