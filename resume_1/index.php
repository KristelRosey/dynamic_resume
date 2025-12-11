<!DOCTYPE html>

<?php
require "db.php";

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 3;
$offset = ($page - 1) * $itemsPerPage;

$total = $conn->query("SELECT COUNT(*) AS total FROM projects")->fetch_assoc()['total'];
$projects = $conn->query("SELECT * FROM projects ORDER BY id DESC LIMIT $itemsPerPage OFFSET $offset");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kristel Rose Jarina - Portfolio</title>
    <link rel="stylesheet" href="design/style.css">
</head>
<body>
    <div class="container">
      
        <header>
            <div class="header-content">
                <div class="name-section">
                    <h1>Kristel Rose Jarina</h1>
                    <p class="subtitle">Web Developer</p>
                    <p class="subtitle">Multimedia Designer</p>
                    <p class="subtitle">Data Analyst</p>
                </div>
                <div class="header-buttons">
                    <a href="files/resume.pdf" download class="btn-download">Download my cv</a>
                    <a href="#contact" class="btn-primary">Get in touch</a>
                </div>
            </div>
        </header>

      
        <main>
     
            <aside class="sidebar">
                <nav>
                    <ul>
                        <li><a href="#introduction">Introduction</a></li>
                        <li><a href="#about">About me</a></li>
                        <li><a href="#education">Education</a></li>
                        <li><a href="#projects">Projects</a></li>
                        <li><a href="#skills">Skills</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </nav>
            </aside>

       
            <div class="content-area">
        
                <section id="introduction" class="section-content active">
                    <div class="profile-section">
                        <div class="profile-card">
                            <img src="files/resume_profile.png" alt="Kristel Rose Jarina">
                        </div>

                        <div class="about-content">
                            <h2>Introduction</h2>
                            <h3>An interdisciplinary creative who builds engaging digital solutions by uniting technical precision, visual design, and data-driven insight.</h3>
                            <p>My work integrates the creation of interactive digital experiences, the design of compelling visual and multimedia content, and the analysis of data to inform and elevate creative solutions.</p>
                            <a href="#about" class="btn-more">MORE ABOUT ME</a>
                        </div>
                    </div>
                </section>

                  <?php
$about = $conn->query("SELECT * FROM about_me ORDER BY id DESC LIMIT 1")->fetch_assoc();
?>

<section id="about" class="section-content">
    <div class="profile-section">
        <div class="profile-card">
            <img src="files/resume_profile.png" alt="Kristel Rose Jarina">
        </div>

        <div class="about-detail">
            <h2>About me</h2>
            <p class="intro-text"><?= htmlspecialchars($about['intro_text'] ?? ''); ?></p>
            
            <?php if (!empty($about['quote'])): ?>
                <blockquote><?= htmlspecialchars($about['quote']); ?></blockquote>
            <?php endif; ?>

            <div class="qualities">
                <?php if (!empty($about['strengths'])): ?>
                    <div class="quality-item">
                        <strong>STRENGTHS:</strong> <?= htmlspecialchars($about['strengths']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($about['weakness'])): ?>
                    <div class="quality-item">
                        <strong>WEAKNESS:</strong> <?= htmlspecialchars($about['weakness']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($about['bucket_list'])): ?>
                    <div class="quality-item">
                        <strong>BUCKET LIST:</strong> <?= htmlspecialchars($about['bucket_list']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


            
               <section id="skills" class="section-content">
    <div class="profile-section">
        <div class="profile-card">
            <img src="files/resume_profile.png" alt="Kristel Rose Jarina">
        </div>

        <div class="skills-content">
            <h2>Skills</h2>
            <p class="skills-intro">Expertise apply skills, collaborate on innovative projects, And grow with industry-standard tools and workflows.</p>
            
            <h3>KEY SKILLS</h3>
            
            <div class="skills-grid">
                <?php
             
                $skills = $conn->query("SELECT * FROM skills ORDER BY id DESC");
                if ($skills->num_rows > 0):
                    while ($skill = $skills->fetch_assoc()):
                    
                        $skill_text = nl2br(str_replace('|', "\n", htmlspecialchars($skill['skill_name'])));
                ?>
                    <div class="skill-card">
                        <h4><?= $skill_text; ?></h4>
                    </div>
                <?php
                    endwhile;
                else:
                ?>
                    <p>No skills added yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

         
             <section id="education" class="section-content">
    <div class="profile-section">
        <div class="profile-card">
            <img src="files/resume_profile.png" alt="Kristel Rose Jarina">
        </div>

        <div class="education-content">
            <h2>Education</h2>
            <?php
            require "db.php";
            $education = $conn->query("SELECT * FROM education ORDER BY id DESC");
           if ($education->num_rows > 0):
    while ($edu = $education->fetch_assoc()):
?>
    <div class="education-card">
        <h4><?= htmlspecialchars($edu['school']); ?></h4>
        <p class="edu-year"><?= htmlspecialchars($edu['year_completed']); ?></p>
        <p><?= htmlspecialchars($edu['degree']); ?></p>
    </div>
<?php
    endwhile;
else:
?>
    <p>No education records yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

              
                <section id="projects" class="section-content">
                    <div class="profile-section">
                        <div class="profile-card">
                            <img src="files/resume_profile.png" alt="Kristel Rose Jarina">
                        </div>

                        <div class="projects-content">
    <h2>Projects</h2>

    <div class="project-list">

        <?php while ($p = $projects->fetch_assoc()): ?>
            <div class="project-card">
                <h3><?= htmlspecialchars($p['title']); ?></h3>
            </div>
        <?php endwhile; ?>

        <div class="project-item">
            <?php if ($page > 1): ?>
                <a href="index.php?page=<?= $page - 1; ?>" class="previous">< previous</a>
            <?php endif; ?>

            <?php if (($page * $itemsPerPage) < $total): ?>
                <a href="index.php?page=<?= $page + 1; ?>" class="next">next ></a>
            <?php endif; ?>
        </div>

    </div>
</div>

                    </div>
                </section>

        
                <section id="skills" class="section-content">
                    <div class="profile-section">
                        <div class="profile-card">
                            <img src="files/resume_profile.png" alt="Kristel Rose Jarina">
                        </div>

                        <div class="skills-content">
                            <h2>Skills</h2>
                            <p class="skills-intro">Expertise apply skills, collaborate on innovative projects, And grow with industry-standard tools and workflows.</p>
                            
                            <h3>KEY SKILLS</h3>
                            
                            <div class="skills-grid">
                                <div class="skill-card">
                                    <h4>Programming<br>& Software<br>Development</h4>
                                </div>
                                <div class="skill-card">
                                    <h4>Database<br>Management</h4>
                                </div>
                                <div class="skill-card">
                                    <h4>UI/UX & Visual<br>Design</h4>
                                </div>
                                <div class="skill-card">
                                    <h4>Leadership &<br>Team<br>Collaboration</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

             
                <section id="contact" class="section-content">
                    <div class="profile-section">
                        <div class="profile-card">
                            <img src="files/resume_profile.png" alt="Kristel Rose Jarina">
                        </div>

                        <div class="contact-content">
                            <h2>Contact</h2>
                            <p class="contact-intro">A graphic designer is a professional within the graphic design and graphic arts industry who assembles together images, typography, or motion graphics to create a piece of design.</p>
                            
                            <div class="contact-card">
                                <div class="contact-item">
                                    <label>Facebook</label>
                                    <p>facebook.com/rosee.jar</p>
                                </div>
                                
                                <div class="contact-item">
                                    <label>Email</label>
                                    <p>kristelrosejarina@gmail.com</p>
                                </div>
                                
                                <div class="contact-item">
                                    <label>Contact Num</label>
                                    <p>0999 999 9999</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                
               
                document.querySelectorAll('.section-content').forEach(section => {
                    section.classList.remove('active');
                });
                
                
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>