<?php
include 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mainCategory = $_POST['main_category']; 
    $subCategory = $_POST['sub_category']; 
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];  
    $author = $_POST['author'];      
    $publishedDate = $_POST['published_date'];  
    $description = $_POST['description'];
    $content = $_POST['content'];    
    $image = $_FILES['image'];

    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($image['name']);

    if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
        $query = "INSERT INTO posts (main_category, sub_category, title, subtitle, author, published_date, description, content, image) 
                  VALUES ('$mainCategory', '$subCategory', '$title', '$subtitle', '$author', '$publishedDate', '$description', '$content', '" . $image['name'] . "')";
        if (mysqli_query($conn, $query)) {
            header('Location: admin.php?success=1');
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading the file.";
    }
}
?>
