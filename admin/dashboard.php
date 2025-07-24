<?php
session_start();
require_once '../config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}
// Fetch subjects and tests count
$subjects = $pdo->query('SELECT COUNT(*) as count FROM subjects')->fetch()['count'];
$tests = $pdo->query('SELECT COUNT(*) as count FROM tests')->fetch()['count'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="container py-4">
    <h1 class="mb-4">Panel de Administración</h1>
    <p><strong>Asignaturas:</strong> <?php echo $subjects; ?></p>
    <p><strong>Pruebas:</strong> <?php echo $tests; ?></p>
    <a href="subjects.php" class="btn btn-secondary">Gestionar Asignaturas</a>
    <a href="tests.php" class="btn btn-secondary">Gestionar Pruebas</a>
    <a href="questions.php" class="btn btn-secondary">Gestionar Preguntas</a>
    <a href="logout.php" class="btn btn-danger">Salir</a>
</body>
</html>
