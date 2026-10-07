<?php
include "header.php";
$category = $_GET['category'] ?? '';
$search = "%" . ($_GET['search'] ?? '') . "%";

$stmt = $conn->prepare("SELECT * FROM clubs WHERE status='Active' AND (category = ? OR ? = '') AND (club_name LIKE ? OR description LIKE ?)");
$stmt->bind_param("ssss", $category, $category, $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>
<h2>Explore Campus Clubs</h2>
<form method="get" style="display: flex; gap: 10px; margin: 20px 0; flex-wrap: wrap;">
    <select name="category" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
        <option value="">All Categories</option>
        <option value="Technical" <?php if($category=='Technical') echo 'selected'; ?>>Technical</option>
        <option value="Cultural" <?php if($category=='Cultural') echo 'selected'; ?>>Cultural</option>
        <option value="Sports" <?php if($category=='Sports') echo 'selected'; ?>>Sports</option>
    </select>
    <input type="text" name="search" placeholder="Search club name..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; flex-grow: 1;">
    <button type="submit" class="btn" style="width: auto; padding: 10px 20px;">Search</button>
</form>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
<?php while ($p = $result->fetch_assoc()): ?>
    <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.04); display: flex; flex-direction: column;">
        <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="Club" style="width: 100%; height: 180px; object-fit: cover;">
        <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
            <span style="font-size: 0.75rem; font-weight: 600; color: var(--sage-green); text-transform: uppercase; margin-bottom: 5px;"><?php echo htmlspecialchars($p['category']); ?></span>
            <h3 style="margin-bottom: 8px;"><?php echo htmlspecialchars($p['club_name']); ?></h3>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 15px; flex-grow: 1;"><?php echo substr(htmlspecialchars($p['description']), 0, 80); ?>...</p>
            <a href="club_details.php?id=<?php echo $p['club_id']; ?>" class="btn">View Details</a>
        </div>
    </div>
<?php endwhile; ?>
</div>
<?php if ($result->num_rows == 0) echo "<p style='margin-top: 20px;'>No clubs found.</p>"; ?>
<?php include "footer.php"; ?>