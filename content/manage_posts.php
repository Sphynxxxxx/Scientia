<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_post'])) {
    $postId = $_POST['post_id'];

    $query = "DELETE FROM comments WHERE post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $stmt->close();

    $query = "SELECT image FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $stmt->close();

    if ($image && file_exists("uploads/" . $image)) {
        unlink("uploads/" . $image);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_comment'])) {
    $commentId = $_POST['comment_id'];

    $query = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $commentId);
    $stmt->execute();
    $stmt->close();
}

$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <title>Manage Existing Posts</title>
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>SCIENTIA</h1>
            <h2>Manage Existing Posts</h2>
            <a href="admin.php" class="btn-back">Back to Publish Post</a>
        </header>

        <div class="admin-content">
            <h2>Existing Posts</h2>
            <div class="existing-posts">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="post-item">
                            <h3><?php echo $row['title']; ?></h3>
                            <p><?php echo $row['description']; ?></p>
                            <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="post-image">
                            <p><strong>Category:</strong> <?php echo $row['main_category']; ?> - <?php echo $row['sub_category']; ?></p>
                            
                            <a href="edit_post.php?post_id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>

                            <form action="" method="POST">
                                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete_post" class="delete-btn">Delete</button>
                            </form>

                            <h4>Comments:</h4>
                            <?php
                            $postId = $row['id'];
                            $commentQuery = "
                                SELECT comments.id, comments.comment, comments.created_at, users.email 
                                FROM comments 
                                JOIN users ON comments.user_id = users.id
                                WHERE comments.post_id = ? 
                                ORDER BY comments.created_at DESC
                            ";
                            $commentStmt = $conn->prepare($commentQuery);
                            $commentStmt->bind_param("i", $postId);
                            $commentStmt->execute();
                            $comments = $commentStmt->get_result();
                            ?>
                            <?php if ($comments->num_rows > 0): ?>
                                <ul>
                                    <?php while ($comment = $comments->fetch_assoc()): ?>
                                        <li>
                                            <p><?php echo $comment['comment']; ?></p>
                                            <p><strong>Email:</strong> <?php echo $comment['email']; ?></p>
                                            <form action="" method="POST">
                                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                                <button type="submit" name="delete_comment" class="delete-comment-btn">Delete Comment</button>
                                            </form>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else: ?>
                                <p>No comments yet.</p>
                            <?php endif; ?>
                        </div>
                        <hr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No posts available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
