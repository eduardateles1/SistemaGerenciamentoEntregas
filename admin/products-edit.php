<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Editar Produtos</h4>
            <a href="products.php" class="btn btn-primary float-end">Voltar</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <?php
                        $paramValue = checkParamId('id');
                        if(!is_numeric($paramValue)){
                            echo '<h5> O Id não é um número inteiro </h5>';
                            return false;
                        }

                        $product = getById('products', $paramValue);
                        if($product)
                        {
                                if($product['status'] ==200)
                                {
                            ?>
                            <input type="hidden" name="product_id" value="<?=$product['data']['id']; ?>" />
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="category_id">Selecione a categoria</label>
                        <select name="category_id" class="form-select" id="category_id">
                            <option value="">Selecione a categoria</option>
                                            <?php
                                                $categories = getAll('categories');
                                                if ($categories) {
                                                    if (mysqli_num_rows($categories) > 0) {
                                                        foreach ($categories as $category) {
                                                            ?>
                                                            <option 
                                                            value="<?= $category['id']; ?>"
                                                            <?= $product['data']['category_id'] == $category['id'] ? 'selected':''; ?>
                                                            >
                                                                <?=  $category['name']; ?>
                                                            </option>
                                                        <?php
                                                        }
                                                    } else {
                                                        echo '<option value="">Nenhuma categoria encontrada</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">Algo deu errado!</option>';
                                                }
                                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="name">Nome do produto</label>
                        <input type="text" name="name" value="<?= $product['data']['name'];?>" required class="form-control" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="price">Preço</label>
                        <input type="number" name="price" value="<?= $product['data']['price'];?>" required class="form-control" />
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="quantity">Quantidade</label>
                        <input type="number" name="quantity" value="<?= $product['data']['quantity'];?>" class="form-control" />
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description">Descrição</label>
                        <textarea name="description" class="form-control" rows="3"><?= $product['data']['description']; ?></textarea>

                    </div>

                    <div class="col-md-6">
                        <label>Status (Unchecked=Visible, Checked=Hidden)</label>
                        <br />
                        <input type="checkbox" name="status" value="<?= $product['data']['status'] == true ? 'checked' : '';?>" style="width:30px;height:30px;" />
                    </div>

                    <div class="col-md-6 mb-3 text-end">
                        <br />
                        <button type="submit" name="updateProduct"class="btn btn-primary">Atualizar</button>
                    </div>
                </div>
                <?php
                     }else
                        {
                         echo '<h5>'.$product['message'].'</h5>';
                         return false;
                        }
                    }else
                        {
                            echo '<h5>Algo deu errado!</h5>';
                            return false;
                        }
                    ?>
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>