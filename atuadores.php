<?php
session_start();
// Apenas utilizadores autenticados podem controlar atuadores
if (!isset($_SESSION['username'])) {
    die("Acesso negado.");
}

// Verifica se os dados do formulário foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se os campos 'device' e 'estado' existem
    if (isset($_POST['device']) && isset($_POST['estado'])) {
        
        $device = $_POST['device'];
        $estado = $_POST['estado'];
        
        // --- Medida de Segurança ---
        // Lista de atuadores permitidos. Evita que alguém tente escrever em pastas não autorizadas.
        $atuadores_permitidos = ['ventilador', 'aspressor', 'porta', 'LuzSBC'];
        
        if (in_array($device, $atuadores_permitidos)) {
            
            $path_valor = "api/files/" . $device . "/valor.txt";
            $path_log = "api/files/" . $device . "/log.txt";
            
            // Escreve o novo estado no ficheiro valor.txt
            file_put_contents($path_valor, $estado);
            
            // Adiciona uma entrada ao log
            $hora_log = date('Y-m-d H:i:s');
            $log_entry = $hora_log . ";" . $estado . PHP_EOL;
            file_put_contents($path_log, $log_entry, FILE_APPEND);
            
            // Redireciona de volta para a dashboard para ver a alteração
            header("Location: dashboard.php");
            exit(); // Termina o script após o redirecionamento
            
        } else {
            echo "Erro: Dispositivo não permitido.";
        }
    } else {
        echo "Erro: Dados do formulário incompletos.";
    }
} else {
    // Se alguém tentar aceder ao ficheiro diretamente via URL
    echo "Método não permitido.";
    header("Location: dashboard.php");
}
?>