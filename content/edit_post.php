<?php
include 'config.php';

if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    $query = "SELECT * FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_post'])) {
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $author = $_POST['author'];
        $publishedDate = $_POST['published_date'];
        $description = $_POST['description'];
        $content = $_POST['content'];
        $mainCategory = $_POST['main_category'];
        $subCategory = $_POST['sub_category'];

        $image = $post['image']; 
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            if (file_exists("uploads/" . $image)) {
                unlink("uploads/" . $image);
            }
            $image = $_FILES['image']['name'];
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        }

        $query = "UPDATE posts SET title = ?, subtitle = ?, author = ?, published_date = ?, description = ?, content = ?, main_category = ?, sub_category = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssssi", $title, $subtitle, $author, $publishedDate, $description, $content, $mainCategory, $subCategory, $image, $postId);
        $stmt->execute();
        $stmt->close();

        header("Location: manage_posts.php");
        exit;
    }
} else {
    header("Location: manage_posts.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <title>Edit Post</title>
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>Edit Post</h1>
            <a href="manage_posts.php" class="btn-back">Back to Manage Posts</a>
        </header>

        <div class="admin-content">
            <form action="edit_post.php?post_id=<?php echo $post['id']; ?>" method="POST" enctype="multipart/form-data" class="admin-form">
                <div class="form-group">
                    <label for="main_category">Select Main Category:</label>
                    <select name="main_category" id="main_category" required>
                        <option value="Discover the Cosmos" <?php if ($post['main_category'] == 'Discover the Cosmos') echo 'selected'; ?>>Discover the Cosmos</option>
                        <option value="Observation Hub" <?php if ($post['main_category'] == 'Observation Hub') echo 'selected'; ?>>Observation Hub</option>
                        <option value="Science & Mysteries" <?php if ($post['main_category'] == 'Science & Mysteries') echo 'selected'; ?>>Science & Mysteries</option>
                        <option value="Space Missions & Exploration" <?php if ($post['main_category'] == 'Space Missions & Exploration') echo 'selected'; ?>>Space Missions & Exploration</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sub_category">Select Subcategory:</label>
                    <input type="text" name="sub_category" id="sub_category" value="<?php echo $post['sub_category']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="title">Post Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="subtitle">Post Subtitle:</label>
                    <input type="text" id="subtitle" name="subtitle" value="<?php echo $post['subtitle']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="author">Author Name:</label>
                    <input type="text" id="author" name="author" value="<?php echo $post['author']; ?>">
                </div>

                <div class="form-group">
                    <label for="published_date">Published Date:</label>
                    <input type="date" id="published_date" name="published_date" value="<?php echo $post['published_date']; ?>">
                </div>

                <div class="form-group">
                    <label for="description">Post Description:</label>
                    <textarea id="description" name="description" rows="5" required><?php echo $post['description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="content">Post Content:</label>
                    <textarea id="content" name="content" rows="10" required><?php echo $post['content']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Upload New Image (Optional):</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <p>Current Image: <img src="uploads/<?php echo $post['image']; ?>" alt="Current Image" width="100"></p>
                </div>

                <button type="submit" name="update_post" class="submit-btn">Update Post</button>
            </form>
        </div>
    </div>
</body>
</html>
