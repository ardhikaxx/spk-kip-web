<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak terdaftar pada sistem.');
        }

        // Normally we'd send an email here, but per request, we redirect to reset page
        return redirect()->route('password.reset', ['email' => $request->email]);
    }

    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        if (!$email) return redirect()->route('password.request');
        
        return view('auth.reset-password', compact('email'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Gagal mengubah password. Email tidak ditemukan.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Ubah password berhasil! Silahkan login dengan password baru Anda.');
    }
}
