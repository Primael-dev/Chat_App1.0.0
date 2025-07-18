<?php
session_start();
include_once "config.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if(!empty($email) && !empty($password)){
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
        
        // Vérifier si le mot de passe est hashé avec password_hash() ou md5()
        if(password_verify($password, $row['password'])){
            // Nouveau système avec password_hash()
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";
        }
        elseif(md5($password) === $row['password']){
            // Ancien système avec md5() - pour la compatibilité
            $_SESSION['unique_id'] = $row['unique_id'];
            echo "success";
        }
        else{
            echo "Email or Password is Incorrect!";
        }
    }else{
        echo "Email or Password is Incorrect!";
    }
}else{
    echo "All input fields are required!";
}
?>