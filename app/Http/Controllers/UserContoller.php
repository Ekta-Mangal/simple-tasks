<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserContoller extends Controller
{
    /**
     * Contructor
     */
    public function __construct() {}

    /**
     * Store (Register) a newly created resource in storage.
     */
    public function register(Request $request)
    {
        //TODO: Implement register logic
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        //TODO: Implement login logic
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        //TODO: Implement login logic
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //TODO: Implement delete logic and apply constraints if needed
    }
}
