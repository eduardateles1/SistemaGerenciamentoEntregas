<?php
     $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Essencial</div>

                <a class="nav-link <?= $page == 'index.php' ? 'active': '';?>"   href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link <?= $page == 'order-create.php' ? 'active':''; ?>" href="order-create.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Criar Pedidos
                </a>
                <a class="nav-link <?=$page == 'orders.php' ? 'active': '';?>" 
                    href="orders.php" href="orders.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Visualizar Pedidos
                </a>

                <div class="sb-sidenav-menu-heading">Interface</div>

                <a class="nav-link collapsed" href="#" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Categorias
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCategory" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link  <?=$page == 'categories-create.php' ? 'active': '';?>" href="categories-create.php">Criar Categoria</a>
                        <a class="nav-link  <?=$page == 'categories.php' ? 'active': '';?>" href="categories.php">Visualizar categorias</a>
                    </nav>
                </div>
                
                <a class="nav-link collapsed" href="#" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseProducts" aria-expanded="false" aria-controls="collapseProducts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Produtos
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProducts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?=$page == 'products-create.php' ? 'active': '';?>" href="products-create.php">Adicionar Produtos</a>
                        <a class="nav-link <?=$page == 'products.php' ? 'active': '';?>" href="products.php">Visualizar Produtos</a>
                    </nav>
                </div>
                
               
                <div class="sb-sidenav-menu-heading">Gerenciar usuários</div>

                <a class="nav-link collapsed" href="#" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseCustomers"
                    aria-expanded="false" aria-controls="collapseCustomers">

                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Clientes
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCustomers" aria-labelledby="headingOne"data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?=$page == 'customers-create.php' ? 'active': '';?>" href="customers-create.php">Add Cliente</a>
                        <a class="nav-link <?=$page == 'customers.php' ? 'active': '';?>" href="customers.php">Visualizar Clientes</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#collapseAdmins"
                    aria-expanded="false" aria-controls="collapseAdmins">

                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Admins / Funcionários
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseAdmins" aria-labelledby="headingOne"data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?=$page == 'admins-create.php' ? 'active': '';?>" href="admins-create.php">Add admin</a>
                        <a class="nav-link <?=$page == 'admins.php' ? 'active': '';?>" href="admins.php">Visualizar admins</a>  
                    </nav>
                    
                </div>

                <div class="sb-sidenav-menu-heading">Complemento</div>
                <a class="nav-link" href="charts.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Gráficos
                </a>
                <a class="nav-link" href="tables.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tabelas
                </a>
            </div>
            <div class="sb-sidenav-footer">
            <div class="small">Logado como:</div>
            Easy Delivery
        </div>
        </div>

    </nav>
</div>