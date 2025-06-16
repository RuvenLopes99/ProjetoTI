<?php
header('Content-Type: text/html; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_FILES['imagem']){
        $tmp_name = $_FILES["imagem"]["tmp_name"];
        $name = basename($_FILES["imagem"]["name"]);
        move_uploaded_file($tmp_name, "imagens/".$name);
        header('Location: /projeto/dashboard.php');
    }
    else{
        echo "Não existe o elemento imagem";
    }
}
else
{
    echo "Erro" . $_SERVER ["REDIRECT_STATUS"];
}

?>