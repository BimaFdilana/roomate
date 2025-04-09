<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Debug sementara untuk cek apakah instance-nya benar
        // dd(get_class($user)); // Harusnya: App\Models\User

        return view('account', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'photos' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        // Pastikan ini object User Eloquent
        if (!$user instanceof \App\Models\User) {
            return redirect()->back()->withErrors(['user' => 'User tidak valid.']);
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($request->hasFile('photos')) {
            $path = $request->file('photos')->store('profile_photos', 'public');
            $user->photos = $path;
        }

        $user->save(); // error terjadi di sini kalau bukan instance Eloquent

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Pastikan user adalah instance dari model
        if (!$user instanceof \App\Models\User) {
            return redirect()->back()->withErrors(['user' => 'User tidak valid.']);
        }

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

}