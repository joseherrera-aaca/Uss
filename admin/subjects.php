<?php
session_start();
require_once '../config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $stmt = $pdo->prepare('INSERT INTO subjects(name) VALUES(?)');
    $stmt->execute([$name]);
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>Swal.fire('Asignatura creada');</script>";
}
$subjects = $pdo->query('SELECT * FROM subjects')->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Asignaturas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h1>Asignaturas</h1>
    <form method="post" class="mb-3">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input class="form-control" type="text" name="name" required>
        </div>
        <button class="btn btn-primary" type="submit">Agregar</button>
    </form>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Nombre</th></tr></thead>
        <tbody>
            <?php foreach ($subjects as $sub): ?>
            <tr><td><?php echo $sub['id']; ?></td><td><?php echo htmlspecialchars($sub['name']); ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="dashboard.php">Volver al panel</a>
</body>
</html>
