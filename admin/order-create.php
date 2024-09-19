<?php include('includes/header.php'); ?>

<!-- Modal -->
<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Adicionar Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Insira o nome do cliente</label>
                    <input type="text" class="form-control" id="c_name">
                </div>

                <div class="mb-3">
                    <label>Insira o telefone do cliente</label>
                    <input type="text" class="form-control" id="c_phone">
                </div>

                <div class="mb-3">
                    <label>Insira o e-mail do cliente (opcional)</label>
                    <input type="text" class="form-control" id="c_email">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary saveCustomer">Salvar</button>
            </div>
        </div>
    </div>
</div>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Criar pedido</h4>
            <a href="orders.php" class="btn btn-primary float-end">Voltar</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="orders-code.php " method="POST">

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="name">Selecione o produto</label>
                        <select name="product_id" class="form-select">
                            <option value="">Selecione o produto</option>
                            <?php
                            $products = getAll('products');
                            if($products){
                                if(mysqli_num_rows($products) > 0){
                                    foreach ($products as $prodItem) {
                                        ?>
                            <option value="<?= $prodItem['id'];?>"><?= $prodItem['name']; ?></option>
                            <?php
                                    }
                                }else{
                                    echo '<option value="">Não há produtos cadastrados</option>';
                                }

                            }else{
                                echo '<option value="">Algo deu errado</option>';
                            }
                        ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="name">Quantidade</label>
                        <input type="number" name="quantity" value="1" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <br/>
                        <button type="submit" name="addItem" class="btn btn-primary">Adicionar Item</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Tabela de produtos -->
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Produtos</h4>
        </div>
        <div class="card-body" id="productArea">
            <?php
              if(isset($_SESSION['productItems']))
              {
                $sessionProducts = $_SESSION['productItems'];
                if(empty($sessionProducts )){
                    unset($_SESSION['productItemsIds']);
                    unset($_SESSION['productItems']);
                }
                ?>
            <div class="table-responsive mb-3" id="productContent">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Preço total</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                $i = 1;
                                foreach ($sessionProducts as $key => $item) : 
                            ?>
                        <tr>
                            <td> <?= $i++; ?></td>
                            <td> <?= $item['name']; ?></td>
                            <td> <?= $item['price']; ?></td>
                            <td>
                                <div class="input-group qtyBox">
                                    <input type="hidden" value="<?= $item['product_id']; ?>" class="prodId">
                                    <button class="input-group-text decrement">-</button>
                                    <input type="text" value="<?=$item['quantity']; ?>" class="qty quantityInput">
                                    <button class="input-group-text increment">+</button>
                                </div>
                            </td>
                            <td><?= number_format( $item['price'] * $item['quantity'], 0); ?></td>
                            <td>
                                <a href="order-item-delete.php?index=<?= $key; ?>" class="btn btn-danger">Remover</a>
                            </td>

                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>

            <div class="mt-2">
                <div class="row">
                    <div class="col-md-4">
                        <label>Selecione a forma de pagamento</label>
                        <select id="payment_mode" class="form-select">
                            <option value="">Selecione o meio de pagamento</option>
                            <option value="Pagamento em Dinheiro">Pagamento em dinheiro</option>
                            <option value="Pagamento Online">Pagamento online</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Insira o número de telefone do cliente</label>
                        <input type="number" id="cphone" class="form-control" values="">
                    </div>
                    <div class="col-md-4">
                        <br>
                        <button type="button" class="btn btn-warning w-100 proceedToPlace">Fazer Pedido</button>
                    </div>
                </div>
            </div>
            <?php
              } 
              else{
                echo '<h5>Nenhum item adicionado</h5>';
              }
            ?>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>