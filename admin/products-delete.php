<?php

require '../config/function.php';

$paramResultId = checkParamId('id');
if(is_numeric($paramResultId)){ 

    $productId = validate($paramResultId);
    
    $product = getById('products',$productId);

    if($product['status'] == 200){

        $response = delete('products',$productId);
        if($response)
        {
            redirect('products.php','Produto deletado com sucesso!');
        }
        else{
            redirect('products.php','Algo deu errado!');
        }
    }else{
        redirect('products.php',$product['message']);
    }
}else{
    redirect('products.php','Algo deu errado!');
}
?>