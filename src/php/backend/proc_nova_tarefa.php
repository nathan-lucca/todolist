<?php
session_start();
require '../connect.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["titulo_tarefa"]) || empty($_POST["categoria"]) || empty($_POST["descricao_tarefa"])) {
        $response['status'] = 'empty_fields';
        $response['message'] = 'Todos os campos precisam ser preenchidos!';
    } else {
        $usuario_id = $_SESSION['id_logado'];
        $titulo = mysqli_real_escape_string($con, $_POST["titulo_tarefa"]);
        $categoria = $_POST["categoria"];
        $descricao = mysqli_real_escape_string($con, $_POST["descricao_tarefa"]);

        $sqlNovaTarefa = "INSERT INTO tarefas (id_usuario, id_categoria, titulo_tarefa, descricao_tarefa) VALUES ($usuario_id, $categoria, '$titulo', '$descricao')";

        if (mysqli_query($con, $sqlNovaTarefa)) {
            $response['status'] = 'success';
            $response['message'] = 'Tarefa adicionada com sucesso!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Erro ao adicionar a tarefa: ' . mysqli_error($con);
        }

        mysqli_close($con);
    }
}

echo json_encode($response);
exit();
