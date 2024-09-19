<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Imprimir Pedidos</h4>
            <a href="orders.php" class="btn btn-primary float-end">Voltar</a>
        </div>
        <div class="card-body">

        <div id="myBillingArea">

       
            <?php
            if(isset($_GET['track']))
            {
                $trackingNo = validate($_GET['track']);
                if($trackingNo == ''){
                    ?>
                        <div class="text-center py-5">
                        <h5>Por favor, forneça o número de rastreamento!</h5>
                        <div>
                        <a href="order.php" class="btn btn-primary mt-4 w-25">Voltar para pedidos</a>
                        </div>
                    </div>
                    <?php
                }
                $orderQuery = "SELECT o.*, c.* FROM orders o, customers c 
                         WHERE c.id = o.customer_id AND tracking_no = '$trackingNo' LIMIT 1";

                $orderQueryRes = mysqli_query($con, $orderQuery);

                if(!$orderQueryRes){
                    echo "<h5>Algo deu errado ao imprimir o pedido! </h5>";
                    return false;
                }
                if(mysqli_num_rows($orderQueryRes) >0)
                {
                        $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
                        ?>
                         <table style="width: 100%; margin-bottom: 20px;">
                            <tbody>
                                <tr>
                                    <td style="text-align: center;" colspan="2">
                                        <h4 style="font-size: 23px; line-height: 30px; margin:2px; padding: 0;">Grupo
                                            ABC</h4>
                                        <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">418,
                                            Ricardo Rodovia, São Paulo</p>
                                        <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">Grupo ABC
                                            LTDA.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">
                                            Informações do Cliente</h4>
                                            <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Nome
                                                do Cliente: <?= $orderDataRow['name']; ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">
                                                Telefone do cliente: <?= $orderDataRow['phone']; ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Email
                                                do cliente: <?= $orderDataRow['email']; ?> </p>
                                    </td>
                                    <td align="end">
                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Detalhes
                                            do Pedido:</h4>
                                            <p style="font-size: 16px; line-height: 20px; margin:0px; padding: 0;">N° do
                                                pedido: <?= $orderDataRow['invoice_no']; ?> </p>
                                            <p style="font-size: 16px; line-height: 20px; margin:0px; padding: 0;">Data
                                                do pedido: <?= date('d M Y'); ?> </p>
                                            <p style="font-size: 16px; line-height: 20px; margin:0px; padding: 0;">
                                                Endereço: 418, Ricardo Rodovia, São Paulo </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                }
                else{
                    echo "<h5>Nenhum dado encontrado!</h5>";
                    return false;
                }
                $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, o.*, oi.*, p.* FROM orders o, order_items oi,
                            products p WHERE oi.order_id=o.id AND p.id=oi.product_id AND o.tracking_no='$trackingNo'";
                
                $orderItemQueryRes = mysqli_query($con, $orderItemQuery);
                if($orderItemQueryRes){

                    if(mysqli_num_rows($orderItemQueryRes) >0)
                    {
                        ?>
                        <div class="table-responsive mb-3">
                            <table style="width:100%;" cellpadding="5">
                                <thead>
                                    <tr>
                                        <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                        <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">Nome do
                                            Produto</th>
                                        <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Preço</th>
                                        <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Quantidade
                                        </th>
                                        <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Preço Total
                                        </th>
                                    </tr>
                                <tbody>
                                    <?php
                                            $i = 1;
                                            foreach($orderItemQueryRes as $key => $row):
                                        ?>
                                    <tr>
                                        <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                        <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                        <td style="border-bottom: 1px solid #ccc;">
                                            <?= number_format($row['orderItemPrice'],0); ?></td>
                                        <td style="border-bottom: 1px solid #ccc;"><?= $row['orderItemQuantity']; ?></td>
                                        <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                            <?= number_format($row['orderItemPrice'] * $row['orderItemQuantity'],0) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="4" align="end" style="font-weight: bold;">Total Geral: </td>
                                        <td colspan="1" style="font-weight: bold;"><?= number_format($row['total_amount'],0); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Modo de Pagamento: <?=$row['payment_mode'];?></td>
                                    </tr>
                                </tbody>
                                </thead>
                            </table>
                        </div>
                        <?php
                    }
                    else{
                        "<h5>Nenhum registro encontrado</h5>";
                        return false;
                    }
                }
                else{
                    "<h5>Algo deu errado ao imprimir o pedido! </h5>";
                    return false;
                }

            }
            else{
                ?>
             </div>
                <div class="text-center py-5">
                        <h5>Nenhum parâmetro de número de rastreamento encontrado!</h5>
                        <div>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Voltar para pedidos</a>
                        </div>
                    </div>
                <?php
            }
            ?>
        </div>
        
        <div class="mt-4 text-end">
                    <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()">Imprimir</button>
                    <button class="btn btn-primary px-4 mx-1" onclick="downloadPDF('<?= $orderDataRow['invoice_no']; ?>')">Download PDF</button>

                </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>