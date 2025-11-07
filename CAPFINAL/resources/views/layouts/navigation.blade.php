<!-- Sidebar Navigation -->
<div x-data="{ open: false }">
<!-- Sidebar -->
<aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-screen fixed left-0 top-0 z-40 transform transition-transform duration-300 ease-in-out lg:translate-x-0" :class="{ '-translate-x-full': !open, 'translate-x-0': open }">
    <!-- Logo -->
    <div class="p-4 lg:p-6 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="bg-green-600 p-2 rounded-lg">
                <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18.5c-4.03-1.21-7-5.35-7-9.5V8.52l7-3.12 7 3.12V11c0 4.15-2.97 8.29-7 9.5z"/>
                </svg>
            </div>
            <div>
                <h1 class="font-bold text-gray-900 text-base lg:text-lg">BenguetCropMap</h1>
                <p class="text-xs text-gray-500">Agricultural System</p>
            </div>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 p-3 lg:p-4 space-y-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg text-sm lg:text-base {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('map.index') }}" class="flex items-center gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg text-sm lg:text-base {{ request()->routeIs('map.*') ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
            <span class="font-medium">Interactive Map</span>
        </a>

        <a href="{{ route('crop-data.index') }}" class="flex items-center gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg text-sm lg:text-base {{ request()->routeIs('crop-data.*') ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
            </svg>
            <span class="font-medium">Crop Data</span>
        </a>

        <a href="{{ route('predictions.predict.form') }}" class="flex items-center gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg text-sm lg:text-base {{ request()->routeIs('predictions.predict.*') ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            <span class="font-medium">Predictions</span>
        </a>

        <a href="{{ route('predictions.history') }}" class="flex items-center gap-3 px-3 lg:px-4 py-2.5 lg:py-3 rounded-lg text-sm lg:text-base {{ request()->routeIs('predictions.history') ? 'bg-green-50 text-green-700' : 'text-gray-700 hover:bg-gray-50' }}">
            <svg class="w-4 h-4 lg:w-5 lg:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">History</span>
        </a>
    </nav>

    <!-- User Profile -->
    <div class="border-t border-gray-200 p-3 lg:p-4">
        <div class="flex items-center gap-2 lg:gap-3 px-3 lg:px-4 py-2">
            <div class="bg-green-600 w-8 h-8 lg:w-10 lg:h-10 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-white font-semibold text-sm lg:text-base">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs lg:text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <div class="mt-2 space-y-1">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 lg:px-4 py-2 text-xs lg:text-sm text-gray-700 hover:bg-gray-50 rounded-lg">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 px-3 lg:px-4 py-2 text-xs lg:text-sm text-red-600 hover:bg-red-50 rounded-lg">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Mobile Menu Button -->
<!-- Mobile hamburger button -->
<button @click="open = !open" class="lg:hidden fixed top-4 left-4 z-50 bg-white p-2 rounded-lg shadow-lg border border-gray-200 hover:bg-gray-50 active:scale-95 transition-transform">
    <svg x-show="!open" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
    <svg x-show="open" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
</button>

<!-- Mobile overlay -->
<div x-show="open" @click="open = false" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
</div>
