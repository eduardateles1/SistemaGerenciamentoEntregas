<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Editar Cliente</h4>
            <a href="customers.php" class="btn btn-primary float-end">Voltar</a>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php " method="POST">

                <?php
                    $paramValue = checkParamId('id');
                    if(!is_numeric($paramValue)){
                        echo '<h5>'.$paramValue.'</h5>';
                        return false;
                    }
                    $customer = getById('customers', $paramValue);
                    if($customer['status'] ==200)
                    {
                        ?>
                        <input type="hidden" name= "customerId" value="<?= $customer['data']['id']; ?>" >
                        
                         <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">Nome*</label>
                    <input type="text" name="name" required value="<?= $customer['data']['name']; ?>" class="form-control" />
                </div>

                <div class="col-md-12 mb-3">
                    <label for="name">Email</label>
                    <input type="text" name="email" value="<?= $customer['data']['email']; ?>"  class="form-control" />
                </div>

                <div class="col-md-12 mb-3">
                    <label for="name">Telefone</label>
                    <input type="text" name="phone" value="<?= $customer['data']['phone']; ?>" class="form-control" />
                </div>

                <div class="col-md-6">
                    <label>Status (Unchecked=Visible, Checked=Hidden)</label>
                    <br/>
                    <input type="checkbox" name="status" value="<?= $customer['data']['status'] == true ? 'checked': ''; ?>" style="width:30px;height:30px"; />
                </div>

                <div class="col-md-6 mb-3 text-end">
                    <br/>
                    <button type="submit" name="updateCustomer"class="btn btn-primary">Salvar</button>
                </div>
             </div>
                        <?php
                    }
                    else
                    {
                        echo '<h5>'.$customer['message'].'</h5>';
                        return false;
                    }
                ?>

            
            
            </form>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>