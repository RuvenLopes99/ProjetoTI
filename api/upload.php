<?php
// Define que a resposta será em formato JSON, ideal para APIs
header('Content-Type: application/json; charset=utf-8');

// --- Requisitos do Projeto ---
$max_filesize_kb = 1000; // Tamanho máximo de 1000kB
$allowed_extensions = ['jpg', 'png']; // Extensões permitidas

// Resposta padrão
$response = ['status' => 'error', 'message' => 'Método não permitido.'];
http_response_code(405); // Method Not Allowed

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Verifica se o ficheiro 'imagem' foi enviado e não teve erros
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        
        $target_dir = "imagens/";
        $file = $_FILES['imagem'];
        $filename = basename($file["name"]);
        $target_file = $target_dir . $filename;
        $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $file_size_kb = $file['size'] / 1024;

        // --- Validações ---
        
        // 1. Validar a extensão do ficheiro
        if (!in_array($file_extension, $allowed_extensions)) {
            $response['message'] = 'Erro: Apenas são permitidos ficheiros .jpg ou .png.';
            http_response_code(415); // Unsupported Media Type
        
        // 2. Validar o tamanho do ficheiro
        } elseif ($file_size_kb > $max_filesize_kb) {
            $response['message'] = 'Erro: O ficheiro excede o tamanho máximo de ' . $max_filesize_kb . 'kB.';
            http_response_code(413); // Payload Too Large

        // 3. Verificar se o diretório de destino existe e tem permissão de escrita
        } elseif (!is_dir($target_dir) || !is_writable($target_dir)) {
            $response['message'] = 'Erro no servidor: O diretório de uploads não existe ou não tem permissão de escrita.';
            http_response_code(500); // Erro Interno do Servidor

        } else {
            // Tenta mover o ficheiro
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $response['status'] = 'success';
                $response['message'] = 'Upload de ' . htmlspecialchars($filename) . ' realizado com sucesso.';
                http_response_code(200); // OK
            } else {
                $response['message'] = 'Ocorreu um erro ao guardar o ficheiro.';
                http_response_code(500); // Erro Interno do Servidor
            }
        }
    }
    else{
        $response['message'] = "Pedido inválido: Nenhum ficheiro 'imagem' recebido ou ocorreu um erro no upload.";
        http_response_code(400); // Pedido Inválido
    }
}

// Envia a resposta final como JSON
echo json_encode($response);
?>