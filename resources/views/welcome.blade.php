<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management System</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #10b981;
            --dark: #0f172a;
            --light: #f8fafc;
            --text: #334155;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text);
            background-color: #ffffff;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            padding: 1.5rem 0;
            transition: all 0.3s ease;
            background: transparent;
            z-index: 1000;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--dark) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), #818cf8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text) !important;
            padding: 0.5rem 1.25rem !important;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--primary) !important;
        }

        .btn-login {
            background: var(--primary);
            color: white !important;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
            background: var(--primary-dark);
        }

        .btn-dashboard {
            background: var(--dark);
            color: white !important;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.3);
            transition: all 0.3s;
        }

        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.4);
            background: #000;
        }

        /* Hero Section */
        .hero {
            padding: 8rem 0 5rem;
            position: relative;
            background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.05), transparent 40%),
                        radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.05), transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--dark);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--primary), #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            line-height: 1.6;
            max-width: 600px;
        }

        .hero-image-wrapper {
            position: relative;
            z-index: 1;
        }

        .hero-image {
            background: white;
            border-radius: 24px;
            padding: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
            transition: transform 0.5s ease;
        }

        .hero-image:hover {
            transform: perspective(1000px) rotateY(0) rotateX(0);
        }

        .hero-image img {
            border-radius: 16px;
            width: 100%;
            height: auto;
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* Features Section */
        .features {
            padding: 5rem 0;
            background: var(--light);
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.02);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.1);
            border-color: rgba(79, 70, 229, 0.1);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .icon-blue { background: rgba(79, 70, 229, 0.1); color: var(--primary); }
        .icon-green { background: rgba(16, 185, 129, 0.1); color: var(--secondary); }
        .icon-purple { background: rgba(168, 85, 247, 0.1); color: #a855f7; }

        .feature-card h3 {
            font-weight: 700;
            font-size: 1.35rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0;
        }

        /* CTA Section */
        .cta {
            padding: 6rem 0;
            background: linear-gradient(135deg, var(--dark), #1e293b);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url('data:image/svg+xml,<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="2" fill="rgba(255,255,255,0.05)"/></svg>');
        }

        .cta h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .cta p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
            z-index: 1;
        }

        .cta .btn-cta {
            background: white;
            color: var(--dark);
            font-weight: 700;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .cta .btn-cta:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(255,255,255,0.2);
        }

        /* Footer */
        footer {
            background: white;
            padding: 2rem 0;
            text-align: center;
            color: var(--text-muted);
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 3rem;
            }
            .hero {
                padding-top: 6rem;
                text-align: center;
            }
            .hero-subtitle {
                margin: 0 auto 2.5rem;
            }
            .hero-image {
                transform: none;
                margin-top: 3rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <div class="brand-icon"><i class="fas fa-cubes"></i></div>
                AssetSystem
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars fs-3 text-dark"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#beranda">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-dashboard">
                            Masuk Dashboard <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login">
                            Masuk <i class="fas fa-sign-in-alt ms-2"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill mb-4 fw-semibold" style="letter-spacing: 0.5px;">
                        <i class="fas fa-rocket me-2"></i> Versi 2.0 Telah Hadir
                    </div>
                    <h1 class="hero-title">Kelola Aset <span>Lebih Cerdas & Mudah</span></h1>
                    <p class="hero-subtitle">Sistem Manajemen Aset modern yang dirancang untuk mempermudah pemantauan inventaris, pencatatan sirkulasi, dan pengelolaan pengajuan barang secara real-time.</p>
                    <div class="d-flex gap-3 justify-content-lg-start justify-content-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-login px-4 py-3" style="font-size: 1.1rem;">
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-login px-4 py-3" style="font-size: 1.1rem;">
                                Mulai Sekarang
                            </a>
                        @endauth
                        <a href="#fitur" class="btn btn-light px-4 py-3 fw-bold rounded-pill shadow-sm" style="font-size: 1.1rem; color: var(--dark);">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-wrapper">
                        <!-- Abstract Dashboard Representation -->
                        <div class="hero-image">
                            <div class="d-flex flex-column gap-3">
                                <!-- Fake Header -->
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                                    <div class="d-flex gap-2">
                                        <div style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444;"></div>
                                        <div style="width: 12px; height: 12px; border-radius: 50%; background: #f59e0b;"></div>
                                        <div style="width: 12px; height: 12px; border-radius: 50%; background: #10b981;"></div>
                                    </div>
                                    <div style="height: 8px; width: 100px; background: #f1f5f9; border-radius: 4px;"></div>
                                </div>
                                <!-- Fake Content -->
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div style="background: #e0e7ff; height: 100px; border-radius: 12px; padding: 1rem;">
                                            <div style="width: 30px; height: 30px; background: #4f46e5; border-radius: 8px; margin-bottom: 1rem;"></div>
                                            <div style="height: 10px; width: 80%; background: rgba(0,0,0,0.1); border-radius: 4px; margin-bottom: 8px;"></div>
                                            <div style="height: 20px; width: 40%; background: #4f46e5; border-radius: 4px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div style="background: #dcfce7; height: 100px; border-radius: 12px; padding: 1rem;">
                                            <div style="width: 30px; height: 30px; background: #10b981; border-radius: 8px; margin-bottom: 1rem;"></div>
                                            <div style="height: 10px; width: 80%; background: rgba(0,0,0,0.1); border-radius: 4px; margin-bottom: 8px;"></div>
                                            <div style="height: 20px; width: 40%; background: #10b981; border-radius: 4px;"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div style="background: #f8fafc; height: 150px; border-radius: 12px; padding: 1rem; border: 1px solid #e2e8f0;">
                                            <div class="d-flex justify-content-between mb-3">
                                                <div style="height: 15px; width: 30%; background: #cbd5e1; border-radius: 4px;"></div>
                                                <div style="height: 15px; width: 10%; background: #cbd5e1; border-radius: 4px;"></div>
                                            </div>
                                            <div style="height: 8px; width: 100%; background: #e2e8f0; border-radius: 4px; margin-bottom: 12px;"></div>
                                            <div style="height: 8px; width: 90%; background: #e2e8f0; border-radius: 4px; margin-bottom: 12px;"></div>
                                            <div style="height: 8px; width: 95%; background: #e2e8f0; border-radius: 4px; margin-bottom: 12px;"></div>
                                            <div style="height: 8px; width: 80%; background: #e2e8f0; border-radius: 4px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="fitur">
        <div class="container">
            <div class="section-header">
                <h2>Fitur Unggulan</h2>
                <p class="text-muted fs-5">Semua yang Anda butuhkan untuk mengelola aset dalam satu platform.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-blue">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>
                        <h3>Manajemen Inventaris</h3>
                        <p>Kelola data barang, kategori, dan jenis barang dengan mudah. Pantau stok barang secara real-time dan akurat.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-green">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h3>Sirkulasi Barang</h3>
                        <p>Catat setiap barang masuk dan keluar dengan rinci. Riwayat transaksi tersimpan rapi untuk mempermudah audit.</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon icon-purple">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <h3>Sistem Pengajuan</h3>
                        <p>Fasilitas pengajuan barang bagi pengguna. Proses persetujuan (approval) oleh admin yang terintegrasi langsung dengan stok.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Siap Mengelola Aset Anda?</h2>
            <p>Bergabunglah dan rasakan kemudahan mengelola inventaris tanpa repot dengan AssetSystem.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-cta">
                    Masuk ke Dashboard <i class="fas fa-arrow-right"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-cta">
                    Login Sekarang <i class="fas fa-arrow-right"></i>
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} AssetSystem. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Script for Navbar -->
    <script>
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.getElementById('navbar').classList.add('scrolled');
            } else {
                document.getElementById('navbar').classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
