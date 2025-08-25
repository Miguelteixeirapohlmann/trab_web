<?php

require_once 'includes/auth.php';
require_once 'includes/conexao.php';
include 'includes/header.php';
include 'includes/menu.php';

// CRUD de pets
$erro = '';
// Adicionar pet
if (isset($_POST['add_pet'])) {
    $nome = trim($_POST['nome']);
    $nascimento = $_POST['nascimento'];
    $especie_id = intval($_POST['especie_id']);
    $prontuario = trim($_POST['prontuario']);
    $genero = $_POST['genero'];
    if ($nome && $nascimento && $especie_id && $genero) {
        $stmt = $conn->prepare('INSERT INTO pets (nome, nascimento, especie_id, prontuario, genero) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('ssiss', $nome, $nascimento, $especie_id, $prontuario, $genero);
        if (!$stmt->execute()) {
            $erro = 'Erro ao adicionar pet.';
        }
    }
}
// Remover pet
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $conn->query('DELETE FROM pets WHERE id = ' . $id);
}
// Editar pet
if (isset($_POST['edit_pet'])) {
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $nascimento = $_POST['nascimento'];
    $especie_id = intval($_POST['especie_id']);
    $prontuario = trim($_POST['prontuario']);
    $genero = $_POST['genero'];
    if ($nome && $nascimento && $especie_id && $genero) {
        $stmt = $conn->prepare('UPDATE pets SET nome=?, nascimento=?, especie_id=?, prontuario=?, genero=? WHERE id=?');
        $stmt->bind_param('ssissi', $nome, $nascimento, $especie_id, $prontuario, $genero, $id);
        $stmt->execute();
    }
}
// Listar pets
$pets = $conn->query('SELECT pets.*, especies.especie FROM pets JOIN especies ON pets.especie_id = especies.id ORDER BY pets.nome');
$especies = $conn->query('SELECT * FROM especies ORDER BY especie');
$especies_arr = [];
while($row = $especies->fetch_assoc()) {
    $especies_arr[$row['id']] = $row['especie'];
}
?>
<body class="bg-light">
<div class="container">
    <h2>Gerenciar Pets</h2>
    <?php if($erro): ?><div class="alert alert-danger"><?=$erro?></div><?php endif; ?>
    <form method="post" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome do pet" required>
        </div>
        <div class="col-md-2">
            <input type="date" name="nascimento" class="form-control" required>
        </div>
        <div class="col-md-2">
            <select name="especie_id" class="form-select" required>
                <option value="">Espécie</option>
                <?php foreach($especies_arr as $id=>$esp): ?>
                <option value="<?=$id?>"><?=$esp?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <textarea name="prontuario" class="form-control" placeholder="Prontuário"></textarea>
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <div class="form-check me-2">
                <input class="form-check-input" type="radio" name="genero" id="macho" value="macho" required>
                <label class="form-check-label" for="macho">Macho</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="genero" id="femea" value="femea" required>
                <label class="form-check-label" for="femea">Fêmea</label>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" name="add_pet" class="btn btn-success">Adicionar</button>
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead><tr><th>ID</th><th>Nome</th><th>Nasc.</th><th>Espécie</th><th>Gênero</th><th>Prontuário</th><th>Ações</th></tr></thead>
        <tbody>
        <?php while($row = $pets->fetch_assoc()): ?>
            <tr>
                <form method="post" class="align-middle">
                    <input type="hidden" name="id" value="<?=$row['id']?>">
                    <td><?=$row['id']?></td>
                    <td><input type="text" name="nome" value="<?=$row['nome']?>" class="form-control" required></td>
                    <td><input type="date" name="nascimento" value="<?=$row['nascimento']?>" class="form-control" required></td>
                    <td>
                        <select name="especie_id" class="form-select" required>
                            <?php foreach($especies_arr as $id=>$esp): ?>
                            <option value="<?=$id?>" <?=($row['especie_id']==$id?'selected':'')?>><?=$esp?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genero" value="macho" <?=($row['genero']=='macho'?'checked':'')?> required>
                            <label class="form-check-label">Macho</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="genero" value="femea" <?=($row['genero']=='femea'?'checked':'')?> required>
                            <label class="form-check-label">Fêmea</label>
                        </div>
                    </td>
                    <td><textarea name="prontuario" class="form-control"><?=$row['prontuario']?></textarea></td>
                    <td>
                        <button type="submit" name="edit_pet" class="btn btn-primary btn-sm mb-1">Salvar</button>
                        <a href="?del=<?=$row['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este pet?')">Excluir</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</body>
</html>
