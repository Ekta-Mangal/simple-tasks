<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function view(Request $request)
    {
        try {
            $userId = Auth::id();
            $user = User::with(['contact', 'contact.country'])->findOrFail($userId);
            return view('profile.view', compact('user'));
        } catch (Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();
            return back()->with('success', 'Password Updated Successfully');
        } catch (Exception $e) {
            return back()->with("error", "Something Went Wrong: " . $e->getMessage());
        }
    }

    public function list(Request $request)
    {
        try {
            $data = User::with(['contact', 'contact.country'])->get();
            return view('profile.contacts', compact('data'));
        } catch (Exception $e) {
            return back()->with("error", "Something Went Wrong: " . $e->getMessage());
        }
    }
}
