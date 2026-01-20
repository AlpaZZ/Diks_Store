@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
<!-- Hero -->
<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Hubungi Kami</h1>
        <p class="lead">Kami siap membantu Anda kapanpun</p>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="row g-4">
                <!-- Contact Info -->
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Informasi Kontak</h4>
                            
                            <div class="d-flex mb-4">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-whatsapp text-success fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">WhatsApp</h6>
                                    <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none">
                                        +62 812-3456-7890
                                    </a>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-4">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-envelope text-primary fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Email</h6>
                                    <a href="mailto:support@diksstore.com" class="text-decoration-none">
                                        support@diksstore.com
                                    </a>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-4">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-instagram text-danger fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Instagram</h6>
                                    <a href="https://instagram.com/diksstore" target="_blank" class="text-decoration-none">
                                        @diksstore
                                    </a>
                                </div>
                            </div>
                            
                            <div class="d-flex">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-discord text-info fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Discord</h6>
                                    <a href="#" class="text-decoration-none">
                                        Diks Store Community
                                    </a>
                                </div>
                            </div>
                            
                            <hr class="my-4">
                            
                            <h6 class="mb-3">Jam Operasional</h6>
                            <p class="mb-1"><i class="bi bi-clock"></i> Senin - Jumat: 09:00 - 21:00</p>
                            <p class="mb-0"><i class="bi bi-clock"></i> Sabtu - Minggu: 10:00 - 18:00</p>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-4">Kirim Pesan</h4>
                            
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" placeholder="Nama Anda" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="email@example.com" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Subjek</label>
                                    <select class="form-select">
                                        <option>Pertanyaan Umum</option>
                                        <option>Bantuan Pembelian</option>
                                        <option>Komplain</option>
                                        <option>Kerjasama</option>
                                        <option>Lainnya</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label">Pesan</label>
                                    <textarea class="form-control" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-send"></i> Kirim Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ -->
            <div class="card border-0 shadow-sm mt-5">
                <div class="card-body p-5">
                    <h4 class="fw-bold mb-4 text-center">Pertanyaan yang Sering Diajukan</h4>
                    
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Bagaimana cara membeli akun di Diks Store?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Pilih produk yang diinginkan, klik "Beli Sekarang", pilih metode pembayaran, lalu lakukan pembayaran. 
                                    Setelah pembayaran dikonfirmasi, kredensial akun akan dikirimkan kepada Anda.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Apakah transaksi di Diks Store aman?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, semua transaksi di Diks Store dijamin aman. Kami melakukan verifikasi terhadap setiap akun 
                                    sebelum dijual dan memberikan garansi 1x24 jam untuk setiap pembelian.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Bagaimana jika ada masalah dengan akun yang dibeli?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Jika ada masalah dalam 1x24 jam setelah pembelian, segera hubungi kami melalui WhatsApp. 
                                    Tim kami akan membantu menyelesaikan masalah atau memberikan penggantian/refund.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Metode pembayaran apa saja yang tersedia?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Kami menerima pembayaran melalui Transfer Bank (BCA, BRI, BNI, Mandiri), E-Wallet (GoPay, OVO, DANA), 
                                    dan metode pembayaran lainnya. Detail akan diberikan saat checkout.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
