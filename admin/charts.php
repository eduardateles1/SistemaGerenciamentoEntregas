<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Envios Mensais</h4>
            <a href="index.php" class="btn btn-primary float-end">Voltar</a>
        </div>
        <div>
            <canvas id="myLineChart"></canvas>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <script>
        const labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'];
        const data = {
            labels: labels,
            datasets: [{
                label: 'Envios Mensais',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };
        
        const config = {
            type: 'line',
            data: data,
        };
        
        // Inicializando o gráfico de linha
        const myLineChart = new Chart(
            document.getElementById('myLineChart'),
            config
        );
        </script>

        <div class="card-body">
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
