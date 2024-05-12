<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //ensures the user is logged in

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all users
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

        /**
     * display a menu create a user
     */
    public function user_create()
    {
        return view('admin.user-create');
    }

    //function to register a user in the database
    public function register(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean' // Ensure is_admin is boolean
        ]);

        // Create a new user
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->is_admin = $request->has('is_admin'); // Convert checkbox value to boolean

        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('message', 'User registered successfully!');
    }

    // change a user to and from being an admin
    public function promote(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->is_admin = $user->is_admin ? 0 : 1; // Toggle the value of is_admin field
            $user->save();
            // You can add any additional logic or redirect the user as needed
        }
        return redirect()->route('admin.users');
    }
}
