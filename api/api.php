<?php
header('Content-Type: text/html; charset=utf-8');
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['nome']) && isset($_POST['valor']) && isset($_POST['hora']))//resultados do postman
    {

        if (file_exists("files/" . $_POST['nome'])){

            echo file_put_contents("files/" . $_POST['nome'] . "/valor.txt", $_POST['valor']);
            echo file_put_contents("files/" . $_POST['nome'] . "/hora.txt", $_POST['hora']);
            echo file_put_contents("files/" . $_POST['nome'] . "/log.txt", $_POST['hora'] . ";" . $_POST['valor'] . PHP_EOL, FILE_APPEND);
            //escreve no ficheiro
        }
        else{

            http_response_code(400); //bad request
        }
    }
    else{
        http_response_code(400);
    }
}
    
else if($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['nome'])){
        
        if (file_exists("files/" . $_GET['nome'])){

            echo file_get_contents("files/" . $_GET['nome'] . "/valor.txt");

        }
        else{

            http_response_code(400);
        }
    }
    else{
        echo "faltam parametros no GET";
        http_response_code(400);
    }
}
else
{
    echo "Método não Permitido";
    http_response_code(403); //forbidden
}
?>