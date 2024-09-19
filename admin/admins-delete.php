<?php

require '../config/function.php';

$paramResultId = checkParamId('id');
if(is_numeric($paramResultId)){ // Corrigido para $paramResultId

    $adminId = validate($paramResultId);
    
    $admin = getById('admins',$adminId);
    if($admin['status'] == 200){

        $adminDeleteResponse = delete('admins',$adminId);
        if($adminDeleteResponse)
        {
            redirect('admins.php','Usuário deletado com sucesso!');
        }
        else{
            redirect('admins.php','Algo deu errado!');
        }
    }else{
        redirect('admins.php',$admin['message']);
    }
}else{
    redirect('admins.php','Algo deu errado!');
}
?>