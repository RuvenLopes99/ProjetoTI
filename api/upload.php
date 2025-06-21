<?php
// Define que a resposta será em formato JSON, ideal para APIs
header('Content-Type: application/json; charset=utf-8');

// Resposta padrão
$response = ['status' => 'error', 'message' => 'Método não permitido.'];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Verifica se o ficheiro 'imagem' foi enviado e não teve erros
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0){
        
        $target_dir = "imagens/"; // O ficheiro será guardado em /api/imagens/
        
        // Verifica se o diretório de destino existe e tem permissão de escrita
        if (!is_dir($target_dir) || !is_writable($target_dir)) {
            $response['message'] = 'Erro no servidor: O diretório de uploads não existe ou não tem permissão de escrita.';
            http_response_code(500); // Erro Interno do Servidor
        } else {
            $tmp_name = $_FILES["imagem"]["tmp_name"];
            $name = basename($_FILES["imagem"]["name"]);
            $target_file = $target_dir . $name;
            
            // Verifica se o ficheiro foi movido com sucesso
            if (move_uploaded_file($tmp_name, $target_file)) {
                $response['status'] = 'success';
                $response['message'] = 'Upload de ' . htmlspecialchars($name) . ' realizado com sucesso.';
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