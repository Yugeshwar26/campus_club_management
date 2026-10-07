<?php
include "header.php";
if (($_SESSION["role"] ?? "") != "admin") { header("Location: login.php"); exit; }

if (isset($_GET["action"], $_GET["id"])) {
    $id = (int)$_GET["id"];
    $status = ($_GET["action"] == "approve") ? "Approved" : "Rejected";
    
    $stmt = $conn->prepare("UPDATE membership_requests SET status=? WHERE request_id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

$rows = $conn->query("SELECT r.request_id, u.name AS student, c.club_name AS club, r.reason, r.status FROM membership_requests r JOIN users u ON r.user_id = u.user_id JOIN clubs c ON r.club_id = c.club_id ORDER BY r.request_id DESC");
?>
<h2>Membership Requests</h2>
<table style="width: 100%; background: white; border-collapse: collapse; margin-top: 20px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
    <tr style="background: var(--sage-green); color: white; text-align: left;">
        <th style="padding: 12px;">Student</th>
        <th style="padding: 12px;">Club</th>
        <th style="padding: 12px;">Reason</th>
        <th style="padding: 12px;">Status</th>
        <th style="padding: 12px;">Action</th>
    </tr>
    <?php while ($r = $rows->fetch_assoc()): ?>
    <tr style="border-bottom: 1px solid #eee;">
        <td style="padding: 12px; font-weight: 600;"><?php echo htmlspecialchars($r['student']); ?></td>
        <td style="padding: 12px;"><?php echo htmlspecialchars($r['club']); ?></td>
        <td style="padding: 12px;"><?php echo htmlspecialchars($r['reason']); ?></td>
        <td style="padding: 12px;">
            <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; 
                <?php 
                if($r['status']=='Pending') echo 'background: #fff3cd; color: #856404;';
                elseif($r['status']=='Approved') echo 'background: #d4edda; color: #155724;';
                else echo 'background: #f8d7da; color: #721c24;';
                ?>">
                <?php echo $r['status']; ?>
            </span>
        </td>
        <td style="padding: 12px;">
            <?php if ($r['status'] == 'Pending'): ?>
                <a href="?action=approve&id=<?php echo $r['request_id']; ?>" style="color: var(--sage-green); font-weight: 600; text-decoration: none; margin-right: 15px;">Approve</a>
                <a href="?action=reject&id=<?php echo $r['request_id']; ?>" style="color: var(--cherry-red); font-weight: 600; text-decoration: none;">Reject</a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php include "footer.php"; ?>