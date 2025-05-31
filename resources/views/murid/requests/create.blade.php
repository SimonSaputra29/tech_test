@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto mt-12 bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-duration="700">
        <h1 class="text-3xl font-extrabold text-center text-blue-700 mb-8">✉️ Buat Request ke Guru</h1>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 text-red-800 px-4 py-3 rounded-lg shadow-sm" data-aos="fade-down">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('requests.store') }}" method="POST">
            @csrf

            {{-- Pilih Guru --}}
            <div class="mb-8" data-aos="zoom-in-up" data-aos-delay="100">
                <label class="block text-lg font-semibold mb-4 text-gray-700">👨‍🏫 Pilih Guru</label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach ($gurus as $guru)
                        <label for="guru_{{ $guru->id }}"
                            class="group cursor-pointer border p-4 rounded-xl shadow-sm hover:shadow-md transition-all duration-200
                                   @if (old('guru_id') == $guru->id) border-blue-600 ring-2 ring-blue-300 @else border-gray-200 @endif">
                            <div class="flex items-start gap-3">
                                <input type="radio" name="guru_id" id="guru_{{ $guru->id }}"
                                    value="{{ $guru->id }}"
                                    class="mt-1 h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300"
                                    @checked(old('guru_id') == $guru->id) required>

                                <div>
                                    <div class="font-semibold text-lg text-gray-800">{{ $guru->name }}</div>
                                    <div class="text-sm text-gray-500 italic">
                                        {{ $guru->skill ?? 'Keahlian belum diisi' }}
                                    </div>
                                    <a href="{{ route('guru.show', $guru->id) }}" target="_blank"
                                        class="text-indigo-600 hover:underline text-xs mt-1 block">
                                        🔎 Lihat Profil
                                    </a>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Aksi --}}
            <div class="flex justify-between gap-4 mt-8" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ url()->previous() }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-semibold transition duration-200">
                    Batal
                </a>

                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold text-sm shadow-md hover:from-blue-700 hover:to-blue-800 transition duration-300">
                    🚀 Kirim Request
                </button>
            </div>
        </form>
    </div>
@endsection
