<?php

namespace App\Http\Middleware;
use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CustomerAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get the order ID from the URL parameter
        $orderId = $request->route('id');

        // Retrieve the order from the database
        $order = Order::find($orderId);

        

        // Check if the order exists and if the authenticated user is a customer and their ID matches the user_id in the order
        if ($user-> id == $order->user_id) {
            return $next($request); // Proceed with the request
        }

        // If the user is not authorized, you can redirect them or return a response
        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
