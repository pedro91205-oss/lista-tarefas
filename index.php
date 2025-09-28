<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <div class="content-wrapper p-4">
        <h2>Lista de Tarefas</h2>
        
        <!-- Formulário para nova tarefa -->
        <div class="card mb-3">
            <div class="card-body">
                <form id="form-tarefa">
                    <div class="mb-2">
                        <input type="text" name="titulo" class="form-control" placeholder="Título" required>
                    </div>
                    <div class="mb-2">
                        <textarea name="descricao" class="form-control" placeholder="Descrição"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Tarefa</button>
                </form>
            </div>
        </div>

        <!-- Lista de tarefas -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="lista-tarefas">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Conteúdo será carregado via Ajax -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
$(document).ready(function(){

    // Função para carregar tarefas
    function carregarTarefas() {
        $.get('acoes.php', {acao: 'listar'}, function(data){
            $('#lista-tarefas tbody').html(data);
        });
    }

    carregarTarefas();

    // Adicionar tarefa
    $('#form-tarefa').submit(function(e){
        e.preventDefault();
        $.post('acoes.php', $(this).serialize() + '&acao=adicionar', function(){
            $('#form-tarefa')[0].reset();
            carregarTarefas();
        });
    });

    // Marcar como concluída ou excluir
    $(document).on('click', '.btn-concluir', function(){
        let id = $(this).data('id');
        $.post('acoes.php', {acao: 'concluir', id: id}, function(){
            carregarTarefas();
        });
    });

    $(document).on('click', '.btn-excluir', function(){
        if(confirm('Deseja realmente excluir esta tarefa?')){
            let id = $(this).data('id');
            $.post('acoes.php', {acao: 'excluir', id: id}, function(){
                carregarTarefas();
            });
        }
    });

});
</script>
</body>
</html>
