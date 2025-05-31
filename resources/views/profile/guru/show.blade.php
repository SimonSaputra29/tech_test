@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-lg p-10 mt-12" data-aos="fade-up" data-aos-duration="800">
        <div class="flex flex-col items-center text-center gap-6">
            {{-- Foto Profil --}}
            <div data-aos="zoom-in" data-aos-delay="200">
                @if ($guru->photo)
                    <img src="{{ asset('storage/' . $guru->photo) }}" alt="Profile Photo"
                        class="w-36 h-36 rounded-full object-cover border-4 border-blue-500 shadow-xl">
                @else
                    <div class="w-36 h-36 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 shadow-xl">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14c4.418 0 8 1.79 8 4v2H4v-2c0-2.21 3.582-4 8-4zm0-4a4 4 0 110-8 4 4 0 010 8z" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Informasi Guru --}}
            <div>
                <h2 class="text-3xl font-extrabold text-blue-700">{{ $guru->name }}</h2>
                <p class="text-sm text-gray-600">{{ $guru->email }}</p>

                @if ($guru->location)
                    <div class="flex items-center justify-center gap-1 text-gray-500 mt-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"></path>
                            <circle cx="12" cy="9" r="2.5" />
                        </svg>
                        <span>{{ $guru->location }}</span>
                    </div>
                @endif

                @if ($guru->role)
                    <span
                        class="inline-block mt-3 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider">
                        {{ $guru->role }}
                    </span>
                @endif

                @if ($guru->skill)
                    <div class="mt-3 text-gray-700">
                        <span class="font-medium">Skill/Bidang:</span>
                        {{ $guru->skill }}
                    </div>
                @endif

                @if ($guru->identity_card)
                    <div class="mt-3">
                        <span class="font-medium text-gray-700">Kartu Identitas:</span>
                        <a href="{{ asset('storage/' . $guru->identity_card) }}" class="text-blue-600 hover:underline ml-1"
                            target="_blank">Lihat File</a>
                    </div>
                @endif
            </div>

            {{-- Tombol Edit --}}
            @auth
                @if (auth()->user()->role === 'guru')
                    <a href="{{ route('guru.profile.edit') }}"
                        class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-full transition duration-300"
                        data-aos="fade-up" data-aos-delay="400">
                        Edit Profil
                    </a>
                @endif
            @endauth
        </div>

        {{-- Pesan Sukses --}}
        @if (session('success'))
            <div class="mt-6 text-green-700 bg-green-100 border border-green-200 px-4 py-3 rounded" data-aos="fade-in"
                data-aos-delay="500">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection
