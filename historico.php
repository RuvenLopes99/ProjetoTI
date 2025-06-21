<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("refresh:5;url=index.php");
    die("Acesso restrito.");
}
    $title=$_GET['title'];

    $log_txt = file_get_contents("api/files/" . $title . "/log.txt");

?>
<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Estacionamento - Histórico</title>
        <link rel="icon" type="image/x-icon" href="imagens/square-parking-solid.ico">
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
            crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
    <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php">Dashboard Estacionamento</a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="dashboard.php">Página Principal</a>
                        </li>
                    </ul>

                    <a href="logout.php" class="btn btn-outline-secondary">Sair</a>

                </div>
            </div>
        </nav>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-xxl-12 text-center">
                <h1>Histórico -
                    <?php echo $title?></h1>
                    
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <ul class="list-group">
                    <li class="list-group-item"><?php echo nl2br($log_txt)?></li>
                </ul>
            </div>
        </div>
    </div>
    </body>
</html>