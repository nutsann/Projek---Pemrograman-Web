<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        $activeOrders = $user->orders()->whereIn('status', ['pending', 'processing'])->latest()->with('items')->take(5)->get();
        $orderStats = [
            'total' => $user->orders()->count(),
            'active' => $user->orders()->whereIn('status', ['pending', 'processing'])->count(),
            'completed' => $user->orders()->where('status', 'completed')->count(),
        ];
        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('profile.index', compact('user', 'activeOrders', 'orderStats', 'notifications'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        $notifications = $user->notifications()->latest()->paginate(15);

        return view('profile.notifications', compact('notifications'));
    }

    public function update(Request $req)
    {
        $user = Auth::user();
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($req->hasFile('profile_photo')) {
            $oldPhoto = $user->profile_photo;
            $path = $req->file('profile_photo')->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
            if ($oldPhoto && ! filter_var($oldPhoto, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }

        $user->update($validated);

        return back()->with('success', 'Profil diperbarui.');
    }

    public function updatePassword(Request $req)
    {
        $user = Auth::user();
        $validated = $req->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Password saat ini salah.');
        }

        $user->update(['password' => Hash::make($validated['new_password'])]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
