<style>
    .hover\:shadow-lg:hover {
        transform: scale(1.05);
    }
</style>

@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto mt-16 bg-gradient-to-br from-white via-blue-50 to-blue-100 rounded-2xl shadow-xl p-10"
        data-aos="fade-up" data-aos-duration="1000">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-blue-700 mb-3">Dashboard Guru</h1>
            <p class="text-gray-600 text-lg mb-6">Selamat datang, Guru! Silakan cek permintaan dari murid Anda.</p>
        </div>

        <div class="flex justify-center mt-6" data-aos="zoom-in" data-aos-delay="300">
            <a href="{{ route('requests.index') }}"
                class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-full text-lg font-medium transition-all duration-300 shadow-md hover:shadow-lg">
                📋 Lihat Daftar Request
            </a>
        </div>
    </div>
@endsection
