<?php
include 'config.php';

$acao = $_REQUEST['acao'] ?? '';

if($acao == 'adicionar'){
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO tarefas (titulo, descricao) VALUES (?, ?)");
    $stmt->execute([$titulo, $descricao]);

} elseif($acao == 'listar') {
    $stmt = $pdo->query("SELECT * FROM tarefas ORDER BY created_at DESC");
    $tarefas = $stmt->fetchAll();
    foreach($tarefas as $t){
        $status = $t['concluida'] ? '<span class="badge bg-success">Concluída</span>' : '<span class="badge bg-warning">Pendente</span>';
        $btnConcluir = $t['concluida'] ? '' : '<button class="btn btn-sm btn-success btn-concluir" data-id="'.$t['id'].'"><i class="bi bi-check-lg"></i></button>';
        $btnExcluir = '<button class="btn btn-sm btn-danger btn-excluir" data-id="'.$t['id'].'"><i class="bi bi-trash"></i></button>';

        echo "<tr>
                <td>{$t['titulo']}</td>
                <td>{$t['descricao']}</td>
                <td>$status</td>
                <td>$btnConcluir $btnExcluir</td>
              </tr>";
    }

} elseif($acao == 'concluir'){
    $id = $_POST['id'];
    $stmt = $pdo->prepare("UPDATE tarefas SET concluida = 1 WHERE id = ?");
    $stmt->execute([$id]);

} elseif($acao == 'excluir'){
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ?");
    $stmt->execute([$id]);
}
?>
