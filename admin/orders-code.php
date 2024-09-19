<?php

include('../config/function.php');
include('../config/dbcon.php');

if (!isset($_SESSION['productItems'])) {
    $_SESSION['productItems'] = [];
}
if (!isset($_SESSION['productItemsIds'])) {
    $_SESSION['productItemsIds'] = [];
}

if (isset($_POST['addItem'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($con, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
    if ($checkProduct) {
        if (mysqli_num_rows($checkProduct) > 0) {
            $row = mysqli_fetch_assoc($checkProduct);
            if ($row['quantity'] < $quantity) {
                redirect('order-create.php', 'Apenas ' . $row['quantity'] . ' quantidade disponível!');
            }
            $productData = [
                'product_id' => $row['id'],
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $quantity,
            ];
            if (!in_array($row['id'], $_SESSION['productItemsIds'])) {
                array_push($_SESSION['productItemsIds'], $row['id']);
                array_push($_SESSION['productItems'], $productData);
            } else {
                foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                    if ($prodSessionItem['product_id'] == $row['id']) {
                        $newQuantity = $prodSessionItem['quantity'] + $quantity;
                        $productData = [
                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'price' => $row['price'],
                            'quantity' => $newQuantity,
                        ];
                        $_SESSION['productItems'][$key] = $productData;
                    }
                }
            }
            redirect('order-create.php', 'Item adicionado: ' . $row['name']);
        } else {
            redirect('order-create.php', 'Nenhum produto desse tipo foi encontrado');
        }
    } else {
        redirect('order-create.php', 'Algo deu errado!');
    }
}
if(isset($_POST['productIncDec']))
{
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;
    foreach($_SESSION['productItems'] as $key => $item){
        if($item['product_id'] == $productId){

            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity; 
        }
    }
    if($flag){

        jsonResponse(200, 'success', 'Quantidade atualizada');
    }else{

        jsonResponse(500, 'error', 'Algo deu errado!');
        
    }
}

//PEDIDOS
if(isset($_POST['proceedToPlaceBtn']))
{
    $phone = validate($_POST['cphone']);
    $payment_mode = validate($_POST['payment_mode']);

    //verificando o cliente
    $checkCustomer = mysqli_query($con,"SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
    if($checkCustomer){
        if(mysqli_num_rows($checkCustomer)>0)
        {
            $_SESSION['invoice_no'] = "INV-" .rand(111111, 999999);
            $_SESSION['cphone'] = $phone;
            $_SESSION['payment_mode'] = $payment_mode;
            jsonResponse(200,'success','Cliente encontrado!');

        }
        else{
            $_SESSION['cphone'] = $phone;
            jsonResponse(404,'warning','Cliente não encontrado!');
        }
    }
    else{
        jsonResponse(500,'error','Algo deu errado!');
    }
}

//CLIENTES DA TABELAS DE PEDIDOS
if(isset($_POST['saveCustomerBtn']))
{
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);

    if($name != '' && $phone != ''){

        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' =>  $email
        ];
        $result = insert('customers', $data);
        if($result){
            jsonResponse(200,'success','Cliente cadastrado com sucesso!');
        }else{
            jsonResponse(500,'error','Algo deu errado!');
        }
    }else{
        jsonResponse(422,'warning','Por favor, preencha os campos obrigatórios');

    }
}

//SALVAR PEDIDOS
if (isset($_POST['saveOrder'])) 
{
    $phone = validate($_SESSION['cphone']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $payment_mode = validate($_SESSION['payment_mode']);

    // Verificar se o cliente existe
    $checkCustomer = mysqli_query($con, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
    if (!$checkCustomer) {
        jsonResponse(500, 'error', 'Algo deu errado ao verificar o cliente');
    }

    if (mysqli_num_rows($checkCustomer) > 0) 
    {
        $customerData = mysqli_fetch_assoc($checkCustomer);

        // Verificar se há itens no pedido
        if (!isset($_SESSION['productItems'])) {
            jsonResponse(404, 'warning', 'Não há itens para fazer o pedido!');
        }

        $sessionProducts = $_SESSION['productItems'];
        $totalAmount = 0;

        // Calcular o valor total do pedido
        foreach ($sessionProducts as $amtItem) {
            $totalAmount += $amtItem['price'] * $amtItem['quantity'];
        }

        // Preparar dados do pedido
        $data = [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(111111, 999999),
            'invoice_no' => $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => 'Reservado',
            'payment_mode' => $payment_mode,
        ];

        // Inserir pedido no banco de dados
        $result = insert('orders', $data);
        $lastOrderId = mysqli_insert_id($con);

        // Inserir itens do pedido e atualizar quantidade dos produtos
        foreach ($sessionProducts as $prodItem) {
            $productId = $prodItem['product_id'];
            $price = $prodItem['price'];
            $quantity = $prodItem['quantity'];

            // Dados do item do pedido
            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity
            ];
            $orderItemQuery = insert('order_items', $dataOrderItem);

            // Verificar e atualizar quantidade do produto
            $checkProductQuantityQuery = mysqli_query($con, "SELECT * FROM products WHERE id='$productId'");
            $productQtyData = mysqli_fetch_assoc($checkProductQuantityQuery);
            $totalProductQuantity = $productQtyData['quantity'] - $quantity;

            $dataUpdate = [
                'quantity' => $totalProductQuantity
            ];
            $updateProductQty = update('products', $productId, $dataUpdate);
        }
        // Limpar sessão
        unset($_SESSION['productItemsIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);

        jsonResponse(200, 'success', 'Pedido criado com sucesso!');
    } else {
        jsonResponse(404, 'warning', 'Nenhum cliente encontrado!');
    }
}

?>