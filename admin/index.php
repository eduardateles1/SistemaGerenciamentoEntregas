<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Pedidos</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="orders.php">Visualizar detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Produtos</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="products.php">Visualizar detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Calcular Frete</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="frete_form.php">Visualizar detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-black text-white mb-4">
                <div class="card-body">Mapa</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="buscaMapa.php">Visualizar detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <!-- Gráficos lado a lado -->
        <div class="row">
            <!-- Pie Chart -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Gráfico Envios (Estados)
                    </div>
                    <div class="card-body">
                        <canvas id="myPieChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
            <!-- Line Chart -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-line me-1"></i>
                        Gráfico Envios Mensais
                    </div>
                    <div class="card-body">
                        <canvas id="myLineChart" width="100%" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Configuração do gráfico de pizza
const pieData = {
    labels: ['MG', 'SP', 'RS', 'RJ', 'PE', 'GO'],
    datasets: [{
        label: '# de Envios',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1,
        backgroundColor: ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0', '#D35400'],
    }]
};

function handleHover(evt, item, legend) {
    legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
        colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
    });
    legend.chart.update();
}

function handleLeave(evt, item, legend) {
    legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
        colors[index] = color.length === 9 ? color.slice(0, -2) : color;
    });
    legend.chart.update();
}

const pieConfig = {
    type: 'pie',
    data: pieData,
    options: {
        plugins: {
            legend: {
                onHover: handleHover,
                onLeave: handleLeave
            }
        }
    }
};

// Configuração do gráfico de linha
const lineData = {
    labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
    datasets: [{
            label: 'Média 1',
            data: [65, 59, 80, 81, 56, 55, 40],
            borderColor: 'rgba(255,99,132,1)',
            backgroundColor: 'rgba(255,99,132,0.2)',
        },
        {
            label: 'Média 2',
            data: [28, 48, 40, 19, 86, 27, 90],
            borderColor: 'rgba(54,162,235,1)',
            backgroundColor: 'rgba(54,162,235,0.2)',
        }
    ]
};

const lineConfig = {
    type: 'line',
    data: lineData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Envios Mensais'
            }
        }
    }
};

window.onload = function() {
    const pieCtx = document.getElementById('myPieChart').getContext('2d');
    new Chart(pieCtx, pieConfig);

    const lineCtx = document.getElementById('myLineChart').getContext('2d');
    new Chart(lineCtx, lineConfig);
};
</script>

<?php include('includes/footer.php'); ?>