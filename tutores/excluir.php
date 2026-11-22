
<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../config/auth.php';
exigirLogin();

$id = (int)($_GET['id'] ?? 0);

// Verifica se existem animais vinculados ao tutor
$stmt = $pdo->prepare("SELECT COUNT(*) FROM animais WHERE tutor_id = ?");
$stmt->execute([$id]);
$quantidade = $stmt->fetchColumn();

if ($quantidade > 0) {
    echo '<script>
        alert("Não é possível excluir este tutor, pois existem animais vinculados a ele.");
        window.location.href = "index.php";
    </script>';
    exit;
}

// Exclui o tutor caso não existam animais vinculados
$stmt = $pdo->prepare("DELETE FROM tutores WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit;
