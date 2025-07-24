<?php
session_start();
require_once '../config.php';
require_once '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel'])) {
    $file = $_FILES['excel']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    foreach ($sheet->getRowIterator(2) as $row) { // Skip header
        $cells = [];
        foreach ($row->getCellIterator() as $cell) {
            $cells[] = $cell->getValue();
        }
        list($subjectName, $testName, $questionText, $opt1, $opt2, $opt3, $opt4, $correct) = $cells;
        // Subject
        $stmt = $pdo->prepare('SELECT id FROM subjects WHERE name = ?');
        $stmt->execute([$subjectName]);
        $subject = $stmt->fetch();
        if (!$subject) {
            $stmt = $pdo->prepare('INSERT INTO subjects(name) VALUES(?)');
            $stmt->execute([$subjectName]);
            $subject_id = $pdo->lastInsertId();
        } else {
            $subject_id = $subject['id'];
        }
        // Test
        $stmt = $pdo->prepare('SELECT id FROM tests WHERE name = ? AND subject_id = ?');
        $stmt->execute([$testName, $subject_id]);
        $test = $stmt->fetch();
        if (!$test) {
            $stmt = $pdo->prepare('INSERT INTO tests(name, subject_id) VALUES(?, ?)');
            $stmt->execute([$testName, $subject_id]);
            $test_id = $pdo->lastInsertId();
        } else {
            $test_id = $test['id'];
        }
        // Question
        $stmt = $pdo->prepare('INSERT INTO questions(test_id, question_text) VALUES(?, ?)');
        $stmt->execute([$test_id, $questionText]);
        $qid = $pdo->lastInsertId();
        $options = [$opt1, $opt2, $opt3, $opt4];
        foreach ($options as $index => $text) {
            $is_correct = ($correct == $index+1) ? 1 : 0;
            $stmt = $pdo->prepare('INSERT INTO options(question_id, text, is_correct) VALUES(?, ?, ?)');
            $stmt->execute([$qid, $text, $is_correct]);
        }
    }
    $message = 'Importación completada';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Importar Pruebas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="container py-4">
    <h1>Importar Pruebas desde Excel</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="excel" accept=".xlsx,.xls" required>
        <button class="btn btn-primary" type="submit">Subir</button>
    </form>
    <a href="dashboard.php">Volver al panel</a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <?php if ($message): ?>
    <script>toastr.success('<?php echo $message; ?>');</script>
    <?php endif; ?>
</body>
</html>
