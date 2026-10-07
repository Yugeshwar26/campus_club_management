<?php include_once "db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Club Management</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap');
        :root { --bg-beige: #f4f1eb; --text-main: #1a202c; --sage-green: #5c664d; --cherry-red: #8a2a2b; --white: #ffffff; }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--bg-beige); color: var(--text-main); }
        .navbar { display: flex; justify-content: space-between; padding: 1.5rem 3rem; background: var(--white); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .navbar a { text-decoration: none; color: var(--text-main); font-weight: 600; margin-left: 20px; }
        .navbar a:hover { color: var(--cherry-red); }
        .container { padding: 3rem; max-width: 1200px; margin: auto; }
        .form-box { max-width: 400px; margin: auto; background: var(--white); padding: 2rem; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.04); }
        .form-box input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; }
        .btn { display: inline-block; width: 100%; padding: 12px; border-radius: 8px; background: var(--cherry-red); color: white; border: none; font-weight: 600; cursor: pointer; text-align: center; text-decoration: none; }
        .msg { padding: 10px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px; }
        .err { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div style="font-size: 1.5rem; font-weight: 600; color: var(--cherry-red);">CampusClubs</div>
        <div>
            <a href="index.php">Home</a>
            <a href="clubs.php">Browse Clubs</a>
            <?php if (!isset($_SESSION["user_id"])): ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php elseif ($_SESSION["role"] == "admin"): ?>
                <a href="admin_clubs.php">Manage Clubs</a>
                <a href="admin_requests.php">Requests</a>
                <a href="logout.php" style="color: var(--sage-green);">Logout</a>
            <?php else: ?>
                <a href="my_requests.php">My Requests</a>
                <a href="logout.php" style="color: var(--sage-green);">Logout (<?php echo $_SESSION["name"]; ?>)</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container">
