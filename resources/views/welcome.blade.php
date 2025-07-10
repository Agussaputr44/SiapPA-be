<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiapPA - Sistem Pelaporan Kekerasan Anak dan Perempuan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: linear-gradient(135deg, rgb(241, 140, 176) 0%, rgb(248, 187, 208) 100%);
            color: white;
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(241, 140, 176, 0.3);
            transition: all 0.3s ease;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            color: #fff;
            font-size: 2rem;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
        }

        .nav-links a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .mobile-menu span {
            width: 25px;
            height: 3px;
            background: white;
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgb(241, 140, 176) 0%, rgb(248, 187, 208) 100%);
            color: white;
            padding: 120px 0 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle cx="200" cy="200" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="600" cy="300" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="800" cy="500" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="300" cy="700" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="900" cy="100" r="1.5" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out;
            background: linear-gradient(45deg, #fff, #ffb3d1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 1s ease-out 0.2s both;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: linear-gradient(45deg, #e91e63, #f06292);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(233, 30, 99, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        .btn-download {
            background: linear-gradient(45deg, rgb(241, 140, 176), rgb(248, 187, 208));
            color: white;
            font-size: 1.2rem;
            padding: 18px 40px;
            margin-top: 20px;
            animation: pulse 2s infinite;
        }

        .btn-download:hover {
            background: linear-gradient(45deg, rgb(248, 187, 208), rgb(241, 140, 176));
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(241, 140, 176, 0.4);
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #fef7f7;
        }

        .features h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 60px;
            color: #2c3e50;
            position: relative;
        }

        .features h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(45deg, rgb(241, 140, 176), rgb(248, 187, 208));
            border-radius: 2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-top: 50px;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(241, 140, 176, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(248, 187, 208, 0.2);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(241, 140, 176, 0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, rgb(241, 140, 176), rgb(248, 187, 208));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .feature-card p {
            color: #6c757d;
            line-height: 1.6;
        }

        /* About Section */
        .about {
            padding: 80px 0;
            background: white;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-text h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .about-text p {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .about-image {
            text-align: center;
            font-size: 15rem;
            color: rgb(241, 140, 176);
            opacity: 0.7;
        }

        /* Stats Section */
        .stats {
            padding: 80px 0;
            background: linear-gradient(135deg, rgb(241, 140, 176) 0%, rgb(248, 187, 208) 100%);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .stat-card {
            text-align: center;
            padding: 30px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Download Section */
        .download {
            padding: 80px 0;
            background: linear-gradient(135deg, rgb(241, 140, 176) 0%, rgb(248, 187, 208) 100%);
            color: white;
            text-align: center;
        }

        .download h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .download p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .download-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .download-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .download-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-section h3 {
            margin-bottom: 20px;
            color: rgb(248, 187, 208);
        }

        .footer-section p,
        .footer-section a {
            color: #bdc3c7;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
        }

        .footer-section a:hover {
            color: rgb(248, 187, 208);
        }

        .footer-bottom {
            border-top: 1px solid #34495e;
            padding-top: 20px;
            color: #bdc3c7;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: flex;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .about-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .about-image {
                font-size: 8rem;
            }

            .download-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <nav class="container">
            <div class="logo">
                <img src="logo/logo.png" alt="Logo SiapPA" style="height: 40px;">
                SiapPA
            </div>

            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#features">Fitur</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
            <div class="mobile-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1>SiapPA</h1>
                <p>Sistem Pelaporan Kekerasan Anak dan Perempuan yang Aman, Terpercaya, dan Mudah Digunakan. Bersama
                    kita lindungi mereka yang membutuhkan.</p>
                <div class="download-buttons">
                    <a href="/download/android" class="download-btn">
                        <i class="fab fa-android"></i>
                        Download Sekarang
                    </a>
                    {{-- <a href="/download/ios" class="download-btn">
                    <i class="fab fa-apple"></i>
                    Download untuk iOS
                </a>
                <a href="/download/web" class="download-btn">
                    <i class="fas fa-globe"></i>
                    Akses Web App
                </a> --}}
                </div>


            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2>Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>Keamanan Terjamin</h3>
                    <p>Semua data dan identitas pelapor dijamin keamanannya dengan enkripsi tingkat tinggi dan sistem
                        anonimitas yang kuat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Respon Cepat</h3>
                    <p>Sistem notifikasi real-time untuk memastikan setiap laporan ditangani dengan cepat dan tepat oleh
                        pihak berwenang.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mudah Digunakan</h3>
                    <p>Interface yang intuitif dan user-friendly, memungkinkan siapa saja dapat membuat laporan dengan
                        mudah dan cepat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Pelacakan Lokasi</h3>
                    <p>Fitur GPS terintegrasi untuk membantu identifikasi lokasi kejadian dan mempercepat proses
                        penanganan.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Dukungan 24/7</h3>
                    <p>Tim support dan konselor profesional siap membantu korban dan pelapor kapan saja, 24 jam sehari 7
                        hari seminggu.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Laporan Analitik</h3>
                    <p>Dashboard komprehensif untuk monitoring dan analisis data kekerasan guna pencegahan yang lebih
                        efektif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Tentang SiapPA</h2>
                    <p>SiapPA adalah platform digital yang dikembangkan khusus untuk memberikan solusi komprehensif
                        dalam pelaporan dan penanganan kasus kekerasan terhadap anak dan perempuan.</p>
                    <p>Dengan teknologi Laravel yang robust dan fitur keamanan tingkat tinggi, kami berkomitmen untuk
                        menciptakan lingkungan yang aman bagi korban untuk melaporkan kejadian yang mereka alami.</p>
                    <p>Tim kami terdiri dari para ahli teknologi, psikolog, dan aktivis hak asasi manusia yang
                        berdedikasi untuk melindungi mereka yang paling rentan dalam masyarakat.</p>
                </div>
                <div class="about-image">
                    <i class="fas fa-hands-helping"></i>
                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>SiapPA</h3>
                    <p>Melindungi yang terlindungi, menjadi suara bagi yang tidak bersuara.</p>
                </div>
                <div class="footer-section">
                    <h3>Kontak</h3>
                    {{-- <a href="mailto:info@SiapPA.id"></a> --}}
                    <a href="tel:+628001234567">+621276370587</a>
                    <p>Jl. Bathin alam</p>
                </div>
                <div class="footer-section">
                    <h3>Bantuan</h3>
                    <a href="">FAQ</a>
                    <a href="">Panduan Penggunaan</a>
                    <a href="">Pusat Bantuan</a>
                </div>
                <div class="footer-section">
                    <h3>Legal</h3>
                    <a href="">Kebijakan Privasi</a>
                    <a href="">Syarat & Ketentuan</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 SiapPA. Semua hak dilindungi. Dibuat dengan ❤️ untuk Indonesia yang lebih aman.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(241, 140, 176, 0.95)'; // pink semi-transparent
            } else {
                header.style.background =
                'linear-gradient(135deg, rgb(241, 140, 176) 0%, rgb(248, 187, 208) 100%)'; // pink gradient
            }
        });


        // Download button functionality
        document.querySelectorAll('a[href^="/download"]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mempersiapkan Download...';
                this.style.pointerEvents = 'none';

                // Simulate download preparation
                setTimeout(() => {
                    // Reset button
                    this.innerHTML = originalText;
                    this.style.pointerEvents = 'auto';

                    // Show success message
                    const notification = document.createElement('div');
                    notification.style.cssText = `
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: #4CAF50;
                        color: white;
                        padding: 15px 20px;
                        border-radius: 10px;
                        z-index: 10000;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                    `;
                    notification.innerHTML =
                        '<i class="fas fa-check"></i> Download dimulai! Terima kasih telah menggunakan SiapPA.';
                    document.body.appendChild(notification);

                    // Remove notification after 3 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);

                    // Here you would implement actual download logic
                    // For Laravel, you might redirect to a download controller
                    // window.location.href = this.href;
                }, 2000);
            });
        });

        // Mobile menu toggle
        const mobileMenu = document.querySelector('.mobile-menu');
        const navLinks = document.querySelector('.nav-links');

        mobileMenu.addEventListener('click', function() {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        });

        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.7
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const target = parseInt(stat.textContent);
                        let current = 0;
                        const increment = target / 100;

                        const timer = setInterval(() => {
                            current += increment;
                            if (current >= target) {
                                current = target;
                                clearInterval(timer);
                            }
                            stat.textContent = Math.floor(current) + (stat.textContent
                                .includes('+') ? '+' : '');
                        }, 20);
                    });
                }
            });
        }, observerOptions);

        observer.observe(document.querySelector('.stats'));
    </script>
</body>

</html>
