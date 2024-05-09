<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pizza;
use Illuminate\Support\Facades\Session;
use App\Models\OrderItem;
class CustomerController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }




    public function menu()
    {
        $pizzas = Pizza::all();
        return view('customer.menu', compact('pizzas'));
    }

    public function cart()
    {   
        // Fetch all items from the session
        $orderItems = Session::get('cart', []);
        dd($orderItems);
    
        // Pass the order items to the view
        return view('customer.cart', compact('orderItems'));
    }

    public function history()
    {
        return view('customer.history');
    }

    public function add(Request $request, $pizzaId){

        
        $size = $request->size;
        
        $orderItem = new OrderItem();
        $orderItem->pizza_id = $pizzaId;
        $orderItem->size = $size;
        $orderItems = Session::get('cart', []);
        $orderItems[] = $orderItem;

        Session::put('cart', $orderItems);
        Session::flash('success_message', "Item has been added to the cart");
        return back();
    }
}
