<?php
include "header.php";
$id = (int)($_GET["id"] ?? 0);
$stmt = $conn->prepare("SELECT * FROM clubs WHERE club_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
if (!$p) { echo "<p>Club not found.</p>"; include "footer.php"; exit; }
?>
<div style="background: white; border-radius: 16px; padding: 30px; display: flex; gap: 30px; box-shadow: 0 4px 16px rgba(0,0,0,0.04); flex-wrap: wrap;">
    <img src="<?php echo htmlspecialchars($p['image_url']); ?>" alt="Club" style="width: 400px; height: 300px; object-fit: cover; border-radius: 12px;">
    <div style="flex: 1; display: flex; flex-direction: column; gap: 15px;">
        <h2><?php echo htmlspecialchars($p['club_name']); ?></h2>
        <div style="background: var(--bg-beige); padding: 15px; border-radius: 8px;">
            <p><strong>Category:</strong> <?php echo htmlspecialchars($p['category']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($p['status']); ?></p>
        </div>
        <p style="line-height: 1.6; color: #555;"><?php echo htmlspecialchars($p['description']); ?></p>
        <?php if ($p['status'] == 'Active'): ?>
            <a href="join.php?id=<?php echo $p['club_id']; ?>" class="btn" style="max-width: 200px;">Join Club</a>
        <?php endif; ?>
    </div>
</div>
<?php include "footer.php"; ?>