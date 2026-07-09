<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPA | PT Surveyor Indonesia (Persero)</title>
    <meta name="description" content="Sistem Manajemen Proyek Aplikasi (SIMPA) - Platform monitoring proyek terpadu PT Surveyor Indonesia (Persero) untuk transparansi dan akurasi pelaporan.">
    <link rel="shortcut icon" type="image/png" href="<?= base_url('images/icon_simpa.png') ?>" />
    <link rel="manifest" href="<?= base_url('manifest.json') ?>" />
    <meta name="theme-color" content="#002d5c">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        si: {
                            blue: '#004996',
                            light: '#0060c7',
                            dark: '#002d5c',
                            deeper: '#001e3e',
                            gold: '#FFB800',
                            gold2: '#FCD34D',
                        }
                    },
                    fontFamily: {
                        sans: ['"Nunito Sans"', 'sans-serif'],
                        inter: ['"Nunito Sans"', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 7s ease-in-out infinite',
                        'float-slow': 'float 10s ease-in-out infinite',
                        'pulse-slow': 'pulse 5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'shimmer': 'shimmer 2.5s linear infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease forwards',
                        'counter': 'counter 2s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-18px)' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-200% 0' },
                            '100%': { backgroundPosition: '200% 0' },
                        },
                        fadeInUp: {
                            from: { opacity: '0', transform: 'translateY(30px)' },
                            to: { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * { scroll-behavior: smooth; box-sizing: border-box; }

        /* Prevent horizontal scroll on mobile */
        html, body { max-width: 100vw; overflow-x: hidden; }

        /* Glassmorphism */
        .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.15); }
        .glass-dark { background: rgba(0,29,62,0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); }

        /* Nav */
        .nav-glass {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,73,150,0.08);
        }

        /* Hero */
        .hero-overlay {
            background: linear-gradient(110deg, rgba(0,29,62,0.97) 0%, rgba(0,46,92,0.90) 45%, rgba(0,73,150,0.55) 80%, transparent 100%);
        }

        /* Gradient text */
        .text-gradient-white { background: linear-gradient(135deg, #ffffff 0%, #c7d9f8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .text-gradient-gold { background: linear-gradient(135deg, #FFB800 0%, #FCD34D 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .text-gradient-blue { background: linear-gradient(135deg, #004996 0%, #0060c7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Glow effects */
        .glow-gold { box-shadow: 0 0 30px rgba(255,184,0,0.35), 0 0 60px rgba(255,184,0,0.15); }
        .glow-blue { box-shadow: 0 0 30px rgba(0,73,150,0.35), 0 0 60px rgba(0,73,150,0.15); }

        /* Animated bg dots */
        .dot-grid { background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px); background-size: 30px 30px; }

        /* Feature card */
        .feature-card { transition: all 0.4s cubic-bezier(0.4,0,0.2,1); }
        .feature-card:hover { transform: translateY(-10px); }
        .feature-card::before { content: ''; position: absolute; inset: 0; border-radius: inherit; background: linear-gradient(135deg, rgba(0,73,150,0.05), rgba(255,184,0,0.05)); opacity: 0; transition: opacity 0.4s ease; }
        .feature-card:hover::before { opacity: 1; }

        /* Progress bar animate */
        .progress-fill { width: 0; transition: width 1.5s cubic-bezier(0.4,0,0.2,1); }

        /* Divider */
        .section-divider { width: 60px; height: 4px; border-radius: 2px; background: linear-gradient(90deg, #004996, #FFB800); flex-shrink: 0; }

        /* CTA shimmer btn */
        .btn-shimmer {
            position: relative;
            overflow: hidden;
        }
        .btn-shimmer::after {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            animation: shimmer 2.5s infinite;
        }
        @keyframes shimmer { 0% { left: -100%; } 100% { left: 150%; } }

        /* Scroll reveal */
        [data-aos] { transition-timing-function: cubic-bezier(0.4,0,0.2,1) !important; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #004996; border-radius: 3px; }

        /* Topbar */
        .topbar-ticker span { display: inline-flex; align-items: center; gap: 0.35rem; }

        /* Nav link underline */
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px; background: #004996; border-radius: 1px; transition: width 0.3s ease; }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }

        /* About image */
        .img-hover-scale { overflow: hidden; border-radius: 1rem; }
        .img-hover-scale img { transition: transform 0.7s cubic-bezier(0.4,0,0.2,1); }
        .img-hover-scale:hover img { transform: scale(1.06); }

        /* Stat number */
        .stat-num { font-variant-numeric: tabular-nums; }

        /* ===== MOBILE RESPONSIVE FIXES ===== */
        @media (max-width: 640px) {
            /* Nav height mobile */
            .nav-glass .container { height: 64px !important; }

            /* Hero section padding mobile */
            .hero-section-container {
                padding-top: 5rem !important;
                padding-bottom: 7rem !important;
            }

            /* Badge System Online */
            .system-badge {
                font-size: 0.65rem !important;
                padding: 0.35rem 0.75rem !important;
            }

            /* Hero title */
            .hero-title {
                font-size: 2rem !important;
                line-height: 1.15 !important;
            }

            /* Hero subtitle */
            .hero-subtitle {
                font-size: 0.95rem !important;
                padding-left: 1rem !important;
            }

            /* CTA buttons - stack on mobile */
            .hero-cta {
                flex-direction: column !important;
                gap: 0.75rem !important;
            }
            .hero-cta a {
                width: 100% !important;
                justify-content: center !important;
                padding: 0.9rem 1.5rem !important;
                font-size: 0.95rem !important;
            }

            /* Trust badges wrap */
            .trust-badges {
                gap: 0.75rem !important;
            }
            .trust-badges > div {
                font-size: 0.65rem !important;
            }

            /* About section */
            .about-section { padding-top: 3.5rem !important; padding-bottom: 3.5rem !important; }
            .about-grid { gap: 2.5rem !important; }
            .about-title { font-size: 1.75rem !important; }

            /* Features section */
            .features-section { padding-top: 3.5rem !important; padding-bottom: 3.5rem !important; }
            .features-title { font-size: 1.75rem !important; }
            .feature-card { padding: 1.5rem !important; }
            .feature-number { font-size: 3.5rem !important; }

            /* CTA section */
            .cta-section { padding-top: 4rem !important; padding-bottom: 4rem !important; }
            .cta-title { font-size: 1.75rem !important; }
            .cta-buttons {
                flex-direction: column !important;
                gap: 0.75rem !important;
                align-items: stretch !important;
            }
            .cta-buttons a {
                width: 100% !important;
                justify-content: center !important;
                padding: 1rem 1.5rem !important;
                font-size: 0.95rem !important;
            }

            /* Footer */
            .footer-grid { gap: 2rem !important; }

            /* Mobile menu improvements */
            #mobileMenu .container { padding-left: 1rem !important; padding-right: 1rem !important; }
        }

        @media (max-width: 768px) {
            /* General mobile padding */
            .container { padding-left: 1rem !important; padding-right: 1rem !important; }

            /* Decorative blobs - hide on mobile to prevent overflow */
            .decorative-blob { display: none !important; }

            /* Feature cards full width on small tablets */
            .feature-card-p { padding: 1.75rem !important; }
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased font-sans overflow-x-hidden">

    <!-- Top Bar -->
    <div class="bg-si-deeper text-white py-2 hidden md:block">
        <div class="container mx-auto px-6 flex justify-between items-center text-xs font-semibold tracking-wider">
            <div class="flex gap-6 topbar-ticker">
                <span><i class="fas fa-phone-alt text-si-gold"></i> (021) 5265526</span>
                <span><i class="fas fa-envelope text-si-gold"></i> humas@ptsi.co.id</span>
                <span><i class="fas fa-map-marker-alt text-si-gold"></i> Jl. Gatot Subroto Kav. 56, Jakarta Selatan</span>
            </div>
            <div class="flex gap-5 items-center">
                <a href="#" class="hover:text-si-gold transition-colors duration-200">Career</a>
                <span class="text-white/20">|</span>
                <a href="#" class="hover:text-si-gold transition-colors duration-200">Contact</a>
                <span class="text-white/20">|</span>
                <a href="#" class="hover:text-si-gold transition-colors duration-200">ID / EN</a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="nav-glass sticky top-0 z-50 shadow-[0_2px_20px_rgba(0,73,150,0.08)]">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="<?= base_url('images/logo_si.png') ?>" alt="Surveyor Indonesia" class="h-10 md:h-12 border-r pr-4 border-slate-200">
                <img src="<?= base_url('images/logo_simpa.png') ?>" alt="SIMPA" class="h-8 md:h-10">
            </div>
            
            <div class="hidden lg:flex items-center gap-8 text-sm font-bold uppercase tracking-wide text-slate-600">
                <a href="#" class="nav-link active text-si-blue hover:text-si-blue transition-colors">Beranda</a>
                <a href="#about" class="nav-link hover:text-si-blue transition-colors">Tentang</a>
                <a href="#solutions" class="nav-link hover:text-si-blue transition-colors">Fitur</a>
                <a href="#contact" class="nav-link hover:text-si-blue transition-colors">Kontak</a>
                <a href="<?= base_url('login-page') ?>" 
                   class="btn-shimmer ml-4 bg-gradient-to-r from-si-blue to-si-light hover:from-si-dark hover:to-si-blue text-white px-7 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2 hover:-translate-y-0.5">
                    <i class="fas fa-sign-in-alt text-xs"></i> Login Sistem
                </a>
            </div>
            
            <button class="lg:hidden text-si-blue text-2xl p-2 rounded-lg hover:bg-si-blue/5 transition-colors" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div class="lg:hidden hidden bg-white border-t border-slate-100 shadow-lg" id="mobileMenu">
            <div class="container mx-auto px-6 py-4 flex flex-col gap-4 text-sm font-bold uppercase tracking-wide text-slate-600">
                <a href="#" class="py-2 hover:text-si-blue border-b border-slate-50">Beranda</a>
                <a href="#about" class="py-2 hover:text-si-blue border-b border-slate-50">Tentang</a>
                <a href="#solutions" class="py-2 hover:text-si-blue border-b border-slate-50">Fitur</a>
                <a href="<?= base_url('login-page') ?>" class="mt-2 bg-si-blue text-white text-center py-3 rounded-xl font-bold">Login Sistem</a>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section class="relative min-h-screen flex items-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="<?= base_url('images/landing.webp') ?>" alt="Industry Hero" 
                 class="w-full h-full object-cover object-center scale-105" style="transform-origin: center;">
            <div class="absolute inset-0 hero-overlay"></div>
            <!-- Dot grid overlay -->
            <div class="absolute inset-0 dot-grid opacity-30"></div>
        </div>
        
        <!-- Decorative blobs (hidden on mobile to prevent overflow) -->
        <div class="decorative-blob absolute top-1/4 right-0 w-[600px] h-[600px] bg-si-blue rounded-full mix-blend-screen filter blur-[120px] opacity-20 animate-pulse-slow pointer-events-none"></div>
        <div class="decorative-blob absolute bottom-0 left-1/3 w-[400px] h-[400px] bg-si-gold rounded-full mix-blend-screen filter blur-[100px] opacity-15 animate-pulse-slow pointer-events-none" style="animation-delay: 3s;"></div>
        
        <div class="hero-section-container container mx-auto px-4 sm:px-6 relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12 py-20 sm:py-24 lg:py-32">
            <!-- Left: Text content -->
            <div class="w-full lg:w-[55%] animate-fade-in-up" data-aos="fade-right" data-aos-duration="1000">
                <!-- Badge -->
                <div class="system-badge inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full glass border border-white/20 mb-6 sm:mb-8">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse flex-shrink-0"></span>
                    <span class="text-white text-xs font-bold tracking-[0.15em] uppercase whitespace-nowrap">System Online — SIMPA v2.0</span>
                </div>
                
                <h1 class="hero-title text-white font-extrabold leading-[1.1] mb-4 sm:mb-6 text-[1.85rem] sm:text-4xl md:text-5xl lg:text-[4.25rem]">
                    Sistem Manajemen<br>
                    Proyek Aplikasi<br>
                    <span class="text-gradient-gold">PT Surveyor Indonesia</span>
                </h1>
                
                <p class="hero-subtitle text-white/75 text-base sm:text-lg md:text-xl leading-relaxed mb-8 sm:mb-10 max-w-xl font-inter font-light border-l-[3px] border-si-gold pl-4 sm:pl-6">
                    Platform monitoring proyek terpadu yang menghadirkan transparansi data real-time dan akurasi pelaporan di setiap level manajemen.
                </p>
                
                <div class="hero-cta flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4 mb-10 sm:mb-14">
                    <a href="<?= base_url('login-page') ?>" 
                       class="btn-shimmer bg-gradient-to-r from-si-gold to-yellow-400 hover:from-yellow-400 hover:to-si-gold text-si-dark px-6 sm:px-8 py-3.5 sm:py-4 rounded-2xl text-sm sm:text-base font-black shadow-[0_8px_30px_rgba(255,184,0,0.4)] hover:shadow-[0_12px_40px_rgba(255,184,0,0.6)] hover:-translate-y-1.5 transition-all duration-300 flex items-center justify-center gap-3 glow-gold">
                        <i class="fas fa-sign-in-alt text-sm"></i> Masuk Dashboard
                    </a>
                    <a href="#about" 
                       class="glass border border-white/25 text-white px-6 sm:px-8 py-3.5 sm:py-4 rounded-2xl text-sm sm:text-base font-bold hover:bg-white/15 hover:-translate-y-1.5 transition-all duration-300 flex items-center justify-center gap-3">
                        <i class="fas fa-play-circle text-sm text-si-gold"></i>
                        Pelajari Lebih
                    </a>
                </div>

                <!-- Trust badges -->
                <div class="trust-badges flex flex-wrap items-center gap-4 sm:gap-6 pt-6 sm:pt-8 border-t border-white/10">
                    <div class="flex items-center gap-2 text-white/60 text-xs font-semibold tracking-wider uppercase">
                        <i class="fas fa-shield-alt text-si-gold"></i> COBIT Framework
                    </div>
                    <div class="flex items-center gap-2 text-white/60 text-xs font-semibold tracking-wider uppercase">
                        <i class="fas fa-lock text-si-gold"></i> Secure Access
                    </div>
                    <div class="flex items-center gap-2 text-white/60 text-xs font-semibold tracking-wider uppercase">
                        <i class="fas fa-database text-si-gold"></i> Real-time Data
                    </div>
                </div>
            </div>
            
            <!-- Right: Floating Dashboard Card -->
            <div class="hidden lg:block lg:w-[40%] animate-float" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="200">
                <div class="glass-dark p-7 rounded-3xl shadow-[0_30px_80px_rgba(0,0,0,0.4)] relative overflow-hidden">
                    <!-- Decorative corner -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-si-gold/20 to-transparent rounded-bl-full pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-si-blue/30 to-transparent rounded-tr-full pointer-events-none"></div>
                    
                    <!-- Card header -->
                    <div class="flex justify-between items-center mb-7 pb-5 border-b border-white/10">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-si-gold/20 flex items-center justify-center">
                                <i class="fas fa-chart-line text-si-gold text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Live Dashboard</h3>
                                <p class="text-white/40 text-xs">Status Sistem</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-mono bg-green-500/15 text-green-300 border border-green-500/30 px-2.5 py-1.5 rounded-lg flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span> ONLINE
                        </span>
                    </div>
                    
                    <!-- Stats grid -->
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-white/5 rounded-2xl p-4 border border-white/5">
                            <p class="text-white/50 text-xs font-semibold uppercase tracking-wider mb-1">Total Aplikasi</p>
                            <p class="text-white text-2xl font-black stat-num">15+</p>
                            <p class="text-green-400 text-xs font-semibold mt-1"><i class="fas fa-arrow-trend-up mr-1"></i>+12% bulan ini</p>
                        </div>
                        <div class="bg-white/5 rounded-2xl p-4 border border-white/5">
                            <p class="text-white/50 text-xs font-semibold uppercase tracking-wider mb-1">Active PIC</p>
                            <p class="text-white text-2xl font-black stat-num">10</p>
                            <p class="text-white/40 text-xs font-semibold mt-1"><i class="fas fa-minus mr-1"></i>Tetap stabil</p>
                        </div>
                    </div>

                    <!-- Progress bars -->
                    <div class="space-y-4 mb-6">
                        <div>
                            <div class="flex justify-between text-xs text-white/70 mb-2 font-semibold">
                                <span>Audit Kepatuhan COBIT</span>
                                <span class="text-white font-bold">98%</span>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-2">
                                <div class="progress-fill bg-si-gold h-2 rounded-full" style="width:0" data-width="98%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs text-white/70 mb-2 font-semibold">
                                <span>Akurasi Pelaporan Data</span>
                                <span class="text-white font-bold">100%</span>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-2">
                                <div class="progress-fill bg-si-gold h-2 rounded-full" style="width:0" data-width="100%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs text-white/70 mb-2 font-semibold">
                                <span>Progress Proyek Aktif</span>
                                <span class="text-white font-bold">76%</span>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-2">
                                <div class="progress-fill bg-si-gold h-2 rounded-full" style="width:0" data-width="76%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Security badge -->
                    <div class="flex items-center gap-4 bg-si-blue/20 p-4 rounded-2xl border border-si-blue/20">
                        <div class="w-10 h-10 bg-gradient-to-br from-si-blue to-si-light rounded-xl flex items-center justify-center text-white shadow-md shrink-0">
                            <i class="fas fa-shield-halved text-sm"></i>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Protected by COBIT Framework</p>
                            <p class="text-white/40 text-xs mt-0.5">Standardisasi Tata Kelola TI Terjamin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Stats Bar - visible on md+ screens, compact grid on mobile -->
        <div class="absolute bottom-0 left-0 right-0" style="background: rgba(0,29,62,0.75); backdrop-filter: blur(20px); border-top: 1px solid rgba(255,255,255,0.08);">
            <div class="container mx-auto px-4 sm:px-6 py-4 sm:py-6 grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-8">
                <div class="text-white text-center">
                    <div class="text-2xl sm:text-3xl font-black text-si-gold stat-num">50+</div>
                    <div class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.1em] sm:tracking-[0.15em] text-white/50 mt-1">Proyek Aktif</div>
                </div>
                <div class="text-white text-center">
                    <div class="text-2xl sm:text-3xl font-black text-si-gold stat-num">100%</div>
                    <div class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.1em] sm:tracking-[0.15em] text-white/50 mt-1">Audit Kepatuhan</div>
                </div>
                <div class="text-white text-center">
                    <div class="text-xl sm:text-3xl font-black text-si-gold">Real-time</div>
                    <div class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.1em] sm:tracking-[0.15em] text-white/50 mt-1">Pelaporan Data</div>
                </div>
                <div class="text-white text-center">
                    <div class="text-2xl sm:text-3xl font-black text-si-gold stat-num">70+</div>
                    <div class="text-[10px] sm:text-xs font-bold uppercase tracking-[0.1em] sm:tracking-[0.15em] text-white/50 mt-1">Unit Kerja</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ABOUT SECTION ===== -->
    <section id="about" class="about-section py-16 sm:py-20 md:py-28 bg-slate-50 relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden">
            <div class="decorative-blob absolute -top-40 -right-40 w-[500px] h-[500px] bg-si-blue/5 rounded-full"></div>
            <div class="decorative-blob absolute -bottom-40 -left-40 w-[400px] h-[400px] bg-si-gold/5 rounded-full"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 relative z-10">
            <div class="about-grid grid lg:grid-cols-2 gap-10 sm:gap-16 lg:gap-20 items-center">
                <!-- Image Column -->
                <div class="relative" data-aos="zoom-in-right" data-aos-duration="1000">
                    <!-- Decorative frames -->
                    <div class="absolute -top-5 -left-5 w-full h-full bg-gradient-to-br from-si-blue/20 to-si-light/10 rounded-3xl -z-0"></div>
                    <div class="absolute -bottom-5 -right-5 w-40 h-40 bg-gradient-to-tl from-si-gold/30 to-yellow-300/20 rounded-3xl -z-0"></div>
                    
                    <!-- Main image -->
                    <div class="img-hover-scale relative z-10 shadow-[0_25px_60px_rgba(0,73,150,0.18)] rounded-3xl">
                        <div class="absolute inset-0 bg-gradient-to-t from-si-dark/40 via-transparent to-transparent z-10 rounded-3xl pointer-events-none"></div>
                        <img src="<?= base_url('images/graha_si.jpg') ?>" 
                             alt="Graha Surveyor Indonesia" 
                             class="w-full h-auto rounded-3xl object-cover">
                        <!-- Caption overlay -->
                        <div class="absolute bottom-0 left-0 right-0 p-5 z-20">
                            <div class="glass-dark rounded-2xl px-5 py-3 inline-flex items-center gap-3">
                                <i class="fas fa-building text-si-gold"></i>
                                <div>
                                    <p class="text-white text-sm font-bold">Graha Surveyor Indonesia</p>
                                    <p class="text-white/50 text-xs">Jl. Gatot Subroto, Jakarta Selatan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating badge -->
                    <div class="absolute -right-6 top-1/3 bg-white p-4 rounded-2xl shadow-[0_10px_40px_rgba(0,73,150,0.15)] z-20 hidden md:flex items-center gap-3 border border-slate-100 animate-float" style="animation-delay: 1s;">
                        <div class="w-12 h-12 rounded-2xl bg-green-50 text-green-500 flex items-center justify-center text-xl font-black shadow-inner">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-slate-800 stat-num">100%</p>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Akurasi Audit</p>
                        </div>
                    </div>

                    <!-- Year badge -->
                    <div class="absolute -left-6 bottom-1/4 bg-gradient-to-br from-si-blue to-si-light p-4 rounded-2xl shadow-xl z-20 hidden md:flex items-center gap-3 animate-float-slow">
                        <div class="text-center">
                            <p class="text-2xl font-black text-white stat-num">2026</p>
                            <p class="text-xs text-white/70 font-semibold uppercase tracking-wider">Est.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Text Column -->
                <div class="space-y-7" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="100">
                    <div class="inline-flex items-center gap-2">
                        <div class="section-divider"></div>
                        <h2 class="text-si-blue font-bold tracking-[0.15em] uppercase text-xs ml-3">Tentang Solusi Digital</h2>
                    </div>
                    
                    <h3 class="about-title text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight">
                        Integrasi Sistem untuk<br>
                        <span class="text-gradient-blue">Efisiensi Bisnis</span>
                    </h3>
                    
                    <p class="text-lg text-slate-500 leading-relaxed font-inter">
                        SIMPA dirancang khusus untuk memenuhi kebutuhan pengawasan proyek di lingkungan 
                        <strong class="text-slate-700 font-bold">PT Surveyor Indonesia (Persero)</strong>. 
                        Melalui digitalisasi proses, kami memastikan transparansi data dan akurasi pelaporan di setiap level manajemen.
                    </p>
                    
                    <div class="space-y-3 pt-2">
                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-white hover:shadow-[0_8px_30px_rgba(0,73,150,0.08)] transition-all duration-300 border border-slate-100 hover:border-si-blue/20 group cursor-default">
                            <div class="mt-0.5 w-11 h-11 rounded-2xl bg-si-blue/8 flex items-center justify-center text-si-blue shrink-0 group-hover:bg-si-blue group-hover:text-white transition-all duration-300">
                                <i class="fas fa-shield-alt text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 mb-1">Standardisasi Audit Proyek (COBIT Framework)</h4>
                                <p class="text-sm text-slate-500">Memastikan tata kelola TI perusahaan berjalan sesuai framework internasional yang diakui.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-white hover:shadow-[0_8px_30px_rgba(255,184,0,0.08)] transition-all duration-300 border border-slate-100 hover:border-si-gold/30 group cursor-default">
                            <div class="mt-0.5 w-11 h-11 rounded-2xl bg-si-gold/10 flex items-center justify-center text-yellow-600 shrink-0 group-hover:bg-si-gold group-hover:text-white transition-all duration-300">
                                <i class="fas fa-chart-line text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 mb-1">Executive Dashboard Real-time</h4>
                                <p class="text-sm text-slate-500">Visualisasi data progres proyek secara langsung dengan grafik interaktif yang komprehensif.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-5 rounded-2xl bg-white hover:shadow-[0_8px_30px_rgba(16,185,129,0.08)] transition-all duration-300 border border-slate-100 hover:border-green-200 group cursor-default">
                            <div class="mt-0.5 w-11 h-11 rounded-2xl bg-green-50 flex items-center justify-center text-green-600 shrink-0 group-hover:bg-green-500 group-hover:text-white transition-all duration-300">
                                <i class="fas fa-database text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 mb-1">Pusat Data Terpusat & Aman</h4>
                                <p class="text-sm text-slate-500">Penyimpanan dokumen bukti pengerjaan yang tersentralisasi dengan akses berbasis peran.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SOLUTIONS / FEATURES SECTION ===== -->
    <section id="solutions" class="features-section py-16 sm:py-20 md:py-28 bg-white relative overflow-hidden">
        <!-- Subtle grid bg -->
        <div class="absolute inset-0 pointer-events-none" style="background-image: linear-gradient(rgba(0,73,150,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(0,73,150,0.03) 1px, transparent 1px); background-size: 50px 50px;"></div>
        
        <div class="container mx-auto px-4 sm:px-6 relative z-10">
            <div class="max-w-2xl mx-auto mb-20 text-center" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 mb-5">
                    <div class="section-divider"></div>
                    <h2 class="text-si-blue font-bold tracking-[0.15em] uppercase text-xs mx-3">Fitur Unggulan Platform</h2>
                    <div class="section-divider"></div>
                </div>
                <h3 class="features-title text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-5 leading-tight">Solusi Monitoring <span class="text-gradient-blue">Terpadu</span></h3>
                <p class="text-slate-500 text-lg font-inter">Semua yang Anda butuhkan untuk mengelola proyek IT dalam satu platform yang terintegrasi.</p>
            </div>
            
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5 sm:gap-8">
                <!-- Card 1 -->
                <div class="feature-card feature-card-p relative p-6 sm:p-9 bg-white border border-slate-100 rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.07)] hover:shadow-[0_25px_60px_-10px_rgba(0,73,150,0.14)] group overflow-hidden" 
                     data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-si-blue to-si-light transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-t-3xl"></div>
                    <div class="feature-number absolute top-5 right-5 text-[60px] sm:text-[80px] font-black text-slate-50 leading-none select-none group-hover:text-si-blue/5 transition-colors duration-500">01</div>
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-si-blue/8 to-si-blue/5 rounded-2xl flex items-center justify-center text-si-blue text-xl sm:text-2xl mb-5 sm:mb-8 group-hover:from-si-blue group-hover:to-si-light group-hover:text-white group-hover:shadow-lg group-hover:scale-110 transition-all duration-400 shadow-sm">
                        <i class="fas fa-gauge-high"></i>
                    </div>
                    <h4 class="text-lg sm:text-xl font-extrabold mb-3 text-slate-800">Pelacakan Real-time</h4>
                    <p class="text-slate-500 leading-relaxed text-sm">Dapatkan visualisasi data progres proyek secara instan untuk pengambilan keputusan yang lebih cepat melalui Dashboard Eksekutif yang komprehensif.</p>
                    <div class="mt-6 flex items-center gap-2 text-si-blue text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span>Lihat Fitur</span><i class="fas fa-arrow-right text-xs"></i>
                    </div>
                </div>
                
                <!-- Card 2 -->
                <div class="feature-card feature-card-p relative p-6 sm:p-9 bg-white border border-slate-100 rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.07)] hover:shadow-[0_25px_60px_-10px_rgba(255,184,0,0.14)] group overflow-hidden" 
                     data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-si-gold to-yellow-300 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-t-3xl"></div>
                    <div class="feature-number absolute top-5 right-5 text-[60px] sm:text-[80px] font-black text-slate-50 leading-none select-none group-hover:text-si-gold/10 transition-colors duration-500">02</div>
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-si-gold/10 to-si-gold/5 rounded-2xl flex items-center justify-center text-yellow-600 text-xl sm:text-2xl mb-5 sm:mb-8 group-hover:from-si-gold group-hover:to-yellow-400 group-hover:text-white group-hover:shadow-lg group-hover:scale-110 transition-all duration-400 shadow-sm">
                        <i class="fas fa-sliders"></i>
                    </div>
                    <h4 class="text-lg sm:text-xl font-extrabold mb-3 text-slate-800">Sistem Bobot Modul</h4>
                    <p class="text-slate-500 leading-relaxed text-sm">Perhitungan progres yang sangat akurat menggunakan rata-rata tertimbang (Weighted Average) berdasarkan tingkat kesulitan tiap fitur aplikasi.</p>
                    <div class="mt-6 flex items-center gap-2 text-si-gold text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span>Lihat Fitur</span><i class="fas fa-arrow-right text-xs"></i>
                    </div>
                </div>
                
                <!-- Card 3 -->
                <div class="feature-card feature-card-p relative p-6 sm:p-9 bg-white border border-slate-100 rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.07)] hover:shadow-[0_25px_60px_-10px_rgba(16,185,129,0.14)] group overflow-hidden" 
                     data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-green-400 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-t-3xl"></div>
                    <div class="feature-number absolute top-5 right-5 text-[60px] sm:text-[80px] font-black text-slate-50 leading-none select-none group-hover:text-green-50 transition-colors duration-500">03</div>
                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 text-xl sm:text-2xl mb-5 sm:mb-8 group-hover:from-emerald-500 group-hover:to-green-400 group-hover:text-white group-hover:shadow-lg group-hover:scale-110 transition-all duration-400 shadow-sm">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h4 class="text-lg sm:text-xl font-extrabold mb-3 text-slate-800">Laporan PDF Instan</h4>
                    <p class="text-slate-500 leading-relaxed text-sm">Ekspor ringkasan progres dan daftar aplikasi ke format PDF profesional siap cetak hanya dengan satu klik untuk keperluan audit.</p>
                    <div class="mt-6 flex items-center gap-2 text-emerald-600 text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span>Lihat Fitur</span><i class="fas fa-arrow-right text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Additional features row -->
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5 sm:gap-8 mt-5 sm:mt-8">
                <div class="feature-card relative p-9 bg-white border border-slate-100 rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.07)] hover:shadow-[0_25px_60px_-10px_rgba(139,92,246,0.14)] group overflow-hidden" 
                     data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-violet-500 to-purple-400 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-t-3xl"></div>
                    <div class="w-16 h-16 bg-violet-50 rounded-2xl flex items-center justify-center text-violet-600 text-2xl mb-8 group-hover:from-violet-500 group-hover:to-purple-400 group-hover:text-white group-hover:bg-gradient-to-br group-hover:shadow-lg transition-all duration-400">
                        <i class="fas fa-users-gear"></i>
                    </div>
                    <h4 class="text-xl font-extrabold mb-3 text-slate-800">Manajemen Pengguna</h4>
                    <p class="text-slate-500 leading-relaxed text-sm">Sistem role-based access control (RBAC) memastikan setiap pengguna hanya mengakses data sesuai wewenangnya.</p>
                </div>
                <div class="feature-card relative p-9 bg-white border border-slate-100 rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.07)] hover:shadow-[0_25px_60px_-10px_rgba(6,182,212,0.14)] group overflow-hidden" 
                     data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-500 to-sky-400 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-t-3xl"></div>
                    <div class="w-16 h-16 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 text-2xl mb-8 group-hover:from-cyan-500 group-hover:to-sky-400 group-hover:text-white group-hover:bg-gradient-to-br group-hover:shadow-lg transition-all duration-400">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4 class="text-xl font-extrabold mb-3 text-slate-800">Notulensi & Absensi</h4>
                    <p class="text-slate-500 leading-relaxed text-sm">Pencatatan notulensi rapat dan daftar hadir yang terintegrasi langsung dengan data proyek dan aplikasi terkait.</p>
                </div>
                <div class="feature-card relative p-9 bg-white border border-slate-100 rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.07)] hover:shadow-[0_25px_60px_-10px_rgba(249,115,22,0.14)] group overflow-hidden" 
                     data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 to-amber-400 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-t-3xl"></div>
                    <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 text-2xl mb-8 group-hover:from-orange-500 group-hover:to-amber-400 group-hover:text-white group-hover:bg-gradient-to-br group-hover:shadow-lg transition-all duration-400">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h4 class="text-xl font-extrabold mb-3 text-slate-800">Log Aktivitas</h4>
                    <p class="text-slate-500 leading-relaxed text-sm">Rekam jejak setiap perubahan data secara otomatis untuk keperluan audit trail dan keamanan sistem yang menyeluruh.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="cta-section relative py-16 sm:py-20 md:py-28 overflow-hidden bg-si-deeper">
        <!-- Background image subtle -->
        <div class="absolute inset-0 z-0">
            <img src="<?= base_url('images/landing.webp') ?>" alt="" class="w-full h-full object-cover opacity-10 mix-blend-luminosity">
            <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(0,29,62,0.97) 0%, rgba(0,73,150,0.90) 100%);"></div>
        </div>
        <div class="decorative-blob absolute -right-40 -top-40 w-[500px] h-[500px] bg-si-gold/10 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="decorative-blob absolute -left-40 -bottom-40 w-[400px] h-[400px] bg-si-blue/40 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute inset-0 dot-grid opacity-10 pointer-events-none"></div>
        
        <div class="container mx-auto px-4 sm:px-6 text-center text-white relative z-10" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full glass border border-white/10 mb-6 sm:mb-8">
                <span class="w-2 h-2 rounded-full bg-si-gold flex-shrink-0"></span>
                <span class="text-white text-xs font-bold tracking-[0.15em] uppercase">Mulai Sekarang</span>
            </div>
            <h2 class="cta-title text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-extrabold mb-4 sm:mb-6 max-w-3xl mx-auto leading-tight">
                Siap Meningkatkan<br>
                <span class="text-gradient-gold">Transparansi Monitoring</span><br>
                Proyek Anda?
            </h2>
            <p class="text-white/60 text-base sm:text-lg mb-8 sm:mb-12 max-w-xl mx-auto font-inter">
                Bergabunglah bersama tim PT Surveyor Indonesia dalam mengelola proyek lebih efisien dan terukur.
            </p>
            <div class="cta-buttons flex flex-col sm:flex-row flex-wrap justify-center gap-3 sm:gap-4">
                <a href="<?= base_url('login-page') ?>" 
                   class="btn-shimmer bg-gradient-to-r from-si-gold to-yellow-400 hover:from-yellow-400 hover:to-si-gold text-si-dark px-8 sm:px-12 py-4 sm:py-5 rounded-2xl font-black text-base sm:text-lg shadow-[0_10px_40px_rgba(255,184,0,0.4)] hover:shadow-[0_15px_50px_rgba(255,184,0,0.6)] hover:-translate-y-1.5 transition-all duration-300 uppercase tracking-wider glow-gold flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Akses SIMPA Sekarang
                </a>
                <a href="#about"
                   class="glass border border-white/20 text-white px-8 sm:px-10 py-4 sm:py-5 rounded-2xl font-bold text-base sm:text-lg hover:bg-white/10 hover:-translate-y-1.5 transition-all duration-300 flex items-center justify-center">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer id="contact" class="bg-si-deeper text-white pt-12 sm:pt-16 md:pt-20 pb-8 sm:pb-10 relative border-t-[3px] border-si-gold overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="decorative-blob absolute top-0 right-0 w-[400px] h-[400px] bg-si-blue/20 rounded-full blur-[100px] pointer-events-none"></div>
        
        <div class="container mx-auto px-4 sm:px-6 relative z-10">
            <div class="footer-grid grid sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-10 lg:gap-12 mb-10 sm:mb-16 pb-10 sm:pb-16 border-b border-white/8">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="<?= base_url('images/logo_si.png') ?>" alt="SI Logo" class="h-12 brightness-0 invert">
                    </div>
                    <p class="text-white/55 text-sm leading-relaxed mb-8 max-w-xs font-inter">
                        PT Surveyor Indonesia (Persero) adalah perusahaan pemberi jasa inspeksi dan konsultasi yang berkomitmen mewujudkan keunggulan dan daya saing nasional.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://www.instagram.com/surveyor.indonesia/" target="_blank" 
                           class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#E1306C] hover:border-[#E1306C] hover:-translate-y-1 transition-all duration-200 text-sm">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/pt-surveyor-indonesia/" target="_blank" 
                           class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#0077b5] hover:border-[#0077b5] hover:-translate-y-1 transition-all duration-200 text-sm">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.facebook.com/surveyor.indonesia/" target="_blank" 
                           class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#1877F2] hover:border-[#1877F2] hover:-translate-y-1 transition-all duration-200 text-sm">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.youtube.com/@surveyor_ID" target="_blank" 
                           class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#FF0000] hover:border-[#FF0000] hover:-translate-y-1 transition-all duration-200 text-sm">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://twitter.com/pt_surveyor" target="_blank" 
                           class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-black hover:border-black hover:-translate-y-1 transition-all duration-200" title="X (Twitter)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.738l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation links -->
                <div>
                    <h5 class="font-bold text-sm uppercase tracking-[0.15em] mb-6 text-white/70">Navigasi</h5>
                    <ul class="space-y-3 text-sm text-white/50 font-inter">
                        <li><a href="#" class="hover:text-si-gold transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-si-gold"></i> Beranda</a></li>
                        <li><a href="#about" class="hover:text-si-gold transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-si-gold"></i> Tentang SIMPA</a></li>
                        <li><a href="#solutions" class="hover:text-si-gold transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-si-gold"></i> Fitur Platform</a></li>
                        <li><a href="<?= base_url('login-page') ?>" class="hover:text-si-gold transition-colors duration-200 flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-si-gold"></i> Login Sistem</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h5 class="font-bold text-sm uppercase tracking-[0.15em] mb-6 text-white/70">Kontak Kami</h5>
                    <ul class="space-y-4 text-sm text-white/55 font-inter">
                        <li class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-si-gold/15 flex items-center justify-center text-si-gold shrink-0 mt-0.5">
                                <i class="fas fa-map-marker-alt text-xs"></i>
                            </div>
                            <div>
                                <strong class="text-white/80 block mb-0.5">Kantor Pusat</strong>
                                Graha Surveyor Indonesia<br>Jl. Gatot Subroto Kav. 56, Jakarta Selatan 12950
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-si-gold/15 flex items-center justify-center text-si-gold shrink-0">
                                <i class="fas fa-phone-alt text-xs"></i>
                            </div>
                            <div><strong class="text-white/80 mr-1">Phone:</strong> +62-21 526 5526</div>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-si-gold/15 flex items-center justify-center text-si-gold shrink-0">
                                <i class="fas fa-envelope text-xs"></i>
                            </div>
                            <div><strong class="text-white/80 mr-1">Email:</strong> humas@ptsi.co.id</div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center text-xs text-white/30 tracking-wider font-semibold gap-4">
                <p>&copy; 2026 PT SURVEYOR INDONESIA (PERSERO). All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-si-gold transition-colors duration-200">Privacy Policy</a>
                    <a href="#" class="hover:text-si-gold transition-colors duration-200">Disclaimer</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS Init
        AOS.init({ once: true, offset: 60, duration: 800 });

        // Mobile menu toggle
        const btn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            const icon = btn.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });

        // Animate progress bars on scroll
        const progressBars = document.querySelectorAll('.progress-fill');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    const targetWidth = bar.getAttribute('data-width');
                    setTimeout(() => { bar.style.width = targetWidth; }, 300);
                    observer.unobserve(bar);
                }
            });
        }, { threshold: 0.3 });
        progressBars.forEach(bar => observer.observe(bar));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const offset = 80;
                    const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                    // Close mobile menu if open
                    menu.classList.add('hidden');
                    btn.querySelector('i').classList.add('fa-bars');
                    btn.querySelector('i').classList.remove('fa-times');
                }
            });
        });

        // Nav active state on scroll
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (window.pageYOffset >= sectionTop) current = section.getAttribute('id');
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) link.classList.add('active');
            });
        });
    </script>
    
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('<?= base_url('sw.js') ?>').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
</body>
</html>
