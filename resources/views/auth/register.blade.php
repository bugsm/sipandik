<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Daftar Akun SIPANDIK</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Buat akun untuk melaporkan bug dan mengakses data</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" autocomplete="tel" placeholder="08xxxxxxxxxx" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- NIP (Optional) -->
        <div class="mt-4">
            <x-input-label for="nip" :value="__('NIP (Opsional)')" />
            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')" placeholder="NIP untuk ASN" />
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- Jabatan -->
        <div class="mt-4">
            <x-input-label for="jabatan" :value="__('Jabatan/Instansi')" />
            <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan" :value="old('jabatan')" placeholder="Jabatan atau nama instansi" />
            <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register Button -->
        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                {{ __('Daftar Akun') }}
            </button>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800 hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
