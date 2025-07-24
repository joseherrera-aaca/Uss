<?php
session_start();
require_once '../config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $test_id = (int)($_POST['test_id'] ?? 0);
    $question = $_POST['question'] ?? '';
    $options = $_POST['options'] ?? [];
    $correct = $_POST['correct'] ?? '';
    $stmt = $pdo->prepare('INSERT INTO questions(test_id, question_text) VALUES(?, ?)');
    $stmt->execute([$test_id, $question]);
    $qid = $pdo->lastInsertId();
    foreach ($options as $index => $text) {
        $is_correct = ($correct == $index) ? 1 : 0;
        $stmt = $pdo->prepare('INSERT INTO options(question_id, text, is_correct) VALUES(?, ?, ?)');
        $stmt->execute([$qid, $text, $is_correct]);
    }
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>Swal.fire('Pregunta creada');</script>";
}
$tests = $pdo->query('SELECT * FROM tests')->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Preguntas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h1>Preguntas</h1>
    <form method="post" class="mb-3">
        <div class="mb-3">
            <label class="form-label">Prueba</label>
            <select class="form-select" name="test_id">
                <?php foreach ($tests as $t): ?>
                <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Pregunta</label>
            <input class="form-control" type="text" name="question" required>
        </div>
        <?php for ($i=0; $i<4; $i++): ?>
            <div class="mb-3">
                <label class="form-label">Opción <?php echo $i+1; ?></label>
                <input class="form-control" type="text" name="options[]" required>
            </div>
        <?php endfor; ?>
        <div class="mb-3">
            <label class="form-label">Respuesta Correcta (0-3)</label>
            <input class="form-control" type="number" name="correct" min="0" max="3" required>
        </div>
        <button class="btn btn-primary" type="submit">Agregar</button>
    </form>
    <a href="dashboard.php">Volver al panel</a>
</body>
</html>
