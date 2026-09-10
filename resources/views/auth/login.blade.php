<x-guest-layout>
    <!-- Card Header -->
    <div class="mb-6 text-center">
        <h2 class="text-xl font-black text-white tracking-tight">Masuk ke Portal SIM-SDI</h2>
        <p class="text-xs text-slate-400 mt-1">Gunakan akun staf, guru, atau administrator yang terdaftar.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                Alamat Email <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path>
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="nama@sdi-bim.sch.id"
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-950/70 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    Kata Sandi <span class="text-rose-500">*</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors" href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-950/70 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                >
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-700 bg-slate-950 text-emerald-600 focus:ring-emerald-500 focus:ring-offset-slate-900" name="remember">
                <span class="ms-2 text-xs text-slate-300">Ingat sesi saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-900/40 transition-all transform active:scale-98 flex items-center justify-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span>Masuk ke Sistem</span>
            </button>
        </div>
    </form>

    <!-- Quick Demo Accounts Helper -->
    <div class="mt-8 pt-6 border-t border-slate-800">
        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center mb-3">
            Akun Percobaan Cepat (Demo Login)
        </p>
        <div class="space-y-2 text-xs">
            <button
                type="button"
                onclick="fillDemo('admin@sdi-bim.sch.id', 'password123')"
                class="w-full p-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800/80 border border-slate-800 flex items-center justify-between text-left transition-colors group"
            >
                <div>
                    <span class="font-bold text-purple-300 block">Administrator / Tata Usaha</span>
                    <span class="text-slate-400 text-[11px] font-mono">admin@sdi-bim.sch.id</span>
                </div>
                <span class="text-[10px] bg-purple-500/20 text-purple-300 px-2 py-0.5 rounded font-mono group-hover:bg-purple-500 group-hover:text-white transition-colors">Pilih</span>
            </button>

            <button
                type="button"
                onclick="fillDemo('ahmad.fauzi@sdi-bim.sch.id', 'password123')"
                class="w-full p-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800/80 border border-slate-800 flex items-center justify-between text-left transition-colors group"
            >
                <div>
                    <span class="font-bold text-emerald-300 block">Guru PAI & Wali Kelas 1-A</span>
                    <span class="text-slate-400 text-[11px] font-mono">ahmad.fauzi@sdi-bim.sch.id</span>
                </div>
                <span class="text-[10px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded font-mono group-hover:bg-emerald-500 group-hover:text-white transition-colors">Pilih</span>
            </button>

            <button
                type="button"
                onclick="fillDemo('siti.maryam@sdi-bim.sch.id', 'password123')"
                class="w-full p-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800/80 border border-slate-800 flex items-center justify-between text-left transition-colors group"
            >
                <div>
                    <span class="font-bold text-teal-300 block">Guru Matematika & Wali 2-A</span>
                    <span class="text-slate-400 text-[11px] font-mono">siti.maryam@sdi-bim.sch.id</span>
                </div>
                <span class="text-[10px] bg-teal-500/20 text-teal-300 px-2 py-0.5 rounded font-mono group-hover:bg-teal-500 group-hover:text-white transition-colors">Pilih</span>
            </button>
        </div>
        <p class="text-[10px] text-slate-500 text-center mt-2 font-mono">Kata sandi seluruh akun demo: password123</p>
    </div>

    @push('scripts')
    <script>
        function fillDemo(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>
    @endpush
</x-guest-layout>
