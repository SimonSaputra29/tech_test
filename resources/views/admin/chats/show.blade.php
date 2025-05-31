@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6" data-aos="fade-up" data-aos-duration="700">
        {{-- Tombol Kembali --}}
        <a href="/admin"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 hover:text-gray-900 transition duration-200 shadow-sm mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <h2 class="text-3xl font-extrabold mb-4 text-gray-900">
            Percakapan antara {{ $requestModel->murid->name }} dan {{ $requestModel->guru->name }}
        </h2>
        <p class="mb-6 text-gray-600 font-medium">
            Status: <span class="capitalize">{{ $requestModel->status }}</span>
        </p>

        <div id="chat-box" class="bg-white p-6 border rounded-lg shadow max-h-[600px] overflow-y-auto">
            @foreach ($chats as $chat)
                <div class="mb-4 flex {{ $chat->sender->id === $requestModel->murid_id ? 'justify-start' : 'justify-end' }}"
                    data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div
                        class="max-w-[70%] px-4 py-3 rounded-lg
                    {{ $chat->sender->id === $requestModel->murid_id ? 'bg-blue-100 text-blue-900' : 'bg-green-100 text-green-900' }}">
                        <strong class="block mb-1">{{ $chat->sender->name }}</strong>
                        <p class="whitespace-pre-wrap">{{ $chat->message }}</p>
                        <span class="block text-xs text-gray-400 mt-1 text-right">
                            {{ $chat->created_at->format('d M Y H:i') }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Scroll otomatis ke pesan terakhir saat halaman dimuat
        window.onload = function() {
            const chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        };
    </script>
@endsection
