<?php
include_once '../config/dbcon.php';
require('../config/function.php');

if(isset($_POST['loginBtn'])){
    extract($_POST);

    $stmt = $con->prepare("SELECT * FROM user_account WHERE email=? OR username=?");
    $stmt->bind_param("ss", $username, $username);

    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows > 0){
        $data = $res->fetch_assoc();

        if(password_verify($passwrd, $data['password'])){
            //session_start();
            $_SESSION['login_name'] = $data['username'];
            $_SESSION['user_role'] = $data['role'];
            echo "<script>window.location.href='../admin/index.php';</script>";
        } else {
            $error = "Senha incorreta";
            echo "<script>window.location.href='../index.php?error=$error';</script>";
        }
    } else {
        $error = "Usuário não encontrado";
        echo "<script>window.location.href='../index.php?error=$error';</script>";
    }
}
?>
