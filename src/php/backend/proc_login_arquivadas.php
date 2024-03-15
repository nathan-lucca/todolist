<?php
session_start();

require '../connect.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["senha_login_arquivadas"])) {
        $response['status'] = 'empty_fields';
        $response['message'] = 'Todos os campos precisam ser preenchidos!';
    } else {
        $senha = md5($_POST["senha_login_arquivadas"]);
        $usuario_logado = $_SESSION['id_logado'];

        $find_user = "SELECT * FROM usuarios WHERE id_usuario = $usuario_logado AND senha_arquivada_usuario = '$senha'";
        $result_user = mysqli_query($con, $find_user);

        if (mysqli_num_rows($result_user) > 0) {
            $_SESSION['login_arquivadas'] = 1;

            $response['status'] = 'success';
            $response['message'] = 'Desbloqueado com sucesso!';
        } else {
            $response['status'] = 'error_login';
            $response['message'] = 'Senha incorreta!';
        }

        mysqli_close($con);
    }
}

echo json_encode($response);
exit();
