@extends('admin.layout')

@section('title', 'Manajemen Staff')
@section('page-heading', 'Manajemen Staff')
@section('page-description', 'Kelola akun dan akses pegawai Veloura.')

@section('content')
<div class="panel">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:24px">
        <div>
            <h2 style="font-size:20px;margin:0 0 8px;color:#392b2d">Daftar Staff</h2>
            <p style="font-size:13px;color:#88797a;margin:0">
                Total staff terdaftar: <strong>{{ $users->total() }}</strong>
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            + Tambah Staff
        </a>
    </div>

    @php
        $activeCount = \App\Models\User::where('role', 'staff')
            ->where('is_active', true)
            ->count();
    @endphp

    <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;margin-bottom:24px">
        <div style="background:#f8f0eb;border:1px solid #ead8d1;border-radius:12px;padding:20px">
            <p style="font-size:13px;color:#88797a;margin:0 0 8px">Total Staff</p>
            <p style="font-size:28px;font-weight:700;color:#54252f;margin:0">
                {{ \App\Models\User::where('role', 'staff')->count() }}
            </p>
        </div>

        <div style="background:#f8f0eb;border:1px solid #ead8d1;border-radius:12px;padding:20px">
            <p style="font-size:13px;color:#88797a;margin:0 0 8px">Staff Aktif</p>
            <p style="font-size:28px;font-weight:700;color:#54252f;margin:0">
                {{ $activeCount }}
            </p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.users.index') }}"
          style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama atau email staff..."
            style="flex:1;min-width:220px"
        >
        <button type="submit" class="btn btn-primary">Cari</button>

        @if(request('search'))
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:16px">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom:16px">
            {{ $errors->first() }}
        </div>
    @endif

    <div style="overflow-x:auto">
        <table class="table" style="width:100%;min-width:650px">
            <thead>
                <tr>
                    <th style="width:55px">No.</th>
                    <th>Nama Staff</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th style="min-width:180px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if($user->id === auth()->id())
                                <span style="font-size:11px;color:#88797a">(Akun kamu)</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_active)
                                <span style="display:inline-block;padding:5px 11px;border-radius:20px;background:#e1f4e8;color:#267448;font-size:12px;font-weight:600">
                                    Aktif
                                </span>
                            @else
                                <span style="display:inline-block;padding:5px 11px;border-radius:20px;background:#fde8e8;color:#a52d36;font-size:12px;font-weight:600">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:8px;flex-wrap:wrap">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="btn btn-primary">Edit</a>

                                @if($user->id !== auth()->id())
                                    <form method="POST"
                                          action="{{ route('admin.users.toggle-active', $user) }}"
                                          onsubmit="return confirm('Yakin ingin mengubah status akun staff ini?')">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="btn {{ $user->is_active ? 'btn-danger' : 'btn-secondary' }}">
                                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:32px;color:#88797a">
                            Belum ada data staff yang sesuai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px">
        {{ $users->withQueryString()->links() }}
    </div>
</div>

<style>
@media (max-width: 640px) {
    .panel {
        padding: 16px !important;
    }
}
</style>
@endsection