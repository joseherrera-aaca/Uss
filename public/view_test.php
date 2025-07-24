<?php
require_once '../config.php';
if (!isset($_GET['id'])) {
    die('ID de prueba no proporcionado');
}
$test_id = (int)$_GET['id'];
$stmt = $pdo->prepare('SELECT name FROM tests WHERE id = ?');
$stmt->execute([$test_id]);
$test = $stmt->fetch();
if (!$test) {
    die('Prueba no encontrada');
}
$stmt = $pdo->prepare('SELECT * FROM questions WHERE test_id = ?');
$stmt->execute([$test_id]);
$questions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($test['name']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
    </style>
</head>
<body class="container py-4">
    <h1><?php echo htmlspecialchars($test['name']); ?></h1>
    <?php foreach ($questions as $index => $q): ?>
        <div class="mb-3">
            <strong><?php echo ($index+1) . '. ' . htmlspecialchars($q['question_text']); ?></strong>
            <div>
                <?php
                $stmt = $pdo->prepare('SELECT * FROM options WHERE question_id = ?');
                $stmt->execute([$q['id']]);
                $options = $stmt->fetchAll();
                ?>
                <?php foreach ($options as $opt): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="q<?php echo $q['id']; ?>">
                        <label class="form-check-label"><?php echo htmlspecialchars($opt['text']); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
