<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::with(['items.productVariant.product.images'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('storefront.dashboard.index', compact('user', 'orders'));
    }

    public function show(Order $order)
    {
        // Ensure users can only see their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.productVariant.product.images', 'payment']);

        return view('storefront.dashboard.show', compact('order'));
    }
}

