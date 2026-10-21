<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Hanya Admin yang boleh mengelola akun Staff.
     */
    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);
    }

    /**
     * Ambil akun Staff saja.
     * Akun Admin dan Customer tidak bisa diedit lewat controller ini.
     */
    private function findStaff(int $id): User
    {
        return User::where('role', 'staff')->findOrFail($id);
    }

    /**
     * Daftar Staff, pencarian, dan ringkasan akun.
     */
    public function index(Request $request): View
    {
        $this->ensureAdmin();

        $query = User::where('role', 'staff');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $totalStaff = User::where('role', 'staff')->count();

        $activeStaff = User::where('role', 'staff')
            ->where('is_active', true)
            ->count();

        $users = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'totalStaff',
            'activeStaff'
        ));
    }

    /**
     * Menampilkan formulir tambah Staff.
     */
    public function create(): View
    {
        $this->ensureAdmin();

        return view('admin.users.create');
    }

    /**
     * Menyimpan akun Staff baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $staff = new User();
        $staff->name = trim($validated['name']);
        $staff->email = $validated['email'];
        $staff->password = Hash::make($validated['password']);

        // Role ditetapkan oleh server, bukan oleh formulir.
        $staff->role = 'staff';
        $staff->is_active = true;
        $staff->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun Staff berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit Staff.
     */
    public function edit(int $id): View
    {
        $this->ensureAdmin();

        $staff = $this->findStaff($id);

        return view('admin.users.edit', compact('staff'));
    }

    /**
     * Memperbarui data Staff.
     * Password bersifat opsional saat mengedit.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->ensureAdmin();

        $staff = $this->findStaff($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($staff->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $staff->name = trim($validated['name']);
        $staff->email = $validated['email'];

        if (!empty($validated['password'])) {
            $staff->password = Hash::make($validated['password']);
        }

        $staff->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data Staff berhasil diperbarui.');
    }

    /**
     * Mengaktifkan atau menonaktifkan akun Staff.
     */
    public function toggleActive(int $id): RedirectResponse
    {
        $this->ensureAdmin();

        $staff = $this->findStaff($id);

        $staff->is_active = !$staff->is_active;
        $staff->save();

        $message = $staff->is_active
            ? 'Akun Staff berhasil diaktifkan.'
            : 'Akun Staff berhasil dinonaktifkan.';

        return redirect()
            ->route('admin.users.index')
            ->with('success', $message);
    }
}
