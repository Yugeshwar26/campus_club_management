<?php
include "header.php";
if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }
$club_id = (int)($_GET["id"] ?? 0);
$msg = "";

$stmt = $conn->prepare("SELECT club_name FROM clubs WHERE club_id=? AND status='Active'");
$stmt->bind_param("i", $club_id);
$stmt->execute();
$club = $stmt->get_result()->fetch_assoc();
if (!$club) { echo "<div class='container'><p>Club not available.</p></div>"; include "footer.php"; exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = trim($_POST["reason"]);
    $stmt = $conn->prepare("INSERT INTO membership_requests (user_id, club_id, reason) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $_SESSION["user_id"], $club_id, $reason);
    $stmt->execute();
    $msg = "Your membership request has been submitted and is pending approval.";
}
?>
<div class="form-box">
    <h2>Join <?php echo htmlspecialchars($club["club_name"]); ?></h2>
    <?php if ($msg) echo "<div class='msg' style='margin-top:15px;'>$msg</div>"; ?>
    <form method="post" style="margin-top: 15px;">
        <textarea name="reason" rows="5" placeholder="Why do you want to join this club?" required style="width:100%; padding:12px; border-radius:8px; border:1px solid #ddd; margin-bottom:15px; font-family:inherit;"></textarea>
        <button type="submit" class="btn">Submit Request</button>
    </form>
</div>
<?php include "footer.php"; ?>