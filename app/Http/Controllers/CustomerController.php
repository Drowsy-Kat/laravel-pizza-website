<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
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
        $orderTotal = 0;
        foreach ($orderItems as $item) {
            //dd($item);
            if ($item->size->id == 1) {
                $orderTotal += $item->pizza->pizza_small_price;
            } elseif ($item->size->id == 2) {
                $orderTotal += $item->pizza->pizza_medium_price;
            } elseif ($item->size->id == 3) {
                $orderTotal += $item->pizza->pizza_large_price;
            }
        }
        


    
        // Pass the order items to the view
        return view('customer.cart', compact('orderItems', 'orderTotal'));
    }

    public function history()
    {
        $user_id = Auth::user()->id;
        $orders = Order::where('user_id', $user_id)->get();

        return view('customer.history', compact('orders'));
    }

    public function add(Request $request, $pizzaId)
    {

        
        $size = $request->size;
        
        $orderItem = new OrderItem();
        $orderItem->pizza_id = $pizzaId;
        $orderItem->size_id = $size;
        $orderItems = Session::get('cart', []);
        $orderItems[] = $orderItem;

        Session::put('cart', $orderItems);
        Session::flash('success_message', "Item has been added to the cart");
        return back();
    }

    public function checkout(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->delivery_method_id = $request->delivery_method;
        
        $order->save();

        $orderItems = Session::get('cart', []);
        foreach ($orderItems as $item) 
        {
            $item->order_id = $order->id;
            $item->save();
        }

        // Empty the cart session
        Session::forget('cart');

        return redirect()->route('home');

    }

    public function order(string $id)
    {
        $orderItems = OrderItem::where('order_id', $id)->get();

        $orderTotal = 0;
        foreach ($orderItems as $item) {
            //dd($item);
            if ($item->size->id == 1) {
                $orderTotal += $item->pizza->pizza_small_price;
            } elseif ($item->size->id == 2) {
                $orderTotal += $item->pizza->pizza_medium_price;
            } elseif ($item->size->id == 3) {
                $orderTotal += $item->pizza->pizza_large_price;
            }
        }

        return view('customer.order', compact('orderItems', 'orderTotal'));

    }
}
