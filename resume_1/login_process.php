<?php
session_start();
require "db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admins WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();

   
    $inputHash = hash("sha256", $password);

    if ($inputHash === $admin["password"]) {
        $_SESSION["admin"] = $admin["username"];
        header("Location: admin_dashboard.php");
        exit;
    }
}

$_SESSION['error'] = "Invalid login!";
header("Location: log_in.php");
