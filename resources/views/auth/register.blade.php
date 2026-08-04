<x-guest-layout>
    <h2>Buat Akun Baru</h2>
    <p>Bergabung dan mulai perjalanan investasi emas Anda.</p>

    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label class="field-label" for="name">Nama Lengkap</label>
            <input id="name" class="field-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Anda" />
            @error('name')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="field-label" for="email">Email</label>
            <input id="email" class="field-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="email@contoh.com" />
            @error('email')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="field-label" for="password">Password</label>
            <input id="password" class="field-input" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />
            @error('password')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" class="field-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
            @error('password_confirmation')<p class="error-text">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="btn-gold" style="margin-top:8px;">Daftar Sekarang</button>

        <p style="text-align:center;font-size:13px;color:var(--muted);margin:8px 0 0;">
            Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--gold);font-weight:700;text-decoration:none;">Masuk</a>
        </p>
    </form>
</x-guest-layout>
