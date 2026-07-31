@extends('layouts.admin')
@section('title', 'Users')
@section('content')

<div style="font-size:0.8rem;color:var(--muted);margin-bottom:8px;">Users <span style="margin:0 6px;">›</span> List</div>

<div class="page-header">
    <h1 class="page-title">Users</h1>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('admin.students.enroll-form') }}" class="btn btn-secondary">+ Manual Enroll</a>
        <button type="button" onclick="toggleNewUser()" style="background:#f5a623;color:#1a1a1a;border:none;border-radius:8px;padding:10px 20px;font-weight:700;font-size:0.85rem;cursor:pointer;font-family:inherit;">New user</button>
    </div>
</div>

@if(session('success'))
<div style="background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.4);color:var(--success);border-radius:8px;padding:12px 16px;font-size:0.85rem;margin-bottom:16px;">✅ {{ session('success') }}</div>
@endif
@if($errors->any())
<div style="background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.4);color:#fca5a5;border-radius:8px;padding:12px 16px;font-size:0.85rem;margin-bottom:16px;">❌ {{ $errors->first() }}</div>
@endif

{{-- New user form (toggled) --}}
<div id="new-user-panel" style="display:{{ $errors->has('email') || $errors->has('password') || $errors->has('role') ? 'block' : 'none' }};background:var(--bg2);border:1px solid var(--border);border-radius:12px;padding:20px;margin-bottom:20px;">
    <h3 style="font-weight:700;margin-bottom:14px;">➕ New user</h3>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-bottom:14px;">
            <div>
                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Role *</label>
                <select name="role" class="form-control" required>
                    <option value="student" {{ old('role', 'student') === 'student' ? 'selected' : '' }}>User (Student)</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (only one allowed)</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Password *</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password" required>
            </div>
        </div>
        <div style="font-size:0.75rem;color:var(--muted);margin-bottom:14px;">
            Selecting <strong style="color:#fbbf24;">Admin</strong> makes this user the only admin account that can access the admin panel.
        </div>
        <div style="display:flex;gap:8px;">
            <button type="submit" class="btn btn-primary btn-sm">💾 Create user</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleNewUser()">Cancel</button>
        </div>
    </form>
</div>

<div class="table-wrap">
    {{-- Search bar --}}
    <div style="display:flex;justify-content:flex-end;padding:14px 16px;border-bottom:1px solid var(--border);">
        <form method="GET" action="{{ route('admin.students.index') }}" style="display:flex;gap:8px;align-items:center;">
            <input type="hidden" name="per_page" value="{{ $perPage }}">
            <div style="position:relative;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);">🔍</span>
                <input type="text" name="q" class="form-control" value="{{ $search }}" placeholder="Search"
                       style="padding-left:36px;min-width:240px;border-radius:10px;">
            </div>
            @if($search !== '')
            <a href="{{ route('admin.students.index', ['per_page' => $perPage]) }}" class="btn btn-secondary btn-sm">✕ Clear</a>
            @endif
        </form>
    </div>

    <table class="table">
        <thead>
            <tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Enrollments</th><th style="text-align:right;">Actions</th></tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td style="font-weight:600;">{{ $student->name }}</td>
                <td style="color:var(--muted);">{{ $student->email }}</td>
                <td style="color:var(--muted);">{{ $student->phone ?? '—' }}</td>
                <td>
                    @if($student->role === 'admin')
                    <span style="display:inline-block;padding:3px 12px;border:1px solid #f5a623;color:#f5a623;border-radius:8px;font-size:0.75rem;font-weight:600;">admin</span>
                    @endif
                </td>
                <td><span class="badge badge-indigo">{{ $student->enrollments_count }}</span></td>
                <td>
                    <div style="display:flex;gap:16px;justify-content:flex-end;align-items:center;">
                        <a href="#" onclick="toggleEdit({{ $student->id }});return false;" style="color:#f5a623;font-weight:600;font-size:0.85rem;">✎ Edit</a>
                        @if($student->role !== 'admin')
                        <form method="POST" action="{{ route('admin.users.destroy', $student) }}" onsubmit="return confirm('Delete {{ $student->name }}? This removes their enrollments too.')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none;border:none;color:var(--danger);font-weight:600;font-size:0.85rem;cursor:pointer;font-family:inherit;padding:0;">🗑 Delete</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            {{-- Inline edit row --}}
            <tr id="edit-row-{{ $student->id }}" style="display:none;">
                <td colspan="6" style="background:var(--bg3);padding:18px 20px;">
                    <form method="POST" action="{{ route('admin.users.update', $student) }}">
                        @csrf @method('PUT')
                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;margin-bottom:12px;">
                            <div>
                                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
                            </div>
                            <div>
                                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $student->email }}" required>
                            </div>
                            <div>
                                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $student->phone }}">
                            </div>
                            <div>
                                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">Role</label>
                                <select name="role" class="form-control">
                                    <option value="student" {{ $student->role === 'student' ? 'selected' : '' }}>User (Student)</option>
                                    <option value="admin" {{ $student->role === 'admin' ? 'selected' : '' }}>Admin (only one allowed)</option>
                                </select>
                            </div>
                            <div>
                                <label style="display:block;font-size:0.72rem;color:var(--muted);margin-bottom:4px;">New Password <span style="color:var(--muted);">(optional)</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current" autocomplete="new-password">
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <button type="submit" class="btn btn-primary btn-sm">💾 Save</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit({{ $student->id }})">Cancel</button>
                            @if($student->role === 'admin')
                            <span style="font-size:0.75rem;color:#fbbf24;align-self:center;">⚠️ This is the admin login. Saving as Admin demotes every other admin (single-admin policy).</span>
                            @else
                            <span style="font-size:0.75rem;color:var(--muted);align-self:center;">Saving as Admin makes this the ONLY admin account.</span>
                            @endif
                        </div>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:40px;">{{ $search !== '' ? 'No users match "' . $search . '"' : 'No users yet' }}</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Per page --}}
    <div style="display:flex;justify-content:center;align-items:center;gap:10px;padding:14px;border-top:1px solid var(--border);font-size:0.85rem;color:var(--muted);">
        <form method="GET" action="{{ route('admin.students.index') }}" style="display:flex;align-items:center;gap:10px;">
            <input type="hidden" name="q" value="{{ $search }}">
            Per page
            <select name="per_page" class="form-control" style="width:auto;padding:6px 10px;" onchange="this.form.submit()">
                @foreach([10, 20, 50, 100] as $n)
                <option value="{{ $n }}" {{ $perPage === $n ? 'selected' : '' }}>{{ $n }}</option>
                @endforeach
            </select>
        </form>
    </div>
</div>
<div style="margin-top:20px;">{{ $students->links() }}</div>

@endsection

@push('scripts')
<script>
function toggleEdit(id) {
    const row = document.getElementById('edit-row-' + id);
    row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
}
function toggleNewUser() {
    const panel = document.getElementById('new-user-panel');
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}
</script>
@endpush
