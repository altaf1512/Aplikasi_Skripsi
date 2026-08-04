<x-app-layout>
    <div style="max-width:640px;margin:auto;">
        <div class="page-header">
            <span class="badge badge-gold">PEMULA</span>
            <h1>Konsultasi Pemula</h1>
            <p>Masukkan rencana investasi untuk mendapatkan estimasi gram emas Anda.</p>
        </div>

        <div class="card">
            <form action="{{ route('consultation.beginner.process') }}" method="POST" style="display:flex;flex-direction:column;gap:20px;">
                @csrf

                <!-- Budget -->
                <div>
                    <label class="field-label">Budget Investasi (Rupiah)</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:13px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:700;color:var(--muted);pointer-events:none;">Rp</span>
                        <input
                            type="number" name="budget" id="budget"
                            required min="100000"
                            class="field-input"
                            style="padding-left:40px;"
                            placeholder="Misal: 5000000"
                            value="{{ old('budget') }}"
                        >
                    </div>
                    @error('budget')<p style="font-size:12px;color:#f87171;margin-top:5px;">{{ $message }}</p>@enderror
                </div>

                <!-- Tujuan -->
                <div>
                    <label class="field-label">Tujuan Investasi</label>
                    <select name="goal" class="field-input" required>
                        <option value="dana_darurat"      {{ old('goal')=='dana_darurat' ? 'selected' : '' }}>Dana Darurat</option>
                        <option value="tabungan_nikah"    {{ old('goal')=='tabungan_nikah' ? 'selected' : '' }}>Tabungan Menikah</option>
                        <option value="dana_pendidikan"   {{ old('goal')=='dana_pendidikan' ? 'selected' : '' }}>Dana Pendidikan Anak</option>
                        <option value="haji_umroh"        {{ old('goal')=='haji_umroh' ? 'selected' : '' }}>Haji / Umroh</option>
                        <option value="lainnya"           {{ old('goal')=='lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <!-- Jangka Waktu -->
                <div>
                    <label class="field-label">Jangka Waktu Investasi</label>
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                        @php $tf = old('timeframe','long_term'); @endphp
                        <label style="cursor:pointer;">
                            <input type="radio" name="timeframe" value="short_term" {{ $tf=='short_term' ? 'checked' : '' }} style="display:none;" class="tf-radio">
                            <div class="tf-opt {{ $tf=='short_term' ? 'tf-selected' : '' }}">
                                <div style="font-weight:700;font-size:13px;">Jangka Pendek</div>
                                <div style="font-size:11px;color:var(--muted);margin-top:3px;">&lt; 1 Tahun</div>
                            </div>
                        </label>
                        <label style="cursor:pointer;">
                            <input type="radio" name="timeframe" value="mid_term" {{ $tf=='mid_term' ? 'checked' : '' }} style="display:none;" class="tf-radio">
                            <div class="tf-opt {{ $tf=='mid_term' ? 'tf-selected' : '' }}">
                                <div style="font-weight:700;font-size:13px;">Jangka Menengah</div>
                                <div style="font-size:11px;color:var(--muted);margin-top:3px;">1 – 3 Tahun</div>
                            </div>
                        </label>
                        <label style="cursor:pointer;">
                            <input type="radio" name="timeframe" value="long_term" {{ $tf=='long_term' ? 'checked' : '' }} style="display:none;" class="tf-radio">
                            <div class="tf-opt {{ $tf=='long_term' ? 'tf-selected' : '' }}">
                                <div style="font-weight:700;font-size:13px;">Jangka Panjang</div>
                                <div style="font-size:11px;color:var(--muted);margin-top:3px;">&gt; 3 Tahun</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Info harga emas -->
                <div style="padding:12px 16px;background:rgba(200,168,75,.07);border:1px solid rgba(200,168,75,.18);border-radius:11px;display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(200,168,75,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="18" height="18" fill="none" stroke="#c8a84b" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:.5px;">Harga Emas Saat Ini</div>
                        <div style="font-size:14px;font-weight:800;color:#fff;margin-top:2px;">Rp {{ number_format(\Illuminate\Support\Facades\Cache::get('gold_price', 1400000), 0, ',', '.') }} / gram</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center;padding:14px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    Hitung Estimasi Emas
                </button>
            </form>
        </div>
    </div>

    <style>
    .btn{display:inline-flex;align-items:center;gap:8px;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;border:none;font-family:inherit;transition:all .18s;}
    .btn-gold{background:linear-gradient(135deg,#e5cf85,#c8a84b);color:#000;}
    .btn-gold:hover{transform:translateY(-1px);box-shadow:0 8px 22px rgba(200,168,75,.4);}
    .tf-opt{padding:14px 10px;border:1px solid var(--border);border-radius:12px;text-align:center;transition:all .18s;background:var(--bg);color:var(--text);}
    .tf-opt:hover{border-color:rgba(200,168,75,.4);color:#fff;}
    .tf-selected{border-color:var(--gold)!important;background:rgba(200,168,75,.1)!important;color:var(--gold)!important;}
    </style>
    <script>
    document.querySelectorAll('.tf-radio').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.tf-opt').forEach(function(el){ el.classList.remove('tf-selected'); });
            this.nextElementSibling.classList.add('tf-selected');
        });
    });
    </script>
</x-app-layout>
