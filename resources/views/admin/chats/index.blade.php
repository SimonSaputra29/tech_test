@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-extrabold mb-8 text-gray-900" data-aos="fade-down" data-aos-duration="800">
            Daftar Percakapan
        </h1>

        <div class="overflow-x-auto rounded-xl shadow-lg border border-gray-200 bg-white" data-aos="fade-up"
            data-aos-delay="200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-100">
                    <tr>
                        @php
                            $headers = ['ID Request', 'Murid', 'Guru', 'Status', 'Aksi'];
                        @endphp
                        @foreach ($headers as $header)
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-blue-800 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($requests as $req)
                        <tr class="hover:bg-blue-50 transition-colors duration-300 cursor-pointer" data-aos="fade-up"
                            data-aos-delay="{{ $loop->index * 70 }}" onclick="highlightRow(this)">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $req->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $req->murid->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $req->guru->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="inline-block px-3 py-1 text-xs font-medium rounded-full
                                    {{ $req->status === 'selesai'
                                        ? 'bg-green-100 text-green-700'
                                        : ($req->status === 'ditolak'
                                            ? 'bg-red-100 text-red-700'
                                            : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.chats.show', $req->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-semibold hover:underline transition"
                                    onclick="event.stopPropagation()">
                                    Lihat Chat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">
                                Tidak ada percakapan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function highlightRow(row) {
            document.querySelectorAll('tbody tr').forEach(tr => {
                tr.classList.remove('bg-blue-100');
            });
            row.classList.add('bg-blue-100');
        }
    </script>
@endsection
