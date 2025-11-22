<div class="table-container">
    <div class="header-tools">
        <h2>Lista de Usuários</h2>
        <a href="/mvc_13/usuario/formulario" class="btn-novo"><i class="ri-user-add-line"></i> Novo Usuário</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
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
                    <td><strong><?= $p["nome"] ?></strong></td>
                    <td><?= $p["email"] ?></td>
                    <td class="acoes" style="text-align: center;">
                        <a href="/mvc_13/usuario/formularioalterar?id=<?= $p["id"] ?>" 
                           class="btn-icone btn-editar" title="Editar">
                           <i class="ri-pencil-line"></i>
                        </a>
                        
                        <a href="/mvc_13/usuario/excluir?id=<?= $p["id"] ?>" 
                           class="btn-icone btn-excluir" 
                           onclick="return confirm('Tem certeza que deseja excluir este usuário?');"
                           title="Excluir">
                           <i class="ri-delete-bin-line"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center; color: #999;'>Nenhum usuário cadastrado.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>