<x-app-layout>
    <div class="page-header">
        <span class="badge badge-gold">ADMINISTRATOR</span>
        <h1>Kelola Pengguna</h1>
        <p>Daftar pengguna dan pengaturan hak akses.</p>
    </div>

    <!-- STAT -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:22px;">
        <div class="card" style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;min-width:44px;border-radius:13px;background:rgba(200,168,75,.12);color:var(--gold);display:flex;align-items:center;justify-content:center;">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;">Total Pengguna</div>
                <div style="font-size:24px;font-weight:900;color:#fff;margin-top:2px;">{{ $users->total() }}</div>
            </div>
        </div>
        <div class="card" style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;min-width:44px;border-radius:13px;background:rgba(16,185,129,.1);color:#34d399;display:flex;align-items:center;justify-content:center;">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;">Admin</div>
                <div style="font-size:24px;font-weight:900;color:#fff;margin-top:2px;">{{ $users->where('role','admin')->count() }}</div>
            </div>
        </div>
        <div class="card" style="display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;min-width:44px;border-radius:13px;background:rgba(59,130,246,.1);color:#60a5fa;display:flex;align-items:center;justify-content:center;">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 10-16 0"/></svg>
            </div>
            <div>
                <div style="font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;">User Biasa</div>
                <div style="font-size:24px;font-weight:900;color:#fff;margin-top:2px;">{{ $users->where('role','user')->count() }}</div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-title">Daftar Pengguna</div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Bergabung</th>
                        <th>Peran (Role)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td style="color:var(--muted);font-size:12px;">{{ $u->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#e5cf85,#c8a84b);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:900;color:#000;flex-shrink:0;">
                                    {{ strtoupper(substr($u->name,0,1)) }}
                                </div>
                                <span style="font-weight:600;color:#e8eaf0;">{{ $u->name }}</span>
                            </div>
                        </td>
                        <td style="color:var(--muted);">{{ $u->email }}</td>
                        <td style="color:var(--muted);font-size:12px;">{{ $u->created_at->format('d M Y') }}</td>
                        <td>
                            <form action="{{ route('admin.users.update', $u) }}" method="POST" style="display:flex;gap:8px;align-items:center;">
                                @csrf
                                <select name="role" class="field-input" style="width:120px;padding:7px 10px;font-size:13px;">
                                    <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <button type="submit" class="btn btn-gold btn-sm">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div style="margin-top:18px;padding-top:16px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <style>
    .btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 20px;border-radius:11px;font-size:13.5px;font-weight:700;cursor:pointer;transition:all .18s;border:none;font-family:inherit;}
    .btn-gold{background:linear-gradient(135deg,#e5cf85,#c8a84b);color:#000;}
    .btn-gold:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(200,168,75,.35);}
    .btn-sm{padding:6px 13px;font-size:12px;border-radius:9px;}
    </style>
</x-app-layout>
