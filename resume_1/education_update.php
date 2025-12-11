<?php
require "db.php";

$id = $_POST['id'] ?? null;
$school = $_POST['school'] ?? '';
$degree = $_POST['degree'] ?? '';
$year_completed = $_POST['year_completed'] ?? '';

if ($id && $school && $degree && $year_completed) {
    $stmt = $conn->prepare("UPDATE education SET school = ?, degree = ?, year_completed = ? WHERE id = ?");
    $stmt->bind_param("sssi", $school, $degree, $year_completed, $id);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit;
