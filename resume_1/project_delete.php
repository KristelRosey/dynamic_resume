<?php
require "db.php";

$id = $_GET["id"];
$conn->query("DELETE FROM projects WHERE id = $id");

header("Location: admin_dashboard.php");
