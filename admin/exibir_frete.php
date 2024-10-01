<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Resultado de Fretes</h4>
            <a href="frete_form.php" class="btn btn-primary">Voltar</a>
        </div>
        <div class="card-body">
            <?php
            if (isset($_SESSION['resultado_frete'])) {
                $resultado = $_SESSION['resultado_frete'];

                if (!empty($resultado)) {
                    echo '<table class="table table-striped table-hover mt-4">';
                    echo '<thead class="thead-dark"><tr><th>Transportadora</th><th>Modalidade</th><th>Preço</th><th>Prazo</th></tr></thead>';
                    echo '<tbody>';

                    foreach ($resultado as $service) {
                        $companyImage = isset($service['company']['picture']) ? $service['company']['picture'] : 'default-image.png'; 
                        $companyName = isset($service['company']['name']) ? htmlspecialchars($service['company']['name']) : 'N/A';
                        $serviceName = isset($service['name']) ? htmlspecialchars($service['name']) : 'N/A';
                        $servicePrice = isset($service['price']) ? number_format((float)$service['price'], 2, ',', '.') : 'N/A';
                        $serviceDeliveryTime = isset($service['delivery_time']) ? htmlspecialchars($service['delivery_time']) . ' dias' : 'N/A';

                        echo '<tr>';
                        echo '<td><img src="' . htmlspecialchars($companyImage) . '" alt="' . htmlspecialchars($companyName) . '" width="50"></td>';
                        echo '<td>' . $serviceName . '</td>';
                        echo '<td>R$ ' . $servicePrice . '</td>';
                        echo '<td>' . $serviceDeliveryTime . '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody></table>';
                } else {
                    echo '<div class="alert alert-warning" role="alert">Nenhum serviço disponível para o cálculo de frete.</div>';
                }
            } else {
                echo '<div class="alert alert-info" role="alert">Nenhum dado de frete disponível. Por favor, tente novamente.</div>';
            }
            ?>
        </div>
    </div>

</div>


<?php include('includes/footer.php'); ?>