<?php
require "db.php";
$id = $_POST['id'];
$skill_name = $_POST['skill_name'];
$stmt = $conn->prepare("UPDATE skills SET skill_name=? WHERE id=?");
$stmt->bind_param("si", $skill_name, $id);
$stmt->execute();
header("Location: admin_dashboard.php");
