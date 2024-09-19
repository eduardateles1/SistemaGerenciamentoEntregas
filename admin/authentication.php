<?php

if(isset($_SESSION['loggedIn']))
{
    $email = validate($_SESSION['loggedInUser']['email']);
    $query = "SELECT * FROM admins WHERE email ='$email' LIMIT 1";
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) ==0){

    logoutSession();  
    redirect('../index.php','Acesso negado!');
    }
    else{
        $row = mysqli_fetch_assoc($result);
        if($row['is_ban'] ==1){
            logoutSession();  
            redirect('../login.php','Sua conta foi banida!');
        }
    }

}else{
}

?>