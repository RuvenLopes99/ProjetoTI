<?php
header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Se receber dados, responde com sucesso.
    $nome = $_POST['nome'] ?? 'ninguém';
    echo "Olá, " . htmlspecialchars($nome) . "! O seu pedido POST foi recebido com sucesso.";
} else {
    // Se receber um pedido GET (do navegador), dá instruções.
    echo "Este script responde a pedidos POST. Por favor, use o script de teste Python.";
}
?>