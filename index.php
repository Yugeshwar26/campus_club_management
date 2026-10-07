<?php
include "header.php";
$active_clubs = $conn->query("SELECT COUNT(*) AS c FROM clubs WHERE status='Active'")->fetch_assoc()["c"];
$total_members = $conn->query("SELECT COUNT(*) AS c FROM membership_requests WHERE status='Approved'")->fetch_assoc()["c"];
$feat = $conn->query("SELECT * FROM clubs WHERE status='Active' ORDER BY club_id DESC LIMIT 3");
?>
<div style="background: linear-gradient(120deg, var(--sage-green), #3b4231); color: white; border-radius: 16px; padding: 40px; margin-bottom: 30px;">
    <h1 style="font-size: 2.5rem; margin-bottom: 10px;">Find Your Community on Campus</h1>
    <p style="font-size: 1.1rem; margin-bottom: 20px; opacity: 0.9;">Explore technical, cultural, and sports clubs and apply to join online.</p>
    <a href="clubs.php" class="btn" style="background: white; color: var(--text-main); width: auto; padding: 10px 24px;">Explore Clubs</a>
</div>

<div style="display: flex; gap: 20px; margin-bottom: 30px;">
    <div style="background: white; padding: 20px; border-radius: 12px; flex: 1; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <b style="font-size: 2rem; color: var(--cherry-red);"><?php echo $active_clubs; ?></b>
        <div style="color: #666; font-size: 0.9rem;">Active Clubs</div>
    </div>
    <div style="background: white; padding: 20px; border-radius: 12px; flex: 1; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
        <b style="font-size: 2rem; color: var(--cherry-red);"><?php echo $total_members; ?></b>
        <div style="color: #666; font-size: 0.9rem;">Successful Joins</div>
    </div>
</div>

<h2 style="margin-bottom: 20px;">Newly Added Clubs</h2>
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
<?php while ($p = $feat->fetch_assoc()): ?>
    <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.04); display: flex; flex-direction: column;">
        <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="Club" style="width: 100%; height: 180px; object-fit: cover;">
        <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
            <h3 style="margin-bottom: 8px;"><?php echo htmlspecialchars($p['club_name']); ?></h3>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 15px; flex-grow: 1;"><?php echo substr(htmlspecialchars($p['description']), 0, 80); ?>...</p>
            <a href="club_details.php?id=<?php echo $p['club_id']; ?>" class="btn">View Details</a>
        </div>
    </div>
<?php endwhile; ?>
</div>
<?php include "footer.php"; ?>