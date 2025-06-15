<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of the administrators.
     */
    public function index(Request $request)
    {
        $query = Admin::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $admins = $query->with('roles')->latest()->paginate(10);

        return view('admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new administrator.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.create', compact('roles'));
    }

    /**
     * Store a newly created administrator in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'exists:roles,name']
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Assign the role to the admin
        $role = Role::findByName($request->role);
        $admin->assignRole($role);

        return redirect()->route('manage.admins')
            ->with('success', 'Administrator created successfully.');
    }

    /**
     * Display the specified administrator.
     */
    public function show(Admin $admin)
    {
        $admin->load('roles');
        return view('admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified administrator.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        return view('admin.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified administrator in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', 'exists:roles,name']
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->filled('password')) {
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
        }

        // Sync the role (this will remove all existing roles and assign the new one)
        $role = Role::findByName($request->role);
        $admin->syncRoles([$role]);

        return redirect()->route('manage.admins')
            ->with('success', 'Administrator updated successfully.');
    }

    /**
     * Remove the specified administrator from storage.
     */
    public function destroy(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('manage.admins')
                ->with('error', 'You cannot delete your own account.');
        }

        $admin->delete();

        return redirect()->route('manage.admins')
            ->with('success', 'Administrator deleted successfully.');
    }

    /**
     * Toggle the active status of an administrator.
     */
    public function toggleStatus(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('manage.admins')
                ->with('error', 'You cannot deactivate your own account.');
        }

        $admin->update(['is_active' => !$admin->is_active]);

        $status = $admin->is_active ? 'activated' : 'deactivated';
        return redirect()->route('manage.admins')
            ->with('success', "Administrator {$status} successfully.");
    }
}
