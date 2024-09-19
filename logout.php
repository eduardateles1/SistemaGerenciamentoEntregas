<?php
require 'config/function.php';
if(isset($_SESSION['loggedIn'])){

    logoutSession();
    redirect('../index.php','Desconectado com sucesso');
} else{
    echo "Session variable 'loggedIn' is not set.";

}

?>