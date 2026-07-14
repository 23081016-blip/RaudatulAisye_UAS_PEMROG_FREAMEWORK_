<x-guest-layout>
    <div class="mb-6 text-center">
        <h3 class="text-2xl font-bold text-gray-900">Daftar Akun Baru</h3>
        <p class="text-sm text-gray-500 mt-1">Maju Motor Bengkel System</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-semibold text-sm text-gray-700">Nama Lengkap</label>
            <input id="name" 
                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   type="text" 
                   name="name" 
                   :value="old('name')" 
                   required 
                   autofocus 
                   autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block font-semibold text-sm text-gray-700">Email</label>
            <input id="email" 
                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   type="email" 
                   name="email" 
                   :value="old('email')" 
                   required 
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
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-semibold text-sm text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" 
                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between mt-6 pt-2 border-t border-gray-100">
            <a class="underline text-sm text-gray-600 hover:text-blue-600 rounded-md focus:outline-none" href="{{ route('login') }}">
                Sudah punya akun? Login
            </a>

            <button type="submit" 
                    class="inline-flex items-center px-6 py-2.5 bg-gray-900 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-gray-950 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>