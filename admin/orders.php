<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                <h4 class="mb-0">Pedidos</h4>
                </div>
                <div class="col-md-8">
                    <form action="" method="GET">
                        <div class="row g-1">
                            <div class="col-md-4">
                                <input type="date" 
                                class="form-control"
                                name="date" value="<?isset($_GET['date']) == true ? $_GET['date']: ''; ?>"
                                />
                            </div>
                            <div class="col-md-4">
                                <select name="payment_status" class="form-select">
                                    <option value="">Selecione a forma de pagamento</option>
                                    <option 
                                    value="Cash Payment"
                                    <?= 
                                    isset($_GET['payment_status']) == true ? 
                                    ($_GET['payment_status'] == 'Pagamento em Dinheiro' ? 'selected' :'') 
                                    : 
                                    ''; 
                                    ?>
                                    >
                                    Dinheiro
                                </option>
                                    <option 
                                    value="Online Payment"
                                    <?= 
                                    isset($_GET['payment_status']) == true ? 
                                    ($_GET['payment_status'] == 'Pagamento Online' ? 'selected' :'') 
                                    : 
                                    ''; 
                                    ?>
                                    >Pagamento online</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                <a href="" class="btn btn-danger">Resetar</a>
                                <a href="index.php" class="btn btn-primary float-end">Voltar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">

            <?php
            if(isset($_GET['date']) || isset($_GET['payment_status'])){

                $orderDate = validate($_GET['date']);
                $paymentStatus = validate($_GET['payment_status']);

                if($orderDate != '' && $paymentStatus == ''){
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                    WHERE c.id = o.customer_id AND o.order_date='$orderDate' ORDER BY o.id DESC";

                }elseif($orderDate == '' && $paymentStatus != ''){
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                    WHERE c.id = o.customer_id AND o.payment_mode='$paymentStatus' ORDER BY o.id DESC";

                }elseif($orderDate != '' && $paymentStatus != ''){
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                    WHERE c.id = o.customer_id 
                    AND o.order_date='$orderDate' 
                    AND o.payment_mode='$paymentStatus' ORDER BY o.id DESC";

                }else{
                    $query = "SELECT o.*, c.* FROM orders o, customers c 
                    WHERE c.id = o.customer_id ORDER BY o.id DESC";                  
                }
            }else{
                $query = "SELECT o.*, c.* FROM orders o, customers c 
                    WHERE c.id = o.customer_id ORDER BY o.id DESC";

            }
            $orders = mysqli_query($con, $query);
            if($orders){

                if(mysqli_num_rows($orders) >0){
                    ?>
            <table class="table table-striped table-bordered align-items-center justify-content-center">
                <thead>
                    <tr>
                        <th>Numero de rastreio</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Data do pedido</th>
                        <th>Status do pedido</th>
                        <th>Modo de pagamento</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $orderItem) : ?>
                    <tr>
                        <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                        <td><?= $orderItem['name']; ?></td>
                        <td><?= $orderItem['phone']; ?></td>
                        <td><?= date('d M, Y', strtotime($orderItem['order_date'])); ?></td>
                        <td><?= $orderItem['order_status']; ?></td>
                        <td><?= $orderItem['payment_mode']; ?></td>
                        <td>
                            <a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-info mb-0 px-2 btn-sm">Visualizar</a>
                            <a href="order-views-print.php?track=<?= $orderItem['tracking_no']; ?>" class="btn btn-primary mb-0 px-2 btn-sm">Imprimir</a>
                        </td>

                    </tr>
                    <?php endforeach;?>
                </tbody>

            </table>
            <?php
                }
                else{
                    echo '<h5> Nenhum registro disponível </h5>';
                }
            }
            else{
                    echo '<h5>Algo deu errado ao verificar os pedidos</h5>';

            }
        ?>

        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>