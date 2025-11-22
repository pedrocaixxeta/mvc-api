<div class="table-container">
    <div class="header-tools">
        <h2>Recomendações de Livros</h2>
        <a href="/mvc_13/recomendacao/formulario" class="btn-novo"><i class="ri-book-mark-line"></i> Nova Indicação</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Livro</th>
                <th>Gênero</th>
                <th>Indicado por</th>
                <th style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(!empty($parametro)){
            foreach( $parametro as $p){
                ?>
                <tr>
                    <td><b style="font-size: 1.1em;"><?= $p["livro_recomendado"] ?></b></td>
                    <td>
                        <span style="background: #dfe6e9; color: #2d3436; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                            <i class="ri-price-tag-3-fill" style="font-size: 10px; margin-right: 3px;"></i>
                            <?= $p["nome_genero"] ?>
                        </span>
                    </td>
                    <td>
                         <i class="ri-user-voice-line" style="color: var(--secondary-color); margin-right: 5px;"></i>
                        <?= $p["nome_usuario"] ?>
                    </td>
                    <td class="acoes" style="text-align: center;">
                        <a href="/mvc_13/recomendacao/formularioalterar?id=<?= $p["id"] ?>" 
                           class="btn-icone btn-editar" title="Editar">
                           <i class="ri-pencil-line"></i>
                        </a>
                        <a href="/mvc_13/recomendacao/excluir?id=<?= $p["id"] ?>" 
                           class="btn-icone btn-excluir" 
                           onclick="return confirm('Tem certeza que deseja excluir esta recomendação?');"
                           title="Excluir">
                           <i class="ri-delete-bin-line"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
             echo "<tr><td colspan='4' style='text-align:center; color: #999;'>Nenhuma recomendação cadastrada.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>