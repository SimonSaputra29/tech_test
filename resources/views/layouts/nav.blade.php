<nav class="bg-white shadow-md fixed w-full top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        {{-- Brand / Logo --}}
        <a href="{{ Auth::check() ? (Auth::user()->role === 'admin' ? route('admin.index') : (Auth::user()->role === 'guru' ? route('guru.index') : route('murid.index'))) : url('/') }}"
            class="text-2xl font-extrabold text-blue-600 tracking-wide hover:text-blue-700 transition">
            EduMatch Platform
        </a>

        {{-- Menu Navigasi --}}
        <div class="flex items-center space-x-4">
            @auth
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg px-3 py-2 transition">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.121 17.804A9 9 0 1119.07 7.34a7 7 0 10-9.95 10.464z" />
                        </svg>
                        <span class="font-semibold">{{ Auth::user()->name }}</span>
                        <svg :class="{ 'rotate-180': open }"
                            class="w-4 h-4 ml-1 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 text-sm text-gray-700 z-50"
                        style="display: none;">
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.profile.show') : (auth()->user()->role === 'guru' ? route('guru.profile.show') : route('murid.profile.show')) }}"
                            class="block px-4 py-2 hover:bg-blue-50 hover:text-blue-700 transition">
                            Profile
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 hover:bg-red-100 hover:text-red-600 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="px-4 py-2 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition font-medium">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition font-semibold">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- Jangan lupa di layout utama panggil AlpineJS untuk dropdown --}}
<script src="//unpkg.com/alpinejs" defer></script>
