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
                <h1 class="text-3xl font-bold text-blue-700">Daftar Akun EduMatch</h1>
                <p class="text-gray-600 text-sm">Gabung sebagai Guru atau Murid</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block font-medium mb-1 text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nama kamu" required autofocus>
                </div>

                <div>
                    <label for="email" class="block font-medium mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="contoh@edumatch.sch.id" required>
                </div>

                <div>
                    <label for="role" class="block font-medium mb-1 text-gray-700">Role</label>
                    <select name="role" id="role"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="murid" {{ old('role') == 'murid' ? 'selected' : '' }}>Murid</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block font-medium mb-1 text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="••••••••" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block font-medium mb-1 text-gray-700">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="••••••••" required>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition duration-300 shadow-sm">
                        Daftar
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login di sini</a>
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
                title: 'Gagal Daftar',
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
