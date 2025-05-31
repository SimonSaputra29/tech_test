@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white shadow-xl rounded-xl p-8 max-w-5xl mx-auto" data-aos="fade-up" data-aos-duration="800"
            data-aos-easing="ease-in-out">
            <h1 class="text-4xl font-extrabold mb-6 text-gray-900 tracking-wide">
                Dashboard Admin
            </h1>
            <p class="text-lg text-gray-700 mb-12 max-w-3xl leading-relaxed">
                Selamat datang, Admin! Kelola aktivitas pengguna dengan mudah melalui panel ini.
            </p>

            <div class="flex flex-col sm:flex-row gap-8">
                <!-- Card Chat Management -->
                <div class="flex-1 bg-gradient-to-tr from-blue-100 via-blue-200 to-blue-100 border border-blue-300 rounded-2xl p-6 shadow-lg cursor-pointer transform transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-2xl"
                    data-aos="zoom-in" data-aos-delay="100" @mouseenter="hoverChat = true" @mouseleave="hoverChat = false"
                    id="card-chat">
                    <h2 class="text-2xl font-bold mb-3 text-blue-800">Kelola Chat Pengguna</h2>
                    <p class="text-blue-700 mb-6">
                        Lihat dan pantau semua percakapan antara guru dan murid.
                    </p>
                    <a href="{{ route('admin.chats.index') }}"
                        class="inline-block bg-blue-600 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-blue-700 transition-colors duration-300">
                        Buka Kelola Chat
                    </a>
                </div>

                <!-- Card User Management -->
                <div class="flex-1 bg-gradient-to-tr from-green-100 via-green-200 to-green-100 border border-green-300 rounded-2xl p-6 shadow-lg cursor-pointer transform transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-2xl"
                    data-aos="zoom-in" data-aos-delay="300" id="card-user">
                    <h2 class="text-2xl font-bold mb-3 text-green-800">Kelola Pengguna</h2>
                    <p class="text-green-700 mb-6">
                        Tambahkan, edit, atau hapus pengguna aplikasi.
                    </p>
                    <a href="{{ route('admin.pengguna.index') }}"
                        class="inline-block bg-green-600 text-white font-semibold px-6 py-3 rounded-full shadow-md hover:bg-green-700 transition-colors duration-300">
                        Buka Kelola Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Bisa kamu tambahkan JS tambahan kalau mau efek khusus
            // Misal highlight kartu saat hover
            const cardChat = document.getElementById('card-chat');
            const cardUser = document.getElementById('card-user');

            cardChat.addEventListener('mouseenter', () => {
                cardChat.classList.add('ring', 'ring-blue-400');
            });
            cardChat.addEventListener('mouseleave', () => {
                cardChat.classList.remove('ring', 'ring-blue-400');
            });

            cardUser.addEventListener('mouseenter', () => {
                cardUser.classList.add('ring', 'ring-green-400');
            });
            cardUser.addEventListener('mouseleave', () => {
                cardUser.classList.remove('ring', 'ring-green-400');
            });
        });
    </script>
@endsection
