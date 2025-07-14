<?php
session_start();
include_once "config.php";

if (!isset($_SESSION['unique_id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['unique_id'];
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;

if ($post_id <= 0) {
    echo json_encode(['error' => 'ID de post invalide']);
    exit;
}

// Vérifier si l'utilisateur a déjà liké ce post
$sql = mysqli_query($conn, "SELECT * FROM post_likes WHERE post_id = $post_id AND user_id = $user_id");
if (mysqli_num_rows($sql) > 0) {
    // Déjà liké, donc on retire le like
    mysqli_query($conn, "DELETE FROM post_likes WHERE post_id = $post_id AND user_id = $user_id");
    $action = 'unliked';
} else {
    // Pas encore liké, on ajoute le like
    mysqli_query($conn, "INSERT INTO post_likes (post_id, user_id) VALUES ($post_id, $user_id)");
    $action = 'liked';
}

// Compter le nombre de likes
$count_sql = mysqli_query($conn, "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = $post_id");
$count_row = mysqli_fetch_assoc($count_sql);
$like_count = $count_row['like_count'];

echo json_encode([
    'action' => $action,
    'like_count' => $like_count
]); 