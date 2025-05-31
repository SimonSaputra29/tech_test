@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Kelola Pengguna</h1>
            <a href="{{ route('admin.pengguna.create') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-semibold px-6 py-3 rounded-lg shadow transition duration-300">
                + Tambah Pengguna
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-800 rounded shadow" data-aos="fade">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap capitalize text-sm font-semibold
                                {{ $user->role === 'admin' ? 'text-red-600' : ($user->role === 'guru' ? 'text-blue-600' : 'text-green-600') }}">
                                {{ $user->role }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-3 text-sm">
                                <a href="{{ route('admin.pengguna.edit', $user->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 font-semibold" title="Edit">
                                    Edit
                                </a>

                                <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                    class="text-red-600 hover:text-red-900 font-semibold cursor-pointer" title="Hapus">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Modal Delete Confirmation --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 mx-4">
            <h3 class="text-lg font-semibold mb-4 text-gray-900">Konfirmasi Hapus</h3>
            <p id="deleteMessage" class="mb-6 text-gray-700"></p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeModal()"
                    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold transition">Batal</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white font-semibold transition">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // AOS Init
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                duration: 600,
                easing: 'ease-in-out',
                once: true,
            });
        });

        function confirmDelete(userId, userName) {
            const modal = document.getElementById('deleteModal');
            const message = document.getElementById('deleteMessage');
            const form = document.getElementById('deleteForm');

            message.textContent = `Apakah Anda yakin ingin menghapus pengguna "${userName}"?`;
            form.action = `/pengguna/${userId}`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Optional: close modal on clicking outside modal content
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
@endsection
