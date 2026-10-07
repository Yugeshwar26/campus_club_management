<?php
include "header.php";
if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }

$stmt = $conn->prepare("SELECT c.club_name, c.category, r.reason, r.status, r.request_date FROM membership_requests r JOIN clubs c ON r.club_id = c.club_id WHERE r.user_id = ? ORDER BY r.request_date DESC");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$rows = $stmt->get_result();
?>
<h2>My Membership Requests</h2>
<table style="width: 100%; background: white; border-collapse: collapse; margin-top: 20px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
    <tr style="background: var(--sage-green); color: white; text-align: left;">
        <th style="padding: 12px;">Club Name</th>
        <th style="padding: 12px;">Category</th>
        <th style="padding: 12px;">Reason</th>
        <th style="padding: 12px;">Date</th>
        <th style="padding: 12px;">Status</th>
    </tr>
    <?php while ($r = $rows->fetch_assoc()): ?>
    <tr style="border-bottom: 1px solid #eee;">
        <td style="padding: 12px; font-weight: 600;"><?php echo htmlspecialchars($r['club_name']); ?></td>
        <td style="padding: 12px;"><?php echo htmlspecialchars($r['category']); ?></td>
        <td style="padding: 12px;"><?php echo htmlspecialchars($r['reason']); ?></td>
        <td style="padding: 12px;"><?php echo substr($r['request_date'], 0, 10); ?></td>
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
    </tr>
    <?php endwhile; ?>
</table>
<?php include "footer.php"; ?>