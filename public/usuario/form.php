<h2><?= ($parametro != null) ? "Editar Usuário" : "Cadastrar Usuário" ?></h2>

<form method="POST" action="<?= ($parametro != null) ? '/mvc_13/usuario/alterar' : '/mvc_13/usuario/inserir' ?>" class="formulario-padrao">
    
    <label>Nome:</label>
    <input type="text" name="nome" required
           value="<?= ($parametro != null) ? $parametro[0]["nome"] : "" ?>" 
           placeholder="Nome do leitor" />
    
    <label>E-mail:</label>
    <input type="email" name="email" required
           value="<?= ($parametro != null) ? $parametro[0]["email"] : "" ?>" 
           placeholder="exemplo@email.com" />

    <?php
    if ($parametro != null) {
    ?>
        <input type="hidden" name="id" value="<?= $parametro[0]["id"] ?>" />
    <?php
    }
    ?>

    <div class="botoes">
        <input type="submit" value="Salvar" class="btn-salvar" />
        <a href="/mvc_13/usuario/lista" class="btn-cancelar">Cancelar</a>
    </div>
</form>