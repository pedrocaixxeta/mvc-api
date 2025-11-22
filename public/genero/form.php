<h2><?= ($parametro != null) ? "Editar Gênero" : "Novo Gênero" ?></h2>

<form method="POST" action="<?= ($parametro != null) ? '/mvc_13/genero/alterar' : '/mvc_13/genero/inserir' ?>" class="formulario-padrao">
    
    <label>Nome do Gênero:</label>
    <input type="text" name="nome" required
           value="<?= ($parametro != null) ? $parametro[0]["nome"] : "" ?>" 
           placeholder="Ex: Ficção Científica" />

    <?php if ($parametro != null) { ?>
        <input type="hidden" name="id" value="<?= $parametro[0]["id"] ?>" />
    <?php } ?>

    <div class="botoes">
        <input type="submit" value="Salvar" class="btn-salvar" />
        <a href="/mvc_13/genero/lista" class="btn-cancelar">Cancelar</a>
    </div>
</form>