@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <div class="relative bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block">Kesehatan Anda</span>
                    <span class="block text-blue-600">Prioritas Kami</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Memberikan pelayanan kesehatan terbaik dengan didukung oleh tim dokter profesional dan fasilitas modern.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="/appointments/create" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                            Buat Janji
                        </a>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <a href="/services" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            Layanan Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Services Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Layanan Unggulan
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Memberikan perawatan terbaik untuk setiap kebutuhan kesehatan Anda
                </p>
            </div>
            <div class="mt-12 grid gap-8 grid-cols-1 md:grid-cols-3">
                <!-- Service 1 -->
                <div class="flex flex-col bg-white rounded-lg shadow overflow-hidden">
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <div class="text-blue-600 text-4xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Pemeriksaan Umum</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Layanan pemeriksaan kesehatan dasar untuk mendiagnosa dan menangani berbagai penyakit umum.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50">
                        <a href="/services/general" class="text-base font-medium text-blue-600 hover:text-blue-500">
                            Selengkapnya <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="flex flex-col bg-white rounded-lg shadow overflow-hidden">
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <div class="text-blue-600 text-4xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Spesialis Jantung</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Layanan kesehatan jantung oleh dokter spesialis dengan pengalaman dan teknologi terkini.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50">
                        <a href="/services/cardiology" class="text-base font-medium text-blue-600 hover:text-blue-500">
                            Selengkapnya <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="flex flex-col bg-white rounded-lg shadow overflow-hidden">
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <div class="text-blue-600 text-4xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Laboratorium</h3>
                            <p class="mt-3 text-base text-gray-500">
                                Layanan pemeriksaan laboratorium lengkap dengan hasil yang cepat dan akurat.
                            </p>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50">
                        <a href="/services/laboratory" class="text-base font-medium text-blue-600 hover:text-blue-500">
                            Selengkapnya <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctors Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Dokter Kami
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Didukung oleh dokter terbaik di bidangnya
                </p>
            </div>
            <div class="mt-12 grid gap-8 grid-cols-1 md:grid-cols-3">
                <!-- Doctor 1 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="/api/placeholder/300/200" alt="placeholder">
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">dr. Budi Santoso, Sp.PD</h3>
                            <p class="mt-1 text-base text-blue-600">Spesialis Penyakit Dalam</p>
                            <p class="mt-3 text-base text-gray-500">
                                Menyelesaikan pendidikan di Universitas Indonesia dengan pengalaman lebih dari 15 tahun.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="/doctors/budi-santoso" class="text-base font-medium text-blue-600 hover:text-blue-500">
                                Lihat Profil <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Doctor 2 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="/api/placeholder/300/200" alt="placeholder">
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">dr. Siti Rahayu, Sp.A</h3>
                            <p class="mt-1 text-base text-blue-600">Spesialis Anak</p>
                            <p class="mt-3 text-base text-gray-500">
                                Lulusan terbaik Universitas Gadjah Mada dengan pengalaman menangani berbagai kasus pediatri.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="/doctors/siti-rahayu" class="text-base font-medium text-blue-600 hover:text-blue-500">
                                Lihat Profil <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Doctor 3 -->
                <div class="flex flex-col bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex-shrink-0">
                        <img class="h-48 w-full object-cover" src="/api/placeholder/300/200" alt="placeholder">
                    </div>
                    <div class="flex-1 p-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">dr. Andi Wijaya, Sp.JP</h3>
                            <p class="mt-1 text-base text-blue-600">Spesialis Jantung</p>
                            <p class="mt-3 text-base text-gray-500">
                                Dokter spesialis jantung dengan pengalaman internasional dan keahlian dalam tindakan intervensi.
                            </p>
                        </div>
                        <div class="mt-6">
                            <a href="/doctors/andi-wijaya" class="text-base font-medium text-blue-600 hover:text-blue-500">
                                Lihat Profil <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10 text-center">
                <a href="/doctors" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Lihat Semua Dokter
                </a>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Testimoni Pasien
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Apa kata mereka tentang pelayanan kami
                </p>
            </div>
            <div class="mt-12 grid gap-8 grid-cols-1 md:grid-cols-3">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                            </svg>
                        </div>
                        <p class="ml-4 text-base text-gray-500">
                            Pelayanan di rumah sakit ini sangat memuaskan. Para dokter dan perawat sangat profesional dan ramah. Saya merasa nyaman selama perawatan di sini.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="/api/placeholder/40/40" alt="placeholder">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                Ahmad Rizal
                            </p>
                            <p class="text-sm text-gray-500">
                                Pasien Rawat Inap
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                            </svg>
                        </div>
                        <p class="ml-4 text-base text-gray-500">
                            Proses pendaftaran online sangat memudahkan pasien. Dokter yang menangani saya sangat kompeten dan menjelaskan kondisi dengan detail dan mudah dipahami.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="/api/placeholder/40/40" alt="placeholder">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                Dewi Anggraini
                            </p>
                            <p class="text-sm text-gray-500">
                                Pasien Poli Umum
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                            </svg>
                        </div>
                        <p class="ml-4 text-base text-gray-500">
                            Fasilitas rumah sakit sangat modern dan bersih. Saya puas dengan pelayanan dan terapi yang diberikan. Terima kasih kepada seluruh staf yang telah merawat saya.
                        </p>
                    </div>
                    <div class="mt-6 flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="/api/placeholder/40/40" alt="placeholder">
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                Budi Hartono
                            </p>
                            <p class="text-sm text-gray-500">
                                Pasien Fisioterapi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Butuh bantuan medis?</span>
                <span class="block text-blue-200">Hubungi kami sekarang juga.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="/contact" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                        Hubungi Kami
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="/appointments/create" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500">
                        Buat Janji
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection