<?php
require "db.php";
$skill_name = $_POST['skill_name'];
$stmt = $conn->prepare("INSERT INTO skills (skill_name) VALUES (?)");
$stmt->bind_param("s", $skill_name);
$stmt->execute();
header("Location: admin_dashboard.php");
