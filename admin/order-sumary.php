<?php 
include('includes/header.php'); 
if(!isset($_SESSION['productItems'])){
    echo '<script> window.location.href = "order-create.php"; </script>';
}
?>

<!-- Modal -->
<div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">

                <div class="mb-3 p-4">
                    <h5 id="orderPlaceSuccessMessage"></h5>
                </div>

                <a href="orders.php" class="btn btn-secondary">Fechar</a>
                <button type="button" onclick="printMyBillingArea()" class="btn btn-danger">Imprimir</button>
                <button type="button" onclick="downloadPDF('<?= $_SESSION['invoice_no']; ?>')" class="btn btn-warning">Download PDF</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="mb-0">Resumo de pedidos
                        <a href="order-create.php" class="btn btn-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php alertMessage(); ?>

                    <div id="myBillingArea">

                        <?php 
                        if(isset($_SESSION['cphone']))
                        {
                            $phone = validate($_SESSION['cphone']);
                            $invoiceNo = validate($_SESSION['invoice_no']);

                            $customerQuery = mysqli_query($con, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
                            if($customerQuery){
                                if(mysqli_num_rows($customerQuery)>0){

                                    $cRowData = mysqli_fetch_assoc($customerQuery);
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
                                                do Cliente: <?= $cRowData['name']; ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">
                                                Telefone do cliente: <?= $cRowData['phone']; ?> </p>
                                            <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Email
                                                do cliente: <?= $cRowData['email']; ?> </p>
                                    </td>
                                    <td align="end">
                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Detalhes
                                            do Pedido:</h4>
                                            <p style="font-size: 16px; line-height: 20px; margin:0px; padding: 0;">N° do
                                                pedido: <?= $invoiceNo; ?> </p>
                                            <p style="font-size: 16px; line-height: 20px; margin:0px; padding: 0;">Data
                                                do pedido: <?= date('d M Y'); ?> </p>
                                            <p style="font-size: 16px; line-height: 20px; margin:0px; padding: 0;">
                                                Endereço: 418, Ricardo Rodovia, São Paulo </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php
                                }else{
                                    echo '<h5> Nenhum cliente encontrado </h5>';
                                    return;
                                }
                            }
                        }
                        ?>
                        <?php
                        if(isset($_SESSION['productItems']))
                        {
                            $sessionProducts = $_SESSION['productItems'];
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
                                            $totalAmount = 0;

                                            foreach($sessionProducts as $key => $row):
                                                $totalAmount += $row['price'] * $row['quantity'];
                                        ?>
                                    <tr>
                                        <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                        <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                        <td style="border-bottom: 1px solid #ccc;">
                                            <?= number_format($row['price'],0); ?></td>
                                        <td style="border-bottom: 1px solid #ccc;"><?= $row['quantity']; ?></td>
                                        <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                            <?= number_format($row['price'] * $row['quantity'],0) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="4" align="end" style="font-weight: bold;">Total Geral: </td>
                                        <td colspan="1" style="font-weight: bold;"><?= number_format($totalAmount,0); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Modo de Pagamento: <?=$_SESSION['payment_mode'];?></td>
                                    </tr>
                                </tbody>
                                </thead>
                            </table>
                        </div>
                        <?php
                        }
                        else{
                            echo '<h5 class="text-center">Nenhum produto encontrado</h5>';
                        }
                        ?>
                    </div>
                        
                    <?php if(isset($_SESSION['productItems'])) : ?>
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-primary px-4 mx-1" id="saveOrder">Salvar</button>
                        <button class="btn btn-info px-4 mx-1" onclick="printMyBillingArea()">Imprimir</button>
                        <button class="btn btn-warning px-4 mx-1" onclick="downloadPDF('<?= $_SESSION['invoice_no']; ?>')"
                        >Download PDF
                    </button>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>