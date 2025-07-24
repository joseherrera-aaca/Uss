<?php
require_once '../config.php';
// Fetch tests with subjects
$stmt = $pdo->query('SELECT tests.id, tests.name AS test_name, subjects.name AS subject_name FROM tests JOIN subjects ON tests.subject_id = subjects.id');
$tests = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Repositorio de Pruebas</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
    </style>
</head>
<body class="container py-4">
<h1 class="mb-4">Repositorio de Pruebas</h1>
<table id="tests" class="display">
    <thead>
        <tr>
            <th>Asignatura</th>
            <th>Nombre de Prueba</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tests as $test): ?>
        <tr>
            <td><?php echo htmlspecialchars($test['subject_name']); ?></td>
            <td><?php echo htmlspecialchars($test['test_name']); ?></td>
            <td><a href="view_test.php?id=<?php echo $test['id']; ?>" class="btn btn-primary btn-sm">Ver</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function() {
    $('#tests').DataTable();
});
</script>
</body>
</html>
