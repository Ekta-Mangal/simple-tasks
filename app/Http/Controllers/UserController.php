<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Country;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
            $countries = Country::select('id', 'name')->get();
            $html = view('manageuser.add', compact('countries'))->render();
            return response()->json(['html' => $html, 'success' => true]);
        } catch (Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function postadd(UserRequest $request)
    {
        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Create user contact
            $user->contact()->create([
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'postcode' => $request->postcode,
                'country_id' => $request->country,
            ]);

            return back()->with('success', 'User Details Created Successfully');
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function editUser(Request $request)
    {
        try {
            $id = $request->id;
            $data = User::find($id);
            $contactDetails = UserContact::where('user_id', $id)->first();
            $countries = Country::select('id', 'name')->get();
            $html = view('manageuser.edit', compact('data', 'countries', 'contactDetails'))->render();
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
            $user->save();

            $userContact = UserContact::where('user_id', $user->id)->first();
            $userContact->phone = $request->phone;
            $userContact->mobile = $request->mobile;
            $userContact->address1 = $request->address1;
            $userContact->address2 = $request->address2;
            $userContact->address3 = $request->address3;
            $userContact->postcode = $request->postcode;
            $userContact->country_id = $request->country;
            $userContact->save();

            return back()->with('success', 'User Details Updated Successfully');
        } catch (\Exception $e) {
            return back()->with("error", "Something Went Wrong");
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::find($request->id);
            if ($user) {
                $user->contact()->delete();
                $user->delete();
                return response()->json(['message' => 'User Deleted Successfully', 'status' => 'success']);
            }
            return response()->json(['message' => 'User Not Found', 'status' => 'error']);
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json(['message' => 'Something Went Wrong', 'status' => 'error']);
        }
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'string|required|in:Admin,User',
            'contact.phone' => 'required|string',
            'contact.mobile' => 'nullable|string',
            'contact.address1' => 'required|string',
            'contact.address2' => 'required|string',
            'contact.address3' => 'nullable|string',
            'contact.postcode' => 'required|string',
            'contact.country_id' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($request->has('contact')) {
                $user->contact()->create($request->contact);
            }

            $data['token'] = 'Bearer ' . $user->createToken($request->email)->plainTextToken;
            $data['user'] = $user;

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'User registration failed.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $data['token'] = 'Bearer ' . $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;

        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully.',
            'data' => $data,
        ], 200);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
        ], 200);
    }
}
