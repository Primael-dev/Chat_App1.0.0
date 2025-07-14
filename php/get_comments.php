<?php
include_once "config.php";

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
if ($post_id <= 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT c.id, c.comment, c.created_at, u.fname, u.lname, u.img FROM post_comments c JOIN users u ON c.user_id = u.unique_id WHERE c.post_id = $post_id ORDER BY c.created_at ASC";
$result = mysqli_query($conn, $sql);

$comments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $comments[] = [
        'id' => $row['id'],
        'comment' => $row['comment'],
        'created_at' => $row['created_at'],
        'user' => [
            'fname' => $row['fname'],
            'lname' => $row['lname'],
            'img' => $row['img']
        ]
    ];
}

header('Content-Type: application/json');
echo json_encode($comments); 