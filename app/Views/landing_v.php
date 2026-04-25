<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPA | PT Surveyor Indonesia (Persero)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
    <section class="relative h-[85vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="<?= base_url('images/landing.webp') ?>" alt="Industry Hero" class="w-full h-full object-cover brightness-50">
        </div>
        
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-3xl animate-reveal">
                <div class="bg-si-gold w-20 h-1 mb-6"></div>
                <h1 class="text-white text-5xl md:text-7xl font-extrabold leading-tight mb-8">
                    Your Trusted Partner In <span class="text-si-gold">Assurance</span>
                </h1>
                <p class="text-white/90 text-xl md:text-2xl leading-relaxed mb-10 max-w-2xl font-light">
                    SIMPA Enterprise: Integrasi pemantauan progres proyek dan manajemen aset untuk mendukung keunggulan operasional PT Surveyor Indonesia (Persero).
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="<?= base_url('login-page') ?>" class="bg-si-blue hover:bg-si-dark text-white px-10 py-4 rounded text-lg font-bold shadow-xl transition-all flex items-center gap-3">
                        Masuk Dashboard <i class="fas fa-chevron-right text-sm"></i>
                    </a>
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
    <section id="about" class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Office Work" class="rounded-lg shadow-2xl relative z-10">
                    <div class="absolute -top-6 -left-6 w-32 h-32 bg-si-blue rounded-lg -z-0"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-si-gold rounded-lg -z-0"></div>
                </div>
                <div class="space-y-6">
                    <h2 class="text-si-blue font-bold tracking-widest uppercase text-sm">Tentang Solusi Digital</h2>
                    <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight">
                        Integrasi Sistem untuk Efisiensi Bisnis
                    </h3>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        SIMPA dirancang khusus untuk memenuhi kebutuhan pengawasan proyek di lingkungan PT Surveyor Indonesia (Persero). Melalui digitalisasi proses, kami memastikan transparansi data dan akurasi pelaporan di setiap level manajemen.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 text-slate-700">
                            <i class="fas fa-check-circle text-si-blue text-xl"></i>
                            <span class="font-medium font-semibold italic">Standardisasi Audit Proyek (COBIT-19)</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-700">
                            <i class="fas fa-check-circle text-si-blue text-xl"></i>
                            <span class="font-medium font-semibold italic">Monitoring Visual Melalui Executive Dashboard</span>
                        </li>
                        <li class="flex items-center gap-3 text-slate-700">
                            <i class="fas fa-check-circle text-si-blue text-xl"></i>
                            <span class="font-medium font-semibold italic">Penyimpanan Dokumen Terpusat & Aman</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions -->
    <section id="solutions" class="py-24 bg-white">
        <div class="container mx-auto px-6 text-center">
            <div class="max-w-2xl mx-auto mb-20 text-center">
                <h2 class="text-si-blue font-bold tracking-widest uppercase text-sm mb-4">Fitur Utama Platform</h2>
                <h3 class="text-4xl font-extrabold text-slate-900 mb-6">Solusi Monitoring Terpadu</h3>
                <div class="bg-si-gold w-20 h-1 mx-auto"></div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="p-10 bg-white border border-slate-100 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all group">
                    <div class="w-16 h-16 bg-si-blue/5 rounded-full flex items-center justify-center text-si-blue text-3xl mb-8 mx-auto group-hover:bg-si-blue group-hover:text-white transition-all">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">Pelacakan Real-time</h4>
                    <p class="text-slate-500 leading-relaxed">Dapatkan visualisasi data progres proyek secara instan untuk pengambilan keputusan yang lebih cepat.</p>
                </div>
                <!-- Card 2 -->
                <div class="p-10 bg-white border border-slate-100 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all group">
                    <div class="w-16 h-16 bg-si-blue/5 rounded-full flex items-center justify-center text-si-blue text-3xl mb-8 mx-auto group-hover:bg-si-blue group-hover:text-white transition-all">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">Manajemen Tugas</h4>
                    <p class="text-slate-500 leading-relaxed">Atur jadwal, tetapkan PIC, dan pantau penyelesaian setiap audit poin secara mendetail.</p>
                </div>
                <!-- Card 3 -->
                <div class="p-10 bg-white border border-slate-100 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all group">
                    <div class="w-16 h-16 bg-si-blue/5 rounded-full flex items-center justify-center text-si-blue text-3xl mb-8 mx-auto group-hover:bg-si-blue group-hover:text-white transition-all">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h4 class="text-2xl font-bold mb-4">Laporan PDF Instan</h4>
                    <p class="text-slate-500 leading-relaxed">Ekspor ringkasan progres dan audit ke format PDF profesional siap cetak hanya dengan satu klik.</p>
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
    <footer class="bg-si-dark text-white pt-20 pb-10">
        <div class="container mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-12 mb-16 border-b border-white/10 pb-16">
                <div class="border-r border-white/10 pr-12">
                    <img src="<?= base_url('images/logo_si.png') ?>" alt="SI Logo" class="h-14 mb-8 brightness-0 invert">
                    <p class="text-white/60 text-sm leading-relaxed mb-6">
                        PT Surveyor Indonesia adalah perusahaan pemberi jasa konsultasi nirlaba yang didirikan sebagai bentuk komitmen untuk bangsa.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://www.instagram.com/surveyor.indonesia/" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-[#E1306C] hover:border-[#E1306C] transition-all" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/pt-surveyor-indonesia/" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-[#0077b5] hover:border-[#0077b5] transition-all" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.facebook.com/surveyor.indonesia/" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-[#1877F2] hover:border-[#1877F2] transition-all" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/@surveyor_ID" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-[#FF0000] hover:border-[#FF0000] transition-all" title="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="https://twitter.com/pt_surveyor" target="_blank" class="w-10 h-10 rounded-full border border-white/20 flex items-center justify-center hover:bg-[#1DA1F2] hover:border-[#1DA1F2] transition-all" title="Twitter"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                
                <div>
                    <h5 class="font-bold text-lg mb-8 si-border inline-block pb-2">Kontak Kami</h5>
                    <ul class="space-y-4 text-sm text-white/60 leading-relaxed">
                        <li><i class="fas fa-map-marker-alt mr-3 text-si-gold"></i> Graha Surveyor Indonesia (Persero), Jl. Gatot Subroto Kav. 56, Jakarta Selatan</li>
                        <li><i class="fas fa-phone-alt mr-3 text-si-gold"></i> +62-21 526 5526</li>
                        <li><i class="fas fa-envelope mr-3 text-si-gold"></i> humas@ptsi.co.id</li>
                    </ul>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row justify-between items-center text-xs text-white/40 tracking-wider text-uppercase">
                <p>&copy; 2026 PT SURVEYOR INDONESIA. ALL RIGHTS RESERVED.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">PRIVACY POLICY</a>
                    <a href="#" class="hover:text-white transition-colors">DISCLAIMER</a>
                    <a href="#" class="hover:text-white transition-colors">CREDITS</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
