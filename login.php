<?php
include "header.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("SELECT user_id, name, password, role FROM users WHERE email=?");
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($_POST["password"], $user["password"])) {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];
        header("Location: " . ($user["role"] == "admin" ? "admin_requests.php" : "clubs.php"));
        exit;
    }
    $error = "Invalid email or password.";
}
?>
<div class="form-box">
    <h2 style="text-align: center; margin-bottom: 20px;">Login</h2>
    <?php if ($error) echo "<div class='msg err'>$error</div>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Login</button>
    </form>
</div>
</body>
</html>
