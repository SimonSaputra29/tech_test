@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-12 bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up" data-aos-duration="700">

        <a href="/murid/"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 hover:text-gray-900 transition duration-200 shadow-sm mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <h1 class="text-3xl font-extrabold text-center text-blue-700 mb-8">📋 Daftar Request Saya</h1>

        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-800 px-4 py-3 rounded-lg shadow-sm" data-aos="fade-down">
                {{ session('success') }}
            </div>
        @endif

        @if ($requests->count())
            <div class="overflow-x-auto">
                <table class="w-full border text-sm text-gray-700 rounded-xl shadow-sm">
                    <thead>
                        <tr class="bg-blue-50 text-left">
                            <th class="p-3 border-b">👨‍🏫 Guru</th>
                            <th class="p-3 border-b">📌 Status</th>
                            <th class="p-3 border-b">⚙️ Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 border-b">
                                    {{ $request->guru->name ?? '-' }}
                                </td>
                                <td class="p-3 border-b capitalize">
                                    @php
                                        $status = $request->status;
                                        $statusLabel = [
                                            'pending' => ['text-yellow-500', 'Pending'],
                                            'accepted' => ['text-blue-600', 'Diterima'],
                                            'chatting' => ['text-green-600 font-bold', 'Chatting'],
                                            'rejected' => ['text-red-600', 'Ditolak'],
                                            'finished' => ['text-gray-600 font-bold', 'Selesai'],
                                        ];
                                    @endphp
                                    <span class="{{ $statusLabel[$status][0] }}">{{ $statusLabel[$status][1] }}</span>
                                </td>
                                <td class="p-3 border-b">
                                    @if (in_array($request->status, ['accepted', 'chatting']))
                                        <a href="{{ route('chat.show', $request->id) }}"
                                            class="inline-block px-4 py-1 bg-indigo-600 text-white rounded-full text-xs font-medium hover:bg-indigo-700 transition duration-300">
                                            💬 Chat
                                        </a>
                                    @elseif($request->status == 'finished')
                                        <span class="text-gray-400 text-xs">Percakapan Selesai</span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-gray-500 text-center py-6">📭 Belum ada request.</div>
        @endif

        <div class="mt-8 text-center" data-aos="zoom-in" data-aos-delay="100">
            <a href="{{ route('requests.create') }}"
                class="inline-block px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition">
                ➕ Buat Request Baru
            </a>
        </div>
    </div>
@endsection
