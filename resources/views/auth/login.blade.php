<x-guest-layout>
    <div class="mb-6 text-center">
        <h3 class="text-2xl font-bold text-gray-900">Maju Motor</h3>
        <p class="text-sm text-gray-500 mt-1">Sistem Informasi Manajemen Bengkel</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-semibold text-sm text-gray-700">Email</label>
            <input id="email" 
                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   type="email" 
                   name="email" 
                   :value="old('email')" 
                   required 
                   autofocus 
                   autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-semibold text-sm text-gray-700">Password</label>
            <input id="password" 
                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Register Link -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            <a class="underline text-sm text-gray-600 hover:text-blue-600 rounded-md focus:outline-none" href="{{ route('register') }}">
                Belum punya akun?
            </a>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between mt-6 pt-2 border-t border-gray-100">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-500 hover:text-gray-900 rounded-md focus:outline-none" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @else
                <div></div>
            @endif

            <button type="submit" 
                    class="inline-flex items-center px-6 py-2.5 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Log In
            </button>
        </div>
    </form>
</x-guest-layout>