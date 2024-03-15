<?php
session_start();

require '../connect.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email_usuario"]) || empty($_POST["senha_usuario"])) {
        $response['status'] = 'empty_fields';
        $response['message'] = 'Todos os campos precisam ser preenchidos!';
    } else {
        $email = $_POST["email_usuario"];
        $senha = md5($_POST["senha_usuario"]);

        $find_user = "SELECT * FROM usuarios WHERE email_usuario = '$email' AND senha_usuario = '$senha'";
        $result_user = mysqli_query($con, $find_user);

        if (mysqli_num_rows($result_user) > 0) {
            $row = mysqli_fetch_assoc($result_user);

            $_SESSION['user_logado'] = $row['nome_usuario'];
            $_SESSION['email_logado'] = $row['email_usuario'];
            $_SESSION['id_logado'] = $row['id_usuario'];

            $response['status'] = 'success';
            $response['message'] = 'Login realizado com sucesso!';
        } else {
            $response['status'] = 'error_login';
            $response['message'] = 'Email/Senha incorretos ou não encontrados!';
        }

        mysqli_close($con);
    }
}

echo json_encode($response);
exit();
