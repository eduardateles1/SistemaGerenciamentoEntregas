<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Admins/Funcionários
                <a href="admins-create.php" class="btn btn-primary float-end ms-2">Adicionar Admin</a>
                <a href="index.php" class="btn btn-primary float-end">Voltar</a>

            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php 
                $admins = getAll('admins');
                if(!$admins){
                    echo '<h4>Algo deu errado! </h4>';
                    return false;
                }
                if(mysqli_num_rows($admins) > 0) {
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($admins as $adminItem): ?>
                        <tr>
                            <td><?= $adminItem['id'] ?></td>
                            <td><?= $adminItem['name'] ?></td>
                            <td><?= $adminItem['email'] ?></td>
                            <td>
                                <a class="btn btn-success btn-sm" href="admins-edit.php?id=<?= $adminItem['id']; ?>">Editar</a>
                                <a class="btn btn-danger btn-sm" href="admins-delete.php?id=<?= $adminItem['id']; ?>">Deletar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php 
                } else { 
            ?>
            <h4 class='mb-0'>Nenhum registro encontrado</h4>
            <?php 
                } 
            ?>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>
