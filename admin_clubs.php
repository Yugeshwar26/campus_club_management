<?php
include "header.php";
if (($_SESSION["role"] ?? "") != "admin") { header("Location: login.php"); exit; }
$msg = "";

if (isset($_GET["delete"])) {
    $stmt = $conn->prepare("DELETE FROM clubs WHERE club_id=?");
    $stmt->bind_param("i", $_GET["delete"]);
    $msg = $stmt->execute() ? "Club deleted successfully." : "Cannot delete club with active requests.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["club_name"];
    $cat = $_POST["category"];
    $desc = $_POST["description"];
    $img = $_POST["image_url"];

    $stmt = $conn->prepare("INSERT INTO clubs (club_name, category, description, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $cat, $desc, $img);
    $stmt->execute();
    $msg = "Club added successfully.";
}

$clubs = $conn->query("SELECT * FROM clubs ORDER BY club_id DESC");
?>
<h2>Manage Clubs</h2>
<?php if ($msg) echo "<div class='msg' style='margin-bottom:15px;'>$msg</div>"; ?>

<form method="post" style="background: white; padding: 20px; border-radius: 12px; display: grid; gap: 12px; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
        <input type="text" name="club_name" placeholder="Club Name" required style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
        <select name="category" required style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
            <option value="Technical">Technical</option>
            <option value="Cultural">Cultural</option>
            <option value="Sports">Sports</option>
        </select>
    </div>
    <input type="text" name="image_url" placeholder="Image URL (Unsplash link)" required style="padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
    <textarea name="description" placeholder="Description" rows="3" required style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; font-family:inherit;"></textarea>
    <button type="submit" class="btn" style="width: auto;">Add Club</button>
</form>

<table style="width: 100%; background: white; border-collapse: collapse; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
    <tr style="background: var(--sage-green); color: white; text-align: left;">
        <th style="padding: 12px;">ID</th>
        <th style="padding: 12px;">Name</th>
        <th style="padding: 12px;">Category</th>
        <th style="padding: 12px;">Status</th>
        <th style="padding: 12px;">Action</th>
    </tr>
    <?php while ($c = $clubs->fetch_assoc()): ?>
    <tr style="border-bottom: 1px solid #eee;">
        <td style="padding: 12px;"><?php echo $c['club_id']; ?></td>
        <td style="padding: 12px; font-weight: 600;"><?php echo htmlspecialchars($c['club_name']); ?></td>
        <td style="padding: 12px;"><?php echo htmlspecialchars($c['category']); ?></td>
        <td style="padding: 12px;"><?php echo htmlspecialchars($c['status']); ?></td>
        <td style="padding: 12px;"><a href="?delete=<?php echo $c['club_id']; ?>" onclick="return confirm('Delete this club?')" style="color: var(--cherry-red); text-decoration: none; font-weight: 600;">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>
<?php include "footer.php"; ?>