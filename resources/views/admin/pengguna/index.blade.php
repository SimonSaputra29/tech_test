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
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi
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

                                <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')"
                                        class="text-red-600 hover:text-red-900 font-semibold cursor-pointer" title="Hapus">
                                        Hapus
                                    </button>
                                </form>
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
@endsection
