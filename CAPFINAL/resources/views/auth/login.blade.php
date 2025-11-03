<x-guest-layout>
    <div class="mb-4 md:mb-6 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
        <p class="text-sm md:text-base text-gray-600">Sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-lime-400 focus:ring focus:ring-lime-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />

            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-lime-400 focus:ring focus:ring-lime-200 focus:ring-opacity-50"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-lime-500 shadow-sm focus:ring-lime-400" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col gap-3 md:gap-4 mt-4 md:mt-6">
            <button type="submit" class="w-full bg-lime-400 text-gray-900 px-6 py-2.5 md:py-3 rounded-full font-semibold hover:bg-lime-500 hover:-translate-y-0.5 transition-all duration-300 shadow-md hover:shadow-lime-400/50 text-sm md:text-base">
                {{ __('Log in') }}
            </button>

            @if (Route::has('password.request'))
                <a class="text-center text-xs md:text-sm text-gray-600 hover:text-lime-600 transition-colors duration-300" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="mt-4 md:mt-6 text-center">
            <p class="text-xs md:text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-lime-600 hover:text-lime-700 font-semibold transition-colors duration-300">
                    Register here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
