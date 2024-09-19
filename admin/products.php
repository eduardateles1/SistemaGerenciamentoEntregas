<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Produtos
                <a href="products-create.php" class="btn btn-primary float-end ms-2">Adicionar Produto</a>
                <a href="index.php" class="btn btn-primary float-end">Voltar</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php 
                $products = getAll('products');
                if(!$products){
                    echo '<h4>Algo deu errado! </h4>';
                    return false;
                }
                if(mysqli_num_rows($products) > 0) {
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $item): ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['name'] ?></td> 
                            <td><?= $item['price'] ?></td> 
                            <td>
                                <?php
                                    if($item['status'] == 1){
                                        echo '<span class="badge bg-danger">Hidden</span>';
                                    }else{
                                        echo '<span class="badge bg-primary">Visible</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm" href="products-edit.php?id=<?= $item['id']; ?>">Editar</a>
                                <a class="btn btn-danger btn-sm" href="products-delete.php?id=<?= $item['id']; ?>"
                                onclick="return confirm('Tem certeza que deseja excluir?')">Deletar</a
                                >
                                
                            </a>
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
