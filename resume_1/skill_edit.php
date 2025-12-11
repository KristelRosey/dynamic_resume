<?php
require "db.php";
$id = $_GET['id'] ?? 0;
$result = $conn->query("SELECT * FROM skills WHERE id = $id");
$skill = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Skill</title>
    <link rel="stylesheet" href="design/style.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #5c63f2, #7c85f9);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(0,0,0,0.3);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.3);
            width: 400px;
        }
        h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 700;
            text-align: center;
        }
        form input[type="text"] {
            padding: 15px 20px;
            border-radius: 15px;
            border: none;
            width: 100%;
            margin-bottom: 20px;
            font-size: 1rem;
        }
        form button.btn-more {
            background: #7c85f9;
            border: none;
            padding: 15px 0;
            border-radius: 30px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            transition: background 0.3s ease;
        }
        form button.btn-more:hover {
            background: #5c63f2;
        }
        a.back-btn {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #555;
            background: #e0e0ff;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            text-align: center;
            transition: background 0.3s ease;
        }
        a.back-btn:hover {
            background: #cfcfff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Skill</h2>
    <form action="skill_update.php" method="POST">
        <input type="hidden" name="id" value="<?= $skill['id']; ?>">
        <input type="text" name="skill_name" value="<?= htmlspecialchars($skill['skill_name']); ?>" required>
        <button class="btn-more" type="submit">Update</button>
    </form>
    
</div>

</body>
</html>
