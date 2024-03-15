<?php
// Iniciar a sessão
session_start();

// Esvaziar a sessão
$_SESSION = array();

// Verificar se os cookies estão sendo usados
if (ini_get("session.use_cookies")) {
    // Obter os parâmetros do cookie da sessão
    $params = session_get_cookie_params();

    // Definir todos os cookies para o domínio como vazios e expirados
    foreach ($_COOKIE as $cookie_name => $cookie_value) {
        setcookie(
            $cookie_name,
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
}

// Destruir a sessão
session_destroy();

// Redirecionar para a página inicial
header('Location: ../../../index.php');
