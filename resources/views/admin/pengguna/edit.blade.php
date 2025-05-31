@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow-md mt-10" data-aos="fade-up">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Edit Pengguna</h1>

        <form action="{{ route('admin.pengguna.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block font-semibold mb-1 text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block font-semibold mb-1 text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block font-semibold mb-1 text-gray-700">Password <small
                            class="text-gray-500">(Kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block font-semibold mb-1 text-gray-700">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="role" class="block font-semibold mb-1 text-gray-700">Role</label>
                    <select name="role" id="role"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block font-semibold mb-1 text-gray-700">Lokasi</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $user->location) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('location')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="skill" class="block font-semibold mb-1 text-gray-700">Skill (khusus guru)</label>
                <textarea name="skill" id="skill" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('skill', $user->skill) }}</textarea>
                @error('skill')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="photo" class="block font-semibold mb-1 text-gray-700">Foto Profil</label>
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil"
                            class="w-24 h-24 object-cover rounded mb-2 border" />
                    @endif
                    <input type="file" name="photo" id="photo"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0 file:font-semibold
                    file:bg-blue-100 file:text-blue-700
                    hover:file:bg-blue-200" />
                    @error('photo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="identity_card" class="block font-semibold mb-1 text-gray-700">Kartu Identitas (KTP /
                        Pelajar)</label>
                    @if ($user->identity_card)
                        <img src="{{ asset('storage/' . $user->identity_card) }}" alt="Kartu Identitas"
                            class="w-48 h-auto mb-2 border rounded" />
                    @endif
                    <input type="file" name="identity_card" id="identity_card"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0 file:font-semibold
                    file:bg-blue-100 file:text-blue-700
                    hover:file:bg-blue-200" />
                    @error('identity_card')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 flex items-center justify-between">
                <button type="submit"
                    class="bg-green-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.pengguna.index') }}" class="text-gray-600 hover:text-gray-900 underline">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
