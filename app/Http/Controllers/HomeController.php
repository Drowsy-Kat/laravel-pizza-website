<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //retreives the is_admin feild from the user in the database
        $userId = Auth::user()->id;
        $isAdmin = User::where('id', $userId)->first()->is_admin;
        
        //returns appropreate page depending if the user is an admin or not
        if ($isAdmin==1) 
        {
            return view('admin.home');
        }
        else if ($isAdmin== 0)
        {
            return view('customer.home');
        }
    }
}
