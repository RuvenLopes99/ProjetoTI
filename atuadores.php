<?php
session_start();

// Apenas utilizadores autenticados podem controlar atuadores
if (!isset($_SESSION['username'])) {
    die("Acesso negado.");
}

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se os campos necessários existem
    if (isset($_POST['device']) && isset($_POST['estado'])) {
        
      
        $device_clicado = $_POST['device']; 
        $estado = $_POST['estado'];       

       
        $device_alvo_led = null; 

        if ($device_clicado == 'ventilador') {
            $device_alvo_led = 'led_pi'; 
        }
        if ($device_clicado == 'porta') {
            $device_alvo_led = 'led_esp'; 
        }
        
       
        $path_valor_clicado = "api/files/" . $device_clicado . "/valor.txt";
        $path_log_clicado = "api/files/" . $device_clicado . "/log.txt";

        if (file_exists($path_valor_clicado)) {
            
            file_put_contents($path_valor_clicado, $estado);

           
            $log_entry = date('Y-m-d H:i:s') . ";" . $estado . PHP_EOL;
            file_put_contents($path_log_clicado, $log_entry, FILE_APPEND);
        }

       
        if ($device_alvo_led !== null) {
            $path_valor_alvo = "api/files/" . $device_alvo_led . "/valor.txt";
            if (file_exists($path_valor_alvo)) {
               
                file_put_contents($path_valor_alvo, $estado);
            }
        }
        
        
        header("Location: dashboard.php");
        exit(); 

    } else {
        echo "Erro: Dados do formulário incompletos.";
    }
} else {
   
    echo "Método não permitido.";
    header("Location: dashboard.php");
}
?>