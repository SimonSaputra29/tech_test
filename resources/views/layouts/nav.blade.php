<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        {{-- Brand / Logo --}}
        <div class="flex items-center space-x-2">
            <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.index') : (Auth::user()->role === 'guru' ? route('guru.index') : route('murid.index'))) : url('/') }}"
                class="text-2xl font-extrabold text-blue-600 tracking-tight hover:text-blue-700 transition-colors">
                EduMatch Platform
            </a>
        </div>

        {{-- Menu Navigasi --}}
        <div class="flex items-center space-x-2 md:space-x-4">
            @auth

                {{-- Tombol Profile --}}
                <a href="{{ auth()->user()->role === 'admin'
                    ? route('admin.profile.show')
                    : (auth()->user()->role === 'guru'
                        ? route('guru.profile.show')
                        : route('murid.profile.show')) }}"
                    class="px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A9 9 0 1119.07 7.34a7 7 0 10-9.95 10.464z" />
                    </svg>
                    <span>Profile</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline ml-2">
                    @csrf
                    <button type="submit"
                        class="px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="px-3 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition">Login</a>
                <a href="{{ route('register') }}"
                    class="px-3 py-2 rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition">Register</a>
            @endauth
        </div>
    </div>
</nav>
