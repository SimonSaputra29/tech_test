@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-16 bg-white rounded-2xl shadow-lg p-10" data-aos="zoom-in" data-aos-duration="800">
        <h1 class="text-3xl font-extrabold text-blue-700 mb-6 text-center">🎓 Dashboard Murid</h1>
        <p class="text-center text-gray-600 mb-8 text-lg">Selamat datang! Silakan akses fitur-fitur yang tersedia:</p>

        <div class="flex flex-col gap-6 items-center">
            <a href="{{ route('requests.index') }}"
                class="w-full text-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-xl text-lg font-semibold shadow hover:shadow-md hover:from-blue-600 hover:to-blue-800 transition duration-300"
                data-aos="fade-up" data-aos-delay="100">
                📩 Lihat &amp; Buat Request ke Guru
            </a>

            {{-- Tambahkan fitur lainnya jika diperlukan --}}
            {{-- 
            <a href="#" class="w-full text-center px-6 py-3 bg-green-500 text-white rounded-xl text-lg font-semibold shadow hover:bg-green-600 transition duration-300" data-aos="fade-up" data-aos-delay="200">
                Fitur Lainnya
            </a> 
            --}}
        </div>
    </div>
@endsection
