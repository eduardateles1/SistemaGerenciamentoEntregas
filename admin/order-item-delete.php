<?php
require '../config/function.php';
require '../config/dbcon.php';

$paramResult = checkParamId('index');
if(is_numeric($paramResult)){

    $indexValue = validate($paramResult);

    if(isset($_SESSION['productItems']) && isset($_SESSION['productItemsIds'])){

        unset($_SESSION['productItems'][$indexValue ]);
        unset($_SESSION['productItemsIds'][$indexValue ]);

        redirect('order-create.php','Item removido');

    }else{
        redirect('order-create.php','Não há item');
    }

}else{
    redirect('order-create.php','Parâmetro não numérico');
}
?>