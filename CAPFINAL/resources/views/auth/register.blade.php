<x-guest-layout>
    <div class="mb-4 md:mb-6 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
        <p class="text-sm md:text-base text-gray-600">Join BenguetCropMap today</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-medium" />
            <x-text-input id="name" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-lime-400 focus:ring focus:ring-lime-200 focus:ring-opacity-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-lime-400 focus:ring focus:ring-lime-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />

            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-lime-400 focus:ring focus:ring-lime-200 focus:ring-opacity-50"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-lime-400 focus:ring focus:ring-lime-200 focus:ring-opacity-50"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-3 md:gap-4 mt-4 md:mt-6">
            <button type="submit" class="w-full bg-lime-400 text-gray-900 px-6 py-2.5 md:py-3 rounded-full font-semibold hover:bg-lime-500 hover:-translate-y-0.5 transition-all duration-300 shadow-md hover:shadow-lime-400/50 text-sm md:text-base">
                {{ __('Register') }}
            </button>
        </div>

        <div class="mt-4 md:mt-6 text-center">
            <p class="text-xs md:text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-lime-600 hover:text-lime-700 font-semibold transition-colors duration-300">
                    Login here
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
