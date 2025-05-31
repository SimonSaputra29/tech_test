@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-xl p-6">
        <h1 class="text-3xl font-bold mb-6">Edit Profile</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('POST')

            <div>
                <label for="name" class="block font-semibold mb-1">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label for="location" class="block font-semibold mb-1">Lokasi</label>
                <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            @if ($user->role === 'guru' || $user->role === 'murid')
                <div>
                    <label for="skill" class="block font-semibold mb-1">
                        @if ($user->role === 'guru')
                            Keahlian (Skill)
                        @else
                            Bidang Pelatihan
                        @endif
                    </label>
                    <textarea name="skill" id="skill" rows="3" class="w-full border rounded px-3 py-2">{{ old('skill', $user->skill) }}</textarea>
                </div>
            @endif

            <div>
                <label class="block font-semibold mb-1">Foto Profile</label>
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profile"
                        class="w-32 h-32 rounded object-cover mb-2">
                @endif
                <input type="file" name="photo" accept="image/*" class="w-full">
            </div>

            <div>
                <label class="block font-semibold mb-1">KTP / Kartu Pelajar</label>
                @if ($user->identity_card)
                    <img src="{{ asset('storage/' . $user->identity_card) }}" alt="Identity Card"
                        class="w-32 h-32 rounded object-cover mb-2">
                @endif
                <input type="file" name="identity_card" accept="image/*" class="w-full">
            </div>

            <div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
