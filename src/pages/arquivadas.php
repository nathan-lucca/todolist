<?php
session_start();
require '../php/connect.php';

if (is_null($_SESSION["user_logado"])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List | Tarefas Arquivadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/arquivadas.css">
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <div class="blur-background"></div>

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
                            <a class="nav-link active" aria-current="page" href="arquivadas.php"><i class="bi bi-archive"></i> Arquivadas</a>
                        </li>
                        <?php
                        if (isset($_SESSION['user_logado'])) {
                        ?>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> <?php echo $_SESSION['user_logado']; ?>
                                </a>
                                <ul class="dropdown-menu profile-dropdown" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="perfil.php"><i class="bi bi-person-standing"></i> Perfil</a></li>
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

    <?php
    $id_logado = $_SESSION['id_logado'];

    $all_list = "SELECT usuarios.*, categorias.*, tarefas.* FROM usuarios
    INNER JOIN tarefas ON usuarios.id_usuario = tarefas.id_usuario
    INNER JOIN categorias ON categorias.id_categoria = tarefas.id_categoria
    WHERE usuarios.id_usuario = $id_logado AND categorias.nome_categoria = 'Arquivada' ORDER BY titulo_tarefa ASC";

    $exec_allList = mysqli_query($con, $all_list);
    ?>
    <div class="col-12 p-5">
        <div class="row">
            <?php
            if (mysqli_num_rows($exec_allList) > 0) {
            ?>
                <div class="container-fluid d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Nova Tarefa</button>
                </div>
                <?php
                while ($row = mysqli_fetch_array($exec_allList)) {
                    $id_tarefa = $row['id_tarefa'];
                    $id_categoria = $row['id_categoria'];
                    $nome_categoria = $row['nome_categoria'];

                    $titulo_tarefa = strip_tags($row['titulo_tarefa']);
                    $descricao_tarefa = strip_tags($row['descricao_tarefa']);
                    $visualizar_titulo_tarefa = strip_tags($row['titulo_tarefa']);
                    $visualizar_descricao_tarefa = strip_tags($row['descricao_tarefa']);
                ?>
                    <div class="col-md-4 mt-3">
                        <div class="card m-1 border rounded-3 mb-2 d-flex flex-column justify-content-between h-100" style="background-color: #282c34; color: white;">
                            <div class="card-body">
                                <h4 class="card-title p-0">
                                    <?php
                                    if (strlen($titulo_tarefa) > 15) {
                                        $titulo_tarefa = substr($titulo_tarefa, 0, 10) . "...";
                                    }

                                    echo $titulo_tarefa;
                                    ?>
                                </h4>
                                <span style="color: #ff6347;"><?php echo $nome_categoria; ?></span>
                                <hr>
                                <p class="card-text" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                                    <?php
                                    if (strlen($descricao_tarefa) > 100) {
                                        $descricao_tarefa = substr($descricao_tarefa, 0, 100) . "...";
                                    }

                                    echo $descricao_tarefa;
                                    ?>
                                </p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modal<?php echo $id_tarefa; ?>">Visualizar</button>
                                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $id_tarefa; ?>">Editar</button>
                                <button type="button" class="btn btn-danger mb-3 btn-excluir-tarefa" data-id="<?php echo $id_tarefa; ?>">Excluir</button>
                            </div>
                        </div>
                    </div>

                    <!-- VISUALIZAR TAREFA -->
                    <div class="modal fade" id="modal<?php echo $id_tarefa; ?>" tabindex="-1" aria-labelledby="modal<?php echo $id_tarefa; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content" style="background-color: #282c34;">
                                <div class="modal-header">
                                    <h1 class="modal-title text-light fs-5" id="modal<?php echo $id_tarefa; ?>">Visualizar Tarefa</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none;">
                                        <span aria-hidden="true" style="color: white; font-size: 3em; top: -8px; position: absolute; right: 10px;">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="titulo_tarefa" class="form-label">Título da Tarefa</label>
                                                    <input type="text" class="form-control" id="titulo_tarefa" value="<?php echo $visualizar_titulo_tarefa; ?>" style="width: 100%; font-size: 1rem; font-weight: 400; line-height: 1.5; background: transparent; color: white; border: none;" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="categoria_tarefa" class="form-label">Categoria da Tarefa</label>
                                                    <input type="text" class="form-control" id="categoria_tarefa" value="<?php echo $nome_categoria; ?>" style="width: 100%; font-size: 1rem; font-weight: 400; line-height: 1.5; background: transparent; color: white; border: none;" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="descricao_tarefa" class="form-label">Descrição da Tarefa</label>
                                                    <textarea class="form-control" name="descricao_tarefa" id="descricao_tarefa" cols="30" rows="9" style="width: 100%; font-size: 1rem; font-weight: 400; line-height: 1.5; color: black; border: none; resize: none;" placeholder="Insira a descrição aqui" disabled required><?php echo $visualizar_descricao_tarefa; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EDITAR TAREFA -->
                    <div class="modal fade" id="modalEdit<?php echo $id_tarefa; ?>" tabindex="-1" aria-labelledby="modalEdit<?php echo $id_tarefa; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                            <div class="modal-content" style="background-color: #282c34;">
                                <div class="modal-header">
                                    <h1 class="modal-title text-light fs-5" id="modalEdit<?php echo $id_tarefa; ?>">Editar Tarefa</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none;">
                                        <span aria-hidden="true" style="color: white; font-size: 3em; top: -8px; position: absolute; right: 10px;">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <form class="forms-sample form-editar" id="form-editar-<?php echo $id_tarefa; ?>" method="post" action="../php/backend/proc_editar_tarefa.php">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="titulo_tarefa" class="form-label">Título da Tarefa</label>
                                                        <input type="text" class="form-control" name="titulo_tarefa" id="titulo_tarefa" value="<?php echo $visualizar_titulo_tarefa; ?>" style="width: 100%; padding: 0.375rem 0 0.75 rem; font-size: 1rem; font-weight: 400; line-height: 1.5;">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="categoria_tarefa" class="form-label">Categoria da Tarefa</label>
                                                        <select name="categoria_tarefa" class="form-control">
                                                            <?php
                                                            $sql = "SELECT * FROM categorias ORDER BY nome_categoria ASC";
                                                            $retorno = mysqli_query($con, $sql);

                                                            while ($categoria_rows = mysqli_fetch_assoc($retorno)) {
                                                                $id_categoria_option = $categoria_rows['id_categoria'];
                                                                $nome_categoria_option = $categoria_rows['nome_categoria'];

                                                                $selected = ($id_categoria_option == $id_categoria) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $id_categoria_option; ?>" <?php echo $selected; ?>><?php echo $nome_categoria_option; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="descricao_tarefa" class="form-label">Descrição da Tarefa</label>
                                                        <textarea class="form-control" name="descricao_tarefa" id="descricao_tarefa" cols="30" rows="9" style="padding: 0.375rem 0 0.75 rem; color: black; font-weight: 400; line-height: 1.5; resize: none;" placeholder="Insira a descrição aqui"><?php echo $visualizar_descricao_tarefa; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer mt-3">
                                                <input type="hidden" name="id_tarefa" value="<?php echo $id_tarefa; ?>">

                                                <button type="button" class="btn btn-primary btn-editar-tarefa" data-id="<?php echo $id_tarefa; ?>">Salvar</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="container-fluid text-center">
                    <h1>
                        Nenhuma Tarefa Arquivada!
                    </h1><br>
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Nova Tarefa</button>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- ADICIONAR TAREFA -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content" style="background-color: #282c34;">
                <div class="modal-header">
                    <h1 class="modal-title text-light fs-5" id="exampleModalLabel">Nova Tarefa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none;">
                        <span aria-hidden="true" style="color: white; font-size: 3em; top: -8px; position: absolute; right: 10px;">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample form-tarefa" method="post" action="../php/backend/proc_nova_tarefa.php">
                        <div class="mb-3">
                            <label for="titulo_tarefa" class="col-form-label text-light">Título:</label><span style="color: red;"> *</span>
                            <input type="text" class="form-control" name="titulo_tarefa" id="titulo_tarefa" placeholder="Insira o título aqui" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria_tarefa" class="col-form-label text-light">Categoria:</label><span style="color: red;"> *</span>
                            <select name="categoria" class="form-control" required>
                                <option value="" selected>Selecione a Categoria desejada</option>
                                <?php
                                $find_categorias = "SELECT * FROM categorias ORDER BY nome_categoria ASC";
                                $exec_find_categoria = mysqli_query($con, $find_categorias);

                                while ($categorias_rows = mysqli_fetch_assoc($exec_find_categoria)) {
                                    $id_categoria = $categorias_rows["id_categoria"];
                                    $nome_categoria = $categorias_rows["nome_categoria"];

                                ?>
                                    <option value="<?php echo $id_categoria; ?>"><?php echo $nome_categoria; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descricao_tarefa" class="col-form-label text-light">Descrição:</label><span style="color: red;"> *</span>
                            <textarea class="form-control" name="descricao_tarefa" id="descricao_tarefa" cols="30" rows="9" style="resize: none;" placeholder="Insira a descrição aqui" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-adicionar-tarefa">Adicionar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <script src="../assets/js/procedures.js"></script>

    <?php if ($_SESSION['login_arquivadas'] == 0) { ?>
        <script src="../assets/js/functions.js"></script>
    <?php } else { ?>
        <script src="../assets/js/elements.js"></script>
    <?php } ?>
</body>

</html>