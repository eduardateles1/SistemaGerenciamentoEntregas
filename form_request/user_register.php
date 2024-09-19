<?php
include_once '../config/dbcon.php';

if(isset($_POST['registerBTn'])) {
    extract($_POST);

    // Hash da senha
    $passwrd = password_hash($passwrd, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO user_account (username, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $username, $email, $passwrd);

    try {
        if ($stmt->execute()) {
            session_start();
            $_SESSION['login_name'] = $username;
            $_SESSION['user_role'] = 'user';
            echo "<script>window.location.href='../admin/index.php';</script>";
        }
    } catch (\Throwable $th) {
        if ($stmt->errno == 1062) {
            $err = explode(' ', $stmt->error);
            $error = trim($err[5], "'");
            echo "<script>window.location.href='../register.php?error=$error';</script>";
        } else {
            print_r($stmt->error);
        }
    }
}
?>
