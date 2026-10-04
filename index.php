<?php 
include 'db.php'; 

// CRUD: DELETE OPERATION
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM clubs WHERE id = $id");
    header("Location: index.php");
    exit;
}

// CRUD: CREATE OPERATION
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_club'])) {
    $name = $_POST['club_name'];
    $desc = $_POST['description'];
    $img = $_POST['image_url'];
    
    $stmt = $conn->prepare("INSERT INTO clubs (club_name, description, image_url) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $desc, $img);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Club Management</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap');
        
        :root {
            --bg-beige: #f4f1eb;
            --text-main: #1a202c;
            --sage-green: #5c664d;
            --cherry-red: #8a2a2b;
            --white: #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-beige);
            color: var(--text-main);
            padding: 2rem;
        }

        header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem;
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        /* Pinterest Grid */
        .club-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 4rem auto;
        }

        .club-card {
            background: var(--white);
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .club-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        }

        /* Animated Image Container */
        .img-container {
            width: 100%;
            height: 200px;
            border-radius: 16px;
            overflow: hidden;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .club-card:hover .img-container img {
            transform: scale(1.1);
        }

        .club-title { font-size: 1.25rem; font-weight: 600; }
        .club-desc { font-size: 0.95rem; color: #666; line-height: 1.5; flex-grow: 1; }

        .btn-group { display: flex; gap: 10px; margin-top: auto; }
        
        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-align: center;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.9; }
        .btn-primary { background-color: var(--cherry-red); color: var(--white); }
        .btn-danger { background-color: transparent; border: 2px solid #ccc; color: #666; }
        
        /* Admin Form */
        .admin-panel {
            max-width: 600px;
            margin: 0 auto;
            background: var(--white);
            padding: 2rem;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
        
        .admin-panel input, .admin-panel textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-family: inherit;
        }
    </style>
</head>
<body>

    <header>
        <h1>Campus Clubs</h1>
        <div class="status" style="color: var(--sage-green); font-weight: 600;">Explore & Join Your Community</div>
    </header>

    <div class="club-grid">
        <?php
        // CRUD: READ OPERATION
        $result = $conn->query("SELECT * FROM clubs ORDER BY created_at DESC");
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '
                <div class="club-card">
                    <div class="img-container">
                        <img src="' . htmlspecialchars($row['image_url']) . '" alt="Club Image">
                    </div>
                    <div class="club-title">' . htmlspecialchars($row['club_name']) . '</div>
                    <div class="club-desc">' . htmlspecialchars($row['description']) . '</div>
                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="alert(\'Membership request sent to the club coordinator!\')">Join Club</button>
                        <a href="?delete=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Remove this club?\')">Delete</a>
                    </div>
                </div>';
            }
        } else {
            echo "<p>No clubs found. Add one below!</p>";
        }
        ?>
    </div>

    <div class="admin-panel">
        <h2 style="margin-bottom: 1.5rem;">Admin: Add New Club</h2>
        <form method="POST" action="">
            <input type="text" name="club_name" placeholder="Club Name" required>
            <input type="text" name="image_url" placeholder="Image URL (e.g., Unsplash link)" required>
            <textarea name="description" placeholder="Club Description..." rows="4" required></textarea>
            <button type="submit" name="add_club" class="btn btn-primary" style="width: 100%;">Create Club</button>
        </form>
    </div>

</body>
</html>