<?php
session_start();
include_once "config.php";

if (!isset($_SESSION['unique_id'])) {
    http_response_code(401);
    echo "Non autorisé.";
    exit();
}

$user_id = $_SESSION['unique_id'];
$content = isset($_POST['content']) ? mysqli_real_escape_string($conn, $_POST['content']) : '';
$image_name = NULL;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $img_tmp = $_FILES['image']['tmp_name'];
    $img_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array(strtolower($img_ext), $allowed)) {
        $image_name = time() . '_' . uniqid() . '.' . $img_ext;
        move_uploaded_file($img_tmp, 'images/' . $image_name);
    } else {
        echo "Type d'image non supporté.";
        exit();
    }
}

$sql = "INSERT INTO posts (user_id, content, image) VALUES ((SELECT user_id FROM users WHERE unique_id = $user_id), '$content', " . ($image_name ? "'$image_name'" : "NULL") . ")";
if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "Erreur lors de la création du post.";
} 