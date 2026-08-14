<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar with Side Drawer</title>
    <!-- FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }

        /* Navbar CSS */
        .site-header {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-brand {
            font-size: 1.4rem;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
        }

        /* Desktop Navigation */
        .nav-links-desktop {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            list-style: none;
        }
        .nav-links-desktop a {
            text-decoration: none;
            color: #334155;
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links-desktop a:hover {
            color: #2563eb;
        }

        /* Hamburger Button */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #334155;
            cursor: pointer;
            padding: 5px;
        }

        /* Overlay (ለጀርባ ብዥታ/ጥቁረት ብቻ፣ ክሊክ አያስተናግድም) */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
            z-index: 1040;
            pointer-events: none; /* ከውጭ ቢነካም እንዳይዘጋ ያደርጋል */
        }
        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Side Drawer Navigation Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100%;
            background-color: #ffffff;
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            box-shadow: 4px 0 15px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .mobile-menu.active {
            transform: translateX(0);
        }

        /* Drawer Header (Logo + Close X Button) */
        .mobile-menu-header {
            padding: 1rem 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
        }
        .mobile-menu-header .brand {
            font-weight: bold;
            font-size: 1.2rem;
            color: #2563eb;
        }
        .close-menu-btn {
            background: none;
            border: none;
            font-size: 1.4rem;
            color: #64748b;
            cursor: pointer;
        }

        /* Drawer Body Links */
        .mobile-menu-body {
            padding: 1rem 0;
            flex: 1;
        }
        .mobile-nav-list {
            list-style: none;
        }
        .mobile-nav-item a, 
        .mobile-dropdown-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            color: #334155;
            font-weight: 500;
            border: none;
            background: none;
            font-size: 1rem;
            cursor: pointer;
            text-align: left;
        }
        .mobile-nav-item a:hover, 
        .mobile-dropdown-btn:hover {
            background-color: #f1f5f9;
            color: #2563eb;
        }

        /* Submenu (Dropdown) inside Drawer */
        .mobile-submenu {
            display: none;
            background-color: #f8fafc;
            padding-left: 1rem;
        }
        .mobile-submenu.open {
            display: block;
        }
        .mobile-submenu a {
            font-size: 0.95rem;
            color: #475569;
        }

        /* Action Buttons at Bottom of Drawer */
        .mobile-menu-footer {
            padding: 1.2rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }
        .btn {
            padding: 0.6rem 1rem;
            text-align: center;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #2563eb;
            color: white;
        }
        .btn-outline {
            border: 1px solid #cbd5e1;
            color: #334155;
        }

        /* Media Queries for Responsive Display */
        @media (max-width: 768px) {
            .nav-links-desktop {
                display: none;
            }
            .mobile-menu-btn {
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <header class="site-header">
        <div class="nav-container">
            <a href="#" class="nav-brand">TesheAI</a>

            <!-- Desktop Links -->
            <ul class="nav-links-desktop">
                <li><a href="#">ዋና ገጽ</a></li>
                <li><a href="#">ትምህርቶች</a></li>
                <li><a href="#">ስለ እኛ</a></li>
                <li><a href="#">አግኙን</a></li>
            </ul>

            <!-- Mobile Hamburger Button (☰) -->
            <button class="mobile-menu-btn" id="hamburgerBtn" onclick="toggleMobileMenu()">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Background Overlay (ከጀርባ ያለው ጥቁረት) -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- Side Drawer Mobile Menu -->
    <aside class="mobile-menu" id="mobileMenu">
        <!-- Drawer Header -->
        <div class="mobile-menu-header">
            <span class="brand">TesheAI</span>
            <!-- Close Button (❌) -->
            <button class="close-menu-btn" onclick="closeMobileMenu()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Drawer Body -->
        <div class="mobile-menu-body">
            <ul class="mobile-nav-list">
                <li class="mobile-nav-item">
                    <a href="#"><i class="fa-solid fa-house"></i> ዋና ገጽ</a>
                </li>
                
                <!-- Submenu / Dropdown Item -->
                <li class="mobile-nav-item">
                    <button class="mobile-dropdown-btn" onclick="toggleSubmenu('coursesSubmenu', this)">
                        <span><i class="fa-solid fa-book"></i> ትምህርቶች</span>
                        <i class="fa-solid fa-chevron-down arrow-icon"></i>
                    </button>
                    <div class="mobile-submenu" id="coursesSubmenu">
                        <a href="#">HTML & CSS</a>
                        <a href="#">JavaScript</a>
                        <a href="#">PHP / Laravel</a>
                    </div>
                </li>

                <li class="mobile-nav-item">
                    <a href="#"><i class="fa-solid fa-circle-info"></i> ስለ እኛ</a>
                </li>
                <li class="mobile-nav-item">
                    <a href="#"><i class="fa-solid fa-envelope"></i> አግኙን</a>
                </li>
            </ul>
        </div>

        <!-- Drawer Footer Buttons -->
        <div class="mobile-menu-footer">
            <a href="#" class="btn btn-outline">Sign In</a>
            <a href="#" class="btn btn-primary">Sign Up</a>
        </div>
    </aside>

    <!-- JavaScript logic -->
    <script>
        // ሜኑውን መክፈቻ እና መዝጊያ
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            
            menu.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // ሜኑውን በ X ቁልፍ ብቻ መዝጊያ
        function closeMobileMenu() {
            document.getElementById('mobileMenu').classList.remove('active');
            document.getElementById('mobileMenuOverlay').classList.remove('active');
        }

        // በሜኑ ውስጥ ያሉ Submenu / Dropdown ማስፋፊያ
        function toggleSubmenu(id, btn) {
            const submenu = document.getElementById(id);
            const arrow = btn.querySelector('.arrow-icon');
            
            submenu.classList.toggle('open');
            
            // የቀስቷን አቅጣጫ መቀየር
            if (submenu.classList.contains('open')) {
                arrow.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                arrow.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        }
    </script>

</body>
</html>
