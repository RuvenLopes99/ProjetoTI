<?php
// api_get_estado.php

// Define o tipo de conteúdo da resposta como texto simples
header('Content-Type: text/plain');

// Verifica se o parâmetro 'nome' foi enviado via GET
if (isset($_GET['nome'])) {
    $device = $_GET['nome'];
    $file_path = "files/" . $device . "/valor.txt";

    // Verifica se o ficheiro do dispositivo existe antes de ler
    if (file_exists($file_path)) {
        echo file_get_contents($file_path);
    } else {
        // Retorna um erro 404 se o dispositivo não for encontrado
        http_response_code(404);
        echo "Dispositivo nao encontrado.";
    }
} else {
    // Retorna um erro 400 se o parâmetro 'nome' não for fornecido
    http_response_code(400);
    echo "Parametro 'nome' em falta.";
}
?>