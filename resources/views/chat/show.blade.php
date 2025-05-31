@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4 text-blue-700">Chat antara Guru & Murid</h2>
        {{-- Tombol Akhiri Percakapan (hanya jika status chatting) --}}
        @if ($requestModel->status === 'chatting')
            <form action="{{ route('chat.end', $requestModel->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                    Akhiri Percakapan
                </button>
            </form>
        @endif

        {{-- Jika status finished --}}
        @if ($requestModel->status === 'finished')
            <div class="mt-6 p-4 bg-gray-100 text-gray-700 rounded">
                Percakapan telah diakhiri.
            </div>
        @endif

        <div class="mb-2 text-gray-500">Request ID: {{ $requestModel->id }}</div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div id="chat-box" class="mb-6 h-72 overflow-y-auto border rounded p-4 bg-gray-50 flex flex-col space-y-3">
            @forelse($chats as $chat)
                <div class="flex {{ $chat->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
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
                <div class="text-center text-gray-400">Belum ada pesan.</div>
            @endforelse
        </div>

        <form action="{{ route('chat.send', $requestModel->id) }}" method="POST" class="flex gap-2">
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
