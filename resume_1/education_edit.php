<?php
require "db.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin_dashboard.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM education WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$education = $result->fetch_assoc();

if (!$education) {
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Education</title>
    <link rel="stylesheet" href="design/style.css" />
    <style>
        body {
            background: linear-gradient(135deg, #5c63f2, #7c85f9);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            padding: 20px;
        }
        .container {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 40px 50px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            box-sizing: border-box;
            text-align: center;
        }
        h2 {
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 1.8rem;
            border-bottom: 2px solid #7c85f9;
            padding-bottom: 12px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"] {
            padding: 14px 15px;
            margin-bottom: 20px;
            border-radius: 12px;
            border: none;
            font-size: 1rem;
            outline: none;
            box-sizing: border-box;
        }
        .btn-more {
            background: #7c85f9;
            border: none;
            padding: 15px 0;
            border-radius: 25px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            font-size: 1.1rem;
            box-shadow: 0 6px 18px rgba(124, 133, 249, 0.7);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-more:hover {
            background-color: #5c63f2;
            box-shadow: 0 8px 22px rgba(92, 99, 242, 0.9);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Education</h2>
    <form action="education_update.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($education['id']) ?>">
        <input type="text" name="school" value="<?= htmlspecialchars($education['school']) ?>" placeholder="School" required>
        <input type="text" name="degree" value="<?= htmlspecialchars($education['degree']) ?>" placeholder="Degree" required>
        <input type="text" name="year_completed" value="<?= htmlspecialchars($education['year_completed']) ?>" placeholder="Year Completed" required>
        <button class="btn-more" type="submit">Update</button>
    </form>
</div>
</body>
</html>
s