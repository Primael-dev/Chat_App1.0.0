<?php
session_start();
include_once "config.php";

$sql = "SELECT posts.id, posts.content, posts.image, posts.created_at, users.fname, users.lname, users.img AS user_img FROM posts JOIN users ON posts.user_id = users.user_id ORDER BY posts.created_at DESC";
$result = mysqli_query($conn, $sql);

$posts = [];
$user_id = isset($_SESSION['unique_id']) ? $_SESSION['unique_id'] : 0;
while ($row = mysqli_fetch_assoc($result)) {
    // Compter les likes
    $like_sql = mysqli_query($conn, "SELECT COUNT(*) AS like_count FROM post_likes WHERE post_id = " . $row['id']);
    $like_row = mysqli_fetch_assoc($like_sql);
    $like_count = $like_row['like_count'];
    // Vérifier si l'utilisateur a liké
    $has_liked = false;
    if ($user_id) {
        $user_like_sql = mysqli_query($conn, "SELECT 1 FROM post_likes WHERE post_id = " . $row['id'] . " AND user_id = $user_id LIMIT 1");
        $has_liked = mysqli_num_rows($user_like_sql) > 0;
    }
    $posts[] = [
        'id' => $row['id'],
        'content' => $row['content'],
        'image' => $row['image'],
        'created_at' => $row['created_at'],
        'user' => [
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'img' => $row['user_img']
        ],
        'like_count' => $like_count,
        'has_liked' => $has_liked
    ];
}

header('Content-Type: application/json');
echo json_encode($posts); 