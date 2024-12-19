<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'scientia';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, title, subtitle, author, published_date, image, description, created_at FROM posts ORDER BY created_at DESC LIMIT 10";
$result = $conn->query($sql);

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
} else {
    echo "No posts found.";
}

$current_post_id = $posts[0]['id'];

$sql_random = "SELECT id, title, subtitle, image, description FROM posts WHERE id != ? ORDER BY RAND() LIMIT 3";
$stmt_random = $conn->prepare($sql_random);
$stmt_random->bind_param("i", $current_post_id);  
$stmt_random->execute();
$result_random = $stmt_random->get_result();

$related_posts = [];
if ($result_random->num_rows > 0) {
    while ($row = $result_random->fetch_assoc()) {
        $related_posts[] = $row;
    }
} else {
    echo "No related posts found.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="content\css\styles.css">
    <title>Scientia</title>
</head>

<body>
    <div class="sidebar">
        <h1>A</h1>
        <h1>S</h1>
        <h1>T</h1>
        <h1>R</h1>
        <h1>O</h1>
        <h1>N</h1>
        <h1>O</h1>
        <h1>M</h1>
        <h1>Y</h1>
    </div>
    <div class="main-content">
        <header>
            <div class="logo">
                <h1>SKĒˈENTĒƎ</h1>
            </div>
            <nav>
                <ul class="nav-links">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Search">
                        <button class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <li><a href="index.php" class="nav-link">Home</a></li>
                    <li><a href="#" class="nav-link">Profile</a></li>
                    <li><a href="content/AboutUs.php" class="nav-link">About Us</a></li>
                    <li>
                        <button class="login-button">
                            <a href="content/form.php" style="text-decoration: none; color: inherit;">Login/Register</a>
                        </button>
                    </li>

                </ul>
            </nav>
            <button class="mobile-menu-toggle"><i class="fa-solid fa-bars"></i>
        </header>
        <section class="dropdown-nav">
            <ul class="dropdown-links">
                <li class="dropdown">
                    <a href="#" class="dropdown-link">Discover the Cosmos<i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="Subcategories/Planets.php">Planets</a></li>
                        <li><a href="Subcategories/stars.php">Stars</a></li>
                        <li><a href="Subcategories/galaxy.php">Galaxies</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-link">Observation Hub<i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="Subcategories/Telescope_Setup.php">Telescope Setup</a></li>
                        <li><a href="Subcategories/Stargazing_Tips.php">Stargazing Tips</a></li>
                        <li><a href="Subcategories/Astronomy_Events.php">Astronomy Events</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-link">Space Missions & Exploration<i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-link">Astronomy Tools & Apps<i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                    </ul>
                </li>
            </ul>
        </section>

        <section class="news-section">
            <h2 class="news-title">Latest News</h2>
            <div class="news-grid">
                <?php foreach ($posts as $post): ?>
                    <div class="news-card">
                        <img src="content/uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="News Image" class="news-image">
                        <div class="news-content">
                            <h3 class="news-heading"><?php echo htmlspecialchars($post['title']); ?></h3>
                            <p class="news-description">
                                <?php echo htmlspecialchars($post['description']); ?>
                            </p>
                            <div class="news-meta">
                                <span class="news-date"><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

                
        
        <section class="related-posts">
            <h2 class="related-title">Related Posts</h2>
            <div class="related-grid">
                <?php foreach ($related_posts as $related_post): ?>
                    <div class="related-card">
                        <img src="content/uploads/<?php echo htmlspecialchars($related_post['image']); ?>" alt="Related Post" class="related-image">
                        <h3 class="related-heading"><?php echo htmlspecialchars($related_post['title']); ?></h3>
                        <p class="related-description"><?php echo htmlspecialchars($related_post['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>



        <footer>
            <div class="footer-content">
                <p>&copy; 2024 Scientia. All Rights Reserved. | Designed by Larry Denver Biaco</p>
                <ul class="social-links">
                    <li><a href="https://www.facebook.com/larrydenver.biaco"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com/_larrryyyyyy/"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="https://github.com/Sphynxxxxx"><i class="fa-brands fa-github"></i></a></li>
                </ul>
            </div>
        </footer>
    </div>
    <script src="content/js/script.js"></script>
</body>
</html>
