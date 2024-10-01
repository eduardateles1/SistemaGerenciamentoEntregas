<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Calcule seu frete</h4>
            <a href="index.php" class="btn btn-primary">Voltar</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="calcular_frete.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cep_origem" class="form-label">CEP de Origem:</label>
                        <input type="text" class="form-control" id="cep_origem" name="cep_origem" required pattern="\d{8}" title="Digite um CEP válido sem hífen">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cep_destino" class="form-label">CEP de Destino:</label>
                        <input type="text" class="form-control" id="cep_destino" name="cep_destino" required pattern="\d{8}" title="Digite um CEP válido sem hífen">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="peso" class="form-label">Peso (kg):</label>
                        <input type="number" class="form-control" id="peso" name="peso" step="0.01" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="comprimento" class="form-label">Comprimento (cm):</label>
                        <input type="number" class="form-control" id="comprimento" name="comprimento" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="altura" class="form-label">Altura (cm):</label>
                        <input type="number" class="form-control" id="altura" name="altura" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="largura" class="form-label">Largura (cm):</label>
                        <input type="number" class="form-control" id="largura" name="largura" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="valor_declarado" class="form-label">Valor Declarado (R$):</label>
                        <input type="number" class="form-control" id="valor_declarado" name="valor_declarado" step="0.01" value="0">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Calcular Frete</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>