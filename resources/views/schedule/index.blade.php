@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white rounded shadow p-8">
        <h1 class="text-2xl font-bold mb-4">Jadwal Pertemuan</h1>
        <div class="mb-4">
            <span class="font-semibold">Request ID:</span> {{ $requestModel->id }}<br>
            <span class="font-semibold">Status Request:</span> {{ ucfirst($requestModel->status) }}
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex justify-end">
            <a href="{{ route('schedules.create', $requestModel->id) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Tambah Jadwal
            </a>
        </div>

        @if ($schedules->count())
            <table class="min-w-full divide-y divide-gray-200 border rounded">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($schedule->date)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <form action="{{ route('schedules.destroy', [$requestModel->id, $schedule->id]) }}"
                                    method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="mt-6 p-4 bg-blue-50 text-blue-700 rounded border border-blue-100">
                Belum ada jadwal untuk request ini.
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">Kembali</a>
        </div>
    </div>
@endsection
