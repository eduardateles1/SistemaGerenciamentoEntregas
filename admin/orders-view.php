<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Pedidos
            <a href="orders.php" class="btn btn-danger float-end">Voltar</a>
            <a href="order-views-print.php?track=<?=$_GET['track']; ?>" class="btn btn-info float-end">Imprimir</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <?php
            if(isset($_GET['track']))
            {
                if($_GET['track'] == ''){
                    ?>
                    <div class="text-center py-5">
                        <h5>Nenhum número de pedido encontrado</h5>
                        <div>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Voltar para pedidos</a>
                        </div>
                    </div>
                    <?php
                    return false;
                }
                $trackingNo = validate($_GET['track']);

                $query = "SELECT o.*, c.* FROM orders o, customers c 
                            WHERE c.id = o.customer_id AND tracking_no = '$trackingNo' ORDER BY o.id DESC";

                $orders = mysqli_query($con,$query);
                if($orders)
                {
                    if(mysqli_num_rows($orders)>0){

                        $orderData = mysqli_fetch_assoc($orders);
                        $orderId = $orderData['id'];

            ?>
            <div class="card card-body shadow border-1 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Detalhes do Pedido</h4>
                        <label class="mb-1">
                            Número do pedido: <span class="fw-bold"><?=$orderData['tracking_no']; ?></span>
                        </label>
                        <br />
                        <label class="mb-1">
                            Data do pedido: <span class="fw-bold"><?=$orderData['order_date']; ?></span>
                        </label>
                        <br />
                        <label class="mb-1">
                            Status do pedido: <span class="fw-bold"><?=$orderData['order_status']; ?></span>
                        </label>
                        <br />
                        <label class="mb-1">
                            Modo de pagamento: <span class="fw-bold"><?=$orderData['payment_mode']; ?></span>
                        </label>
                        <br />
                    </div>
                    <div class="col-md-6">
                        <h4>Detalhes do cliente</h4>
                        <label class="mb-1">
                            Nome completo: <span class="fw-bold"><?=$orderData['name']; ?></span>
                        </label>
                        <br />
                        <label class="mb-1">
                            Email: <span class="fw-bold"><?=$orderData['email']; ?></span>
                        </label>
                        <br />
                        <label class="mb-1">
                            Telefone: <span class="fw-bold"><?=$orderData['phone']; ?></span>
                        </label>
                        <br />
                        
                    </div>
                </div>
            </div>
                
            <?php
                            $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.*
                                    FROM orders as o, order_items as oi, products as p 
                                    WHERE oi.order_id = o.id AND p.id = oi.product_id AND o.tracking_no ='$trackingNo'";

                                    $orderItemRes = mysqli_query($con, $orderItemQuery);
                                    if($orderItemRes)
                                    {
                                            if(mysqli_num_rows($orderItemRes)>0)
                                            {
                                                ?>
            <h4 class="my-3">Itens do pedido</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orderItemRes as $orderItemRow) : ?>
                    <tr>
                    <td width="15%" class="fw-bold text-center">
                            <?= $orderItemRow['name']; ?>
                        </td>
                        <td width="15%" class="fw-bold text-center">
                            <?= number_format($orderItemRow['orderItemPrice'],0) ?>
                        </td>
                        <td width="15%" class="fw-bold text-center">
                            <?= $orderItemRow['orderItemQuantity']; ?>
                        </td>
                        <td width="15%" class="fw-bold text-center">
                            <?= number_format($orderItemRow['orderItemPrice'] * $orderItemRow['orderItemQuantity'],0); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="text-end fw-bold">Preço total:</td>
                        <td colspan="3" class="text-end fw-bold">R$
                            <?= number_format($orderItemRow['total_amount'],0); ?></td>
                    </tr>
                </tbody>

            </table>
            <?php
                                            }
                                            else{
                                                echo '<h5>Algo deu errado ao verficar os pedidos! </h5>';
                                                return false;

                                            }
                                    }
                                    else{
                                        echo '<h5>Algo deu errado ao verficar os pedidos! </h5>';
                                        return false;

                                    }
                            ?>
            <?php

                    }else{
                        echo '<h5>Nenhum registro encontrado!</h5>';
                        return false;

                    }
                }
                else{
                    echo '<h5>Algo deu errado ao verficar os pedidos! </h5>';
                }
                

            }
            ?>
            
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>