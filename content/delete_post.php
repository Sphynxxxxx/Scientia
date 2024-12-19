<?php
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $query = "DELETE FROM posts WHERE id = $postId";

    if (mysqli_query($conn, $query)) {
        header('Location: admin.php?deleted=1');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
