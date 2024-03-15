<?php
session_start();

require '../connect.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nome_usuario"]) || empty($_POST["email_usuario"]) || empty($_POST["senha_usuario"]) || empty($_POST["senha_arquivadas_usuario"])) {
        $response['status'] = 'empty_fields';
        $response['message'] = 'Todos os campos precisam ser preenchidos!';
    } else {
        $nome = mysqli_real_escape_string($con, $_POST["nome_usuario"]);
        $email = $_POST["email_usuario"];
        $senha = md5($_POST["senha_usuario"]);
        $senha_arquivada = md5($_POST["senha_arquivadas_usuario"]);

        $find_user = "SELECT * FROM usuarios WHERE email_usuario = '$email'";
        $result_user = mysqli_query($con, $find_user);

        if (mysqli_num_rows($result_user) > 0) {
            $response['status'] = 'find_user';
            $response['message'] = 'Esse email já está cadastrado no sistema!';
        } else {
            $sqlCadastro = "INSERT INTO usuarios (nome_usuario, email_usuario, senha_usuario, senha_arquivada_usuario) VALUES ('$nome', '$email', '$senha', '$senha_arquivada')";

            if (mysqli_query($con, $sqlCadastro)) {
                $find_last_user = "SELECT * FROM usuarios WHERE email_usuario = '$email'";
                $result_last_user = mysqli_query($con, $find_last_user);
                $row = mysqli_fetch_assoc($result_last_user);

                $_SESSION['user_logado'] = $row['nome_usuario'];
                $_SESSION['email_logado'] = $row['email_usuario'];
                $_SESSION['id_logado'] = $row['id_usuario'];

                $response['status'] = 'success';
                $response['message'] = 'Cadastro realizado com sucesso!';
            }
        }

        mysqli_close($con);
    }
}

echo json_encode($response);
exit();
