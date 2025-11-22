<div class="table-container">
    <div class="header-tools">
        <h2>Gêneros Literários</h2>
        <a href="/mvc_13/genero/formulario" class="btn-novo"><i class="ri-add-circle-line"></i> Novo Gênero</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Gênero</th>
                <th style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(!empty($parametro)){
            foreach( $parametro as $p){
                ?>
                <tr>
                    <td>#<?= $p["id"] ?></td>
                    <td>
                        <span style="background: #eceafc; color: var(--primary-color); padding: 5px 10px; border-radius: 15px; font-weight: bold; font-size: 13px;">
                            <?= $p["nome"] ?>
                        </span>
                    </td>
                    <td class="acoes" style="text-align: center;">
                        <a href="/mvc_13/genero/formularioalterar?id=<?= $p["id"] ?>" 
                           class="btn-icone btn-editar" title="Editar">
                           <i class="ri-pencil-line"></i>
                        </a>
                        <a href="/mvc_13/genero/excluir?id=<?= $p["id"] ?>" 
                           class="btn-icone btn-excluir" 
                           onclick="return confirm('Excluir este gênero?');"
                           title="Excluir">
                           <i class="ri-delete-bin-line"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
             echo "<tr><td colspan='3' style='text-align:center; color: #999;'>Nenhum gênero cadastrado.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>