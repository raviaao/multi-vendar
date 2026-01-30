<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::latest()->paginate(15);
        $adminCount = User::where('role', 'admin')->count();
        $monthlyUsers = User::whereMonth('created_at', now()->month)->count();

        return view('admin.users.index', compact('users', 'adminCount', 'monthlyUsers'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ]);

        // Prepare update data
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
        ];

        // Update password if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Bulk delete users
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
        ]);

        $currentUserId = auth()->id();
        $users = User::whereIn('id', $request->ids)
                    ->where('id', '!=', $currentUserId)
                    ->get();

        $deletedCount = 0;
        foreach ($users as $user) {
            $user->delete();
            $deletedCount++;
        }

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} users deleted successfully!",
            'deleted_count' => $deletedCount
        ]);
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
        ]);

        // Prevent changing own role to user if you're the only admin
        if ($user->id === auth()->id() && $request->role === 'user') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot change your role to user. You are the only admin.'
                ], 400);
            }
        }

        $user->update(['role' => $request->role]);

        return response()->json([
            'success' => true,
            'message' => 'User role updated!',
            'role' => $user->role
        ]);
    }

    /**
     * Activate/Deactivate user
     */
    public function toggleStatus(User $user)
    {
        // In a real app, you might have an 'active' field
        // For now, we'll just return a message
        return response()->json([
            'success' => true,
            'message' => 'User status toggled!',
        ]);
    }

    /**
     * Search users
     */
    public function search(Request $request)
    {
        $search = $request->get('search');

        $users = User::where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->latest()
                    ->paginate(15);

        return view('admin.users.index', compact('users'));
    }
}
