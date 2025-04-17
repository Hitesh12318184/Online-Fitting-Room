<?php
include "connection.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

$register_error = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Collect and sanitize form inputs
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $height = trim($_POST['height']);
  $weight = trim($_POST['weight']);
  $chest = trim($_POST['chest']);
  $waist = trim($_POST['waist']);
  $hips = trim($_POST['hips']);
  $style = trim($_POST['style']);

  try {
    // Validate the inputs
    if (empty($name) || empty($email) || empty($password) || empty($height) || empty($weight) || empty($chest) || empty($waist) || empty($hips) || empty($style)) {
      throw new Exception("Please fill in all fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("Invalid email format.");
    }

    // Prepare the SQL statement to insert the user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, height, weight, chest, waist, hips, style) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
      throw new Exception("Database error: " . $conn->error);
    }

    // Bind the parameters and execute the statement
    $stmt->bind_param("sssssssss", $name, $email, $password, $height, $weight, $chest, $waist, $hips, $style);
    $stmt->execute();
    $stmt->close();

    // Store user data in session
    $_SESSION['user'] = [
      'name' => $name,
      'email' => $email,
      'height' => $height,
      'weight' => $weight,
      'chest' => $chest,
      'waist' => $waist,
      'hips' => $hips,
      'style' => $style
    ];

    // Success message
    $success_message = "Account created successfully! You can now log in.";
    header("Location: login.php?success=1");
    exit();

  } catch (Exception $e) {
    $register_error = $e->getMessage();
  }
}
?>
<!-- Your HTML form here (you can reuse your styled form) -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Virtual Fitting Room - Register</title>
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

    form input, form select {
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

    form input:focus, form select:focus {
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

    .password-strength {
      height: 6px;
      background: var(--gray);
      margin-bottom: 1rem;
      border-radius: 3px;
      overflow: hidden;
      transition: var(--transition);
    }

    .strength-meter {
      height: 100%;
      width: 0;
      transition: var(--transition);
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
    .form-section:nth-child(3) { animation-delay: 0.3s; }
    .form-section:nth-child(4) { animation-delay: 0.4s; }

    .form-section h4 {
      margin: 1rem 0 0.5rem;
      color: var(--dark);
      font-weight: 600;
      font-size: 1rem;
    }

    .form-section p {
      font-size: 0.85rem;
      color: var(--gray-dark);
      margin-bottom: 0.8rem;
    }

    .measurement-guide {
      display: flex;
      align-items: center;
      font-size: 0.85rem;
      color: var(--primary);
      margin-bottom: 0.8rem;
      cursor: pointer;
      transition: var(--transition);
    }

    .measurement-guide:hover {
      color: var(--primary-dark);
      transform: translateX(3px);
    }

    .measurement-guide i {
      margin-right: 0.5rem;
      font-size: 1rem;
    }

    .input-row {
      display: flex;
      gap: 1rem;
    }

    .input-row input {
      flex: 1;
    }

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

    @keyframes fadeInMessage {
      to { opacity: 1; }
    }

    .login-link {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.9rem;
      color: var(--gray-dark);
      animation: fadeIn 0.8s ease forwards;
    }

    .login-link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      position: relative;
    }

    .login-link a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: var(--transition);
    }

    .login-link a:hover::after {
      width: 100%;
    }

    /* Tooltip for measurement guide */
    .tooltip {
      position: relative;
      display: inline-block;
    }

    .tooltip .tooltiptext {
      visibility: hidden;
      width: 200px;
      background-color: var(--dark);
      color: white;
      text-align: center;
      border-radius: 6px;
      padding: 10px;
      position: absolute;
      z-index: 1;
      bottom: 125%;
      left: 50%;
      transform: translateX(-50%);
      opacity: 0;
      transition: var(--transition);
      font-size: 0.8rem;
      font-weight: normal;
    }

    .tooltip:hover .tooltiptext {
      visibility: visible;
      opacity: 1;
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
      
      .input-row {
        flex-direction: column;
        gap: 0;
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

    /* Custom checkbox styling */
    input[type="checkbox"] {
      -webkit-appearance: none;
      appearance: none;
      width: 18px;
      height: 18px;
      border: 2px solid var(--gray);
      border-radius: 4px;
      outline: none;
      cursor: pointer;
      position: relative;
      transition: var(--transition);
    }

    input[type="checkbox"]:checked {
      background-color: var(--primary);
      border-color: var(--primary);
    }

    input[type="checkbox"]:checked::after {
      content: '\f00c';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 0.7rem;
    }

    /* Custom select arrow */
    select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236a5acd' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 12px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Create Your Fitting Room Account</h2>
    
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
    
    <div class="divider">or register with email</div>
    
    <form id="registerForm" method="POST" action="">
      <div class="form-section">
        <input type="text" placeholder="Full Name" name="name" required />
        
        <input type="email" placeholder="Email Address" name="email" required />
        
        <div class="input-group">
          <input type="password" placeholder="Password" name="password" id="password" required />
          <i class="fas fa-eye" id="togglePassword"></i>
        </div>
        <div class="password-strength">
          <div class="strength-meter" id="strengthMeter"></div>
        </div>
      </div>
      
      <div class="form-section">
        <h4>Body Measurements (cm)</h4>
        <p>For accurate virtual fitting results</p>
        <div class="measurement-guide tooltip">
          <i class="fas fa-ruler-combined"></i>
          <span>How to measure properly</span>
          <span class="tooltiptext">Measure around the fullest part of your bust, natural waistline, and widest part of your hips.</span>
        </div>
        
        <div class="input-row">
          <input type="number" placeholder="Height" name="height" min="100" max="250" required />
          <input type="number" placeholder="Weight (kg)" name="weight" min="30" max="200" required />
        </div>
        
        <div class="input-row">
          <input type="number" placeholder="Bust/Chest" name="chest" min="50" max="150" required />
          <input type="number" placeholder="Waist" name="waist" min="40" max="150" required />
        </div>
        
        <input type="number" placeholder="Hips" name="hips" min="50" max="150" required />
      </div>
      
      <div class="form-section">
        <h4>Style Preferences</h4>
        <select name="style" required>
          <option value="" disabled selected>Select your preferred style</option>
          <option value="casual">Casual</option>
          <option value="formal">Formal</option>
          <option value="streetwear">Streetwear</option>
          <option value="athleisure">Athleisure</option>
          <option value="bohemian">Bohemian</option>
        </select>
      </div>
      
      <div class="form-section">
        <label style="display: flex; align-items: center; font-size: 13px; color: #555;">
          <input type="checkbox" name="terms" required style="margin-right: 8px;">
          I agree to the <a href="#" style="color: var(--primary);">Terms of Service</a> and <a href="#" style="color: var(--primary);">Privacy Policy</a>
        </label>
        
        <label style="display: flex; align-items: center; font-size: 13px; color: #555; margin-top: 10px;">
          <input type="checkbox" name="newsletter" checked style="margin-right: 8px;">
          Receive style tips and special offers
        </label>
      </div>

      <button type="submit">Create Account</button>
    </form>
    
    <div id="message"></div>
    
    <div class="login-link">
      Already have an account? <a href="login.php">Log In</a>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById("registerForm");
      const messageBox = document.getElementById("message");
      const togglePassword = document.getElementById("togglePassword");
      const passwordInput = document.getElementById("password");
      const strengthMeter = document.getElementById("strengthMeter");

      // Password visibility toggle
      togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
      });

      // Password strength meter
      passwordInput.addEventListener('input', function() {
        const strength = checkPasswordStrength(this.value);
        updateStrengthMeter(strength);
      });

      function checkPasswordStrength(password) {
        let strength = 0;
        
        // Length check
        if (password.length >= 8) strength += 1;
        if (password.length >= 12) strength += 1;
        
        // Character variety
        if (/[A-Z]/.test(password)) strength += 1;
        if (/[0-9]/.test(password)) strength += 1;
        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        
        return Math.min(strength, 5); // Max strength of 5
      }

      function updateStrengthMeter(strength) {
        const colors = ['#ef4444', '#f97316', '#f59e0b', '#84cc16', '#10b981'];
        const width = (strength / 5) * 100;
        
        strengthMeter.style.width = `${width}%`;
        strengthMeter.style.backgroundColor = colors[strength - 1] || colors[0];
        strengthMeter.style.boxShadow = `0 0 8px ${colors[strength - 1] || colors[0]}`;
      }

      // Form submission
      form.addEventListener("submit", function(e) {
        // Validate terms checkbox
        if (!form.terms.checked) {
          e.preventDefault();
          showMessage("Please accept the Terms of Service", false);
          return;
        }
        
        // Password strength check (optional)
        const strength = checkPasswordStrength(passwordInput.value);
        if (strength < 3) {
          if (!confirm("Your password is weak. Are you sure you want to continue?")) {
            e.preventDefault();
            return;
          }
        }
        
        // Show loading message
        showMessage("Processing your registration...", true);
      });

      function showMessage(text, isSuccess) {
        messageBox.innerText = text;
        messageBox.style.backgroundColor = isSuccess ? 'var(--success)' : 'var(--error)';
        messageBox.style.opacity = 1;
        
        setTimeout(() => {
          messageBox.style.opacity = 0;
        }, 3000);
      }

      // Add floating label effect
      const inputs = document.querySelectorAll('input, select');
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

      // Add character counter for password
      passwordInput.addEventListener('input', function() {
        const counter = document.getElementById('password-counter') || document.createElement('span');
        counter.id = 'password-counter';
        counter.style.fontSize = '0.8rem';
        counter.style.color = this.value.length < 8 ? 'var(--error)' : 'var(--success)';
        counter.textContent = `${this.value.length}/12`;
        
        if (!document.getElementById('password-counter')) {
          this.parentNode.appendChild(counter);
        }
      });
    });
  </script>
</body>
</html>