@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-8" data-aos="fade-up">
        {{-- Tombol Kembali --}}
        <a href="/guru/requests"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 hover:text-gray-900 transition duration-200 shadow-sm mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        {{-- Judul --}}
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">
            Jadwal Request dari <span class="text-blue-600">{{ $requestModel->murid->name ?? '-' }}</span>
        </h1>
        <p class="mb-6 text-gray-500">Daftar jadwal sesi yang telah ditentukan:</p>

        {{-- Tombol Tambah Jadwal --}}
        <a href="{{ route('guru.requests.schedule.create', $requestModel->id) }}"
            class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded-lg transition mb-6"
            data-aos="fade-right">
            + Tambah Jadwal
        </a>

        {{-- Daftar Jadwal --}}
        @if ($schedules->count())
            <div class="space-y-4" data-aos="fade-up" data-aos-delay="100">
                @foreach ($schedules as $schedule)
                    <div
                        class="flex items-center justify-between bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                        <div>
                            <p class="text-gray-800 font-semibold text-lg">
                                {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('d F Y') }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                Jam: {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}
                            </p>
                        </div>
                        <form action="{{ route('guru.requests.schedule.destroy', [$requestModel->id, $schedule->id]) }}"
                            method="POST" onsubmit="return confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm rounded-lg transition shadow">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-6 bg-blue-50 border border-blue-100 text-blue-700 text-sm p-4 rounded-lg" data-aos="fade-up">
                Belum ada jadwal yang ditambahkan.
            </div>
        @endif
    </div>

    {{-- Script Konfirmasi Hapus --}}
    <script>
        function confirmDelete(event) {
            if (!confirm('Yakin ingin menghapus jadwal ini?')) {
                event.preventDefault();
                return false;
            }
        }
    </script>
@endsection
