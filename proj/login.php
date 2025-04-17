<?php
include "connection.php"; // Include database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $login_error = '';

  // Validate login credentials
  $query = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      // Login successful, redirect to index.php
      $_SESSION['user'] = $email;
      header("Location: index.php");
      exit();
    } else {
      // Invalid password
      "<script>alert('Invalid password. Please try again.');</script>";
    }
  } else {
    // Invalid email
    $login_error = "No account found with that email address.";
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Virtual Fitting Room - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary: #6a5acd;
      --primary-light: #7b68ee;
      --primary-dark: #5649a8;
      --secondary: #ff7e5f;
      --secondary-light: #ff9e88;
      --dark: #2d3748;
      --light: #f8fafc;
      --gray: #e2e8f0;
      --gray-dark: #cbd5e0;
      --success: #48bb78;
      --error: #f56565;
      --warning: #ed8936;
      --info: #4299e1;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      animation: fadeIn 1s ease-in;
      color: var(--dark);
      line-height: 1.6;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .container {
      background-color: white;
      padding: 2.5rem;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.1), 0 10px 10px rgba(0,0,0,0.04);
      width: 100%;
      max-width: 500px;
      animation: slideUp 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      position: relative;
      overflow: hidden;
      transition: var(--transition);
    }

    .container:hover {
      box-shadow: 0 25px 50px rgba(0,0,0,0.15), 0 15px 15px rgba(0,0,0,0.1);
    }

    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 8px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      background-size: 200% 100%;
      animation: gradientBG 3s ease infinite;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: var(--dark);
      font-weight: 700;
      font-size: 1.8rem;
      position: relative;
      font-family: 'Montserrat', sans-serif;
      letter-spacing: -0.5px;
    }

    h2::after {
      content: '';
      position: absolute;
      bottom: -12px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      border-radius: 3px;
      animation: stretch 1.5s ease infinite alternate;
    }

    @keyframes stretch {
      0% { width: 80px; }
      100% { width: 120px; }
    }

    .social-login {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .social-btn {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .social-btn:hover {
      transform: translateY(-3px) scale(1.05);
      box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .social-btn:active {
      transform: translateY(1px);
    }

    .google { background: #db4437; }
    .facebook { background: #4267B2; }
    .apple { background: #000; }

    .divider {
      display: flex;
      align-items: center;
      margin: 1.5rem 0;
      color: var(--gray-dark);
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--gray);
      margin: 0 1rem;
    }

    form input {
      width: 100%;
      padding: 0.9rem 1.2rem;
      margin: 0.5rem 0;
      border: 2px solid var(--gray);
      border-radius: 10px;
      font-size: 0.95rem;
      transition: var(--transition);
      font-family: 'Poppins', sans-serif;
      background-color: var(--light);
    }

    form input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 4px rgba(106, 90, 205, 0.2);
      outline: none;
      background-color: white;
    }

    .input-group {
      position: relative;
      margin-bottom: 0.5rem;
    }

    .input-group i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray-dark);
      cursor: pointer;
      transition: var(--transition);
    }

    .input-group i:hover {
      color: var(--primary);
    }

    .form-section {
      margin-bottom: 1.5rem;
      animation: fadeInUp 0.6s ease forwards;
      opacity: 0;
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-section:nth-child(1) { animation-delay: 0.1s; }
    .form-section:nth-child(2) { animation-delay: 0.2s; }

    button {
      width: 100%;
      padding: 1rem;
      background: linear-gradient(135deg, var(--primary), var(--primary-light));
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      margin-top: 1rem;
      transition: var(--transition);
      font-family: 'Poppins', sans-serif;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      box-shadow: 0 4px 6px rgba(106, 90, 205, 0.2);
      position: relative;
      overflow: hidden;
    }

    button:hover {
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
      box-shadow: 0 6px 12px rgba(106, 90, 205, 0.3);
      transform: translateY(-2px);
    }

    button:active {
      transform: translateY(0);
    }

    button::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0));
      opacity: 0;
      transition: var(--transition);
    }

    button:hover::after {
      opacity: 1;
    }

    #message {
      margin-top: 1.5rem;
      padding: 1rem;
      text-align: center;
      color: white;
      font-weight: 500;
      border-radius: 10px;
      opacity: 0;
      transition: var(--transition);
      animation: fadeInMessage 0.5s ease forwards;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .error-message {
      background-color: var(--error);
      opacity: 1 !important;
    }

    @keyframes fadeInMessage {
      to { opacity: 1; }
    }

    .register-link {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.9rem;
      color: var(--gray-dark);
      animation: fadeIn 0.8s ease forwards;
    }

    .register-link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      position: relative;
    }

    .register-link a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: var(--transition);
    }

    .register-link a:hover::after {
      width: 100%;
    }

    .forgot-password {
      text-align: right;
      margin-top: 0.5rem;
    }

    .forgot-password a {
      color: var(--gray-dark);
      font-size: 0.85rem;
      text-decoration: none;
      transition: var(--transition);
    }

    .forgot-password a:hover {
      color: var(--primary);
    }

    /* Responsive design */
    @media (max-width: 600px) {
      .container {
        padding: 1.8rem;
        border-radius: 15px;
      }
      
      h2 {
        font-size: 1.5rem;
      }
    }

    @media (max-width: 400px) {
      body {
        padding: 10px;
      }
      
      .container {
        padding: 1.5rem;
      }
    }

    /* Floating animation for container */
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }

    .container {
      animation: float 6s ease-in-out infinite;
    }

    /* Pulse animation for button */
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.02); }
      100% { transform: scale(1); }
    }

    button {
      animation: pulse 2s ease infinite;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Welcome Back</h2>
    
    <div class="social-login">
      <div class="social-btn google">
        <i class="fab fa-google"></i>
      </div>
      <div class="social-btn facebook">
        <i class="fab fa-facebook-f"></i>
      </div>
      <div class="social-btn apple">
        <i class="fab fa-apple"></i>
      </div>
    </div>
    
    <div class="divider">or login with email</div>
    
    <?php if (!empty($login_error)): ?>
      <div id="message" class="error-message">
        <?php echo htmlspecialchars($login_error); ?>
      </div>
    <?php endif; ?>
    
    <form id="loginForm" method="POST" action="">
      <div class="form-section">
        <input type="email" placeholder="Email Address" name="email" required />
        
        <div class="input-group">
          <input type="password" placeholder="Password" name="password" id="password" required />
          <i class="fas fa-eye" id="togglePassword"></i>
        </div>
        
        <div class="forgot-password">
          <a href="forgot-password.php">Forgot password?</a>
        </div>
      </div>

      <button type="submit" name="login">Log In</button>
    </form>
    
    <div class="register-link">
      Don't have an account? <a href="register.php">Sign Up</a>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById("loginForm");
      const togglePassword = document.getElementById("togglePassword");
      const passwordInput = document.getElementById("password");

      // Password visibility toggle
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
      });

      // Add floating label effect
      const inputs = document.querySelectorAll('input');
      inputs.forEach(input => {
        input.addEventListener('focus', function() {
          this.parentNode.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
          if (this.value === '') {
            this.parentNode.classList.remove('focused');
          }
        });
      });

      // Form submission feedback
      form.addEventListener("submit", function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
        submitBtn.disabled = true;
      });
    });
  </script>
</body>
</html>