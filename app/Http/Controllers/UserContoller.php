<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserContoller extends Controller
{
    public function list(Request $request)
    {
        try {
            $data = User::select('id', 'name', 'email', 'role')->get();
            return view('manageuser.list', compact('data'));
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function add()
    {
        try {
            $html = view('manageuser.add')->render();
            return response()->json(['html' => $html, 'success' => true]);
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function postadd(UserRequest $request)
    {
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();
            return back()->with('success', 'User Created Successfully');
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function editUser(Request $request)
    {
        try {
            $id = $request->id;
            $data = User::find($id);
            $html = view('manageuser.edit', compact('data'))->render();
            return response()->json(['html' => $html, 'success' => true]);
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function update(UserRequest $request)
    {
        try {
            $user = User::findOrFail($request->id_edit);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->update();
            return back()->with('success', 'User Updated Successfully');
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete = User::where('id', $request->id)->delete();
            if ($delete) {
                return response()->json(['message' => 'User Deleted Succesfully', 'status' => 'success']);
            }
            return response()->json(['message' => 'User Deleted Failed', 'status' => 'error']);
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }
}