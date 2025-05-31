@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-12 bg-white rounded-xl shadow-lg p-8" data-aos="zoom-in">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-3">Tambah Jadwal Baru</h1>
        <p class="mb-6 text-gray-600 text-sm">
            Buat jadwal pertemuan untuk request dari <span
                class="font-semibold text-blue-600">{{ $requestModel->murid->name ?? '-' }}</span>
        </p>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded" data-aos="fade-right">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('guru.requests.schedule.store', $requestModel->id) }}" method="POST" data-aos="fade-up"
            data-aos-delay="100">
            @csrf

            {{-- Tanggal --}}
            <div class="mb-5">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pertemuan</label>
                <input type="date" id="date" name="date" value="{{ old('date') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required min="{{ now()->toDateString() }}">
            </div>

            {{-- Waktu --}}
            <div class="mb-6">
                <label for="time" class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                <input type="time" id="time" name="time" value="{{ old('time') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-start gap-3 mt-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow transition duration-200">
                    Simpan Jadwal
                </button>
                <a href="{{ url()->previous() }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg font-semibold transition duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
