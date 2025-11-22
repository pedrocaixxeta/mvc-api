<h2>Visão Geral</h2>
<p style="color: #636e72; margin-bottom: 30px;">Bem-vindo ao sistema de gerenciamento de livros.</p>

<div class="dashboard-cards">
    
    <div class="card">
        <div class="card-info">
            <h3><?= $parametro['qtd_usuarios'] ?></h3>
            <p>Leitores Ativos</p>
        </div>
        <div class="card-icon"><i class="ri-user-smile-line"></i></div>
    </div>

    <div class="card">
        <div class="card-info">
            <h3><?= $parametro['qtd_generos'] ?></h3>
            <p>Gêneros</p>
        </div>
        <div class="card-icon"><i class="ri-price-tag-3-line"></i></div>
    </div>

    <div class="card">
        <div class="card-info">
            <h3><?= $parametro['qtd_recomendacoes'] ?></h3>
            <p>Livros Indicados</p>
        </div>
        <div class="card-icon"><i class="ri-book-2-line"></i></div>
    </div>

</div>

<div class="table-container">
    <div class="header-tools">
        <h3>Últimas Indicações</h3>
        <a href="/mvc_13/recomendacao/formulario" class="btn-novo">Nova Indicação</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Livro</th>
                <th>Gênero</th>
                <th>Indicado por</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($parametro['ultimas_rec'] as $rec): ?>
            <tr>
                <td><b><?= $rec['livro_recomendado'] ?></b></td>
                <td><span style="background: #e0e0e0; padding: 4px 8px; border-radius: 4px; font-size: 12px;"><?= $rec['nome_genero'] ?></span></td>
                <td><?= $rec['nome_usuario'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>