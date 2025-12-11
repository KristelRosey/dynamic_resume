<?php
require "db.php";

$id = $_POST["id"];
$title = $_POST["title"];

$sql = "UPDATE projects SET title = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $title, $id);
$stmt->execute();

header("Location: admin_dashboard.php");

