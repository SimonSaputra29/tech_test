@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white rounded shadow p-8">
        <h1 class="text-2xl font-bold mb-6">Tambah Jadwal Pertemuan</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('schedules.store', $requestModel->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="date" class="block font-semibold mb-2">Tanggal</label>
                <input type="date" name="date" id="date" class="w-full border rounded p-2"
                    min="{{ now()->toDateString() }}" value="{{ old('date') }}" required>
            </div>
            <div class="mb-6">
                <label for="time" class="block font-semibold mb-2">Jam</label>
                <input type="time" name="time" id="time" class="w-full border rounded p-2"
                    value="{{ old('time') }}" required>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('schedules.index', $requestModel->id) }}"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
@endsection
