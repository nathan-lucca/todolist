<?php
require '../connect.php';

$response = array();

if (isset($_GET['id_tarefa'])) {
    $id_tarefa = $_GET['id_tarefa'];

    $query = "DELETE FROM tarefas WHERE id_tarefa = '$id_tarefa'";

    if (mysqli_query($con, $query)) {
        $response['status'] = 'success';
        $response['message'] = 'Tarefa excluída com sucesso!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Erro ao excluir a tarefa: ' . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    $response['status'] = 'error';
    $response['message'] = 'ID da tarefa não fornecido.';
}

echo json_encode($response);
