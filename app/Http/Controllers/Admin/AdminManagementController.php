<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Enums\StatusEnum;
use App\Enums\RoleEnum;
use Spatie\Permission\Models\Role;

class AdminManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::where('id', '!=', auth()->id());
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        
        $admins = $query->with('roles')->paginate(10);
        
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'unique:admins,email', 'email'],
            'phone' => ['required', 'unique:admins,phone', 'string', 'digits:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name']
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => StatusEnum::ACTIVE
        ]);

        // $admin->assignRole($request->role);

        return redirect()->route('admin.manage.index')
            ->with('success', 'Admin created successfully');
    }

    public function edit(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.manage.index')
                ->with('error', 'You cannot edit your own account here');
        }

        $roles = Role::where('guard_name', 'admin')->get();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.manage.index')
                ->with('error', 'You cannot update your own account here');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:admins,email,' . $admin->id],
            'phone' => ['required', 'string', 'digits:10', 'unique:admins,phone,' . $admin->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name']
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->filled('password')) {
            $admin->update(['password' => Hash::make($request->password)]);
        }

        // $admin->syncRoles([$request->role]);

        return redirect()->route('admin.manage.index')
            ->with('success', 'Admin updated successfully');
    }

    public function toggleStatus(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'You cannot change your own status');
        }

        $admin->status = $admin->status === StatusEnum::ACTIVE ? StatusEnum::INACTIVE : StatusEnum::ACTIVE;
        $admin->save();

        return redirect()->route('admin.manage.index')
            ->with('success', 'Admin status updated successfully');
    }

    public function show(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.manage.index')
                ->with('error', 'You cannot view your own profile here');
        }

        $admin->load('roles');
        return view('admin.admins.show', compact('admin'));
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.manage.index')
                ->with('error', 'You cannot delete your own account');
        }

        // Check if admin has super admin role
        if ($admin->hasRole('Super Admin')) {
            return redirect()->route('admin.manage.index')
                ->with('error', 'Cannot delete Super Admin account');
        }

        $admin->delete();

        return redirect()->route('admin.manage.index')
            ->with('success', 'Admin deleted successfully');
    }

    public function resetPassword(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.manage.index')
                ->with('error', 'You cannot reset your own password here');
        }

        // Generate a random password
        $newPassword = Str::random(12);
        
        $admin->update([
            'password' => Hash::make($newPassword)
        ]);

        // In a real application, you would send this password via email
        // For now, we'll show it in the session
        return redirect()->route('admin.manage.index')
            ->with('success', "Password reset successfully. New password: {$newPassword} (Please send this to the admin securely)");
    }
} 