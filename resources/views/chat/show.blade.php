@extends('layouts.app')

@section('content')
    <div data-aos="fade-up" class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow p-6">

        {{-- Tombol Kembali --}}
        <a href="/requests"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 hover:text-gray-900 transition duration-200 shadow-sm mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <h2 class="text-2xl font-bold mb-4 text-blue-700" data-aos="fade-down">Chat antara Guru & Murid</h2>

        {{-- Tombol Akhiri Percakapan --}}
        @if (auth()->user()->role === 'murid' && $requestModel->status === 'chatting')
            <form action="{{ route('chat.end', $requestModel->id) }}" method="POST" class="mt-4" data-aos="zoom-in">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                    Akhiri Percakapan
                </button>
            </form>
        @endif

        {{-- Jika status finished --}}
        @if ($requestModel->status === 'finished')
            <div class="mt-6 p-4 bg-gray-100 text-gray-700 rounded" data-aos="fade-in">
                Percakapan telah diakhiri.
            </div>
        @endif

        <div class="mb-2 text-gray-500" data-aos="fade-right">Request ID: {{ $requestModel->id }}</div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-200" data-aos="zoom-in">
                {{ session('success') }}
            </div>
        @endif

        <div id="chat-box" class="mb-6 h-72 overflow-y-auto border rounded p-4 bg-gray-50 flex flex-col space-y-3">
            @forelse($chats as $chat)
                <div class="flex {{ $chat->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}"
                    data-aos="{{ $chat->sender_id == auth()->id() ? 'fade-left' : 'fade-right' }}">
                    <div
                        class="max-w-xs px-4 py-2 rounded-lg
                        {{ $chat->sender_id == auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                        <span class="block text-xs font-semibold mb-1">
                            {{ $chat->sender_id == auth()->id() ? 'Anda' : $chat->sender->name ?? 'User' }}
                            <span class="text-[10px] text-gray-300 ml-1">{{ $chat->created_at->format('H:i') }}</span>
                        </span>
                        <span>{{ $chat->message }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400" data-aos="fade-up">Belum ada pesan.</div>
            @endforelse
        </div>

        <form action="{{ route('chat.send', $requestModel->id) }}" method="POST" class="flex gap-2" data-aos="fade-up">
            @csrf
            <input type="text" name="message"
                class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Ketik pesan..." autocomplete="off" required>
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Kirim
            </button>
        </form>
    </div>
@endsection
