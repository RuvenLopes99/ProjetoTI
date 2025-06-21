<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("refresh:5;url=index.php");
    die("Acesso restrito.");
}
$imagens_dir = 'api/imagens/';
$latest_image = null;
$latest_time = 0;

if (is_dir($imagens_dir)) {
    $files = array_diff(scandir($imagens_dir), array('.', '..', 'desktop.ini'));
    foreach ($files as $file) {
        $filepath = $imagens_dir . $file;
        if (is_file($filepath) && filemtime($filepath) > $latest_time) {
            $latest_time = filemtime($filepath);
            $latest_image = $filepath;
        }
    }
}
$hora_imagem = $latest_time ? date("Y-m-d H:i:s", $latest_time) : "N/A";
?>

<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="5">
    <title>Hospital Inteligente - Dashboard Dinâmica</title>
    <link rel="icon" type="image/x-icon" href="imagens/square-parking-solid.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Hospital Inteligente</a>
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
                    <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                </p>
                <p>Tecnologia de Internet - Engenharia Informática</p>
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="row">
            <?php
            $path = "api/files/";
            $dispositivos = is_dir($path) ? array_diff(scandir($path), array('.', '..')) : [];
            $atuadores = ['ventilador', 'led_pi', 'led_esp','porta'];

            
            foreach ($dispositivos as $device_folder) {
                if ($device_folder == 'led_pi' || $device_folder == 'led_esp') {
                continue;
                }
                if (is_dir($path . $device_folder)) {
                    $nome = file_exists($path . $device_folder . "/nome.txt") ? trim(file_get_contents($path . $device_folder . "/nome.txt")) : "Nome Indefinido";
                    $valor = file_exists($path . $device_folder . "/valor.txt") ? trim(file_get_contents($path . $device_folder . "/valor.txt")) : "N/A";
                    $hora = file_exists($path . $device_folder . "/hora.txt") ? trim(file_get_contents($path . $device_folder . "/hora.txt")) : "N/A";
                    $imagem = "imagens/" . $device_folder . ".png";

                  
                    $header_style = ''; 
                    if (in_array($device_folder, $atuadores)) {
                        if ($valor == 'Ligado' || $valor == 'Aberta') {
                            $header_style = 'style="background-color: #28a745; color: white;"'; 
                        } elseif ($valor == 'Desligado' || $valor == 'Fechada') {
                            $header_style = 'style="background-color: #dc3545; color: white;"';
                        }
                    }
            ?>
                    <div class="col-sm-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header text-center sensor" <?php echo $header_style; ?>>
                                <strong><?php echo htmlspecialchars($nome) . ": " . htmlspecialchars($valor); ?></strong>
                            </div>
                            <div class="card-body text-center d-flex flex-column justify-content-between">
                                <img class="funcionality-img" 
                                     src="<?php echo file_exists($imagem) ? $imagem : 'imagens/default.png'; ?>" 
                                     alt="<?php echo htmlspecialchars($nome); ?>">

                                <?php if (in_array($device_folder, $atuadores)) : ?>
                                    <form action="atuadores.php" method="post" class="mt-3">
                                        <input type="hidden" name="device" value="<?php echo htmlspecialchars($device_folder); ?>">
                                        <div class="btn-group" role="group">
                                            <button type="submit" name="estado" value="Ligado" class="btn btn-success">Ligar</button>
                                            <button type="submit" name="estado" value="Desligado" class="btn btn-danger">Desligar</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer text-center">
                                <strong>Atualização:</strong> <?php echo htmlspecialchars($hora); ?>
                                <br>
                                <a href="historico.php?title=<?php echo urlencode($device_folder); ?>">Histórico</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Tabela de Dispositivos</strong>
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
                                <?php
                                foreach ($dispositivos as $device_folder) {
                                    if ($device_folder == 'led_pi' || $device_folder == 'led_esp') {
                                         continue;
                                    }      
                                    if (is_dir($path . $device_folder)) {
                                        $nome = trim(file_get_contents($path . $device_folder . "/nome.txt"));
                                        $valor = trim(file_get_contents($path . $device_folder . "/valor.txt"));
                                        $hora = trim(file_get_contents($path . $device_folder . "/hora.txt"));
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($nome); ?></td>
                                    <td><?php echo htmlspecialchars($valor); ?></td>
                                    <td><?php echo htmlspecialchars($hora); ?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <br>
    <script src="