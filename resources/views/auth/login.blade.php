<x-guest-layout>
    <h2>Selamat Datang Kembali</h2>
    <p>Masuk untuk mengakses analisis investasi emas Anda.</p>

    <x-auth-session-status class="alert alert-success" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label class="field-label" for="email">Email</label>
            <input id="email" class="field-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@example.com" />
            @error('email')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="field-label" for="password">Password</label>
            <input id="password" class="field-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            @error('password')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:4px;">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--muted);">
                <input type="checkbox" name="remember" style="accent-color:var(--gold);"> Ingat Saya
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:13px;color:var(--gold);font-weight:600;text-decoration:none;">Lupa Password?</a>
            @endif
        </div>

        <button type="submit" class="btn-gold" style="margin-top:8px;">Masuk Sekarang</button>

        <p style="text-align:center;font-size:13px;color:var(--muted);margin:8px 0 0;">
            Belum punya akun? <a href="{{ route('register') }}" style="color:var(--gold);font-weight:700;text-decoration:none;">Daftar</a>
        </p>
    </form>
</x-guest-layout>
