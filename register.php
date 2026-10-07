<?php
include "header.php";
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $pass);
    
    if ($stmt->execute()) {
        $msg = "Registration successful. Please login.";
    } else {
        $msg = "<span class='err'>Email already registered.</span>";
    }
}
?>
<div class="form-box">
    <h2 style="text-align: center; margin-bottom: 20px;">Create Account</h2>
    <?php if ($msg) echo "<div class='msg'>$msg</div>"; ?>
    <form method="post">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Student Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Register</button>
    </form>
</div>
</body>
</html>