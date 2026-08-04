<x-app-layout>
    <!-- MODAL ADD QUESTION (pure JS) -->
    <div id="modal-add-question" class="modal-backdrop" style="display:none;">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('modal-add-question')">✕</button>
            <p class="modal-title">Tambah Pertanyaan Baru</p>

            @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:16px;">
                <ul style="margin:0;padding-left:16px;">
                    @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.questions.store') }}" method="POST" style="display:flex;flex-direction:column;gap:14px;">
                @csrf
                <div>
                    <label class="field-label">Kode Pertanyaan</label>
                    <input class="field-input" type="text" name="code" value="{{ old('code') }}" placeholder="Misal: Q13" required>
                </div>
                <div>
                    <label class="field-label">Teks Pertanyaan</label>
                    <textarea class="field-input" name="text" rows="3" placeholder="Masukkan teks pertanyaan..." required>{{ old('text') }}</textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;">
                    <div>
                        <label class="field-label">CF Beli (0–1)</label>
                        <input class="field-input" type="number" step="0.1" min="0" max="1" name="cf_beli" value="{{ old('cf_beli', 0.5) }}" required>
                    </div>
                    <div>
                        <label class="field-label">CF Tahan (0–1)</label>
                        <input class="field-input" type="number" step="0.1" min="0" max="1" name="cf_tahan" value="{{ old('cf_tahan', 0.5) }}" required>
                    </div>
                    <div>
                        <label class="field-label">CF Jual (0–1)</label>
                        <input class="field-input" type="number" step="0.1" min="0" max="1" name="cf_jual" value="{{ old('cf_jual', 0.5) }}" required>
                    </div>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;">
                    <button type="button" class="btn btn-outline" onclick="closeModal('modal-add-question')">Batal</button>
                    <button type="submit" class="btn btn-gold">Simpan Pertanyaan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- PAGE HEADER -->
    <div class="page-header" style="display:flex;align-items:flex-start;justify-content:space-between;">
        <div>
            <span class="badge badge-gold">ADMINISTRATOR</span>
            <h1>Kelola Pertanyaan</h1>
            <p>Tambah, ubah teks, atau hapus pertanyaan Expert System.</p>
        </div>
        <button class="btn btn-gold" onclick="openModal('modal-add-question')" style="margin-top:8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Pertanyaan
        </button>
    </div>

    <!-- TABLE -->
    <div class="card">
        <p class="card-title">Daftar Pertanyaan & Nilai Pakar</p>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:60px;">Kode</th>
                        <th>Teks Pertanyaan</th>
                        <th style="width:80px;text-align:center;">CF Beli</th>
                        <th style="width:80px;text-align:center;">CF Tahan</th>
                        <th style="width:80px;text-align:center;">CF Jual</th>
                        <th style="width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                    <tr>
                        <td><strong style="color:var(--gold);">{{ $question->code }}</strong></td>
                        <td>
                            <form id="form-update-{{ $question->id }}" action="{{ route('admin.questions.update', $question) }}" method="POST" style="display:none;">
                                @csrf
                                <textarea class="field-input" name="text" rows="2">{{ $question->text }}</textarea>
                                <input type="hidden" name="cf_beli" value="{{ $question->expertRules->where('hypothesis','Beli')->first()->cf_pakar ?? 0 }}">
                                <input type="hidden" name="cf_tahan" value="{{ $question->expertRules->where('hypothesis','Tahan')->first()->cf_pakar ?? 0 }}">
                                <input type="hidden" name="cf_jual" value="{{ $question->expertRules->where('hypothesis','Jual')->first()->cf_pakar ?? 0 }}">
                                <div style="display:flex;gap:8px;margin-top:8px;">
                                    <button type="submit" class="btn btn-gold btn-sm">Simpan</button>
                                    <button type="button" class="btn btn-outline btn-sm" onclick="toggleEdit({{ $question->id }})">Batal</button>
                                </div>
                            </form>
                            <span id="text-{{ $question->id }}" style="font-size:13px;line-height:1.5;color:#c8cee0;">{{ $question->text }}</span>
                        </td>
                        <td style="text-align:center;color:var(--gold);font-weight:700;">{{ $question->expertRules->where('hypothesis','Beli')->first()->cf_pakar ?? '-' }}</td>
                        <td style="text-align:center;color:#f59e0b;font-weight:700;">{{ $question->expertRules->where('hypothesis','Tahan')->first()->cf_pakar ?? '-' }}</td>
                        <td style="text-align:center;color:#ef4444;font-weight:700;">{{ $question->expertRules->where('hypothesis','Jual')->first()->cf_pakar ?? '-' }}</td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                <button class="btn btn-outline btn-sm" onclick="toggleEdit({{ $question->id }})">Edit</button>
                                <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan {{ $question->code }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleEdit(id) {
            var form = document.getElementById('form-update-' + id);
            var text = document.getElementById('text-' + id);
            if (form.style.display === 'none') {
                form.style.display = 'block';
                text.style.display = 'none';
            } else {
                form.style.display = 'none';
                text.style.display = '';
            }
        }
    </script>

    <style>
        .btn { display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 20px;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;border:none;font-family:inherit; }
        .btn-gold { background:linear-gradient(135deg,#e8cc7a,#c9a84c);color:#000; }
        .btn-gold:hover { transform:translateY(-1px);box-shadow:0 6px 20px rgba(201,168,76,.35); }
        .btn-outline { background:transparent;border:1px solid var(--border);color:var(--muted); }
        .btn-outline:hover { border-color:var(--gold);color:var(--gold); }
        .btn-danger { background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);color:#ef4444; }
        .btn-danger:hover { background:#ef4444;color:#fff; }
        .btn-sm { padding:7px 14px;font-size:12px;border-radius:9px; }
    </style>
</x-app-layout>
