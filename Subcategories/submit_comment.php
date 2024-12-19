<?php
session_start();
include '../content/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['comment'], $_SESSION['id'])) {
    $postId = intval($_POST['post_id']);
    $userId = intval($_SESSION['id']);
    $comment = trim($_POST['comment']);

    if (!empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $postId, $userId, $comment);

        if ($stmt->execute()) {
            header("Location: ../index.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Comment cannot be empty.";
    }
} else {
    echo "Invalid request.";
}
?>
