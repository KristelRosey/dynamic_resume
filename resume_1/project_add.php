<?php
require "db.php";

$title = $_POST["title"];
$sql = "INSERT INTO projects (title) VALUES (?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $title);
$stmt->execute();

header("Location: admin_dashboard.php");
