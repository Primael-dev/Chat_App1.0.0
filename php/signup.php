<?php
session_start();
include_once "config.php";

$prenom = mysqli_real_escape_string($conn, $_POST['fname']);
$nom = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if(!empty($prenom) && !empty($nom) && !empty($email) && !empty($password)){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0){
            echo "$email - This email already exist!";
        }else{
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];
                
                $img_explode = explode('.',$img_name);
                $img_ext = strtolower(end($img_explode));
                
                $extensions = ["jpeg", "png", "jpg"];
                if(in_array($img_ext, $extensions) === true){
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if(in_array($img_type, $types) === true){
                        // Vérifier la taille du fichier (max 5MB)
                        if($_FILES['image']['size'] <= 5000000){
                            // Créer le dossier images s'il n'existe pas
                            if(!file_exists('images')){
                                mkdir('images', 0777, true);
                            }
                            
                            $time = time();
                            $new_img_name = $time.$img_name;
                            
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){
                                $unique_id = rand(time(), 100000000);
                                
                                // IMPORTANT: Utiliser password_hash() au lieu de md5()
                                $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);
                                
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ('{$unique_id}', '{$prenom}','{$nom}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', 'Active now')");
                                
                                if($insert_query){
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    }else{
                                        echo "This email address not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }else{
                                echo "Failed to upload image. Please try again!";
                            }
                        }else{
                            echo "Image file is too large. Max size is 5MB.";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }else{
                    echo "Please upload an image file - jpeg, png, jpg";
                }
            }else{
                echo "Please select an image file!";
            }
        }
    }else{
        echo "$email is not a valid email!";
    }
}else{
    echo "All input fields are required!";
}
?>