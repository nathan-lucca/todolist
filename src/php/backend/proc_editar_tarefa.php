<?php
session_start();
require '../connect.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["titulo_tarefa"]) || empty($_POST["categoria_tarefa"]) || empty($_POST["descricao_tarefa"])) {
        $response['status'] = 'empty_fields';
        $response['message'] = 'Todos os campos precisam ser preenchidos!';
    } else {
        $usuario_id = $_SESSION['id_logado'];
        $id_tarefa = $_POST["id_tarefa"];
        $titulo = mysqli_real_escape_string($con, $_POST["titulo_tarefa"]);
        $categoria = $_POST["categoria_tarefa"];
        $descricao = mysqli_real_escape_string($con, $_POST["descricao_tarefa"]);

        $sqlEditarTarefa = "UPDATE tarefas SET id_categoria = $categoria, titulo_tarefa = '$titulo', descricao_tarefa = '$descricao' WHERE id_tarefa = $id_tarefa AND id_usuario = $usuario_id";

        if (mysqli_query($con, $sqlEditarTarefa)) {
            $response['status'] = 'success';
            $response['message'] = 'Tarefa editada com sucesso!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Erro ao editar a tarefa: ' . mysqli_error($con);
        }

        mysqli_close($con);
    }
}

echo json_encode($response);
exit();
