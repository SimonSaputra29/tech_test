@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto mt-12 bg-white rounded-2xl shadow-lg p-10" data-aos="fade-up" data-aos-duration="800">
        <h1 class="text-3xl font-extrabold text-blue-700 mb-2">📚 Daftar Request dari Murid</h1>
        <p class="mb-6 text-gray-600 text-lg">Berikut adalah permintaan yang masuk ke Anda sebagai Guru:</p>

        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300" data-aos="fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if ($requests->count())
            <div class="overflow-x-auto mt-4" data-aos="fade-up" data-aos-delay="100">
                <table class="min-w-full text-sm text-left border rounded-lg overflow-hidden shadow-sm">
                    <thead class="bg-blue-100 text-blue-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Murid</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Aksi</th>
                            <th class="px-5 py-3">Jadwal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($requests as $request)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold">{{ $request->murid->name ?? '-' }}</span>
                                        @if ($request->murid)
                                            <a href="{{ route('murid.show', $request->murid->id) }}"
                                                class="text-indigo-600 hover:underline text-xs" target="_blank">
                                                Lihat Profil
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-5 py-4">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'accepted' => 'bg-blue-100 text-blue-800',
                                            'chatting' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'finished' => 'bg-gray-200 text-gray-800',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$request->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 space-x-2">
                                    @if ($request->status == 'pending')
                                        <form action="{{ route('requests.accept', $request->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                                Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('requests.reject', $request->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                                Tolak
                                            </button>
                                        </form>
                                    @elseif(in_array($request->status, ['accepted', 'chatting']))
                                        <a href="{{ route('chat.show', $request->id) }}"
                                            class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs">
                                            Chat
                                        </a>
                                    @elseif($request->status == 'finished')
                                        <span class="text-gray-400 text-xs">Selesai</span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 space-x-2">
                                    <a href="{{ route('guru.requests.schedule.index', $request->id) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">
                                        Lihat
                                    </a>
                                    <a href="{{ route('guru.requests.schedule.create', $request->id) }}"
                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                        Tambah
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="mt-6 p-5 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 text-center" data-aos="zoom-in">
                Belum ada request dari murid.
            </div>
        @endif
    </div>
@endsection
