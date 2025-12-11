<?php
require "db.php";

$school = $_POST['school'] ?? '';
$degree = $_POST['degree'] ?? '';
$year_completed = $_POST['year_completed'] ?? '';

if ($school && $degree && $year_completed) {
    $stmt = $conn->prepare("INSERT INTO education (school, degree, year_completed) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $school, $degree, $year_completed);
    $stmt->execute();
}

header("Location: admin_dashboard.php");
exit;
