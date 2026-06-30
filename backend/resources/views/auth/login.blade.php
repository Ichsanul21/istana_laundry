<x-guest-layout>
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="flex flex-col items-center mb-8">
            <span class="w-8 h-[2px] bg-[#FF6B00] mb-3"></span>
            <h2 class="text-[19px] font-black tracking-tight text-black">MASUK</h2>
            <p class="text-[11px] font-mono tracking-wider text-black/40 uppercase mt-1">Admin Panel Istana Laundry</p>
        </div>

        <div class="space-y-5">
            <div>
                <label for="email" class="block text-[11px] font-mono tracking-wider uppercase text-black/60 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full px-4 py-3 bg-white border border-[#E5E5E5] text-sm text-black placeholder:text-black/30 focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-colors"
                    placeholder="admin@istanalaundry.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label for="password" class="block text-[11px] font-mono tracking-wider uppercase text-black/60 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full px-4 py-3 bg-white border border-[#E5E5E5] text-sm text-black placeholder:text-black/30 focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-colors"
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 border border-[#E5E5E5] text-[#FF6B00] focus:ring-[#FF6B00] focus:ring-offset-0 rounded-none">
                <span class="text-[11px] font-mono tracking-wider uppercase text-black/50">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-[11px] font-mono tracking-wider uppercase text-[#FF6B00] hover:text-black transition-colors">
                    Lupa Password?
                </a>
            @endif
        </div>

        <div class="mt-8">
            <button type="submit"
                class="w-full bg-[#FF6B00] text-white text-[12px] font-bold tracking-wider uppercase px-6 py-3.5 hover:bg-black transition-colors duration-300">
                Masuk
            </button>
        </div>
    </form>
</x-guest-layout>
