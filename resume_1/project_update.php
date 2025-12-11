<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: log_in.php");
    exit;
}

require "db.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: admin_dashboard.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Project</title>
    <link rel="stylesheet" href="design/style.css" />
    <style>
        body {
            background: linear-gradient(135deg, #5c63f2, #7c85f9);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .edit-container {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 40px 50px;
            width: 380px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
        }
        .edit-container h2 {
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 1.8rem;
            border-bottom: 2px solid #7c85f9;
            padding-bottom: 10px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"] {
            padding: 12px 15px;
            margin-bottom: 25px;
            border-radius: 10px;
            border: none;
            font-size: 1rem;
            outline: none;
        }
        .btn-save {
            background: #7c85f9;
            border: none;
            padding: 15px 0;
            border-radius: 20px;
            font-weight: 700;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 12px rgba(124, 133, 249, 0.6);
        }
        .btn-save:hover {
            background-color: #5c63f2;
            box-shadow: 0 6px 18px rgba(92, 99, 242, 0.9);
        }
        .btn-cancel {
            margin-top: 15px;
            background: transparent;
            border: 2px solid #7c85f9;
            border-radius: 20px;
            padding: 12px 0;
            color: #7c85f9;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background-color: #7c85f9;
            color: white;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Project</h2>
        <form action="project_update.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($project['id']) ?>" />
            <input
                type="text"
                name="title"
                placeholder="Project Title"
                value="<?= htmlspecialchars($project['title']) ?>"
                required
            />
            <button type="submit" class="btn-save">Save Changes</button>
        </form>
        <a href="admin_dashboard.php" class="btn-cancel">Cancel</a>
    </div>
</body>
</html>
