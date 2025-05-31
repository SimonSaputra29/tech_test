@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl p-8 mt-10" data-aos="fade-up">
        <div class="flex flex-col items-center gap-6">
            {{-- Foto Profil --}}
            <div data-aos="zoom-in">
                @if ($admin->photo)
                    <img src="{{ asset('storage/' . $admin->photo) }}" alt="Profile Photo"
                        class="w-32 h-32 rounded-full object-cover shadow-md border-4 border-blue-200">
                @else
                    <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 shadow-md">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14c4.418 0 8 1.79 8 4v2H4v-2c0-2.21 3.582-4 8-4zm0-4a4 4 0 110-8 4 4 0 010 8z" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Info admin --}}
            <div class="text-center space-y-1" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-blue-700">{{ $admin->name }}</h2>
                <p class="text-sm text-gray-500">{{ $admin->email }}</p>

                <div class="flex justify-center items-center gap-2 text-gray-600 mt-2">
                    @if ($admin->location)
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            <circle cx="12" cy="9" r="2.5" />
                        </svg>
                        <span>{{ $admin->location }}</span>
                    @else
                        <span class="italic text-gray-400">Lokasi belum diisi</span>
                    @endif
                </div>

                @if ($admin->role)
                    <span
                        class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs uppercase tracking-widest shadow-sm">
                        {{ $admin->role }}
                    </span>
                @endif

                @if ($admin->skill)
                    <div class="mt-3 text-gray-700">
                        <span class="font-medium">Skill/Bidang:</span>
                        <span>{{ $admin->skill }}</span>
                    </div>
                @endif

                @if ($admin->identity_card)
                    <div class="mt-3">
                        <span class="font-medium text-gray-700">Kartu Identitas:</span>
                        <a href="{{ asset('storage/' . $admin->identity_card) }}" target="_blank"
                            class="text-blue-600 hover:underline ml-1">📎 Lihat File</a>
                    </div>
                @endif
            </div>

            {{-- Tombol Edit --}}
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.profile.edit') }}"
                        class="mt-6 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-full shadow transition duration-200"
                        data-aos="fade-up" data-aos-delay="200">
                        ✏️ Edit Profil
                    </a>
                @endif
            @endauth
        </div>

        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="mt-6 text-green-700 bg-green-50 border border-green-200 px-4 py-3 rounded shadow-sm"
                data-aos="fade-in">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection
