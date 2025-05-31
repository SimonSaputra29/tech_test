@extends('layouts.app')

@section('styles')
    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0f2fe, #f0f9ff);
        }
    </style>
@endsection

@section('content')
    <div class="flex justify-center items-center min-h-screen px-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8" data-aos="fade-up">
            <div class="text-center mb-6">
                <img src="{{ asset('images/edumatch.png') }}" alt="EduMatch Logo" class="mx-auto h-16 mb-2">
                <h1 class="text-3xl font-bold text-blue-700">Selamat Datang di EduMatch</h1>
                <p class="text-gray-600 text-sm">Platform pembelajaran terbaik untuk siswa dan guru</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block font-medium mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="contoh@edumatch.sch.id" required autofocus>
                </div>

                <div>
                    <label for="password" class="block font-medium mb-1 text-gray-700">Kata Sandi</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="••••••••" required>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition duration-300 shadow-sm">
                        Masuk ke Akun
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal Login',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#2563eb'
            })
        </script>
    @endif

    {{-- AOS --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endsection
