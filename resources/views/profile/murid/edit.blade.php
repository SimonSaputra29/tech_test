@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-2xl px-6 py-10" data-aos="fade-up">
        <h1 class="text-4xl font-bold text-center text-blue-700 mb-8">Edit Profil</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" data-aos="fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" data-aos="fade-in">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('murid.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('POST')

            {{-- Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                    required>
            </div>

            {{-- Lokasi --}}
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">
            </div>

            {{-- Skill/Bidang --}}
            @if ($user->role === 'guru' || $user->role === 'murid')
                <div>
                    <label for="skill" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ $user->role === 'guru' ? 'Keahlian (Skill)' : 'Bidang Pelatihan' }}
                    </label>
                    <textarea name="skill" id="skill" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200">{{ old('skill', $user->skill) }}</textarea>
                </div>
            @endif

            {{-- Foto Profile --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil"
                        class="w-28 h-28 object-cover rounded-full shadow mb-3" data-aos="zoom-in">
                @endif
                <input type="file" name="photo" accept="image/*"
                    class="w-full file:mt-2 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:px-4 file:py-2 hover:file:bg-blue-700">
            </div>

            {{-- Identity Card --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">KTP / Kartu Pelajar</label>
                @if ($user->identity_card)
                    <img src="{{ asset('storage/' . $user->identity_card) }}" alt="Identity Card"
                        class="w-28 h-28 object-cover rounded shadow mb-3" data-aos="zoom-in">
                @endif
                <input type="file" name="identity_card" accept="image/*"
                    class="w-full file:mt-2 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white file:px-4 file:py-2 hover:file:bg-blue-700">
            </div>

            {{-- Submit Button --}}
            <div class="text-center">
                <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-2 rounded-lg transition-all duration-300 shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
