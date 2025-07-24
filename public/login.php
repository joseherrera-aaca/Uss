<?php
session_start();
require_once '../config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: ../admin/dashboard.php');
        exit;
    } else {
        $message = 'Credenciales incorrectas';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="container py-4">
    <h1>Login</h1>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input class="form-control" type="text" name="username" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input class="form-control" type="password" name="password" required>
        </div>
        <button class="btn btn-primary" type="submit">Ingresar</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <?php if ($message): ?>
    <script>toastr.error('<?php echo $message; ?>');</script>
    <?php endif; ?>
</body>
</html>
