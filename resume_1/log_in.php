<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Login - Kristel Rose Jarina</title>
<link rel="stylesheet" href="design/style.css" />
<style>
  

  body {
    background: linear-gradient(135deg, #7dd3fc 0%, #a78bfa 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
    color: white;
  }

  .login-container {
    background: rgba(99, 102, 241, 0.85);
    padding: 3rem 3.5rem;
    border-radius: 1.5rem;
    box-shadow: 0 0 25px rgba(99, 102, 241, 0.6);
    width: 360px;
    max-width: 90vw;
    text-align: center;
  }

  h1 {
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 2.25rem;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
  }

  input[type="text"],
  input[type="password"] {
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    border: none;
    font-size: 1rem;
    outline: none;
    font-weight: 500;
  }

  input::placeholder {
    color: #ddd;
  }

  button.btn-more {
    background-color: #6366f1;
    color: white;
    border: none;
    padding: 0.9rem 0;
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  button.btn-more:hover {
    background-color: #4f46e5;
  }

  .guest-mode {
    margin-top: 1.6rem;
    font-size: 0.9rem;
  }

  .guest-mode a {
    color: #e0e7ff;
    text-decoration: underline;
    cursor: pointer;
  }

  .error-message {
    background: #f87171;
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: white;
  }
</style>
</head>
<body>
  <div class="login-container">
    <h1>Admin Login</h1>

    <?php
      session_start();
      if (isset($_SESSION['error'])) {
          echo '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
          unset($_SESSION['error']);
      }
    ?>

    <form action="login_process.php" method="POST" autocomplete="off">
      <input type="text" name="username" placeholder="Username" required autofocus />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" class="btn-more">Log In</button>
    </form>

    <div class="guest-mode">
      <a href="index.php">Continue as Guest</a>
    </div>
  </div>
</body>
</html>


