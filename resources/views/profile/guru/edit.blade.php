@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-xl p-6 bg-white rounded-2xl shadow-lg mt-12" data-aos="fade-up"
        data-aos-duration="700">
        <h1 class="text-3xl font-extrabold mb-8 text-blue-700 text-center">Edit Profile</h1>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-5 py-3 rounded mb-6" data-aos="fade-in">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-5 py-3 rounded mb-6" data-aos="fade-in">
                <ul class="list-disc pl-6 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('POST')

            <div data-aos="fade-right" data-aos-delay="100">
                <label for="name" class="block font-semibold mb-2 text-gray-700">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div data-aos="fade-right" data-aos-delay="150">
                <label for="location" class="block font-semibold mb-2 text-gray-700">Lokasi</label>
                <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            @if ($user->role === 'guru' || $user->role === 'murid')
                <div data-aos="fade-right" data-aos-delay="200">
                    <label for="skill" class="block font-semibold mb-2 text-gray-700">
                        @if ($user->role === 'guru')
                            Keahlian (Skill)
                        @else
                            Bidang Pelatihan
                        @endif
                    </label>
                    <textarea name="skill" id="skill" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('skill', $user->skill) }}</textarea>
                </div>
            @endif

            <div data-aos="fade-left" data-aos-delay="250">
                <label class="block font-semibold mb-2 text-gray-700">Foto Profile</label>
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profile"
                        class="w-32 h-32 rounded-xl object-cover mb-3 shadow-md border border-gray-300">
                @endif
                <input type="file" name="photo" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div data-aos="fade-left" data-aos-delay="300">
                <label class="block font-semibold mb-2 text-gray-700">KTP / Kartu Pelajar</label>
                @if ($user->identity_card)
                    <img src="{{ asset('storage/' . $user->identity_card) }}" alt="Identity Card"
                        class="w-32 h-32 rounded-xl object-cover mb-3 shadow-md border border-gray-300">
                @endif
                <input type="file" name="identity_card" accept="image/*"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div data-aos="zoom-in" data-aos-delay="350" class="text-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-full transition duration-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
