<?php
// Organiza os dados que vieram do controller
$usuarios = $parametro['usuarios'];
$generos = $parametro['generos'];
// Verifica se é edição
$rec = (isset($parametro['recomendacao'])) ? $parametro['recomendacao'][0] : null;
?>

<h2><?= ($rec != null) ? "Editar Recomendação" : "Nova Recomendação" ?></h2>

<form method="POST" action="<?= ($rec != null) ? '/mvc_13/recomendacao/alterar' : '/mvc_13/recomendacao/inserir' ?>" class="formulario-padrao">

    <label>Nome do Livro:</label>
    <input type="text" name="livro" required
           value="<?= ($rec != null) ? $rec["livro_recomendado"] : "" ?>" 
           placeholder="Ex: O Senhor dos Anéis" />

    <label>Quem está indicando?</label>
    <select name="usuario_id" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
        <option value="">Selecione um usuário...</option>
        <?php foreach($usuarios as $u): ?>
            <option value="<?= $u['id'] ?>" 
                <?= ($rec != null && $rec['usuario_id'] == $u['id']) ? 'selected' : '' ?>>
                <?= $u['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Qual o gênero?</label>
    <select name="genero_id" required style="width: 100%; padding: 10px; margin-bottom: 15px;">
        <option value="">Selecione um gênero...</option>
        <?php foreach($generos as $g): ?>
            <option value="<?= $g['id'] ?>"
                <?= ($rec != null && $rec['genero_id'] == $g['id']) ? 'selected' : '' ?>>
                <?= $g['nome'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if ($rec != null) { ?>
        <input type="hidden" name="id" value="<?= $rec["id"] ?>" />
    <?php } ?>

    <div class="botoes">
        <input type="submit" value="Salvar" class="btn-salvar" />
        <a href="/mvc_13/recomendacao/lista" class="btn-cancelar">Cancelar</a>
    </div>
</form>