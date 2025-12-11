<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: log_in.php");
    exit;
}

require "db.php";

// ABOUT ME editing update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['about_submit'])) {
    $intro = $_POST['intro_text'] ?? '';
    $quote = $_POST['quote'] ?? '';
    $strengths = $_POST['strengths'] ?? '';
    $weakness = $_POST['weakness'] ?? '';
    $bucket_list = $_POST['bucket_list'] ?? '';

    
    $existing = $conn->query("SELECT * FROM about_me ORDER BY id DESC LIMIT 1")->fetch_assoc();

    if ($existing) {
        $stmt = $conn->prepare("UPDATE about_me SET intro_text=?, quote=?, strengths=?, weakness=?, bucket_list=? WHERE id=?");
        $stmt->bind_param("sssssi", $intro, $quote, $strengths, $weakness, $bucket_list, $existing['id']);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO about_me (intro_text, quote, strengths, weakness, bucket_list) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $intro, $quote, $strengths, $weakness, $bucket_list);
        $stmt->execute();
    }

   
    $success_message = "About Me section updated successfully!";
}



$projects = $conn->query("SELECT * FROM projects ORDER BY id DESC");
$education = $conn->query("SELECT * FROM education ORDER BY id DESC");
$skills = $conn->query("SELECT * FROM skills ORDER BY id DESC");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="design/style.css" />
    <style>
       
        body, html { margin: 0; padding: 0; height: 100%; font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #5c63f2, #7c85f9); color: #fff; }
        .container { display: flex; height: 100vh; max-width: 1200px; margin: auto; box-shadow: 0 12px 30px rgba(0,0,0,0.3); border-radius: 20px; background: rgba(0,0,0,0.3); backdrop-filter: blur(12px); overflow: hidden; }
        aside.sidebar { width: 240px; background: rgba(124, 133, 249, 0.85); display: flex; flex-direction: column; padding: 40px 20px; box-sizing: border-box; }
        aside.sidebar h2 { margin: 0 0 40px; font-weight: 700; font-size: 1.8rem; text-align: center; user-select: none; }
        aside.sidebar button { background: transparent; border: none; color: #e0e0ff; padding: 15px 10px; margin-bottom: 20px; font-size: 1.1rem; text-align: left; cursor: pointer; border-radius: 12px; transition: background 0.3s ease; font-weight: 600; }
        aside.sidebar button:hover, aside.sidebar button.active { background: rgba(255,255,255,0.2); color: #fff; font-weight: 700; }
        main.content-area { flex-grow: 1; padding: 50px 60px; overflow-y: auto; box-sizing: border-box; display: flex; flex-direction: column; gap: 50px; }
        .logout-btn { position: absolute; top: 30px; right: 30px; background: #7c85f9; border: none; color: white; padding: 12px 25px; border-radius: 25px; cursor: pointer; font-weight: 700; box-shadow: 0 6px 18px rgba(124, 133, 249, 0.7); transition: background-color 0.3s ease; }
        .logout-btn:hover { background-color: #5c63f2; }

       
        section.panel { background: rgba(255,255,255,0.15); border-radius: 20px; padding: 30px 40px; box-sizing: border-box; max-width: 700px; width: 100%; box-shadow: 0 10px 25px rgba(0,0,0,0.25); display: none; flex-direction: column; }
        section.panel.active { display: flex; }
        section.panel h2 { margin-top: 0; font-weight: 700; font-size: 1.5rem; border-bottom: 2px solid #7c85f9; padding-bottom: 12px; margin-bottom: 20px; }

       
        form input[type="text"], form input[type="number"] { padding: 15px 20px; margin-bottom: 20px; border-radius: 15px; border: none; font-size: 1rem; outline: none; width: 100%; box-sizing: border-box; }
        form button.btn-submit { background: #7c85f9; border: none; padding: 15px 0; border-radius: 30px; font-weight: 700; color: white; cursor: pointer; font-size: 1.1rem; box-shadow: 0 6px 18px rgba(124, 133, 249, 0.7); transition: background-color 0.3s ease, box-shadow 0.3s ease; width: 150px; align-self: flex-start; }
        form button.btn-submit:hover { background-color: #5c63f2; box-shadow: 0 8px 22px rgba(92, 99, 242, 0.9); }

       
        .list-item { background: rgba(0,0,0,0.25); border-radius: 15px; padding: 15px 20px; margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; box-sizing: border-box; }
        .list-item p { margin: 0; font-weight: 600; font-size: 1rem; flex-grow: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .list-item .actions { display: flex; gap: 15px; }
        .list-item .actions a { text-decoration: none; padding: 8px 18px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: background-color 0.3s ease; user-select: none; }
        .list-item .actions a.edit { background: #7c85f9; color: white; }
        .list-item .actions a.edit:hover { background: #5c63f2; }
        .list-item .actions a.delete { background: #e0e0ff; color: #555; }
        .list-item .actions a.delete:hover { background: #cfcfff; }

      
        main.content-area::-webkit-scrollbar { width: 8px; }
        main.content-area::-webkit-scrollbar-thumb { background: rgba(124, 133, 249, 0.6); border-radius: 10px; }
    </style>
</head>
<body>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>

    <div class="container">
        <aside class="sidebar">
            <h2>Admin Menu</h2>
            <button id="btn-projects" class="active">Projects</button>
            <button id="btn-education">Education</button>
            <button id="btn-skills">Skills</button>
            <button id="btn-about">About Me</button>

        </aside>

        <main class="content-area">
            
            <section id="panel-projects" class="panel active">
                <h2>Insert New Project</h2>
                <form action="project_add.php" method="POST">
                    <input type="text" name="title" placeholder="Project Title" required>
                    <button class="btn-submit" type="submit">Add Project</button>
                </form>

                <h2>Existing Projects</h2>
                <?php while ($row = $projects->fetch_assoc()): ?>
                    <div class="list-item">
                        <p><?= htmlspecialchars($row['title']); ?></p>
                        <div class="actions">
                            <a href="project_edit.php?id=<?= $row['id']; ?>" class="edit">Edit</a>
                            <a href="project_delete.php?id=<?= $row['id']; ?>" class="delete" onclick="return confirm('Delete this project?')">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </section>

            
            <section id="panel-education" class="panel">
                <h2>Insert New Education</h2>
                <form action="education_add.php" method="POST">
                    <input type="text" name="school" placeholder="School" required>
                    <input type="text" name="degree" placeholder="Degree" required>
                    <input type="text" name="year_completed" placeholder="Year Completed" required>
                    <button class="btn-submit" type="submit">Add Education</button>
                </form>

                <h2>Existing Education</h2>
                <?php while ($edu = $education->fetch_assoc()): ?>
                    <div class="list-item">
                        <p><strong><?= htmlspecialchars($edu['school']); ?></strong> — <?= htmlspecialchars($edu['degree']); ?> (<?= htmlspecialchars($edu['year_completed']); ?>)</p>
                        <div class="actions">
                            <a href="education_edit.php?id=<?= $edu['id']; ?>" class="edit">Edit</a>
                            <a href="education_delete.php?id=<?= $edu['id']; ?>" class="delete" onclick="return confirm('Delete this education record?')">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </section>

         
            <section id="panel-skills" class="panel">
                <h2>Insert New Skill</h2>
                <form action="skill_add.php" method="POST">
                    <input type="text" name="skill_name" placeholder="Skill Name" required>
                    <button class="btn-submit" type="submit">Add Skill</button>
                </form>

                <h2>Existing Skills</h2>
                <?php while ($skill = $skills->fetch_assoc()): ?>
                    <div class="list-item">
                        <p><?= htmlspecialchars($skill['skill_name']); ?></p>
                        <div class="actions">
                            <a href="skill_edit.php?id=<?= $skill['id']; ?>" class="edit">Edit</a>
                            <a href="skill_delete.php?id=<?= $skill['id']; ?>" class="delete" onclick="return confirm('Delete this skill?')">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </section>

           
<section id="panel-about" class="panel">
    <h2>Edit About Me Section</h2>
    
    <?php
    $about = $conn->query("SELECT * FROM about_me ORDER BY id DESC LIMIT 1")->fetch_assoc();
    ?>

    <form method="POST">
    <label>Intro Text:</label>
    <textarea name="intro_text" rows="4" required><?= isset($about['intro_text']) ? htmlspecialchars($about['intro_text']) : ''; ?></textarea>

    <label>Quote:</label>
    <input type="text" name="quote" value="<?= isset($about['quote']) ? htmlspecialchars($about['quote']) : ''; ?>">

    <label>Strengths (comma separated):</label>
    <input type="text" name="strengths" value="<?= isset($about['strengths']) ? htmlspecialchars($about['strengths']) : ''; ?>">

    <label>Weakness:</label>
    <input type="text" name="weakness" value="<?= isset($about['weakness']) ? htmlspecialchars($about['weakness']) : ''; ?>">

    <label>Bucket List:</label>
    <input type="text" name="bucket_list" value="<?= isset($about['bucket_list']) ? htmlspecialchars($about['bucket_list']) : ''; ?>">

    <button class="btn-submit" type="submit" name="about_submit"><?= $about ? 'Update' : 'Add'; ?></button>
</form>

<?php if (isset($success_message)): ?>
    <p style="color: #aaffaa; margin-top: 10px; font-weight: 600;"><?= $success_message; ?></p>
<?php endif; ?>

</section>


        </main>
    </div>

<script>
const panels = {
    'btn-projects': 'panel-projects',
    'btn-education': 'panel-education',
    'btn-skills': 'panel-skills',
    'btn-about': 'panel-about'
};


function activatePanel(btnId, pushState = true) {
   
    for (let bId in panels) {
        document.getElementById(bId).classList.remove('active');
        document.getElementById(panels[bId]).classList.remove('active');
    }

   
    document.getElementById(btnId).classList.add('active');
    document.getElementById(panels[btnId]).classList.add('active');

    
    if (pushState) {
        history.pushState({panel: btnId}, '', `#${panels[btnId]}`);
    }
}


for (let btnId in panels) {
    document.getElementById(btnId).addEventListener('click', () => activatePanel(btnId));
}


window.addEventListener('load', () => {
    const hash = window.location.hash.substring(1); 
    const btnId = Object.keys(panels).find(id => panels[id] === hash);
    if (btnId) {
        activatePanel(btnId, false);
    } else {
      
        activatePanel('btn-projects', false);
    }
});


window.addEventListener('popstate', (event) => {
    if (event.state && event.state.panel) {
        activatePanel(event.state.panel, false);
    }
});



    const btnProjects = document.getElementById('btn-projects');
    const btnEducation = document.getElementById('btn-education');
    const btnSkills = document.getElementById('btn-skills');
    const panelProjects = document.getElementById('panel-projects');
    const panelEducation = document.getElementById('panel-education');
    const panelSkills = document.getElementById('panel-skills');
    const btnAbout = document.getElementById('btn-about');
    const panelAbout = document.getElementById('panel-about');

    btnAbout.addEventListener('click', () => {
    btnAbout.classList.add('active');
    btnProjects.classList.remove('active');
    btnEducation.classList.remove('active');
    btnSkills.classList.remove('active');

    panelAbout.classList.add('active');
    panelProjects.classList.remove('active');
    panelEducation.classList.remove('active');
    panelSkills.classList.remove('active');
});


    btnProjects.addEventListener('click', () => {
        btnProjects.classList.add('active');
        btnEducation.classList.remove('active');
        btnSkills.classList.remove('active');
        panelProjects.classList.add('active');
        panelEducation.classList.remove('active');
        panelSkills.classList.remove('active');
    });

    btnEducation.addEventListener('click', () => {
        btnEducation.classList.add('active');
        btnProjects.classList.remove('active');
        btnSkills.classList.remove('active');
        panelEducation.classList.add('active');
        panelProjects.classList.remove('active');
        panelSkills.classList.remove('active');
    });

    btnSkills.addEventListener('click', () => {
        btnSkills.classList.add('active');
        btnProjects.classList.remove('active');
        btnEducation.classList.remove('active');
        panelSkills.classList.add('active');
        panelProjects.classList.remove('active');
        panelEducation.classList.remove('active');
    });
</script>
</body>
</html>
