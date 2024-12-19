<?php
session_start();
include '../content/config.php';

$isLoggedIn = isset($_SESSION['id']) && !empty($_SESSION['id']);

$query = "SELECT * FROM posts WHERE sub_category = 'Planets' ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../content/css/styles.css">
    <link rel="stylesheet" href="../content/css/styles2.css">
    <title>Planets</title>
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
                        <input type="text" class="search-input" placeholder="Search" id="searchInput">
                        <button class="search-button" id="searchbutton">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <li><a href="../index.php" class="nav-link">Home</a></li>
                    <li><a href="#" class="nav-link">Profile</a></li>
                    <li><a href="../content/AboutUs.php" class="nav-link">About Us</a></li>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="../content/logout.php" class="nav-link">Logout</a></li>
                    <?php else: ?>
                        <li>
                            <button class="login-button">
                                <a href="../content/form.php" style="text-decoration: none; color: inherit;">Login/Register</a>
                            </button>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <button class="mobile-menu-toggle"><i class="fa-solid fa-bars"></i></button>
        </header>

        <section class="dropdown-nav">
            <ul class="dropdown-links">
            <li class="dropdown">
                    <a href="#" class="dropdown-link">Discover the Cosmos<i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="Planets.php">Planets</a></li>
                        <li><a href="stars.php">Stars</a></li>
                        <li><a href="galaxy.php">Galaxies</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-link">Observation Hub<i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="Telescope_Setup.php">Telescope Setup</a></li>
                        <li><a href="Stargazing_Tips.php">Stargazing Tips</a></li>
                        <li><a href="Astronomy_Events.php">Astronomy Events</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-link">Space Missions & Exploration<i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="">Space Exploration</a></li>
                        <li><a href="#">Human Spaceflight</a></li>
                        <li><a href="#">Robotic Spaceflight</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-link">Astronomy Tools & Apps<i class="fa-solid fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Sky Mapping</a></li>
                        <li><a href="#">Planetary Simulation</a></li>
                        <li><a href="#">Astrophotography Apps</a></li>
                    </ul>
                </li>->
            </ul>
        </section>

        <section class="article-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): 
                    $postId = $row['id'];

                    $likeCountQuery = $conn->prepare("SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?");
                    $likeCountQuery->bind_param("i", $postId);
                    $likeCountQuery->execute();
                    $likeCountResult = $likeCountQuery->get_result();
                    $likeCount = $likeCountResult->fetch_assoc()['like_count'];

                    $commentQuery = $conn->prepare("SELECT comments.comment, users.email FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ?");
                    $commentQuery->bind_param("i", $postId);
                    $commentQuery->execute();
                    $comments = $commentQuery->get_result();
                ?>
                    <div class="post-item">
                        <h1 class="article-title"><?php echo htmlspecialchars($row['title']); ?></h1>
                        <p class="article-subtitle"><?php echo htmlspecialchars($row['subtitle']); ?></p>
                        <div class="article-meta">
                            <span class="author">By <?php echo htmlspecialchars($row['author']); ?></span> |
                            <span class="published-date">Published: <?php echo date('m/d/Y', strtotime($row['published_date'])); ?></span>
                        </div>
                        <div class="media-container">
                            <img src="../content/uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="article-image">
                        </div>
                        <p class="article-description"><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                        <div class="post-content-wrapper">
                            <p><?php echo htmlspecialchars($row['content']); ?></p>
                        </div>
                        <div class="article">
                            <div class="interaction-container">
                                <?php if ($isLoggedIn): ?>
                                    <form method="POST" action="like_post.php">
                                        <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
                                        <button type="submit" class="like-button"><i class="fa-solid fa-heart"></i> Like (<?php echo $likeCount; ?>)</button>
                                    </form>
                                    <div> 
                                        <button class="comment-icon" onclick="toggleCommentBox(<?php echo $postId; ?>)">
                                            <i class="fa-solid fa-comment-dots"></i> Comment
                                        </button>

                                        <form method="POST" action="submit_comment.php" id="commentForm<?php echo $postId; ?>" style="display: none;">
                                            <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
                                            <textarea class="comment-input" name="comment" placeholder="Write a comment..."></textarea>
                                            <button type="submit" class="submit-comment">Submit</button>
                                        </form>
                                    </div>

                                    <div>
                                        <button class="share-button" onclick="copyToClipboard('https://example.com/article.php?id=<?php echo $postId; ?>')">
                                            <i class="fa-solid fa-paper-plane"></i> Share
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <p class="interaction-warning">Please <a href="../content/form.php">log in</a> to like, comment, or share.</p>
                                <?php endif; ?>
                            </div>
                            <div class="comments-display">
                                <h3>Comments:</h3>
                                <?php while ($comment = $comments->fetch_assoc()): ?>
                                    <p><strong><?php echo htmlspecialchars($comment['email']); ?>:</strong> <?php echo htmlspecialchars($comment['comment']); ?></p>
                                <?php endwhile; ?>
                            </div>
                        </div>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No posts available for this subcategory.</p>
            <?php endif; ?>
        </section>
    </div>
    <script src = "../content/js/script.js" ></script>
</body>
</html>
