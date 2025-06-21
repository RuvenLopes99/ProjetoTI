<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("refresh:5;url=index.php");
    die("Acesso restrito.");
}

// Lógica para obter todas as imagens e ordená-las por data
$imagens_dir = 'api/imagens/';
$images = [];
if (is_dir($imagens_dir)) {
    $files = array_diff(scandir($imagens_dir), array('.', '..', 'desktop.ini'));
    foreach ($files as $file) {
        $filepath = $imagens_dir . $file;
        if (is_file($filepath)) {
            // Adiciona a imagem e a sua data de modificação ao array
            $images[$filepath] = filemtime($filepath);
        }
    }
    // Ordena o array por data (mais recente primeiro)
    arsort($images);
}
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hospital Inteligente - Histórico de Imagens</title>
    <link rel="icon" type="image/x-icon" href="imagens/square-parking-solid.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Hospital Inteligente</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Página Principal</a>
                    </li>
                </ul>
                <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <h1 class="text-center mb-4">Histórico de Imagens da Webcam</h1>
        <div class="row">
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image_path => $timestamp): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card">
                            <img src="<?php echo $image_path; ?>" class="card-img-top" alt="Captura de <?php echo date('d-m-Y H:i:s', $timestamp); ?>">
                            <div class="card-footer text-center">
                                <small class="text-muted">
                                    <?php echo date('d-m-Y H:i:s', $timestamp); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Ainda não foram enviadas imagens.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>