<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("refresh:5;url=index.php");
    die("Acesso restrito.");
}
$valor_Humidade = file_get_contents("api/files/Humidade/valor.txt");
$hora_Humidade = file_get_contents("api/files/Humidade/hora.txt");
$nome_Humidade = file_get_contents("api/files/Humidade/nome.txt");//lê o ficheiro e transforma em string

$valor_temperatura = file_get_contents("api/files/Temperatura/valor.txt");
$hora_temperatura = file_get_contents("api/files/Temperatura/hora.txt");
$nome_temperatura = file_get_contents("api/files/Temperatura/nome.txt");

$valor_CO2 = file_get_contents("api/files/CO2/valor.txt");
$hora_CO2 = file_get_contents("api/files/CO2/hora.txt");
$nome_CO2 = file_get_contents("api/files/CO2/nome.txt");



$valor_porta = file_get_contents("api/files/porta/valor.txt");
$hora_porta = file_get_contents("api/files/porta/hora.txt");
$nome_porta = file_get_contents("api/files/porta/nome.txt");



$valor_ventilador = file_get_contents("api/files/ventilador/valor.txt");
$hora_ventilador = file_get_contents("api/files/ventilador/hora.txt");
$nome_ventilador = file_get_contents("api/files/ventilador/nome.txt");

$valor_aspressor = file_get_contents("api/files/aspressor/valor.txt");
$hora_aspressor = file_get_contents("api/files/aspressor/hora.txt");
$nome_aspressor = file_get_contents("api/files/aspressor/nome.txt");

?>

<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta http-equiv="refresh" content="5"> -->
    <title>Estufa Inteligente</title>
    <link rel="icon" type="image/x-icon" href="imagens/square-parking-solid.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Estufa Inteligente</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Página Principal</a>
                    </li>
                </ul>

                <a href="logout.php" class="btn btn-outline-secondary">Logout</a>

            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <img class="float-end" src="imagens/estg.png" alt="Logo IPL" width="300">
                <h1>Servidor IoT - Estufa</h1>
                <p>
                    Bem-vindo
                    <strong><?php echo $_SESSION['username'] ?></strong>
                </p>
                <p>Tecnologia de Internet - Engenharia Informática</p>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"><!--são as doze colunas da pág toda/margin bottom -->
                <div class="card">
                    <div class="card-header text-center sensor" <?php if ($valor_Humidade == "Livre") { ?> style="background-color: #02C39A;" <?php } ?>>
                        <strong><?php echo $nome_Humidade . ": " . $valor_Humidade ?></strong>
                    </div>
                    <div class="card-body text-center">
                        <img class="funcionality-img" src="imagens/Humidade.png" alt="Humidade">
                    </div>
                    <div class="card-footer text-center">
                        <strong>Atualização:</strong>
                        <?php echo $hora_Humidade ?>
                        <br>
                        <a href="historico.php?title=Humidade">Histórico</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-center sensor" <?php if ($valor_temperatura >= 1) { ?> style="background-color: #02C39A;" <?php } ?>>
                        <strong> <?php echo $nome_temperatura . ": " . $valor_temperatura ?></strong>
                    </div>
                    <div class="card-body text-center">
                        <img class="funcionality-img" src="imagens/Temperatura.png" alt="Temperatura">
                    </div>
                    <div class="card-footer text-center">
                        <strong>Atualização:</strong>
                        <?php echo $hora_temperatura ?>
                        <br>
                        <a href="historico.php?title=Temperatura">Histórico</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-center sensor" <?php if ($valor_CO2 <= 900) { ?> style="background-color: #02C39A;" <?php } ?>>
                        <strong><?php echo $nome_CO2 . ": " . (($valor_CO2 )) ?></strong>
                    </div>
                    <div class="card-body text-center">
                        <img class="funcionality-img" src="imagens/CO2.png" alt="CO2">
                    </div>
                    <div class="card-footer text-center">
                        <strong>Atualização:</strong>
                        <?php echo $hora_CO2 ?>
                        <br>
                        <a href="historico.php?title=CO2">Histórico</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-center" style="background-color: #02C39A;">
                        <strong><?php echo $nome_porta . ": " . $valor_porta ?></strong>
                    </div>
                    <div class="card-body text-center">
                        <img class="funcionality-img" src="imagens/porta.png" alt="porta">
                    </div>
                    <div class="card-footer text-center">
                        <strong>Atualização:</strong>
                        <?php echo $hora_porta ?>
                        <br>
                        <a href="historico.php?title=porta">Histórico</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-center sensor" <?php if ($valor_ventilador == 0) { ?> style="background-color: #02C39A;" <?php } ?>>
                        <strong>Ventilador: <?php echo ($valor_ventilador == 1) ? "Ligado" : "Desligado" ?></strong>
                    </div>
                    <div class="card-body text-center">
                        <img class="funcionality-img" src="imagens/ventilador.png" alt="ventilador">
                    </div>
                    <div class="card-footer text-center">
                        <strong>Atualização:</strong>
                        <?php echo $hora_ventilador ?>
                        <br>
                        <a href="historico.php?title=ventilador">Histórico</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-center sensor" <?php if ($valor_aspressor == 0) { ?> style="background-color: #02C39A;" <?php } ?>>
                        <strong>Aspressor: <?php echo ($valor_aspressor == 1) ? "Ligado" : "Desligado" ?></strong>
                    </div>
                    <div class="card-body text-center">
                        <img class="funcionality-img" src="imagens/aspressor.png" alt="aspressor">
                    </div>
                    <div class="card-footer text-center">
                        <strong>Atualização:</strong>
                        <?php echo $hora_aspressor ?>
                        <br>
                        <a href="historico.php?title=aspressor">Histórico</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Tabela de Sensores</strong>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Tipo de dispositivo IoT</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Data de Atualização</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <?php echo $nome_Humidade ?></td>
                                    <td><?php echo $valor_Humidade ?></td>
                                    <td><?php echo $hora_Humidade ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo $nome_temperatura ?></td>
                                    <td><?php echo $valor_temperatura ?></td>
                                    <td><?php echo $hora_temperatura ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo $nome_CO2 ?></td>
                                    <td><?php echo $valor_CO2 ?></td>
                                    <td><?php echo $hora_CO2 ?></td>
                                </tr>
                                <tr>
                                    <td> <?php echo $nome_porta ?></td>
                                    <td><?php echo $valor_porta ?></td>
                                    <td><?php echo $hora_porta ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>