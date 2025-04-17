
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home - Virtual Fitting Room</title>


  <style>
    :root {
  --primary: #ff3e82;
  --secondary: #ff7eb3;
  --dark: #111;
  --light: #f9f9f9;
  --gray: #e0e0e0;
  --transition: all 0.3s ease;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  background: var(--light);
  color: #333;
  line-height: 1.6;
  overflow-x: hidden;
}

header {
  background: var(--dark);
  color: white;
  padding: 1.5rem 0;
  position: sticky;
  top: 0;
  z-index: 100;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

.logo {
  font-size: 1.8rem;
  font-weight: 700;
  color: white;
  text-decoration: none;
  display: flex;
  align-items: center;
}

.logo i {
  margin-right: 10px;
  color: var(--primary);
}

nav ul {
  list-style: none;
  display: flex;
  gap: 1.5rem;
}

nav ul li a {
  color: white;
  text-decoration: none;
  font-weight: 500;
  font-size: 1.1rem;
  transition: var(--transition);
  position: relative;
  padding: 0.5rem 0;
}

nav ul li a:hover {
  color: var(--primary);
}

nav ul li a::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 2px;
  background: var(--primary);
  transition: var(--transition);
}

nav ul li a:hover::after {
  width: 100%;
}

.mobile-menu-btn {
  display: none;
  background: none;
  border: none;
  color: white;
  font-size: 1.5rem;
  cursor: pointer;
}

.hero {
  padding: 5rem 2rem;
  text-align: center;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: white;
  position: relative;
  overflow: hidden;
}

.hero::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
  animation: pulse 15s infinite linear;
}

@keyframes pulse {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.hero-content {
  max-width: 800px;
  margin: 0 auto;
  position: relative;
  z-index: 1;
}

.hero h2 {
  font-size: 3.5rem;
  margin-bottom: 1.5rem;
  animation: fadeInUp 1s ease;
}

.hero p {
  font-size: 1.3rem;
  margin-bottom: 2rem;
  opacity: 0.9;
  animation: fadeInUp 1s ease 0.2s forwards;
  opacity: 0;
}

.btn {
  display: inline-block;
  background: white;
  color: var(--primary);
  padding: 0.8rem 2rem;
  text-decoration: none;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1.1rem;
  transition: var(--transition);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  animation: fadeInUp 1s ease 0.4s forwards;
  opacity: 0;
  position: relative;
  overflow: hidden;
}

.btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.btn:active {
  transform: translateY(1px);
}

.btn::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(rgba(255,255,255,0.3), rgba(255,255,255,0));
  opacity: 0;
  transition: var(--transition);
}

.btn:hover::after {
  opacity: 1;
}

.features {
  padding: 5rem 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.section-title {
  text-align: center;
  font-size: 2.5rem;
  margin-bottom: 3rem;
  color: var(--dark);
  position: relative;
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: linear-gradient(to right, var(--primary), var(--secondary));
  border-radius: 2px;
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

.feature-card {
  background: white;
  border-radius: 10px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  transition: var(--transition);
}

.feature-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.feature-icon {
  font-size: 3rem;
  color: var(--primary);
  margin-bottom: 1.5rem;
}

.feature-card h3 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.feature-card p {
  color: #666;
}

.testimonials {
  background: #f5f5f5;
  padding: 5rem 2rem;
  text-align: center;
}

.testimonial-slider {
  max-width: 800px;
  margin: 0 auto;
  position: relative;
}

.testimonial {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  margin: 0 1rem;
}

.testimonial-content {
  font-style: italic;
  margin-bottom: 1.5rem;
  color: #555;
}

.testimonial-author {
  font-weight: 600;
  color: var(--dark);
}

.newsletter {
  padding: 5rem 2rem;
  background: linear-gradient(135deg, var(--primary), var(--secondary));
  color: white;
  text-align: center;
}

.newsletter-form {
  max-width: 500px;
  margin: 2rem auto 0;
  display: flex;
}

.newsletter-input {
  flex: 1;
  padding: 1rem;
  border: none;
  border-radius: 50px 0 0 50px;
  font-size: 1rem;
  outline: none;
}

.newsletter-btn {
  padding: 0 2rem;
  background: var(--dark);
  color: white;
  border: none;
  border-radius: 0 50px 50px 0;
  font-weight: 600;
  cursor: pointer;
  transition: var(--transition);
}

.newsletter-btn:hover {
  background: #222;
}

footer {
  background: var(--dark);
  color: white;
  padding: 3rem 2rem 1.5rem;
}

.footer-container {
  max-width: 1200px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
}

.footer-logo {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 1rem;
  display: inline-block;
}

.footer-about p {
  opacity: 0.8;
  margin-bottom: 1.5rem;
}

.social-links {
  display: flex;
  gap: 1rem;
}

.social-links a {
  color: white;
  background: rgba(255,255,255,0.1);
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: var(--transition);
}

.social-links a:hover {
  background: var(--primary);
  transform: translateY(-3px);
}

.footer-links h3 {
  font-size: 1.3rem;
  margin-bottom: 1.5rem;
  position: relative;
  padding-bottom: 10px;
}

.footer-links h3::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 40px;
  height: 3px;
  background: var(--primary);
}

.footer-links ul {
  list-style: none;
}

.footer-links li {
  margin-bottom: 0.8rem;
}

.footer-links a {
  color: rgba(255,255,255,0.8);
  text-decoration: none;
  transition: var(--transition);
}

.footer-links a:hover {
  color: var(--primary);
  padding-left: 5px;
}

.copyright {
  text-align: center;
  margin-top: 3rem;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255,255,255,0.1);
  opacity: 0.7;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@media (max-width: 768px) {
  .header-container {
    padding: 0 1rem;
  }
  
  nav {
    position: fixed;
    top: 80px;
    left: -100%;
    width: 80%;
    height: calc(100vh - 80px);
    background: var(--dark);
    flex-direction: column;
    padding: 2rem;
    transition: var(--transition);
    z-index: 99;
  }
  
  nav.active {
    left: 0;
  }
  
  nav ul {
    flex-direction: column;
    gap: 1rem;
  }
  
  .mobile-menu-btn {
    display: block;
  }
  
  .hero h2 {
    font-size: 2.5rem;
  }
  
  .hero p {
    font-size: 1.1rem;
  }
  
  .newsletter-form {
    flex-direction: column;
  }
  
  .newsletter-input {
    border-radius: 50px;
    margin-bottom: 1rem;
  }
  
  .newsletter-btn {
    border-radius: 50px;
    padding: 1rem;
  }
}
</style>
  <meta name="description" content="Experience the future of fashion with our virtual fitting room. Try clothes before you buy them online.">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <script>
    const user = JSON.parse(localStorage.getItem("currentUser"));
    if (!user) {
      window.location.href = "login.php";
    }
  </script>

  <style>
    /* --- All the existing CSS styles here --- */
    /* Keep your long CSS code here exactly as in your original code */
  </style>
</head>
<body>
 Header with user greeting and logout 
  <header>
    <div class="header-container">
      <a href="index.php" class="logo">
        <i class="fas fa-tshirt"></i> Virtual Fitting Room
      </a>
      <nav id="mainNav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="fitting-room.php">Fitting Room</a></li>
          <li><a href="catalog.php">Catalog</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </nav>
      <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <div style="text-align: center; background: var(--dark); color: white; padding: 10px 0;">
      Hello, <span id="username" style="font-weight: bold;"></span> 👋
      <button onclick="logout()" style="margin-left: 20px; padding: 5px 15px; border-radius: 20px; border: none; background: var(--primary); color: white; cursor: pointer;">Logout</button>
    </div>
  </header>


  <section class="hero">
    <div class="hero-content">
      <h2>Try Before You Buy</h2>
      <p>Experience the future of fashion with our advanced virtual fitting room technology. See how clothes look on you without leaving your home.</p>
      <a href="fitting-room.html" class="btn">Start Fitting Now <i class="fas fa-arrow-right"></i></a>
    </div>
  </section>

  
  <section class="features">
    <h2 class="section-title">Why Choose Us</h2>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-user-check"></i></div>
        <h3>Accurate Fit</h3>
        <p>Our advanced algorithms ensure the clothes fit your body type perfectly for realistic results.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-undo"></i></div>
        <h3>Easy Returns</h3>
        <p>Reduce returns by 80% by trying clothes virtually before purchasing.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fas fa-robot"></i></div>
        <h3>AI Powered</h3>
        <p>State-of-the-art AI technology that learns your preferences over time.</p>
      </div>
    </div>
  </section>

 
  <section class="testimonials">
    <h2 class="section-title">What Our Users Say</h2>
    <div class="testimonial-slider">
      <div class="testimonial">
        <p class="testimonial-content">"This virtual fitting room saved me so much time and hassle. I can finally shop online with confidence knowing how clothes will actually look on me!"</p>
        <p class="testimonial-author">- MARUTI AZAMGARH</p>
      </div>
    </div>
  </section>

 
  <section class="newsletter">
    <h2>Stay Updated</h2>
    <p>Subscribe to our newsletter for the latest features and fashion tips.</p>
    <form class="newsletter-form">
      <input type="email" placeholder="Your email address" class="newsletter-input" required>
      <button type="submit" class="newsletter-btn">Subscribe</button>
    </form>
  </section>

  
  <footer>
    <div class="footer-container">
      <div class="footer-about">
        <div class="footer-logo">
          <i class="fas fa-tshirt"></i> Virtual Fitting Room
        </div>
        <p>Try on clothes virtually and shop smarter with our AI-powered technology.</p>
        <div class="social-links">
          <a href="https://www.linkedin.com/in/prince-yadav-5081892a8/"><i class="fab fa--f"></i></a>
          <a href="https://x.com/PrinceYada62215?t=A53z77ZNJbMDcMJyy4LOoA&s=09"><i class="fab fa-twitter"></i></a>
          <a href="https://www.instagram.com/prince.yadav______?igsh=MTczbmZycnFkYnY3YQ=="><i class="fab fa-instagram"></i></a>
        </div>
      </div>
      <div class="footer-links">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="catalog.html">Catalog</a></li>
          <li><a href="fitting-room.html">Fitting Room</a></li>
          <li><a href="about.html">About</a></li>
        </ul>
      </div>
      <div class="footer-links">
        <h3>Support</h3>
        <ul>
          <li><a href="https://www.linkedin.com/in/prince-yadav-5081892a8/">Help Center</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
    </div>
    <div class="copyright">
      &copy; 2025 Virtual Fitting Room. All rights reserved.
    </div>
  </footer>

  
  <script>
    const currentUser = JSON.parse(localStorage.getItem("currentUser"));
    document.getElementById("username").textContent = currentUser?.username || "Guest";

    function logout() {
      localStorage.removeItem("currentUser");
      window.location.href = "login.php";
    }

    // Mobile menu toggle (optional enhancement)
    const mobileMenuBtn = document.getElementById("mobileMenuBtn");
    const mainNav = document.getElementById("mainNav");
    mobileMenuBtn.addEventListener("click", () => {
      mainNav.classList.toggle("active");
    });
  </script>
</body>
</html> 

