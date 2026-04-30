<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPA | PT Surveyor Indonesia (Persero)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        si: {
                            blue: '#004996',
                            light: '#005bb5',
                            dark: '#003366',
                            gold: '#FFB800'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-clip {
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%);
        }
        .nav-glass {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
        }
        .animate-reveal {
            animation: reveal 0.8s ease-out forwards;
        }
        @keyframes reveal {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .si-border {
            border-bottom: 4px solid #FFB800;
        }
        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #ffffff, #e2e8f0);
        }
        .text-gradient-gold {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #FFB800, #FCD34D);
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased">

    <!-- Top Bar -->
    <div class="bg-si-dark text-white py-2 hidden md:block">
        <div class="container mx-auto px-6 flex justify-between items-center text-xs font-semibold tracking-wider">
            <div class="flex gap-6">
                <span><i class="fas fa-phone-alt mr-2 text-si-gold"></i> (021) 5265526</span>
                <span><i class="fas fa-envelope mr-2 text-si-gold"></i> humas@ptsi.co.id</span>
            </div>
            <div class="flex gap-4">
                <a href="#" class="hover:text-si-gold transition-colors">Career</a>
                <a href="#" class="hover:text-si-gold transition-colors">Contact</a>
                <a href="#" class="hover:text-si-gold transition-colors">ID</a>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="nav-glass sticky top-0 z-50 border-b border-slate-100 shadow-sm">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <img src="<?= base_url('images/logo_si.png') ?>" alt="Surveyor Indonesia" class="h-10 md:h-12 border-r pr-4 border-slate-200">
                <img src="<?= base_url('images/logo_simpa.png') ?>" alt="SIMPA" class="h-8 md:h-10">
            </div>
            
            <div class="hidden lg:flex items-center gap-8 text-sm font-bold uppercase tracking-wide">
                <a href="#" class="text-si-blue hover:text-si-light transition-colors">Beranda</a>
                <a href="#about" class="hover:text-si-blue transition-colors">Tentang SIMPA</a>
                <a href="#solutions" class="hover:text-si-blue transition-colors">Solusi</a>
                <a href="<?= base_url('login-page') ?>" class="bg-si-blue hover:bg-si-dark text-white px-8 py-3 rounded shadow-md transition-all">
                    Login Sistem
                </a>
            </div>
            
            <button class="lg:hidden text-si-blue text-2xl">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center overflow-hidden bg-si-dark">
        <div class="absolute inset-0 z-0">
            <img src="<?= base_url('images/landing.webp') ?>" alt="Industry Hero" class="w-full h-full object-cover opacity-40 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-r from-si-dark via-si-dark/80 to-transparent"></div>
        </div>
        
        <!-- Abstract Shapes -->
        <div class="absolute top-20 right-20 w-96 h-96 bg-si-light rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow"></div>
        <div class="absolute bottom-10 right-1/4 w-72 h-72 bg-si-gold rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse-slow" style="animation-delay: 2s;"></div>
        
        <div class="container mx-auto px-6 relative z-10 flex flex-col lg:flex-row items-center justify-between mt-10 pb-24 lg:pb-40">
            <div class="max-w-3xl animate-reveal lg:w-3/5" data-aos="fade-right" data-aos-duration="1000">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-6">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-white text-xs font-bold tracking-widest uppercase">SIMPA</span>
                </div>
                
                <h1 class="text-white text-5xl md:text-7xl font-outfit font-extrabold leading-[1.1] mb-6">
                    Sistem Manajemen Proyek Aplikasi<br><span class="text-gradient-gold">(SIMPA)</span>
                </h1>
                
                <p class="text-white/80 text-lg md:text-xl leading-relaxed mb-10 max-w-2xl font-light border-l-4 border-si-gold pl-6">
                    Integrasi pemantauan progres proyek dan manajemen aplikasi untuk mendukung keunggulan operasional <strong class="text-white">PT Surveyor Indonesia (Persero)</strong>.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="<?= base_url('login-page') ?>" class="bg-si-gold hover:bg-yellow-400 text-si-dark px-8 py-4 rounded-lg text-lg font-bold shadow-[0_0_20px_rgba(255,184,0,0.4)] hover:shadow-[0_0_30px_rgba(255,184,0,0.6)] hover:-translate-y-1 transition-all duration-300 flex items-center gap-3">
                        Masuk Dashboard <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#about" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-all duration-300 flex items-center gap-3 hover:-translate-y-1">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            
            <!-- Floating Hero Card -->
            <div class="hidden lg:block lg:w-2/5 animate-float" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="300">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-2xl shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-si-gold/40 to-transparent rounded-bl-full"></div>
                    
                    <div class="flex justify-between items-center mb-8 border-b border-white/10 pb-4">
                        <h3 class="text-white font-bold text-lg"><i class="fas fa-chart-pie mr-2 text-si-gold"></i> Live Status</h3>
                        <span class="text-xs font-mono bg-green-500/20 text-green-300 px-2 py-1 rounded">SYSTEM ONLINE</span>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between text-sm text-white/80 mb-2">
                                <span>Audit Kepatuhan</span>
                                <span class="font-bold text-white">98%</span>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-2">
                                <div class="bg-gradient-to-r from-si-light to-si-gold h-2 rounded-full" style="width: 98%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-sm text-white/80 mb-2">
                                <span>Akurasi Pelaporan</span>
                                <span class="font-bold text-white">100%</span>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-2">
                                <div class="bg-gradient-to-r from-si-light to-si-gold h-2 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex items-center gap-4 bg-black/20 p-4 rounded-xl border border-white/5">
                        <div class="w-12 h-12 bg-si-blue rounded-full flex items-center justify-center text-xl text-white shadow-inner">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">Protected by COBIT-19</p>
                            <p class="text-white/50 text-xs">Standardisasi Terjamin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Overlay -->
        <div class="absolute bottom-0 left-0 right-0 bg-white/10 backdrop-blur-md border-t border-white/20 py-8 hidden lg:block">
            <div class="container mx-auto px-6 grid grid-cols-4 gap-8">
                <div class="text-white border-r border-white/20 pr-8">
                    <div class="text-3xl font-bold text-si-gold">50+</div>
                    <div class="text-sm font-semibold uppercase tracking-widest opacity-80">Aktif Proyek</div>
                </div>
                <div class="text-white border-r border-white/20 pr-8">
                    <div class="text-3xl font-bold text-si-gold">100%</div>
                    <div class="text-sm font-semibold uppercase tracking-widest opacity-80">Audit Kepatuhan</div>
                </div>
                <div class="text-white border-r border-white/20 pr-8">
                    <div class="text-3xl font-bold text-si-gold">Real-time</div>
                    <div class="text-sm font-semibold uppercase tracking-widest opacity-80">Pelaporan Data</div>
                </div>
                <div class="text-white">
                    <div class="text-3xl font-bold text-si-gold">70+</div>
                    <div class="text-sm font-semibold uppercase tracking-widest opacity-80">Unit Kerja</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-slate-50 relative">
        <!-- Decorative bg -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <svg class="absolute right-0 top-1/2 opacity-[0.03] w-[800px] h-[800px] transform translate-x-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50"/></svg>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative" data-aos="zoom-in-right" data-aos-duration="1000">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl z-10 group">
                        <div class="absolute inset-0 bg-si-blue/20 group-hover:bg-transparent transition-all duration-500 z-10"></div>
                        <img src="<?= base_url('images/graha_si.jpg') ?>" alt="Graha Surveyor Indonesia" class="w-full h-auto transform group-hover:scale-105 transition-transform duration-700">
                    </div>
                    <!-- Decorative Elements -->
                    <div class="absolute -top-6 -left-6 w-32 h-32 bg-gradient-to-br from-si-blue to-si-light rounded-2xl -z-0 shadow-lg"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-gradient-to-tl from-si-gold to-yellow-300 rounded-full -z-0 shadow-lg"></div>
                    
                    <!-- Floating Stat Badge -->
                    <div class="absolute -right-10 top-1/4 bg-white p-4 rounded-xl shadow-xl z-20 flex items-center gap-4 animate-float border border-slate-100 hidden md:flex">
                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xl font-bold">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-slate-800">100%</p>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Akurasi Audit</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-6" data-aos="fade-left" data-aos-duration="1000">
                    <div class="inline-block">
                        <h2 class="text-si-blue font-bold tracking-widest uppercase text-sm border-b-2 border-si-gold pb-1">Tentang Solusi Digital</h2>
                    </div>
                    <h3 class="text-4xl md:text-5xl font-outfit font-extrabold text-slate-900 leading-tight">
                        Integrasi Sistem untuk Efisiensi Bisnis
                    </h3>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        SIMPA dirancang khusus untuk memenuhi kebutuhan pengawasan proyek di lingkungan PT Surveyor Indonesia (Persero). Melalui digitalisasi proses, kami memastikan transparansi data dan akurasi pelaporan di setiap level manajemen.
                    </p>
                    
                    <div class="pt-6">
                        <ul class="space-y-5">
                            <li class="flex items-start gap-4 p-4 rounded-lg hover:bg-white hover:shadow-md transition-all border border-transparent hover:border-slate-100">
                                <div class="mt-1 w-10 h-10 rounded-full bg-si-blue/10 flex items-center justify-center text-si-blue shrink-0">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 mb-1">Standardisasi Audit Proyek (COBIT-19)</h4>
                                    <p class="text-sm text-slate-500">Memastikan tata kelola TI perusahaan berjalan sesuai framework internasional.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4 p-4 rounded-lg hover:bg-white hover:shadow-md transition-all border border-transparent hover:border-slate-100">
                                <div class="mt-1 w-10 h-10 rounded-full bg-si-gold/20 flex items-center justify-center text-yellow-600 shrink-0">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 mb-1">Executive Dashboard Monitoring</h4>
                                    <p class="text-sm text-slate-500">Visualisasi data progres secara real-time dengan grafik interaktif.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4 p-4 rounded-lg hover:bg-white hover:shadow-md transition-all border border-transparent hover:border-slate-100">
                                <div class="mt-1 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                    <i class="fas fa-server"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 mb-1">Pusat Data Terpusat</h4>
                                    <p class="text-sm text-slate-500">Penyimpanan dokumen bukti pengerjaan yang tersentralisasi dan aman.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions -->
    <section id="solutions" class="py-24 bg-white relative">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto mb-20 text-center" data-aos="fade-up">
                <h2 class="text-si-blue font-bold tracking-widest uppercase text-sm mb-4">Fitur Utama Platform</h2>
                <h3 class="text-4xl font-outfit font-extrabold text-slate-900 mb-6">Solusi Monitoring Terpadu</h3>
                <div class="bg-gradient-to-r from-si-blue to-si-gold w-24 h-1.5 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="p-10 bg-white border border-slate-100 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.08)] hover:shadow-[0_20px_50px_-10px_rgba(0,73,150,0.15)] hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-si-blue to-si-light transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="w-16 h-16 bg-si-blue/5 rounded-2xl flex items-center justify-center text-si-blue text-3xl mb-8 group-hover:bg-gradient-to-br group-hover:from-si-blue group-hover:to-si-light group-hover:text-white group-hover:rotate-12 transition-all duration-300 shadow-sm">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">Pelacakan Real-time</h4>
                    <p class="text-slate-500 leading-relaxed">Dapatkan visualisasi data progres proyek secara instan untuk pengambilan keputusan yang lebih cepat melalui Dashboard Eksekutif.</p>
                </div>
                <!-- Card 2 -->
                <div class="p-10 bg-white border border-slate-100 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.08)] hover:shadow-[0_20px_50px_-10px_rgba(255,184,0,0.15)] hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-si-gold to-yellow-300 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="w-16 h-16 bg-si-gold/10 rounded-2xl flex items-center justify-center text-yellow-600 text-3xl mb-8 group-hover:bg-gradient-to-br group-hover:from-si-gold group-hover:to-yellow-400 group-hover:text-white group-hover:-rotate-12 transition-all duration-300 shadow-sm">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">Sistem Bobot Modul</h4>
                    <p class="text-slate-500 leading-relaxed">Perhitungan progres yang sangat akurat menggunakan rata-rata tertimbang (Weighted Average) berdasarkan tingkat kesulitan tiap fitur.</p>
                </div>
                <!-- Card 3 -->
                <div class="p-10 bg-white border border-slate-100 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.08)] hover:shadow-[0_20px_50px_-10px_rgba(16,185,129,0.15)] hover:-translate-y-2 transition-all duration-300 group relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-emerald-400 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                    <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 text-3xl mb-8 group-hover:bg-gradient-to-br group-hover:from-green-500 group-hover:to-emerald-400 group-hover:text-white group-hover:rotate-12 transition-all duration-300 shadow-sm">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4 text-slate-800">Laporan PDF Instan</h4>
                    <p class="text-slate-500 leading-relaxed">Ekspor ringkasan progres dan daftar aset ke format PDF profesional siap cetak hanya dengan satu klik untuk keperluan audit.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-si-blue relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        <div class="container mx-auto px-6 text-center text-white relative z-10">
            <h2 class="text-3xl md:text-5xl font-extrabold mb-8 max-w-4xl mx-auto leading-tight">
                Siap Meningkatkan Transparansi Monitoring Proyek Anda?
            </h2>
            <a href="<?= base_url('login-page') ?>" class="bg-si-gold hover:bg-white text-si-dark px-12 py-5 rounded-full font-bold text-xl shadow-2xl transition-all inline-block uppercase tracking-wider">
                Akses SIMPA Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-si-dark text-white pt-20 pb-10 relative border-t-4 border-si-gold">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 mb-16 border-b border-white/10 pb-16">
                <div class="border-r-0 lg:border-r border-white/10 lg:pr-12">
                    <img src="<?= base_url('images/logo_si.png') ?>" alt="SI Logo" class="h-14 mb-8 brightness-0 invert">
                    <p class="text-white/70 text-sm leading-relaxed mb-8 max-w-md">
                        PT Surveyor Indonesia (Persero) adalah perusahaan pemberi jasa konsultasi nirlaba yang didirikan sebagai bentuk komitmen untuk bangsa dalam mewujudkan keunggulan dan daya saing nasional.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="https://www.instagram.com/surveyor.indonesia/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#E1306C] hover:border-[#E1306C] hover:-translate-y-1 transition-all shadow-lg" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/pt-surveyor-indonesia/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#0077b5] hover:border-[#0077b5] hover:-translate-y-1 transition-all shadow-lg" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.facebook.com/surveyor.indonesia/" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#1877F2] hover:border-[#1877F2] hover:-translate-y-1 transition-all shadow-lg" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/@surveyor_ID" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#FF0000] hover:border-[#FF0000] hover:-translate-y-1 transition-all shadow-lg" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="https://twitter.com/pt_surveyor" target="_blank" class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#1DA1F2] hover:border-[#1DA1F2] hover:-translate-y-1 transition-all shadow-lg" title="Twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                
                <div class="lg:pl-8">
                    <h5 class="font-outfit font-bold text-xl mb-8 si-border inline-block pb-2">Kontak Kami</h5>
                    <ul class="space-y-6 text-sm text-white/70 leading-relaxed">
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-si-gold/20 flex items-center justify-center text-si-gold shrink-0 mt-1">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <strong class="text-white block mb-1">Kantor Pusat</strong>
                                Graha Surveyor Indonesia (Persero)<br>Jl. Gatot Subroto Kav. 56, Jakarta Selatan 12950
                            </div>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-si-gold/20 flex items-center justify-center text-si-gold shrink-0">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div><strong class="text-white mr-2">Phone:</strong> +62-21 526 5526</div>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-si-gold/20 flex items-center justify-center text-si-gold shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div><strong class="text-white mr-2">Email:</strong> humas@ptsi.co.id</div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center text-xs text-white/50 tracking-wider font-semibold">
                <p>&copy; 2026 PT SURVEYOR INDONESIA (PERSERO).</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-si-gold transition-colors">PRIVACY POLICY</a>
                    <a href="#" class="hover:text-si-gold transition-colors">DISCLAIMER</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
        });
    </script>
</body>
</html>
