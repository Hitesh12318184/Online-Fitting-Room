<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Virtual Fitting Room | Try Clothes Digitally</title>
  <meta name="description" content="Experience realistic virtual try-ons with our advanced fitting room technology">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Add these styles to the existing CSS */
    .clothing-overlay {
        position: absolute;
        object-fit: cover;
        pointer-events: none;
        transition: all 0.3s ease;
        transform-origin: center;
        opacity: 0;
    }

    .clothing-overlay.active {
        opacity: 1;
    }

    .clothing-overlay[data-category="tops"] {
        width: 80% !important;
        left: 10% !important;
        top: 15% !important;
        height: 40% !important;
        z-index: 1;
    }

    .clothing-overlay[data-category="bottoms"] {
        width: 75% !important;
        left: 12.5% !important;
        top: 55% !important;
        height: 40% !important;
        z-index: 1;
    }

    .clothing-overlay[data-category="dresses"] {
        width: 75% !important;
        left: 12.5% !important;
        top: 10% !important;
        height: 85% !important;
        z-index: 0;
    }

    .clothing-overlay[data-category="outerwear"] {
        width: 85% !important;
        left: 7.5% !important;
        top: 10% !important;
        height: 70% !important;
        z-index: 2;
    }

    @media (max-width: 768px) {
        .clothing-overlay {
            width: 90% !important;
            left: 5% !important;
        }
        
        .clothing-overlay[data-category="tops"] {
            top: 20% !important;
        }
        
        .clothing-overlay[data-category="bottoms"] {
            top: 60% !important;
        }
    }


    :root {
      --primary: #ff3e82;
      --secondary: #ff7eb3;
      --dark: #111;
      --light: #f9f9f9;
      --gray: #e0e0e0;
      --transition: all 0.3s ease;
      --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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

    /* Main Fitting Room Section */
    .fitting-room-container {
      padding: 5rem 2rem;
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }

    .section-title {
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

    /* Upload Area */
    .upload-area {
      margin: 3rem auto;
      max-width: 600px;
    }

    .upload-box {
      border: 2px dashed var(--gray);
      border-radius: 15px;
      padding: 3rem 2rem;
      transition: var(--transition);
      cursor: pointer;
      position: relative;
      overflow: hidden;
      background: white;
      box-shadow: var(--shadow);
    }

    .upload-box:hover {
      border-color: var(--primary);
      transform: translateY(-5px);
    }

    .upload-box.active {
      border-color: var(--primary);
      background: rgba(255, 62, 130, 0.05);
    }

    .upload-icon {
      font-size: 3rem;
      color: var(--primary);
      margin-bottom: 1rem;
    }

    .upload-text {
      font-size: 1.2rem;
      margin-bottom: 1rem;
    }

    .upload-btn {
      display: inline-block;
      background: var(--primary);
      color: white;
      padding: 0.8rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1rem;
      transition: var(--transition);
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(255, 62, 130, 0.3);
    }

    .upload-btn:hover {
      background: #ff2a72;
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(255, 62, 130, 0.4);
    }

    #fileInput {
      display: none;
    }

    /* Preview Area */
    .preview-container {
      display: flex;
      justify-content: center;
      gap: 3rem;
      margin: 4rem auto;
      flex-wrap: wrap;
    }

    .preview-box {
      position: relative;
      width: 300px;
      height: 450px;
      background: #f1f1f1;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: var(--shadow);
    }

    .preview-box::before {
      content: 'Your Preview';
      position: absolute;
      top: 15px;
      left: 15px;
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      z-index: 2;
    }

    #userImage {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: none;
    }

    .default-user {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #999;
      font-size: 1.2rem;
    }

    .clothing-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: contain;
      pointer-events: none;
      opacity: 0;
      transition: var(--transition);
    }

    .clothing-overlay.active {
      opacity: 1;
    }

    /* Controls */
    .controls {
      margin: 2rem auto;
      max-width: 600px;
      background: white;
      padding: 1.5rem;
      border-radius: 15px;
      box-shadow: var(--shadow);
    }

    .control-group {
      margin-bottom: 1.5rem;
    }

    .control-group h3 {
      margin-bottom: 1rem;
      color: var(--dark);
    }

    .adjustment-controls {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .adjust-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: white;
      border: 1px solid var(--gray);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition);
    }

    .adjust-btn:hover {
      background: var(--primary);
      color: white;
      border-color: var(--primary);
    }

    .slider-container {
      width: 100%;
      margin-top: 1rem;
    }

    .slider {
      width: 100%;
      height: 8px;
      -webkit-appearance: none;
      appearance: none;
      background: var(--gray);
      outline: none;
      border-radius: 10px;
    }

    .slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: var(--primary);
      cursor: pointer;
      transition: var(--transition);
    }

    .slider::-webkit-slider-thumb:hover {
      transform: scale(1.2);
    }

    /* Clothing Options */
    .clothing-options {
      margin: 3rem auto;
    }

    .category-tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }

    .category-tab {
      padding: 0.8rem 1.5rem;
      background: white;
      border: none;
      border-radius: 50px;
      margin: 0 0.5rem 1rem;
      cursor: pointer;
      font-weight: 500;
      transition: var(--transition);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .category-tab.active {
      background: var(--primary);
      color: white;
      box-shadow: 0 4px 15px rgba(255, 62, 130, 0.3);
    }

    .category-tab:hover:not(.active) {
      background: #f0f0f0;
    }

    .clothing-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 1.5rem;
      max-width: 900px;
      margin: 0 auto;
    }

    .clothing-item {
      background: white;
      border-radius: 10px;
      overflow: hidden;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: var(--shadow);
      position: relative;
    }

    .clothing-item:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .clothing-item img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .clothing-info {
      padding: 1rem;
      text-align: left;
    }

    .clothing-info h4 {
      font-size: 0.9rem;
      margin-bottom: 0.3rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .clothing-info p {
      font-size: 0.8rem;
      color: #666;
    }

    .try-on-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background: var(--primary);
      color: white;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
      opacity: 0;
      transition: var(--transition);
    }

    .clothing-item:hover .try-on-badge {
      opacity: 1;
    }

    /* AR Mode */
    .ar-mode {
      margin: 3rem auto;
      text-align: center;
    }

    .ar-btn {
      display: inline-flex;
      align-items: center;
      background: linear-gradient(135deg, #6e45e2, #88d3ce);
      color: white;
      padding: 1rem 2rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1.1rem;
      transition: var(--transition);
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(110, 69, 226, 0.3);
    }

    .ar-btn i {
      margin-right: 10px;
    }

    .ar-btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(110, 69, 226, 0.4);
    }

    /* Footer */
    footer {
      background: var(--dark);
      color: white;
      text-align: center;
      padding: 3rem 2rem 1.5rem;
      margin-top: 3rem;
    }

    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      text-align: left;
    }

    .copyright {
      text-align: center;
      margin-top: 3rem;
      padding-top: 1.5rem;
      border-top: 1px solid rgba(255,255,255,0.1);
      opacity: 0.7;
    }

    /* Responsive */
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
      
      .section-title {
        font-size: 2rem;
      }
      
      .preview-container {
        flex-direction: column;
        align-items: center;
      }
      
      .preview-box {
        width: 100%;
        max-width: 300px;
        height: 400px;
      }
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from { 
        opacity: 0;
        transform: translateY(20px);
      }
      to { 
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fadeIn 0.6s ease forwards;
    }

    .slide-up {
      animation: slideUp 0.8s ease forwards;
    }
  </style>
</head>
<body>
  <header>
    <div class="header-container">
      <a href="index.php" class="logo">
        <i class="fas fa-tshirt"></i> Virtual Fitting Room
      </a>
      <nav id="mainNav">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="fitting-room.html" class="active">Fitting Room</a></li>
          <li><a href="catalog.html">Catalog</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="auth.html">Register</a></li>
        </ul>
      </nav>
      <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </header>

  <section class="fitting-room-container">
    <h2 class="section-title slide-up">Virtual Fitting Room</h2>
    <p class="slide-up" style="text-align: center; max-width: 700px; margin: 0 auto 2rem; color: #666;">Upload your photo and try on clothes virtually to see how they look before you buy</p>

    <div class="upload-area slide-up">
      <div class="upload-box" id="uploadBox">
        <div class="upload-icon">
          <i class="fas fa-cloud-upload-alt"></i>
        </div>
        <div class="upload-text">Drag & drop your photo here or click to browse</div>
        <button class="upload-btn">Select Photo</button>
        <input type="file" id="fileInput" accept="image/*" />
      </div>
    </div>

    <div class="preview-container">
      <div class="preview-box slide-up">
        <div class="default-user">
          <i class="fas fa-user-circle" style="font-size: 5rem; opacity: 0.3;"></i>
        </div>
        <img id="userImage" src="paint 2.avif" alt="Your photo" />
        <img id="overlayTop" class="clothing-overlay" src="paint 2.avif" alt="Clothing overlay" />
        <img id="overlayBottom" class="clothing-overlay" src="paint 2.avif" alt="Clothing overlay" />
        <img id="overlayDress" class="clothing-overlay" src="paint 2.avif" alt="Clothing overlay" />
        <img id="overlayOuter" class="clothing-overlay" src="paint 2.avif" alt="Clothing overlay" />
      </div>
    </div>

    <div class="controls fade-in">
      <div class="control-group">
        <h3>Adjust Clothing</h3>
        <div class="adjustment-controls">
          <button class="adjust-btn" onclick="adjustClothing('size', -0.1)"><i class="fas fa-search-minus"></i></button>
          <button class="adjust-btn" onclick="adjustClothing('size', 0.1)"><i class="fas fa-search-plus"></i></button>
          <button class="adjust-btn" onclick="adjustClothing('positionY', -10)"><i class="fas fa-arrow-up"></i></button>
          <button class="adjust-btn" onclick="adjustClothing('positionY', 10)"><i class="fas fa-arrow-down"></i></button>
          <button class="adjust-btn" onclick="adjustClothing('positionX', -10)"><i class="fas fa-arrow-left"></i></button>
          <button class="adjust-btn" onclick="adjustClothing('positionX', 10)"><i class="fas fa-arrow-right"></i></button>
          <button class="adjust-btn" onclick="adjustClothing('opacity', -0.1)"><i class="fas fa-eye-slash"></i></button>
          <button class="adjust-btn" onclick="adjustClothing('opacity', 0.1)"><i class="fas fa-eye"></i></button>
        </div>
      </div>
    </div>

    <div class="clothing-options fade-in">
      <div class="category-tabs">
        <button class="category-tab active" data-category="tops">Tops</button>
        <button class="category-tab" data-category="bottoms">Bottoms</button>
        <button class="category-tab" data-category="dresses">Dresses</button>
        <button class="category-tab" data-category="outerwear">Outerwear</button>
      </div>

      <div class="clothing-grid" id="clothingGrid">
        <!-- Tops will be loaded here by JavaScript -->
      </div>
    </div>

    <div class="ar-mode fade-in">
      <button class="ar-btn" id="arBtn">
        <i class="fas fa-mobile-alt"></i> Try AR Mode
      </button>
    </div>
  </section>

  <footer>
    <div class="footer-container">
      <div>
        <div class="footer-logo">
          <i class="fas fa-tshirt"></i> Virtual Fitting
        </div>
        <p>Revolutionizing online shopping with our cutting-edge virtual fitting technology.</p>
      </div>
      <div>
        <h3>Quick Links</h3>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="fitting-room.html">Fitting Room</a></li>
          <li><a href="catalog.html">Catalog</a></li>
          <li><a href="about.html">About Us</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
      <div>
        <h3>Support</h3>
        <ul>
          <li><a href="#">FAQs</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Shipping Info</a></li>
          <li><a href="#">Returns</a></li>
        </ul>
      </div>
      <div>
        <h3>Contact Us</h3>
        <ul>
          <li><i class="fas fa-map-marker-alt"></i> 123 Fashion St, Style City</li>
          <li><i class="fas fa-phone"></i> (123) 456-7890</li>
          <li><i class="fas fa-envelope"></i> info@virtualfitting.com</li>
        </ul>
      </div>
    </div>
    <div class="copyright">
      <p>&copy; 2025 Virtual Fitting Room. All rights reserved.</p>
    </div>
  </footer>

  <script>







    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainNav = document.getElementById('mainNav');
    
    mobileMenuBtn.addEventListener('click', () => {
      mainNav.classList.toggle('active');
      mobileMenuBtn.innerHTML = mainNav.classList.contains('active') ? 
        '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });
    
    // File upload functionality
    const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('fileInput');
    const userImage = document.getElementById('userImage');
    const defaultUser = document.querySelector('.default-user');
    
    uploadBox.addEventListener('click', () => {
      fileInput.click();
    });
    
    uploadBox.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploadBox.classList.add('active');
    });
    
    uploadBox.addEventListener('dragleave', () => {
      uploadBox.classList.remove('active');
    });
    
    uploadBox.addEventListener('drop', (e) => {
      e.preventDefault();
      uploadBox.classList.remove('active');
      if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        handleFileUpload(e.dataTransfer.files[0]);
      }
    });
    
    fileInput.addEventListener('change', () => {
      if (fileInput.files.length) {
        handleFileUpload(fileInput.files[0]);
      }
    });
    
    function handleFileUpload(file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        userImage.src = e.target.result;
        userImage.style.display = 'block';
        defaultUser.style.display = 'none';
        
        // Show controls after upload
        document.querySelector('.controls').style.display = 'block';
        document.querySelector('.clothing-options').style.display = 'block';
        document.querySelector('.ar-mode').style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
    
    // Clothing items data
    const clothingItems = {
      tops: [
        { id: 1, name: "Basic White Tee", price: "$24.99", image: "paint 2.avif" },
        { id: 2, name: "Striped Blouse", price: "$39.99", image: "stripped blowse.webp" },
        { id: 3, name: "Black Crop Top", price: "$29.99", image: "black crop trap.jpg" },
        { id: 4, name: "Floral Shirt", price: "$34.99", image: "formla shirts.jpg" },
        { id: 5, name: "blackskirt", price: "$49.99", image: "blackskirt.jpg" },
        { id: 6, name: "formal Shirt", price: "$44.99", image: "formla shirts.jpg" }
      ],
      bottoms: [
      { id: 7, name: "Blue Jeans", price: "$59.99", image: "bluejeans.jpg" },

        { id: 8, name: "Black Skirt", price: "$39.99", image: "blackskirt.jpg" },
        { id: 9, name: "White Linen Pants", price: "$49.99", image: "linnen.jpg" },
        { id: 10, name: "Denim Shorts", price: "$34.99", image: "denim shorts.jpg" }
      ],
      dresses: [
        { id: 11, name: "Little Black Dress", price: "$79.99", image: "liiitle black.webp" },
        { id: 12, name: "Summer Floral Dress", price: "$69.99", image: "sum er formal.jpg" },
        { id: 13, name: "Formal Evening Gown", price: "$129.99", image: "formral evening.jpg" }
      ],
      outerwear: [
        { id: 14, name: "Denim Jacket", price: "$89.99", image: "denim shorts.jpg" },
        { id: 15, name: "Leather Jacket", price: "$149.99", image: "leather jacaket.jpg" },
        { id: 16, name: "Trench Coat", price: "$119.99", image: "trench coat.jpg" },
        { id: 17, name: "Wool Blazer", price: "$99.99", image: "wool blazzer.jpg" }
      ]
    };
    
    // Category tabs
    const categoryTabs = document.querySelectorAll('.category-tab');
    const clothingGrid = document.getElementById('clothingGrid');
    
    categoryTabs.forEach(tab => {
      tab.addEventListener('click', () => {
        categoryTabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        loadClothingItems(tab.dataset.category);
      });
    });
    
    // Load initial category
    loadClothingItems('tops');
    
    function loadClothingItems(category) {
      clothingGrid.innerHTML = '';
      clothingItems[category].forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.className = 'clothing-item';
        itemElement.innerHTML = `
          <img src="${item.image}" alt="${item.name}" />
          <div class="clothing-info">
            <h4>${item.name}</h4>
            <p>${item.price}</p>
          </div>
          <div class="try-on-badge">
            <i class="fas fa-magic"></i>
          </div>
        `;
        itemElement.addEventListener('click', () => tryOnItem(item, category));
        clothingGrid.appendChild(itemElement);
      });
    }
    
    // Try on item
    const overlayElements = {
      tops: document.getElementById('overlayTop'),
      bottoms: document.getElementById('overlayBottom'),
      dresses: document.getElementById('overlayDress'),
      outerwear: document.getElementById('overlayOuter')
    };
    
    function tryOnItem(item, category) {
      // Reset all overlays first
      Object.values(overlayElements).forEach(el => {
        el.classList.remove('active');
      });
      
      // Set the selected overlay
      const overlay = overlayElements[category];
      overlay.src = item.image;
      overlay.classList.add('active');
      
      // Set initial styles
      overlay.style.width = '70%';
      overlay.style.left = '15%';
      overlay.style.top = '15%';
      overlay.style.opacity = '1';
    }
    
    // Clothing adjustment
    function adjustClothing(property, value) {
      const activeOverlays = document.querySelectorAll('.clothing-overlay.active');
      
      activeOverlays.forEach(overlay => {
        switch(property) {
          case 'size':
            const currentWidth = parseFloat(overlay.style.width) || 70;
            const newWidth = Math.max(30, Math.min(150, currentWidth + (value * 100)));
            overlay.style.width = `${newWidth}%`;
            overlay.style.left = `${(100 - newWidth) / 2}%`;
            break;
          case 'positionY':
            const currentTop = parseFloat(overlay.style.top) || 15;
            overlay.style.top = `${currentTop + value}%`;
            break;
          case 'positionX':
            const currentLeft = parseFloat(overlay.style.left) || 15;
            overlay.style.left = `${currentLeft + value}%`;
            break;
          case 'opacity':
            const currentOpacity = parseFloat(overlay.style.opacity) || 1;
            overlay.style.opacity = Math.max(0.1, Math.min(1, currentOpacity + value));
            break;
        }
      });
    }
    
    // AR Mode button
    const arBtn = document.getElementById('arBtn');
    arBtn.addEventListener('click', () => {
      alert('AR mode would launch your device camera for augmented reality try-on. This feature requires app integration.');
    });
    
    // Initially hide controls until image is uploaded
    document.querySelector('.controls').style.display = 'none';
    document.querySelector('.clothing-options').style.display = 'none';
    document.querySelector('.ar-mode').style.display = 'none';


 
    // Modified tryOnItem function with auto-positioning
    function tryOnItem(item, category) {
        // Reset all overlays
        document.querySelectorAll('.clothing-overlay').forEach(overlay => {
            overlay.classList.remove('active');
            overlay.style.opacity = '1';
        });

        // Activate selected overlay
        const overlay = document.querySelector(`.clothing-overlay[data-category="${category}"]`);
        overlay.src = item.image;
        overlay.classList.add('active');

        // Set automatic positioning based on category
        switch(category) {
            case 'tops':
                overlay.style.width = '80%';
                overlay.style.left = '10%';
                overlay.style.top = '15%';
                overlay.style.height = '40%';
                overlay.style.zIndex = '1';
                break;
            case 'bottoms':
                overlay.style.width = '75%';
                overlay.style.left = '12.5%';
                overlay.style.top = '55%';
                overlay.style.height = '40%';
                overlay.style.zIndex = '1';
                break;
            case 'dresses':
                overlay.style.width = '75%';
                overlay.style.left = '12.5%';
                overlay.style.top = '10%';
                overlay.style.height = '85%';
                overlay.style.zIndex = '0';
                break;
            case 'outerwear':
                overlay.style.width = '85%';
                overlay.style.left = '7.5%';
                overlay.style.top = '10%';
                overlay.style.height = '70%';
                overlay.style.zIndex = '2';
                break;
        }
    }

    // Enhanced adjustClothing function with scaling
    function adjustClothing(property, value) {
        const activeOverlay = document.querySelector('.clothing-overlay.active');
        if (!activeOverlay) return;

        const currentStyle = window.getComputedStyle(activeOverlay);
        
        switch(property) {
            case 'size':
                const scale = parseFloat(activeOverlay.style.transform.replace('scale(', '')) || 1;
                activeOverlay.style.transform = `scale(${Math.max(0.5, Math.min(2, scale + value))})`;
                break;
                
            case 'positionY':
                const currentY = parseFloat(currentStyle.top);
                activeOverlay.style.top = `${currentY + value}%`;
                break;
                
            case 'positionX':
                const currentX = parseFloat(currentStyle.left);
                activeOverlay.style.left = `${currentX + value}%`;
                break;
                
            case 'opacity':
                const currentOpacity = parseFloat(currentStyle.opacity);
                activeOverlay.style.opacity = Math.max(0.1, Math.min(1, currentOpacity + value));
                break;
        }
    }

    // Update the loadClothingItems function to add category data attribute
    function loadClothingItems(category) {
        clothingGrid.innerHTML = '';
        clothingItems[category].forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.className = 'clothing-item';
            itemElement.dataset.category = category;
            itemElement.innerHTML = `
                <img src="${item.image}" alt="${item.name}" />
                <div class="clothing-info">
                    <h4>${item.name}</h4>
                    <p>${item.price}</p>
                </div>
                <div class="try-on-badge">
                    <i class="fas fa-magic"></i>
                </div>
            `;
            itemElement.addEventListener('click', () => tryOnItem(item, category));
            clothingGrid.appendChild(itemElement);
        });
    }






    
  </script>
</body>
</html>