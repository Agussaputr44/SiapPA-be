<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email Anda • SiapPA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .email-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            max-width: 600px;
            width: 100%;
            border-radius: 24px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.1),
                0 8px 32px rgba(218, 0, 113, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            overflow: hidden;
            position: relative;
            animation: slideUp 0.8s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .header {
            background: linear-gradient(135deg, #ec4899 0%, #d81b60 50%, #8e24aa 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.5; }
            50% { transform: scale(1.1) rotate(180deg); opacity: 0.8; }
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .tagline {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }
        
        .content {
            padding: 50px 40px;
            text-align: center;
        }
        
        .welcome-text {
            font-size: 1.8rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
            line-height: 1.4;
        }
        
        .description {
            color: #718096;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .verify-button {
            display: inline-block;
            padding: 18px 48px;
            background: linear-gradient(135deg, #ec4899 0%, #d81b60 50%, #8e24aa 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            box-shadow: 
                0 10px 30px rgba(236, 72, 153, 0.3),
                0 4px 15px rgba(216, 27, 96, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .verify-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .verify-button:hover {
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 
                0 15px 40px rgba(236, 72, 153, 0.4),
                0 8px 25px rgba(216, 27, 96, 0.3);
        }
        
        .verify-button:hover::before {
            left: 100%;
        }
        
        .verify-button:active {
            color: #ffffff !important;
            transform: translateY(0);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 40px 0 30px 0;
            color: #a0aec0;
            font-size: 0.9rem;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
        }
        
        .divider span {
            padding: 0 20px;
            font-weight: 500;
        }
        
        .manual-link-section {
            background: #f8fafc;
            border-radius: 16px;
            padding: 25px;
            margin-top: 20px;
        }
        
        .manual-text {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .manual-link {
            display: block;
            word-break: break-all;
            color: #3b82f6;
            font-size: 0.9rem;
            text-decoration: none;
            background: white;
            padding: 15px;
            border-radius: 12px;
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
        }
        
        .manual-link:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        
        .footer {
            background: #f1f5f9;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-text {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 15px;
            color: #10b981;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .security-icon {
            width: 16px;
            height: 16px;
            background: #10b981;
            border-radius: 50%;
            position: relative;
        }
        
        .security-icon::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 10px;
            font-weight: bold;
        }
        
        @media (max-width: 640px) {
            body {
                padding: 10px;
            }
            
            .email-container {
                border-radius: 20px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .logo {
                font-size: 2rem;
            }
            
            .content {
                padding: 40px 25px;
            }
            
            .welcome-text {
                font-size: 1.5rem;
            }
            
            .description {
                font-size: 1rem;
            }
            
            .verify-button {
                padding: 16px 36px;
                font-size: 1.1rem;
                width: 100%;
                max-width: 280px;
            }
            
            .footer {
                padding: 25px 25px;
            }
            
            .manual-link-section {
                padding: 20px;
            }
        }
        
        .animate-bounce {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                transform: translate3d(0,-8px,0);
            }
            70% {
                transform: translate3d(0,-4px,0);
            }
            90% {
                transform: translate3d(0,-2px,0);
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo animate-bounce">SiapPA</div>
            <div class="tagline">Platform Pengaduan Kekerasan Perempuan dan Anak</div>
        </div>
        
        <div class="content">
            <h1 class="welcome-text">Selamat Datang!</h1>
            <p class="description">
                Terima kasih telah bergabung dengan SiapPA. Kami sangat senang Anda menjadi bagian dari komunitas kami. Untuk mengaktifkan akun dan mulai menikmati semua fitur yang tersedia, silakan verifikasi email Anda dengan mengklik tombol di bawah ini.
            </p>
            
            <a href="{{ $verificationUrl }}" class="verify-button">
                Verifikasi Email Sekarang
            </a>
            
            <div class="divider">
                <span>atau</span>
            </div>
            
            <div class="manual-link-section">
                <p class="manual-text">
                    Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempel tautan berikut ke browser:
                </p>
                <a href="{{ $verificationUrl }}" class="manual-link">{{ $verificationUrl }}</a>
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                Email ini dikirim secara otomatis. Jika Anda tidak mendaftar di SiapPA, Anda dapat mengabaikan email ini.
            </p>
        </div>
    </div>
</body>
</html>