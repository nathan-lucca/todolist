<?php
require 'config.php';

$con = mysqli_connect($server, $user, $pass, $bd);

if (mysqli_connect_errno()) {
    echo "Erro de Conexão com o Banco de Dados: " . mysqli_connect_error();
    exit();
}
