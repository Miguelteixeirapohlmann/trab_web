<?php

require_once 'includes/auth.php';
require_once 'includes/conexao.php';
include 'includes/header.php';
include 'includes/menu.php';

// CRUD de espécies
$erro = '';
// Adicionar espécie
if (isset($_POST['add_especie'])) {
    $especie = trim($_POST['especie']);
    if ($especie != '') {
        $stmt = $conn->prepare('INSERT INTO especies (especie) VALUES (?)');
        $stmt->bind_param('s', $especie);
        if (!$stmt->execute()) {
            $erro = 'Erro ao adicionar espécie.';
        }
    }
}
// Remover espécie
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $conn->query('DELETE FROM especies WHERE id = ' . $id);
}
// Editar espécie
if (isset($_POST['edit_especie'])) {
    $id = intval($_POST['id']);
    $especie = trim($_POST['especie']);
    if ($especie != '') {
        $stmt = $conn->prepare('UPDATE especies SET especie = ? WHERE id = ?');
        $stmt->bind_param('si', $especie, $id);
        $stmt->execute();
    }
}
// Listar espécies
$especies = $conn->query('SELECT * FROM especies ORDER BY especie');
?>
<body class="bg-light">
<div class="container">
    <h2>Gerenciar Espécies</h2>
    <?php if($erro): ?><div class="alert alert-danger"><?=$erro?></div><?php endif; ?>
    <form method="post" class="row g-3 mb-4">
        <div class="col-auto">
            <input type="text" name="especie" class="form-control" placeholder="Nova espécie" required>
        </div>
        <div class="col-auto">
            <button type="submit" name="add_especie" class="btn btn-success">Adicionar</button>
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead><tr><th>ID</th><th>Espécie</th><th>Ações</th></tr></thead>
        <tbody>
        <?php while($row = $especies->fetch_assoc()): ?>
            <tr>
                <td><?=$row['id']?></td>
                <td>
                    <form method="post" class="d-flex">
                        <input type="hidden" name="id" value="<?=$row['id']?>">
                        <input type="text" name="especie" value="<?=$row['especie']?>" class="form-control me-2" required>
                        <button type="submit" name="edit_especie" class="btn btn-primary btn-sm me-2">Salvar</button>
                        <a href="?del=<?=$row['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir esta espécie?')">Excluir</a>
                    </form>
                </td>
                <td></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</body>
</html>
