<?php
include('../config/function.php');
include('../config/dbcon.php');

// LÓGICA PARA SALVAR ADMIN
if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($name != '' && $email != '' && $password != '') {
        $emailCheck = mysqli_query($con, "SELECT * FROM admins WHERE email ='$email'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('admins-create.php', 'Email já está em uso por outro usuário.');
            }
        }
        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];
        $result = insert('admins', $data);
        if ($result) {
            redirect('admins.php', 'Admin criado com sucesso!');
        } else {
            redirect('admins-create.php', 'Alguma coisa deu errado!');
        }
    } else {
        redirect('admins-create.php', 'Por favor, preencha os campos obrigatórios!');
    }
}

// LÓGICA ATUALIZAR ADMIN
if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);

    if ($adminData['status'] != 200) {
        redirect('admins-edit.php?id=' . $adminId, 'Por favor, preencha os campos obrigatórios');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1 : 0;

    $emailCheckQuery = "SELECT * FROM admins WHERE email= '$email' AND id!='$adminId'";
    $checkResult = mysqli_query($con, $emailCheckQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        redirect('admins-edit.php' . $adminId, 'Email já está em uso por outro usuário');
    }

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if ($name != '' && $email != '') {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban,
        ];
        $result = update('admins', $adminId, $data);

        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'Dados Atualizado com sucesso!');
        } else {
            redirect('admins-edit.php?id=' . $adminId, 'Algo deu errado!');
        }
    } else {
        redirect('admins-create.php', 'por favor preencha os campos obrigatórios');
    }
}

// LÓGICA PARA CRIAR CATEGORIA
if (isset($_POST['saveCategory'])) {
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status,
    ];
    $result = insert('categories', $data);

    if ($result) {
        redirect('categories.php', 'Categoria criada com sucesso!');
    } else {
        redirect('categories-create.php', 'Algo deu errado!');
    }
}

//LÓGICA PARA ATUALIZAR CATEGORIA
if(isset($_POST['updateCategory'])){

    $categoryId = validate($_POST['categoryId']);

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status,
    ];
    $result = update('categories', $categoryId, $data);

    if ($result) {
        redirect('categories-edit.php?id= '. $categoryId, 'Categoria atualizada com sucesso!');

    } else {
        redirect('categories-create.php?id= '. $categoryId, 'Algo deu errado!');

    }
}

//LÓGICA PARA SALVAR PRODUTOS
if(isset($_POST['saveProduct']))
{
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'description' => $description,
        'status' => $status
    ];
    $result = insert('products', $data);

    if ($result) {
        redirect('products.php', 'Produto criado com sucesso!');
    } else {
        redirect('products-create.php', 'Algo deu errado!');
    }   
}

//LÓGICA ATUALIZAR PRODUTOS
if(isset($_POST['updateProduct']))
{
    $product_id = validate($_POST['product_id']);

    $productData = getById('products',$product_id);
    if(!$productData){
        redirect('products.php','Nenhum produto desse tipo foi encontrado!');
    }

    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'price' => $price,
        'quantity' => $quantity,
        'description' => $description,
        'status' => $status
    ];
    $result = update('products',$product_id, $data);

    if ($result) {
        redirect('products.php?id='.$product_id, 'Produto atualizado com sucesso!');
    } else {
        redirect('products-create.php?id='.$product_id, 'Algo deu errado!');
    }   
}

//LÓGICA PARA SALVAR CLIENTE
if (isset($_POST['saveCustomer'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;

    if ($name != '') {
        $emailCheck = mysqli_query($con, "SELECT * FROM customers WHERE email='$email'");
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect('customers.php', 'Este email já está cadastrado!');
        } else {
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'status' => $status
            ];

            $result = insert('customers', $data);
            if ($result) {
                redirect('customers.php', 'Cliente cadastrado com sucesso!');
            } else {
                redirect('customers.php', 'Algo deu errado!');
            }
        }
    } else {
        redirect('customers.php', 'Por favor, preencha todos os campos necessários.');
    }
}

//LÓGICA PARA ATUALIZAR CLIENTE
if (isset($_POST['updateCustomer']))
{
    $customerId = $_POST['customerId'];
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1 : 0;

    if ($name != '') {
        $emailCheck = mysqli_query($con, "SELECT * FROM customers WHERE email='$email' AND id!='$customerId'");
        if (mysqli_num_rows($emailCheck) > 0) {
            redirect('customers-edit.php?id='.$customerId, 'Este email já está cadastrado!');
        } else {
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'status' => $status
            ];

            $result = update('customers', $customerId, $data);
            if ($result) {
                redirect('customers.php?id='.$customerId, 'Cliente atualizado com sucesso!');
            } else {
                redirect('customers.php?id='.$customerId, 'Algo deu errado!');
            }
        }
    } else {
        redirect('customers.php?id='.$customerId, 'Por favor, preencha todos os campos necessários.');
    }
}


?>
