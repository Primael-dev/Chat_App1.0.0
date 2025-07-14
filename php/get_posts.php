<?php
session_start();
include_once "config.php";

$sql = "SELECT posts.id, posts.content, posts.image, posts.created_at, users.fname, users.lname, users.img AS user_img FROM posts JOIN users ON posts.user_id = users.user_id ORDER BY posts.created_at DESC";
$result = mysqli_query($conn, $sql);

$posts = [];
while ($row = mysqli_fetch_assoc($result)) {
    $posts[] = [
        'id' => $row['id'],
        'content' => $row['content'],
        'image' => $row['image'],
        'created_at' => $row['created_at'],
        'user' => [
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'img' => $row['user_img']
        ]
    ];
}

header('Content-Type: application/json');
echo json_encode($posts); 