<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class ProfileController extends Controller
{
    public function view(Request $request)
    {
        try {
            return view('profile.view');
        } catch (Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }
}
