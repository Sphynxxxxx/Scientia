<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
    <title>Admin Panel</title>
    <script>
        function updateSubcategories() {
            const mainCategory = document.getElementById('main_category').value;
            const subCategorySelect = document.getElementById('sub_category');

            subCategorySelect.innerHTML = '';

            const subcategories = {
                "Discover the Cosmos": ["Planets", "Stars", "Galaxies"],
                "Observation Hub": ["Telescope Setup", "Stargazing Tips", "Astronomy Events"],
                "Science & Mysteries": ["Mystery 1", "Mystery 2", "Mystery 3"],
                "Space Missions & Exploration": ["Mission 1", "Mission 2", "Mission 3"]
            };

            const options = subcategories[mainCategory] || [];
            options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option;
                opt.textContent = option;
                subCategorySelect.appendChild(opt);
            });
        }
    </script>
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1>SCIENTIA</h1>
            <h2>Admin Panel - Manage Posts</h2>
        </header>

        <div class="admin-content">
            <form action="admin_upload.php" method="POST" enctype="multipart/form-data" class="admin-form">
                <div class="form-group">
                    <label for="main_category">Select Main Category:</label>
                    <select name="main_category" id="main_category" required onchange="updateSubcategories()">
                        <option value="Discover the Cosmos">Discover the Cosmos</option>
                        <option value="Observation Hub">Observation Hub</option>
                        <option value="Science & Mysteries">Science & Mysteries</option>
                        <option value="Space Missions & Exploration">Space Missions & Exploration</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sub_category">Select Subcategory:</label>
                    <select name="sub_category" id="sub_category" required>
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">Post Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="subtitle">Post Subtitle:</label>
                    <input type="text" id="subtitle" name="subtitle" required>
                </div>

                <div class="form-group">
                    <label for="author">Author Name:</label>
                    <input type="text" id="author" name="author">
                </div>

                <div class="form-group">
                    <label for="published_date">Published Date:</label>
                    <input type="date" id="published_date" name="published_date">
                </div>

                <div class="form-group">
                    <label for="description">Post Description:</label>
                    <textarea id="description" name="description" rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label for="content">Post Content:</label>
                    <textarea id="content" name="content" rows="10" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Upload Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>

                <button type="submit" name="submit_post" class="submit-btn">Publish Post</button>
            </form>

            <hr>

            <a href="manage_posts.php" class="btn-manage">Go to Manage Existing Posts</a>
        </div>
    </div>
</body>
</html>
