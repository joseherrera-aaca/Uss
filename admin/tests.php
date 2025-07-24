<?php
session_start();
require_once '../config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $subject_id = (int)($_POST['subject_id'] ?? 0);
    $stmt = $pdo->prepare('INSERT INTO tests(name, subject_id) VALUES(?, ?)');
    $stmt->execute([$name, $subject_id]);
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>Swal.fire('Prueba creada');</script>";
}
$tests = $pdo->query('SELECT tests.*, subjects.name as subject_name FROM tests JOIN subjects ON tests.subject_id = subjects.id')->fetchAll();
$subjects = $pdo->query('SELECT * FROM subjects')->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pruebas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="container py-4">
    <h1>Pruebas</h1>
    <form method="post" class="mb-3">
        <div class="mb-3">
            <label class="form-label">Nombre de prueba</label>
            <input class="form-control" type="text" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Asignatura</label>
            <select class="form-select" name="subject_id">
                <?php foreach ($subjects as $sub): ?>
                <option value="<?php echo $sub['id']; ?>"><?php echo htmlspecialchars($sub['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Agregar</button>
    </form>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Nombre</th><th>Asignatura</th></tr></thead>
        <tbody>
            <?php foreach ($tests as $t): ?>
            <tr><td><?php echo $t['id']; ?></td><td><?php echo htmlspecialchars($t['name']); ?></td><td><?php echo htmlspecialchars($t['subject_name']); ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="dashboard.php">Volver al panel</a>
</body>
</html>
