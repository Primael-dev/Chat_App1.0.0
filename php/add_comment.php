<?php
session_start();
include_once "config.php";

if (!isset($_SESSION['unique_id'])) {
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$user_id = $_SESSION['unique_id'];
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

if ($post_id <= 0 || $comment === '') {
    echo json_encode(['error' => 'Données invalides']);
    exit;
}

$sql = mysqli_query($conn, "INSERT INTO post_comments (post_id, user_id, comment) VALUES ($post_id, $user_id, '".mysqli_real_escape_string($conn, $comment)."')");

if ($sql) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Erreur lors de l\'ajout du commentaire']);
} 