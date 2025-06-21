<?php
header('Content-Type: text/plain; charset=utf-8');

// O caminho relativo para a pasta, a partir da localização do script
$dir_path = 'imagens/';

echo "A verificar o diretório: '" . $dir_path . "'\n";
echo "Caminho completo tentado: '" . realpath($dir_path) . "'\n\n";

if (is_dir($dir_path)) {
    echo "[OK] O caminho '$dir_path' é um diretório.\n";

    // A verificação mais importante
    if (is_writable($dir_path)) {
        echo "\n[SUCESSO] O diretório É gravável pelo servidor web!\n";
    } else {
        echo "\n[ERRO] O diretório NÃO é gravável pelo servidor web.\n";
        echo "Isto confirma que é um problema de permissões no servidor.\n";
        echo "SOLUÇÃO: Altere as permissões da pasta 'api/imagens/' para 777.\n";
    }
} else {
    echo "\n[ERRO] O diretório '$dir_path' não foi encontrado ou não é um diretório.\n";
    echo "Verifique se a pasta 'imagens' realmente existe dentro da pasta 'api'.\n";
}
?>