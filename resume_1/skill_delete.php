<?php
require "db.php";
$id = $_GET['id'];
$conn->query("DELETE FROM skills WHERE id=$id");
header("Location: admin_dashboard.php");
