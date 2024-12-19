<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id']) && isset($_SESSION['id'])) {
    $postId = $_POST['post_id'];
    $userId = $_SESSION['id'];

    $checkLike = $conn->prepare("SELECT 1 FROM likes WHERE post_id = ? AND user_id = ?");
    $checkLike->bind_param("ii", $postId, $userId);
    $checkLike->execute();
    $checkLike->store_result();

    if ($checkLike->num_rows === 0) {
        $addLike = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        $addLike->bind_param("ii", $postId, $userId);
        $addLike->execute();
    }

    header("Location: ../Planets.php");
    exit();
}
