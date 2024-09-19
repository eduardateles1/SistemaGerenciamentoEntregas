<?php

require '../config/function.php';

$paramResultId = checkParamId('id');
if(is_numeric($paramResultId)){ 

    $customerId = validate($paramResultId);
    
    $customer = getById('customers',$customerId);

    if($customer['status'] == 200){

        $response = delete('customers',$customerId);
        if($response)
        {
            redirect('customers.php','Cliente deletado com sucesso!');
        }
        else{
            redirect('customers.php','Algo deu errado!');
        }
    }else{
        redirect('customers.php',$customer['message']);
    }
}else{
    redirect('customers.php','Algo deu errado!');
}
?>